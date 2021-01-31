<?php

namespace App\Providers;

use App\Events\SiteCreated;
use App\Events\SiteDeleted;
use App\Listeners\SiteCreatedListener;
use App\Listeners\SiteDeletedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SiteCreated::class => [
            SiteCreatedListener::class
        ],
        SiteDeleted::class => [
            SiteDeletedListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
