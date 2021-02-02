<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\Deploy;
use App\Models\Site;
use Illuminate\Http\Request;

class DeployController extends Controller
{

    public function index(Site $site)
    {
        if(empty($site->getDeployScript()) && !empty($site->getRepository())){
            $site->update([
                'deploy_script' => view('dashboard.deploy.script', compact('site'))
            ]);
        }

        return view('dashboard.deploy.index', compact('site'));
    }


    public function deploy(Site $site)
    {
        Deploy::dispatch($site);

        return redirect()->route('deploy', ['site' => $site]);
    }
}
