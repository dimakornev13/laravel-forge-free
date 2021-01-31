#/bin/bash

if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root."

   exit 1
fi



# sudo sed -i "s/#precedence ::ffff:0:0\/96  100/precedence ::ffff:0:0\/96  100/" /etc/gai.conf

# Configure Swap Disk

if [ -f /swapfile ]; then
    echo "Swap exists."
else
    fallocate -l 1G /swapfile
    chmod 600 /swapfile
    mkswap /swapfile
    swapon /swapfile
    echo "/swapfile none swap sw 0 0" >> /etc/fstab
    echo "vm.swappiness=30" >> /etc/sysctl.conf
    echo "vm.vfs_cache_pressure=50" >> /etc/sysctl.conf
fi

# Upgrade The Base Packages

export DEBIAN_FRONTEND=noninteractive

apt-get update



apt-get upgrade -y



# Add A Few PPAs To Stay Current

apt-get install -y software-properties-common

# apt-add-repository ppa:fkrull/deadsnakes-python2.7 -y
# apt-add-repository ppa:nginx/mainline -y
apt-add-repository ppa:ondrej/nginx -y
# apt-add-repository ppa:chris-lea/redis-server -y
apt-add-repository ppa:ondrej/php -y


# Update Package Lists



apt-get update
# Base Packages



add-apt-repository universe

apt-get install -y build-essential curl pkg-config fail2ban gcc g++ git libmcrypt4 libpcre3-dev \
make python3 python3-pip sendmail supervisor ufw zip unzip whois zsh ncdu awscli uuid-runtime acl libpng-dev libmagickwand-dev

# Install Python Httpie

pip3 install httpie

# Disable Password Authentication Over SSH

sed -i "/PasswordAuthentication yes/d" /etc/ssh/sshd_config
echo "" | sudo tee -a /etc/ssh/sshd_config
echo "" | sudo tee -a /etc/ssh/sshd_config
echo "PasswordAuthentication no" | sudo tee -a /etc/ssh/sshd_config

# Restart SSH

ssh-keygen -A
service ssh restart

# Set The Hostname If Necessary


# echo "mythic-cavern" > /etc/hostname
# sed -i 's/127\.0\.0\.1.*localhost/127.0.0.1	mythic-cavern.localdomain mythic-cavern localhost/' /etc/hosts
# hostname mythic-cavern


# Set The Timezone

# ln -sf /usr/share/zoneinfo/UTC /etc/localtime
ln -sf /usr/share/zoneinfo/UTC /etc/localtime

# Create The Root SSH Directory If Necessary

if [ ! -d /root/.ssh ]
then
	mkdir -p /root/.ssh
	touch /root/.ssh/authorized_keys
fi

# Setup Forge User

useradd forge
mkdir -p /home/forge/.ssh
mkdir -p /home/forge/.forge
adduser forge sudo

# Setup Bash For Forge User

chsh -s /bin/bash forge
cp /root/.profile /home/forge/.profile
cp /root/.bashrc /home/forge/.bashrc

# Set The Sudo Password For Forge

PASSWORD=$(mkpasswd -m sha-512 S38o6FTjaG6YeCozPf4h)
usermod --password $PASSWORD forge

# Build Formatted Keys &amp; Copy Keys To Forge


# cat > /root/.ssh/authorized_keys << EOF
# Laravel Forge
# ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCxGOt8yAydHsabuioBejak4R4WfeIsV1F30bB867/fDIH9WgYkDnbCT9nRD1mYDW8JR4Dq16aZuMEs0Gdd4CuOW6lYt229GIHN96dEBqcrBzS8ID51/Nj1UHSquvvKkTbfEOT7uIomOuJVgs48AfCjmcsW9GyK2CJrAQtgvVFUXUsBNVAH289g8Xrqgmf5p4FPvHpdf0nEZA79X9wADAODpZeAP8P80M2Po1ZWRWpPWSrlHKUtJQldBz7n3e6DTeXdj3yD4mUgdP2lyYQD63bfRFzX/tKBG/yXRcMUjIUsn/3ZPQRJkLO9SRloDAM7pqsT3jwFBHOREn6g963deYab worker@forge.laravel.com


# EOF


cp /root/.ssh/authorized_keys /home/forge/.ssh/authorized_keys

# Create The Server SSH Key

ssh-keygen -f /home/forge/.ssh/id_rsa -t rsa -N ''

# Copy Source Control Public Keys Into Known Hosts File

