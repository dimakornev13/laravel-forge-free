<?php


namespace App\Services\Nginx;


use App\Models\Site;

class NginxDeleteVhost extends DeleteVhost
{

    public function process(Site $site)
    {
        $userHost = getHostUser();

        shell_exec("rm /etc/nginx/sites-available/{$site->getUrl()}");
        shell_exec("rm /etc/nginx/sites-enabled/{$site->getUrl()}");
        shell_exec("rm -rf /home/{$userHost}/{$site->getUrl()}");
        shell_exec("service nginx restart");
    }
}
