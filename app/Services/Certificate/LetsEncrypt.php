<?php

namespace App\Services\Certificate;


use App\Models\LogEvent;
use App\Models\Site;

class LetsEncrypt extends CertificateObtain
{

    public function obtainCertificate(Site $site)
    {
        $url = $site->getUrl();

        $output = shell_exec("certbot --nginx --non-interactive --domains {$url}");

        $this->logger->log(
            stripos($output, 'error') !== false
                ? LogEvent::TYPE_ERROR
                : LogEvent::TYPE_SUCCESS,
            $output
        );
    }


    public function renewCertificate(Site $site)
    {
        // TODO: Implement renewCertificate() method.
    }
}
