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

        try {
            $service->process($event->site);

            $result = $service->getResult();

            $this->logger->success($result);
        } catch (\Error $exception) {
            $this->logger->error(Json::encode($exception));
        }
    }
}
