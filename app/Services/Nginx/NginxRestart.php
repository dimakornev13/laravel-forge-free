<?php

namespace App\Services\Nginx;

use App\Services\Alert\Alert;

class NginxRestart extends ServerRestart
{

    function process(): void
    {
        shell_exec('sudo service nginx restart 2>&1') === null
            ? Alert::success('nginx has been restarted successfully')
            : Alert::error('nginx has not been restarted');
    }
}
