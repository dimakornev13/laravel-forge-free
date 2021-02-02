<?php

namespace App\Events;

use App\Models\Site;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EnvUpdated
{
    use Dispatchable, SerializesModels;

    public $site;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

}
