<?php

namespace Miladmmd\RabbitMq\Interfaces;

interface RpcSendRequestInterface
{
    public function sendMessage(array $message);
    public function setRoutingKey(string $routingKey);
}
