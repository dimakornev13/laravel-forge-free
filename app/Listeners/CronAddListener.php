<?php

namespace App\Listeners;

use App\Events\SiteCreated;
use App\Models\Site;
use App\Services\Cron\CronAdd;
use App\Services\Logger\Logger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CronAddListener
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
     * @param SiteCreated $event
     */
    public function handle(SiteCreated $event)
    {
        /** @var CronAdd $service */
        $service = app(CronAdd::class);

        try {
            $service->process($event->site);

            $this->logger->success($service->getResult());
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

}
