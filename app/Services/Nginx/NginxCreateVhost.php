<?php


namespace App\Services\Nginx;


use App\Models\Site;

class NginxCreateVhost extends CreateVhost
{

    function process(Site $site)
    {
        $userHost = getHostUser();
        $path = "/home/{$userHost}/{$site->getUrl()}/www/public";
        @mkdir($path, 0755, true);

        $nginxConfigFile = view('dashboard.nginx.vhost80', compact('site', 'path'));

        $availablePath = "/etc/nginx/sites-available/{$site->getUrl()}";
        $enablePath = "/etc/nginx/sites-enabled/{$site->getUrl()}";
        file_put_contents($availablePath, $nginxConfigFile);

        shell_exec("ln -s {$availablePath} {$enablePath}");

        shell_exec('service nginx restart');
    }
}
