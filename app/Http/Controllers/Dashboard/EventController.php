<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\LogEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    function delete(LogEvent $event)
    {
        $event->delete();

        return redirect()->route('dashboard');
    }
}
