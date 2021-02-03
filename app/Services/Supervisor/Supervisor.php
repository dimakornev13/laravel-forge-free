<?php


namespace App\Services\Supervisor;


use App\Models\Queue;
use App\Models\Site;

class Supervisor
{

    private $result;


    function reload(Site $site)
    {
        $this->result = shell_exec(view('dashboard.supervisor.script', compact('site')));
    }


    function delete(Queue $queue)
    {
        unlink($queue->getPath());

        if(file_exists($queue->getPath()))
            throw new \Error("File {$queue->getPath()} has not been deleted");

        $this->reload($queue->site);
    }


    function add(Queue $queue)
    {
        $config = view('dashboard.queue.script', compact('queue'));

        $result = file_put_contents($queue->getPath(), $config);

        if($result === false)
            throw new \Error("File {$queue->getPath()} has not been created");

        $this->reload($queue->site);
    }


    function getResult()
    {
        return $this->result;
    }
}
