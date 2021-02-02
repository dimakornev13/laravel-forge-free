<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Queue extends Model
{
    use HasFactory;

    protected $table = 'queues';

    protected $fillable = [
        'timeout',
        'rest_seconds_when_empty',
        'failed_job_delay',
        'processes',
        'tries',
        'site_id'
    ];

    protected $guarded = ['*'];


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

    function getPath(){
        return "/etc/supervisor/conf.d/{$this->site->getUrl()}-{$this->id}";
    }

    function site()
    {
        return $this->belongsTo(Site::class);
    }
}
