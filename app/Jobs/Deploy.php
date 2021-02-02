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
     */
    public function __construct(Site $site)
    {
        $this->site = $site;

        $this->logger = app(Logger::class);
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

        $this->logger->success($deployService->getResult());
    }


    function failed(\Throwable $exception)
    {
        $this->logger->error(Json::encode($exception));
    }
}
