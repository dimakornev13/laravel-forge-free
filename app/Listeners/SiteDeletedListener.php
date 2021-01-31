<?php

namespace App\Listeners;

use App\Events\SiteDeleted;
use App\Services\Nginx\DeleteVhost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SiteDeletedListener
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
     * @param SiteDeleted $event
     * @return void
     */
    public function handle(SiteDeleted $event)
    {
        $service = app(DeleteVhost::class);
        $service->process($event->site);
    }
}
