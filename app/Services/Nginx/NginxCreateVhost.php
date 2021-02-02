<?php


namespace App\Services\Nginx;


use App\Models\Site;

class NginxCreateVhost extends CreateVhost
{

    function process(Site $site)
    {
        $path = "{$site->getSiteDir()}/public";
        $result = mkdir($path, 0755, true);

        if ($result === false)
            throw new \Error("Cannot create directory for site {$site->getUrl()}");

        $nginxConfigFile = view('dashboard.nginx.vhost80', compact('site', 'path'));

        $availablePath = "/etc/nginx/sites-available/{$site->getUrl()}";
        $enablePath = "/etc/nginx/sites-enabled/{$site->getUrl()}";
        $result = file_put_contents($availablePath, $nginxConfigFile);

        if ($result === false)
            throw new \Error("Cannot create nginx config file {$availablePath}");

        symlink($availablePath, $enablePath);

        $this->result = "Vhost for {$site->getUrl()} has been created successful";

//        panel is not available while it works
//        $this->result = shell_exec('sudo service nginx restart');
    }
}
