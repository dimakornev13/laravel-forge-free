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



    public function store(Create $request)
    {
        $site = $this->sites->create($request->validated());

        return redirect()->route('sites.index');
    }


    public function delete(Site $site)
    {
        $this->sites->delete($site);

        return redirect()->route('sites.index');
    }
}
