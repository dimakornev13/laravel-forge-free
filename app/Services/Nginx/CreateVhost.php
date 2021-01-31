<?php


namespace App\Services\Nginx;


use App\Models\Site;

abstract class CreateVhost
{
    abstract function process(Site $site);
}
