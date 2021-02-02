<?php


namespace App\Repositories;


use App\Events\QueueCreated;
use App\Events\QueueDeleted;
use App\Models\Queue;

class QueueRepository extends Repository
{
    public function __construct(Queue $entity)
    {
        $this->entity = $entity;
    }


    function create(array $data)
    {
        $queue = $this->entity->create($data);

        event(new QueueCreated($queue));

        return $queue;
    }


    function delete(Queue $queue)
    {
        event(new QueueDeleted($queue));

        $queue->delete();
    }
}
