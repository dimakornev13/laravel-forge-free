<?php

namespace App\Services\Php;

use App\Services\Alert\Alert;

class PhpRestart
{
    function process()
    {
        shell_exec('sudo service php8.0-fpm restart 2>&1') === null
            ? Alert::success('php8.0-fpm has been restarted successfully')
            : Alert::error('php8.0-fpm has not been restarted');
    }
}
