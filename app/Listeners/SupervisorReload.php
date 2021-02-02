<?php

namespace App\Listeners;

use App\Events\QueueCreated;
use App\Events\QueueDeleted;
use App\Services\Logger\Logger;
use App\Services\Supervisor\Supervisor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SupervisorReload
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
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        /** @var Supervisor $service */
        $service = app(Supervisor::class);

        switch (get_class($event)) {
            case QueueCreated::class:
                $method = 'add';
                break;

            case QueueDeleted::class:
                $method = 'delete';
                break;
        }

        try {
            $service->{$method}($event->queue);

            $this->logger->success($service->getResult());
        } catch (\Error $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
