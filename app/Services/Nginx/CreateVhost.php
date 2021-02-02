<?php


namespace App\Services\Nginx;


use App\Models\Site;

abstract class CreateVhost extends NginxCommon
{
    abstract function process(Site $site);
}
