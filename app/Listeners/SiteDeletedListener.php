<?php

namespace App\Listeners;

use App\Events\SiteDeleted;
use App\Services\Logger\Logger;
use App\Services\Nginx\DeleteVhost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Psy\Util\Json;

class SiteDeletedListener
{
    private $logger;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
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

        $this->logger->success($service->getResult());
    }


    public function failed(\Throwable $exception)
    {
        $this->logger->error($exception->getMessage());
    }
}
