sudo service supervisor restart

php {{ $site->getSiteDir() }}/artisan queue:restart
