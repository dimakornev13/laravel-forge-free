<?php


namespace App\Services\Nginx;


use App\Traits\Result;

abstract class ServerRestart
{
    use Result;

    abstract function process():void;
}
