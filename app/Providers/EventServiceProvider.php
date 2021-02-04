<?php

namespace App\Providers;

use App\Events\CertificateObtained;
use App\Events\EnvUpdated;
use App\Events\QueueCreated;
use App\Events\QueueDeleted;
use App\Events\SiteCreated;
use App\Events\SiteDeleted;
use App\Listeners\CronAddListener;
use App\Listeners\CronRemoveListener;
use App\Listeners\EnvUpdatedListener;
use App\Listeners\NginxRestartListener;
use App\Listeners\SiteCreatedListener;
use App\Listeners\SiteDeletedListener;
use App\Listeners\SupervisorReload;
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
            SiteCreatedListener::class,
            NginxRestartListener::class,
            CronAddListener::class
        ],
        SiteDeleted::class => [
            SiteDeletedListener::class,
            CronRemoveListener::class,
            NginxRestartListener::class,
        ],
        QueueCreated::class => [
            SupervisorReload::class
        ],
        QueueDeleted::class => [
            SupervisorReload::class
        ],
        EnvUpdated::class => [
            EnvUpdatedListener::class
        ],
        CertificateObtained::class => [
            NginxRestartListener::class
        ]
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
