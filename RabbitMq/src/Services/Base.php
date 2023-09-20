<?php

namespace Miladmmd\RabbitMq\Services;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Base
{
    protected AMQPChannel $channel;
    protected AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'localhost'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest')
        );
        $this->channel = $this->connection->channel();
    }

    /**
     * @throws Exception
     */
    protected function close()
    {
        $this->channel->close();
        $this->connection->close();
    }

}
