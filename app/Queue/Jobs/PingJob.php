<?php

namespace App\Queue\Jobs;

use App\Models\QueueHandler;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;

class PingJob extends RabbitMQJob
{

    public function fire()
    {
        $payload = $this->payload();

        $class = QueueHandler::class;
        $method = 'handle';

        ($this->instance = $this->resolve($class))->{$method}($this, $payload);

        $this->delete();
    }

}
