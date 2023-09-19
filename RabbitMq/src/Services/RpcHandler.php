<?php

namespace Miladmmd\RabbitMq\Services;

use Illuminate\Support\Facades\Log;
use Miladmmd\RabbitMq\Interfaces\HandlerInterface;

class RpcHandler implements HandlerInterface
{
    protected $request;

    public function setRequest($request)
    {
        Log::debug($request);
        $this->request = $request;
    }
    public function handle()
    {
        return $this->request;
    }
}
