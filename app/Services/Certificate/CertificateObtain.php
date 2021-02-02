<?php

namespace App\Services\Certificate;

use App\Models\Site;
use App\Services\Logger\Logger;

abstract class CertificateObtain
{
    protected $logger;


    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @param \App\Models\Site $site
     * @return mixed
     */
    abstract public function obtainCertificate(Site $site);


    /**
     * @param Site $site
     * @return mixed
     */
    abstract public function renewCertificate(Site $site);
}
