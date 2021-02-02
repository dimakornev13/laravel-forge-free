<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Site;
use App\Repositories\QueueRepository;
use Illuminate\Http\Request;

class QueueController extends Controller
{

    private $queues;


    public function __construct(QueueRepository $queues)
    {
        $this->queues = $queues;
    }


    public function index(Site $site)
    {

        $fields = (new Queue())->getFillable();

        return view('dashboard.queue.index', compact('site', 'fields'));
    }


    public function store()
    {
        $this->queues->create(\request()->all());

        return redirect()->route('queue', ['site' => \request('site_id')]);
    }


    public function delete(Queue $queue)
    {
        $this->queues->delete($queue);

        return redirect()->route('queue', ['site' => $queue->site_id]);
    }
}
