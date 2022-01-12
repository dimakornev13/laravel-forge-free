<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Nginx\ServerRestart;

class NginxController extends Controller
{

    function restart()
    {
        /** @var ServerRestart $command */
        $command = resolve(ServerRestart::class);
        $command->process();

        return redirect()->back();
    }
}
