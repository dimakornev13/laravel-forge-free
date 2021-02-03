<?php

namespace App\Services\Certificate;


use App\Models\LogEvent;
use App\Models\Site;

class LetsEncrypt extends CertificateObtain
{

    public function obtainCertificate(Site $site)
    {
        $url = $site->getUrl();

        $this->result = shell_exec("sudo certbot --nginx --noninteractive --agree-tos --register-unsafely-without-email  -d {$url} -d www.{$url}");

        if (stripos($this->result, 'Congratulations! You have successfully enabled') === false)
            throw new \Error("Couldn't take certificate for {$site->getUrl()} \n {$this->result}");
    }


    public function renewCertificate(Site $site)
    {
        // TODO: Implement renewCertificate() method.
    }
}
