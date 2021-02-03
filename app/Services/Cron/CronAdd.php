<?php


namespace App\Services\Cron;


use App\Models\Site;

class CronAdd extends CronCommon
{
    function process(Site $site)
    {
        shell_exec("(crontab -l 2>/dev/null; echo \"* * * * * /usr/bin/php {$site->getSiteDir()}/artisan schedule:run >> /dev/null 2>&1\") | crontab -");

        $this->getListCron();
    }
}
