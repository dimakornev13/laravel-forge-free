<?php

namespace App\Listeners;

use App\Events\SiteDeleted;
use App\Models\Site;
use App\Services\Cron\CronDelete;
use App\Services\Logger\Logger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CronRemoveListener
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
     * @param SiteDeleted $event
     */
    public function handle(SiteDeleted $event)
    {
        /** @var CronDelete $service */
        $service = app(CronDelete::class);

        try {
            $service->process($event->site);

            $this->logger->success($service->getResult());
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }


}
