<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sites\Create;
use App\Models\Site;
use App\Repositories\SitesRepository;

class SitesController extends Controller
{
    private $sites;


    public function __construct(SitesRepository $sites)
    {
        $this->sites = $sites;
    }


    public function index()
    {
        $sites = $this->sites->getAvailableSites();

        return view('dashboard.sites.index', compact('sites'));
    }


    public function create()
    {
        $site = $this->sites->getEntity();

        return view('dashboard.sites.create', compact('site'));
    }


    public function update(Site $site)
    {
        $this->sites->update($site, request()->all());

        return redirect()->back();
    }


    public function view(Site $site)
    {
        return redirect()->route('deploy', ['site' => $site]);
    }


    public function store(Create $request)
    {
        return redirect()->route('sites.view', ['site' => $this->sites->create($request->validated())]);
    }


    public function delete(Site $site)
    {
        $this->sites->delete($site);

        return redirect()->route('sites.index');
    }
}
