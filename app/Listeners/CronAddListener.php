<?php

namespace App\Listeners;

use App\Events\SiteCreated;
use App\Models\Site;
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
        try {
            $this->process($event->site);

            $this->logger->success("Cron has been added for site {$event->site->getUrl()}");
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }


    private function process(Site $site)
    {
        shell_exec("(crontab -l 2>/dev/null; echo \"* * * * * /usr/bin/php {$site->getSiteDir()}/artisan schedule:run >> /dev/null 2>&1\") | crontab -");
    }
}
