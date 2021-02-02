<?php

namespace App\Listeners;

use App\Events\SiteCreated;
use App\Services\Logger\Logger;
use App\Services\Nginx\CreateVhost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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

        try {
            $service->process($event->site);

            $result = $service->getResult();

            $this->logger->success($result);
        } catch (\Error $exception) {
            $this->logger->error(Json::encode($exception));
        }
    }
}
