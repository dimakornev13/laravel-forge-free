<?php

namespace App\Services\Cron;

use App\Models\Site;
use App\Traits\Result;

abstract class CronCommon
{
    use Result;

    /**
     * @return string|null
     */
    function getListCron()
    {
        $user = getHostUser();
        $this->result = shell_exec("crontab -u {$user} -l");
        $this->result = "Cron has been set up successful \n {$this->result}";
    }


    abstract function process(Site $site);
}
