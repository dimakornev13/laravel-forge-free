<?php

namespace App\Repositories;

class Repository
{
    protected $entity;


    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
