<?php

namespace Miladmmd\RabbitMq\Interfaces;

interface RpcSendRequestInterface extends MethodInterface
{
    public function sendMessage(array $message);
    public function setRoutingKey(string $routingKey);
}
