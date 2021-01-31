<?php


namespace App\Services\Nginx;


use App\Models\Site;

class NginxDeleteVhost extends DeleteVhost
{

    public function process(Site $site)
    {
        shell_exec("rm /etc/nginx/sites-available/{$site->getUrl()}");
        shell_exec("rm /etc/nginx/sites-enable/{$site->getUrl()}");
        shell_exec("rm -rf /home/{getHostUser()}/{$site->getUrl()}");
        shell_exec("service nginx restart");
    }
}
