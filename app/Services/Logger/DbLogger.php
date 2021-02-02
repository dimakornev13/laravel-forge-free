<?php


namespace App\Services\Logger;


use App\Models\LogEvent;

class DbLogger extends Logger
{

    public function log(int $type, string $message)
    {
        LogEvent::create([
            'type' => $type,
            'content' => str_replace(["\n", "\r"], '<br>', $message)
        ]);
    }
}
