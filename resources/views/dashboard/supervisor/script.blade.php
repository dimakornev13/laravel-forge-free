sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
php {{ $site->getSiteDir() }}/artisan queue:restart
