<?php

namespace Miladmmd\RabbitMq\Traits;

use Miladmmd\RabbitMq\Services\Queue\RabbitQueue;
use ReflectionClass;

trait RabbitQueueTrait
{
    public static function dispatch($data,$queue)
    {
        $rabbit = new RabbitQueue();
        $handlerNameSpace = static::class;
        //get constructor
        $reflection = new ReflectionClass(self::class);
        $constructor = $reflection->getConstructor();

        if ($constructor) {
            $constructorItems = $constructor->getParameters();
        }
        $class = [
            'namespace' => $handlerNameSpace,
            'constructor' => json_encode($constructorItems)
        ];

        $rabbit->setData($data)->setHandle(json_encode($class))->onQueue($queue)->sendMessage();
        return $rabbit;
    }
}
