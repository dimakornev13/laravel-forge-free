<?php

namespace App\Listeners;

use App\Events\SiteCreated;
use App\Services\Logger\Logger;
use App\Services\Nginx\CreateVhost;

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

        try {
            $service->process($event->site);
            $this->logger->success($service->getResult());
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return false;
        }

    }

}
