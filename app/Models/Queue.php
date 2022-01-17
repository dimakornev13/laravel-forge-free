<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Queue extends Model
{
    protected $table = 'queues';

    protected $fillable = [
        'timeout',
        'processes',
        'tries',
        'site_id',
        'queue'
    ];

    protected $guarded = ['*'];

    public $timestamps = false;

    function getId()
    {
        return $this->id;
    }

    function getQueue()
    {
        return $this->queue ?? 'default';
    }

    function getTimeout()
    {
        return $this->timeout;
    }


    function getRestSecondsWhenEmpty()
    {
        return $this->rest_seconds_when_empty;
    }


    function getFailedJobDelay()
    {
        return $this->failed_job_delay;
    }


    function getProcesses()
    {
        return $this->processes;
    }


    function getTries()
    {
        return $this->tries;
    }

    function getPath()
    {
        return "/etc/supervisor/conf.d/{$this->site->getUrl()}-{$this->id}.conf";
    }

    function site()
    {
        return $this->belongsTo(Site::class);
    }
}
