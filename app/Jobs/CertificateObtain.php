<?php

namespace App\Jobs;

use App\Models\Site;
use App\Services\Logger\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CertificateObtain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $site;

    /** @var Logger */
    private $logger;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        $this->site = $site;

        $this->logger = app(Logger::class);
    }


    public function handle()
    {
        /** @var \App\Services\Certificate\CertificateObtain $service */
        $service = app(\App\Services\Certificate\CertificateObtain::class);

        $service->obtainCertificate($this->site);

        $this->logger->success($service->getResult());
    }


    function failed(\Throwable $exception)
    {
        $this->logger->error($exception->getMessage());
    }
}
