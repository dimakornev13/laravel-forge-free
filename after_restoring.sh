#!/bin/bash

panel=/home/forge/panel/
site=/home/fssp-russia.ru/www/

cd $panel
git fetch && git reset --hard && git pull


sudo sed -i 's/default/194\.67\.92\.48/g' /etc/nginx/sites-available/panel
sudo service nginx restart

sudo sed -i 's/DB_DATABASE=homestead/DB_DATABASE=panel/g' .env
sudo sed -i 's/DB_USERNAME=homestead/DB_USERNAME=forge/g' .env
sudo sed -i 's/DB_PASSWORD=secret/DB_PASSWORD=asd/g' .env

php artisan config:cache
php artisan queue:restart

npm run production
