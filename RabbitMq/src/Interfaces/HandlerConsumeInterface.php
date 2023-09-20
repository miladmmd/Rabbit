<?php

namespace Miladmmd\RabbitMq\Interfaces;

interface HandlerConsumeInterface
{
    public function setRequest($request);
    public function handle();
}
