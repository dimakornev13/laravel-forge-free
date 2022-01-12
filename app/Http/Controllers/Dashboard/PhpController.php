<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Php\PhpRestart;

class PhpController extends Controller
{
    function restart()
    {
        /** @var PhpRestart $service */
        $service = resolve(PhpRestart::class);
        $service->process();

        return redirect()->back();
    }
}
