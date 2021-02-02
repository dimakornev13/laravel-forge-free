<?php

namespace App\Listeners;

use App\Events\EnvUpdated;
use App\Models\Site;
use App\Services\Logger\Logger;

class EnvUpdatedListener
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
     * @param EnvUpdated $event
     * @return void
     */
    public function handle(EnvUpdated $event)
    {
        try {
            $this->proccess($event->site);

            $this->logger->success(".env file has been successful updated for site {$event->site->getUrl()}");
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }


    private function proccess(Site $site)
    {
        $result = file_put_contents($site->getEnvDir(), $site->getEnvironment());
        if ($result === false)
            throw new \Error("Couldn't update .env file for {$site->getUrl()} in directory {$site->getEnvDir()}");

        $result = shell_exec("php {$site->getSiteDir()}/artisan config:cache");
        if (stripos($result, 'Configuration cached successfully') === false)
            throw new \Error("Couldn't cache config for {$site->getUrl()} in directory {$site->getEnvDir()} ({$result})");

        $result = shell_exec("php {$site->getSiteDir()}/artisan queue:restart");
        if (stripos($result, 'Broadcasting queue restart signal') === false)
            throw new \Error("Couldn't restart queue for {$site->getUrl()} in directory {$site->getEnvDir()} ({$result})");
    }
}
