<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\CertificateObtain;
use App\Models\Site;
use Illuminate\Http\Request;

class SslController extends Controller
{
    public function index(Site $site)
    {
        return view('dashboard.ssl.index', compact('site'));
    }


    public function store(Site $site)
    {
        dispatch(new CertificateObtain($site));

        return redirect()->route('ssl', ['site' => $site]);
    }
}
