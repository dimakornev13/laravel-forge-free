<?php

namespace App\Services\Certificate;


use App\Events\CertificateObtained;
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

        event(new CertificateObtained());
    }


    public function renewCertificate(Site $site)
    {
        $url = $site->getUrl();

        $this->result = shell_exec("sudo certbot --nginx --noninteractive -d {$url}");

//        if (stripos($this->result, 'Congratulations! You have successfully enabled') === false)
//            throw new \Error("Couldn't take certificate for {$site->getUrl()} \n {$this->result}");

        event(new CertificateObtained());

    }

    public function deleteCertificate(Site $site){
        $url = $site->getUrl();

        $this->result = shell_exec("sudo certbot delete --noninteractive --cert-name {$url}");

        if (stripos($this->result, 'Deleted all files relating to certificate') === false)
            throw new \Error("Couldn't delete certificate for {$site->getUrl()} \n {$this->result}");

        event(new CertificateObtained());

    }
}
