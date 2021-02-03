<?php

namespace App\Console\Commands;

use App\Repositories\SitesRepository;
use App\Services\Certificate\CertificateObtain;
use App\Services\Logger\Logger;
use Illuminate\Console\Command;

class RenewCertificates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renew:certificates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $logger;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Logger $logger)
    {
        parent::__construct();

        $this->logger = $logger;
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** @var SitesRepository */
        $sites = collect(app(SitesRepository::class)->getEntity()->get());

        /** @var CertificateObtain $service */
        $service = app(CertificateObtain::class);

        $sites->each(function ($site) use ($service) {
            try {
                $service->obtainCertificate($site);

                $this->logger->success($service->getResult());
            } catch (\Throwable $exception) {
                $this->logger->error($exception->getMessage());
            }
        });

        return 0;
    }
}
