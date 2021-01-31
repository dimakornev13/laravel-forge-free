<?php

namespace App\Repositories;

use App\Events\SiteCreated;
use App\Events\SiteDeleted;
use App\Models\Site;

/**
 * Class SitesRepository
 * @property \App\Models\Site $entity
 */
class SitesRepository extends Repository
{

    public function __construct(Site $entity)
    {
        $this->entity = $entity;
    }


    /**
     * @return \App\Models\Site[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableSites()
    {
        return $this->entity::all();
    }


    /**
     * @param Site $site
     * @throws \Exception
     */
    public function delete(Site $site)
    {
        SiteDeleted::dispatch($site);

        $site->delete();
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $site = $this->entity->create($data);

        SiteCreated::dispatch($site);

        return $site;
    }
}
