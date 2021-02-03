<?php


namespace App\Services\Cron;


use App\Models\Site;

class CronDelete extends CronCommon
{

    function process(Site $site)
    {
        $user = getHostUser();
        $cronContent = shell_exec("crontab -u {$user} -l");

        $cronContent = collect(explode("\n", $cronContent))->filter(function ($line) use ($site) {
            return stripos($line, $site->getUrl()) === false && !empty($line);
        })->implode("\n");

        $cronContent = trim($cronContent);

        shell_exec("(echo \"{$cronContent}\") | crontab -");

        $this->getListCron();
    }
}
