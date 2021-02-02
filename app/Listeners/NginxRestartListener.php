<?php

namespace App\Listeners;

use App\Services\Logger\Logger;
use App\Services\Nginx\ServerRestart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Psy\Util\Json;

class NginxRestartListener implements ShouldQueue
{
    use InteractsWithQueue, Queueable, Dispatchable;

    /** @var Logger */
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        /** @var ServerRestart $service */
        $service = app(ServerRestart::class);

        $service->process();

        $this->logger->success($service->getResult());
    }

    public function failed(\Throwable $exception){
        $this->logger->error($exception->getMessage());
    }
}