ssh-keyscan -H github.com >> /home/forge/.ssh/known_hosts
ssh-keyscan -H bitbucket.org >> /home/forge/.ssh/known_hosts
ssh-keyscan -H gitlab.com >> /home/forge/.ssh/known_hosts

# Configure Git Settings

git config --global user.name "Dima"
git config --global user.email "dimakornev13@yandex.ru"

# Add The Reconnect Script Into Forge Directory

# cat > /home/forge/.forge/reconnect << EOF
#!/usr/bin/env bash

# echo "# Laravel Forge" | tee -a /home/forge/.ssh/authorized_keys > /dev/null
# echo \$1 | tee -a /home/forge/.ssh/authorized_keys > /dev/null

# echo "# Laravel Forge" | tee -a /root/.ssh/authorized_keys > /dev/null
# echo \$1 | tee -a /root/.ssh/authorized_keys > /dev/null

# echo "Keys Added!"
# EOF

# Setup Forge Home Directory Permissions

chown -R forge:forge /home/forge
chmod -R 755 /home/forge
chmod 700 /home/forge/.ssh/id_rsa

# Setup UFW Firewall

ufw allow 22
ufw allow 80
ufw allow 443
ufw --force enable

# Allow FPM Restart

echo "forge ALL=NOPASSWD: /usr/sbin/service php8.0-fpm reload" > /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.4-fpm reload" > /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.3-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.2-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.1-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.0-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php5.6-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php5-fpm reload" >> /etc/sudoers.d/php-fpm

# Allow Nginx Reload

echo "forge ALL=NOPASSWD: /usr/sbin/service nginx *" >> /etc/sudoers.d/nginx

# Allow Supervisor Reload

echo "forge ALL=NOPASSWD: /usr/bin/supervisorctl *" >> /etc/sudoers.d/supervisor



#
# REQUIRES:
#       - server (the forge server instance)
#

# Install Base PHP Packages

apt-get install -y php7.4-cli php7.4-fpm php7.4-dev \
php7.4-pgsql php7.4-sqlite3 php7.4-gd \
php7.4-curl php7.4-memcached \
php7.4-imap php7.4-mysql php7.4-mbstring \
php7.4-xml php7.4-zip php7.4-bcmath php7.4-soap \
php7.4-intl php7.4-readline php7.4-msgpack php7.4-igbinary php7.4-gmp

# Install Composer Package Manager

if [ ! -f /usr/local/bin/composer ]; then
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
fi

# Misc. PHP CLI Configuration

sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.4/cli/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.4/cli/php.ini
sudo sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.4/cli/php.ini
sudo sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.4/cli/php.ini
sudo sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.4/cli/php.ini

# Ensure PHPRedis Extension Is Available

echo "Configuring PHPRedis"
echo "extension=redis.so" > /etc/php/7.4/mods-available/redis.ini
yes '' | apt install php-redis

# Ensure Imagick Is Available

echo "Configuring Imagick"

apt-get install -y libmagickwand-dev
echo "extension=imagick.so" > /etc/php/7.4/mods-available/imagick.ini
yes '' | apt install php-imagick

# Configure FPM Pool Settings

sed -i "s/^user = www-data/user = forge/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/^group = www-data/group = forge/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;listen\.owner.*/listen.owner = forge/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;listen\.group.*/listen.group = forge/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;request_terminate_timeout.*/request_terminate_timeout = 60/" /etc/php/7.4/fpm/pool.d/www.conf

# Ensure Sudoers Is Up To Date

LINE="ALL=NOPASSWD: /usr/sbin/service php7.4-fpm reload"
FILE="/etc/sudoers.d/php-fpm"
grep -qF -- "forge $LINE" "$FILE" || echo "forge $LINE" >> "$FILE"

# Configure Sessions Directory Permissions

chmod 733 /var/lib/php/sessions
chmod +t /var/lib/php/sessions

# Write Systemd File For Linode

update-alternatives --set php /usr/bin/php7.4

#
# REQUIRES:
#       - server (the forge server instance)
#		- site_name (the name of the site folder)
#

# Install Nginx &amp; PHP-FPM
apt-get install -y nginx

systemctl enable nginx.service

# Generate dhparam File

openssl dhparam -out /etc/nginx/dhparams.pem 2048

# Tweak Some PHP-FPM Settings

sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.4/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.4/fpm/php.ini
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.4/fpm/php.ini
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.4/fpm/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.4/fpm/php.ini

# Configure FPM Pool Settings

sed -i "s/^user = www-data/user = forge/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/^group = www-data/group = forge/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;listen\.owner.*/listen.owner = forge/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;listen\.group.*/listen.group = forge/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;request_terminate_timeout.*/request_terminate_timeout = 60/" /etc/php/7.4/fpm/pool.d/www.conf

