<?php

namespace Miladmmd\RabbitMq\Services;

use Miladmmd\RabbitMq\Interfaces\HandlerInterface;
use Miladmmd\RabbitMq\Interfaces\RpcConsumeInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RpcConsume extends RpcMethod implements RpcConsumeInterface
{
    protected $handler;
    public function __construct(HandlerInterface $handler)
    {
        parent::__construct();
        $this->handler = $handler;

    }

    public function consume(string $queueName)
    {
        $this->channel->queue_declare($queueName, false, false, false, false);
        echo "RPC Server waiting for requests...\n";
        $callback = function ($request) {
            $this->handler->setRequest($request->body);
            $msg = new AMQPMessage($request->body, ['correlation_id' => $request->get('correlation_id')]);
            $request->delivery_info['channel']->basic_publish($msg, '', $request->get('reply_to'));
            $request->delivery_info['channel']->basic_ack($request->delivery_info['delivery_tag']);
        };
        $this->channel->basic_consume($queueName, '', false, false, false, false, $callback);
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

}
