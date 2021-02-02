<?php

namespace App\Events;

use App\Models\Site;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SiteDeleted
{
    use Dispatchable;

    /**
     * @var Site
     */
    public $site;


    /**
     * SiteDeleted constructor.
     * @param Site $site
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }
}
