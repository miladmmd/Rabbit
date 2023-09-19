<?php

namespace Miladmmd\RabbitMq\Services;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Base
{
    protected AMQPChannel $channel;
    protected AMQPStreamConnection $connection;
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            5672,
            'guest',
            'guest'
        );

        $this->channel = $this->connection->channel();
    }

    /**
     * @throws \Exception
     */
    protected function close()
    {
        $this->channel->close();
        $this->connection->close();
    }

}
