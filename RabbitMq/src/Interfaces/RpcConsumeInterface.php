<?php

namespace Miladmmd\RabbitMq\Interfaces;

interface RpcConsumeInterface extends MethodInterface
{
    public function consume(string $queueName);
}
