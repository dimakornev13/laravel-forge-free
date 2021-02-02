<?php

namespace App\Jobs;

use App\Models\Site;
use App\Services\Deploy\DeployImplement;
use App\Services\Logger\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psy\Util\Json;

class Deploy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $site;

    private $logger;


    /**
     * Deploy constructor.
     * @param Site $site
     * @param Logger $logger
     */
    public function __construct(Site $site, Logger $logger)
    {
        $this->site = $site;

        $this->logger = $logger;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var DeployImplement $deployService */

        $deployService = app(\App\Services\Deploy\Deploy::class);
        $deployService->deploy($this->site);

        $result = $deployService->getResult();

        $this->logger->success($result);
    }

    function failed(\Throwable $exception){
        $this->logger->error(Json::encode($exception));
    }
}
