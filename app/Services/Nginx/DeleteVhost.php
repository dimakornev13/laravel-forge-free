<?php


namespace App\Services\Nginx;


use App\Models\Site;

abstract class DeleteVhost extends NginxCommon
{
    abstract public function process(Site $site);
}
