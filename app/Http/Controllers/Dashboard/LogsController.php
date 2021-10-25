<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Site;

class LogsController extends Controller
{
    function index(Site $site){
        dump($site);
    }
}
