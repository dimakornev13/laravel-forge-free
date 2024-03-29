<?php
/** @var \App\Models\Queue $queue */
?>
[program:{{ $queue->site->getCleanUrl() }}{!! $queue->getId() !!}-worker]
process_name=%(program_name)s_%(process_num)02d
command=php {{ $queue->site->getSiteDir() }}/artisan queue:work --queue={!! $queue->getQueue() !!} --tries={!! $queue->getTries() !!}
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user={{ getHostUser() }}
numprocs={{ $queue->getProcesses() }}
stopwaitsecs=3600
