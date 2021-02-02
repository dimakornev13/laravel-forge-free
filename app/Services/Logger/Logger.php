<?php

namespace App\Services\Logger;

use App\Models\LogEvent;

abstract class Logger
{
    abstract protected function log(int $type, string $message);


    public function success(string $message)
    {
        $this->log(LogEvent::TYPE_SUCCESS, $message);
    }


    public function error(string $message)
    {
        $this->log(LogEvent::TYPE_ERROR, $message);
    }


    public function warning(string $message)
    {
        $this->log(LogEvent::TYPE_WARNING, $message);
    }


    public function info(string $message)
    {
        $this->log(LogEvent::TYPE_NOTIFICATION, $message);
    }
}
