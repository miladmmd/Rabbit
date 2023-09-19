<?php

namespace Miladmmd\RabbitMq\Services;

use Miladmmd\RabbitMq\Interfaces\RpcSendRequestInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RpcSendRequest extends RpcMethod implements RpcSendRequestInterface
{
    protected string $routingKey;
    protected string $callbackQueue;

    public function setRoutingKey(string $routingKey)
    {
        $this->routingKey = $routingKey;
    }

    public function sendMessage(array $message)
    {
        $this->message($message)->ack()->close();
    }

    protected function ack()
    {
        $this->channel->basic_consume($this->callbackQueue, '', false, false, false, false, function ($response) {
            echo "Response: " . $response->body . "\n";
        });

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }

        return $this;
    }



    protected function message(array $array)
    {
        list($callback_queue, ,) = $this->channel->queue_declare('', false, false, true, false);
        $request = new AMQPMessage(json_encode($array, true), [
            'correlation_id' => uniqid(),
            'reply_to' => $callback_queue,
        ]);
        $this->channel->basic_publish($request, '', $this->routingKey);
        $this->callbackQueue = $callback_queue;
        return $this;
    }
}
