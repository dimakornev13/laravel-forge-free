sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
php {{ $site->getSiteDir() }}/artisan queue:restart
