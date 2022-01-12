<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Supervisor\Supervisor;
use Illuminate\Http\Request;

class SupervisordController extends Controller
{
    function restart(){
        /** @var Supervisor $service */
        $service = resolve(Supervisor::class);
        $service->restart();

        return redirect()->back();
    }
}
