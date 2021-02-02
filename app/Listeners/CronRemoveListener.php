<?php

namespace App\Listeners;

use App\Events\SiteDeleted;
use App\Models\Site;
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
        try {
            $this->process($event->site);

            $this->logger->success("Cron has been removed for site {$event->site->getUrl()}");
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }


    private function process(Site $site)
    {
        $user = getHostUser();
        $cronContent = shell_exec("crontab -u {$user} -l");

        $cronContent = collect(explode("\n", $cronContent))->filter(function ($line) use ($site) {
            return stripos($line, $site->getUrl()) === false;
        })->implode("\n");

        shell_exec("(crontab -l 2>/dev/null; echo \"{$cronContent}\") | crontab -");
    }
}
