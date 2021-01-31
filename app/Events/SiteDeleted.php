<?php

namespace App\Events;

use App\Models\Site;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SiteDeleted
{
    use Dispatchable, SerializesModels;

    /**
     * @var Site
     */
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
