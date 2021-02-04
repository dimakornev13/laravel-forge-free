#!/bin/bash

if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root."

   exit 1
fi

echo "vagrant ALL=NOPASSWD: /usr/sbin/service php8.0-fpm reload" >> /etc/sudoers.d/php-fpm
echo "vagrant ALL=NOPASSWD: /usr/sbin/service php7.4-fpm reload" >> /etc/sudoers.d/php-fpm
echo "vagrant ALL=NOPASSWD: /usr/sbin/service php7.3-fpm reload" >> /etc/sudoers.d/php-fpm
echo "vagrant ALL=NOPASSWD: /usr/sbin/service php7.2-fpm reload" >> /etc/sudoers.d/php-fpm
echo "vagrant ALL=NOPASSWD: /usr/sbin/service php7.1-fpm reload" >> /etc/sudoers.d/php-fpm
echo "vagrant ALL=NOPASSWD: /usr/sbin/service php7.0-fpm reload" >> /etc/sudoers.d/php-fpm
echo "vagrant ALL=NOPASSWD: /usr/sbin/service php5.6-fpm reload" >> /etc/sudoers.d/php-fpm
echo "vagrant ALL=NOPASSWD: /usr/sbin/service php5-fpm reload" >> /etc/sudoers.d/php-fpm

# Allow Nginx Reload

echo "vagrant ALL=NOPASSWD: /usr/sbin/service nginx *" >> /etc/sudoers.d/nginx

# Allow Supervisor Reload

echo "vagrant ALL=NOPASSWD: /usr/bin/supervisorctl *" >> /etc/sudoers.d/supervisor

chmod 777 /etc/nginx/sites-available /etc/nginx/sites-enabled
chmod 777 /etc/supervisor/conf.d

# line below prevent issue when address to another laravel project
# and it has the same env because DOTENV
php /home/$USER/panel/artisan config:cache
# line below prevent the problem described before but for queues (i.e. deploy)
php /home/$USER/panel/artisan queue:restart

echo 'DONE'
