<?php


namespace App\Services\Deploy;


use App\Models\Site;
use App\Services\Logger\Logger;

abstract class Deploy
{

    protected $result;

    public function getResult(){
        return $this->result;
    }

    abstract function deploy(Site $site);
}
