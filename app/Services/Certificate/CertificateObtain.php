<?php

namespace App\Services\Certificate;

use App\Models\Site;
use App\Traits\Result;

abstract class CertificateObtain
{

    use Result;
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
