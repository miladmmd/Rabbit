<?php

namespace Miladmmd\RabbitMq\Providers;

use Illuminate\Support\ServiceProvider;
use Miladmmd\RabbitMq\Interfaces\HandlerInterface;
use Miladmmd\RabbitMq\Interfaces\RpcConsumeInterface;
use Miladmmd\RabbitMq\Interfaces\RpcSendRequestInterface;
use Miladmmd\RabbitMq\Services\RpcConsume;
use Miladmmd\RabbitMq\Services\RpcHandler;
use Miladmmd\RabbitMq\Services\RpcSendRequest;


class RabbitServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(abstract: RpcConsumeInterface::class,concrete: RpcConsume::class);
        $this->app->bind(abstract: RpcSendRequestInterface::class,concrete: RpcSendRequest::class);
        $this->app->singleton(abstract: HandlerInterface::class,concrete: RpcHandler::class);
    }

    public function boot()
    {

    }
}
