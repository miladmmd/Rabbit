<?php

namespace Miladmmd\RabbitMq\Services\Queue;

use Miladmmd\RabbitMq\Interfaces\HandleQueueInterface;
use Miladmmd\RabbitMq\Services\Base;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitQueue extends Base
{
    protected string $queueName;
    protected mixed $data;
    protected $handle;
    public function onQueue($queueName)
    {
        $this->queueName = $queueName;
        return $this;
    }

    public function setHandle($handle)
    {
        $this->handle = $handle;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    public function sendMessage()
    {
        $this->channel->queue_declare(queue: $this->queueName,passive: false, durable: true, exclusive: false, auto_delete: false);
        $data = [
            'handler' => $this->handle,
            'data' => json_encode($this->data,true)
        ];

        $msg = new AMQPMessage(
            json_encode($data),
            array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );

        $this->channel->basic_publish($msg,'',$this->queueName);
        echo ' [x] Sent ', "\n";
        $this->channel->close();
        $this->connection->close();

    }

    public function consume(string $queueName)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
        $callback = function ($msg) {
            echo ' [x] Received ', "\n";
            $getData = collect(json_decode($msg->getBody()))->toArray();
            $handler =collect(json_decode($getData['handler']))->toArray();

            $constructor = collect(json_decode($handler['constructor']))->toArray();
            $constructor_name = (collect($constructor[0])->toArray())['name'];
            $nameSpace = $handler['namespace'];

            app($nameSpace,[
                $constructor_name =>collect(json_decode($getData['data']))
            ])->handle();
//            app($nameSpace,[])
            $msg->ack();
        };
        $this->channel->basic_qos(null, 1, false);
        $this->channel->basic_consume($queueName, '', false, false, false, false, $callback);

        try {
            $this->channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }

    protected function runHandler($handler,$constructor)
    {
        $instance = app("App\Queue\HandleTestQueue",[$constructor['name'] => $constructor['value']]);
    }
}
