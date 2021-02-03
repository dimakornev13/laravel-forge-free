<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository extends Repository
{
    public function __construct(User $entity)
    {
        $this->entity = $entity;
    }


    public function create(array $data)
    {
        $this->entity->create($data);
    }
}
