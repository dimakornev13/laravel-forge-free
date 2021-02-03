<?php
/** @var \App\Models\Queue $queue */
?>
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php {{ $queue->site->getSiteDir() }}/artisan queue:work --sleep={{ $queue->getRestSecondsWhenEmpty() }} --tries={{ $queue->getTries() }} --max-time={{ $queue->getTimeout() }}
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user={{ getHostUser() }}
numprocs={{ $queue->getProcesses() }}
stopwaitsecs=3600
