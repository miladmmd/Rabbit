<?php

namespace Miladmmd\RabbitMq\Interfaces;

interface HandlerInterface
{
    public function setRequest($request);
    public function handle();
}
