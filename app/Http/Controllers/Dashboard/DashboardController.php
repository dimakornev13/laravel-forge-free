<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\LogEvent;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $entities = LogEvent::orderByDesc('id')->paginate(30);

        return view('dashboard', compact('entities'));
    }
}
