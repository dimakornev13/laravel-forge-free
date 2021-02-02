<?php
/** @var \App\Models\Site $site */
?>
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php {{ $site->getSiteDir() }}/artisan queue:work --sleep=3 --tries=1 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user={{ getHostUser() }}
numprocs=8
redirect_stderr=true
stopwaitsecs=3600
