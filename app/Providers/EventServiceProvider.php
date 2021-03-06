<?php

namespace App\Providers;

use App\Jobs\TestJob;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        App::bindMethod(TestJob::class . '@handle', fn($job) => $job->handle());
    }
}
