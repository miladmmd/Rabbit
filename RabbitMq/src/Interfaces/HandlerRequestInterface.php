<?php

namespace Miladmmd\RabbitMq\Interfaces;

interface HandlerRequestInterface
{
    public function setRequest($request);
    public function handle();
}