# Configure Primary Nginx Settings

sed -i "s/user www-data;/user forge;/" /etc/nginx/nginx.conf
sed -i "s/worker_processes.*/worker_processes auto;/" /etc/nginx/nginx.conf
sed -i "s/# multi_accept.*/multi_accept on;/" /etc/nginx/nginx.conf
sed -i "s/# server_names_hash_bucket_size.*/server_names_hash_bucket_size 128;/" /etc/nginx/nginx.conf

# Configure Gzip

cat > /etc/nginx/conf.d/gzip.conf << EOF
gzip_comp_level 5;
gzip_min_length 256;
gzip_proxied any;
gzip_vary on;
gzip_http_version 1.1;

gzip_types
application/atom+xml
application/javascript
application/json
application/ld+json
application/manifest+json
application/rss+xml
application/vnd.geo+json
application/vnd.ms-fontobject
application/x-font-ttf
application/x-web-app-manifest+json
application/xhtml+xml
application/xml
font/opentype
image/bmp
image/svg+xml
image/x-icon
text/cache-manifest
text/css
text/plain
text/vcard
text/vnd.rim.location.xloc
text/vtt
text/x-component
text/x-cross-domain-policy;

EOF

# Disable The Default Nginx Site

rm /etc/nginx/sites-enabled/default
rm /etc/nginx/sites-available/default
service nginx restart

# Install A Catch All Server

cat > /etc/nginx/sites-available/000-catch-all << EOF
server {
    return 404;
}
EOF

ln -s /etc/nginx/sites-available/000-catch-all /etc/nginx/sites-enabled/000-catch-all

# Restart Nginx &amp; PHP-FPM Services

# Restart Nginx &amp; PHP-FPM Services

#service nginx restart
service nginx reload

if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
then
    service php8.0pm restart > /dev/null 2>&amp;1
    service php7.4-fpm restart > /dev/null 2>&amp;1
fi

# Add Forge User To www-data Group

usermod -a -G www-data forge
id forge
groups forge




curl --silent --location https://deb.nodesource.com/setup_12.x | bash -

apt-get update

sudo apt-get install -y nodejs

npm install -g pm2
npm install -g gulp
npm install -g yarn

#
# REQUIRES:
#		- server (the forge server instance)
#		- db_password (random password for mysql user)
#

# Set The Automated Root Password

export DEBIAN_FRONTEND=noninteractive

# todo mariadb set up



# Install &amp; Configure Redis Server

apt-get install -y redis-server
sed -i 's/bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf
service redis-server restart
systemctl enable redis-server

yes '' | pecl install -f redis

# Ensure PHPRedis extension is available
if pecl list | grep redis >/dev/null 2>&amp;1;
then
echo "Configuring PHPRedis"
echo "extension=redis.so" > /etc/php/7.4/mods-available/redis.ini
yes '' | apt install php7.4-redis

fi



# Install &amp; Configure Memcached

apt-get install -y memcached
sed -i 's/-l 127.0.0.1/-l 0.0.0.0/' /etc/memcached.conf
service memcached restart

# Configure Supervisor Autostart

systemctl enable supervisor.service
service supervisor start

# Disable protected_regular

sudo sed -i "s/fs.protected_regular = .*/fs.protected_regular = 0/" /usr/lib/sysctl.d/protect-links.conf

sysctl --system

# Setup Unattended Security Upgrades



apt-get install -y unattended-upgrades

cat > /etc/apt/apt.conf.d/50unattended-upgrades << EOF
Unattended-Upgrade::Allowed-Origins {
    "Ubuntu focal-security";
};
Unattended-Upgrade::Package-Blacklist {
    //
};
EOF

cat > /etc/apt/apt.conf.d/10periodic << EOF
APT::Periodic::Update-Package-Lists "1";
APT::Periodic::Download-Upgradeable-Packages "1";
APT::Periodic::AutocleanInterval "7";
APT::Periodic::Unattended-Upgrade "1";
EOF

echo "chose 'no'"
echo "If you don't do this, the ISPConfig installation will fail."
dpkg-reconfigure dash


service apparmor stop
update-rc.d -f apparmor remove
apt-get remove apparmor apparmor-utils -y


# Setup MariaDB Repositories

apt install mariadb-client mariadb-server -y

sed -i 's/bind-address/\#bind-address/g' /etc/mysql/mariadb.conf.d/50-server.cnf
mysql_secure_installation

# default mariadb password will be 5IXes316KEdf
service mysql restart