<?php

namespace App\Events;

use App\Models\Queue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueCreated
{
    use Dispatchable, SerializesModels;

    public $queue;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

}
