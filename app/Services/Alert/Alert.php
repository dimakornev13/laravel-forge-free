<?php

namespace App\Services\Alert;

class Alert
{

    static function success(string $message)
    {
        request()->session()->push('alerts.success', $message);
    }

    static function error(string $message)
    {
        request()->session()->push('alerts.error', $message);
    }

    static function getSuccesses(): array
    {
        return request()->session()->pull('alerts.success', []);
    }

    static function getErrors(): array
    {
        return request()->session()->pull('alerts.error', []);
    }
}
