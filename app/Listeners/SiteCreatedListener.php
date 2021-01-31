<?php

namespace App\Listeners;

use App\Events\SiteCreated;
use App\Services\Nginx\CreateVhost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SiteCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Handle the event.
     *
     * @param SiteCreated $event
     * @return void
     */
    public function handle(SiteCreated $event)
    {
        $service = app(CreateVhost::class);
        $service->process($event->site);
    }
}
