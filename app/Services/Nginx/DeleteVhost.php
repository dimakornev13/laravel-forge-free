<?php


namespace App\Services\Nginx;


use App\Models\Site;

abstract class DeleteVhost
{
    abstract public function process(Site $site);
}
