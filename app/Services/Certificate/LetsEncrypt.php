<?php

namespace App\Services\Certificate;


use App\Models\Site;

class LetsEncrypt extends CertificateObtain
{

    public function obtainCertificate(Site $site)
    {
        $this->result = (string)shell_exec("sudo certbot --nginx --noninteractive --agree-tos --register-unsafely-without-email  -d {$site->getUrl()} -d www.{$site->getUrl()} 2>&1");

        if (stripos($this->result, 'Congratulations! You have successfully enabled') === false)
            throw new \Error("Couldn't take certificate for {$site->getUrl()} \n {$this->result}");
    }


    public function renewCertificate(Site $site)
    {
        $this->result = (string)shell_exec("sudo certbot --nginx --noninteractive -d {$site->getUrl()} 2>&1");
    }

    public function deleteCertificate(Site $site){
        $this->result = (string)shell_exec("sudo certbot delete --noninteractive --cert-name {$site->getUrl()} 2>&1");

        if (stripos($this->result, 'Deleted all files relating to certificate') === false)
            throw new \Error("Couldn't delete certificate for {$site->getUrl()} \n {$this->result}");
    }
}
