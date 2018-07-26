<?php

namespace App\Providers;

use App\Events\GitHubEvent;
use App\Listeners\GitHubListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ExampleEvent' => [
            'App\Listeners\ExampleListener',
        ],
        GitHubEvent::class => [
            GitHubListener::class
        ],
    ];
}
