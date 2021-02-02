<?php

namespace App\Listeners;

use App\Events\SiteCreated;
use App\Services\Logger\Logger;
use App\Services\Nginx\CreateVhost;
use Psy\Util\Json;

class SiteCreatedListener
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
     * @param SiteCreated $event
     * @return void
     */
    public function handle(SiteCreated $event)
    {
        $service = app(CreateVhost::class);

        $service->process($event->site);

        $this->logger->success($service->getResult());
    }


    public function failed(\Throwable $exception)
    {
        $this->logger->error($exception->getMessage());
    }
}
