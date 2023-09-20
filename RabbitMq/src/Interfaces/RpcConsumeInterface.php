<?php

namespace Miladmmd\RabbitMq\Interfaces;

interface RpcConsumeInterface
{
    public function setHandler(HandlerConsumeInterface $handlerConsume);
    public function consume(string $queueName);
}
