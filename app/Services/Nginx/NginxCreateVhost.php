<?php


namespace App\Services\Nginx;


use App\Models\Site;

class NginxCreateVhost extends CreateVhost
{

    function process(Site $site)
    {
        $path = "{$site->getSiteDir()}/public";
        @mkdir($path, 0755, true);

        $nginxConfigFile = view('dashboard.nginx.vhost80', compact('site', 'path'));

        $availablePath = "/etc/nginx/sites-available/{$site->getUrl()}";
        $enablePath = "/etc/nginx/sites-enabled/{$site->getUrl()}";
        $result = file_put_contents($availablePath, $nginxConfigFile);

        if($result === false)
            throw new \Error("Cannot create nginx config file {$availablePath}");

        shell_exec("ln -s {$availablePath} {$enablePath}");

        $this->result = shell_exec('sudo service nginx restart 2>&1');
    }
}
