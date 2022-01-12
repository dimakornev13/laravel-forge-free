#/bin/bash
# wget https://raw.githubusercontent.com/moxyrus/laravel-web-panel-hosting/master/install.sh && bash install.sh

if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root."

   exit 1
fi

echo "Enter email (login) for panel: "
read LOGIN

echo "Enter password for panel: "
read LOGIN_PASSWORD

echo "Enter system user password (Forge user): "
read FORGE_PASSWORD

echo "Enter ip (for nginx work): "
read IP_HOST

echo "Enter mysql root password: "
read MYSQL_ROOT_PASSWORD

echo "Enter mysql user password: "
read MYSQL_USER_PASSWORD

echo "Enter SSH public key (it can be obtained like 'cat ~/.ssh/id_rsa.pub'): "
read SSH_KEY

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
make python3 python3-pip supervisor ufw zip unzip whois zsh ncdu awscli uuid-runtime acl libpng-dev libmagickwand-dev \
whois snapd mc

#apt-get install -y sendmail

#LOGIN_PASSWORD=$(htpasswd -bnBC 10 "" $LOGIN_PASSWORD | tr -d ':\n')

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

PASSWORD=$(mkpasswd -m sha-512 $FORGE_PASSWORD)
usermod --password $PASSWORD forge

# Build Formatted Keys &amp; Copy Keys To Forge


cat > /root/.ssh/authorized_keys << EOF
# Your PC
$SSH_KEY

EOF


cp /root/.ssh/authorized_keys /home/forge/.ssh/authorized_keys

# Create The Server SSH Key

ssh-keygen -f /home/forge/.ssh/id_rsa -t rsa -N ''

# Copy Source Control Public Keys Into Known Hosts File

ssh-keyscan -H github.com >> /home/forge/.ssh/known_hosts
ssh-keyscan -H bitbucket.org >> /home/forge/.ssh/known_hosts
ssh-keyscan -H gitlab.com >> /home/forge/.ssh/known_hosts

# Setup Forge Home Directory Permissions

chown -R forge:forge /home/forge
chmod -R 755 /home/forge
chmod 700 /home/forge/.ssh/id_rsa

# Setup UFW Firewall

ufw allow 22
ufw allow 80
ufw allow 443
ufw allow 3306
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


echo "forge ALL=NOPASSWD: /usr/bin/certbot *" >> /etc/sudoers.d/certbot

# Allow Nginx Reload

echo "forge ALL=NOPASSWD: /usr/sbin/service nginx *" >> /etc/sudoers.d/nginx

# Allow Supervisor Reload

echo "forge ALL=NOPASSWD: /usr/bin/supervisorctl *" >> /etc/sudoers.d/supervisor



#
# REQUIRES:
#       - server (the forge server instance)
#

# Install Base PHP Packages

apt-get install -y php8.0-cli php8.0-fpm php8.0-dev \
php8.0-pgsql php8.0-sqlite3 php8.0-gd \
php8.0-curl php8.0-memcached \
php8.0-imap php8.0-mysql php8.0-mbstring \
php8.0-xml php8.0-zip php8.0-bcmath php8.0-soap \
php8.0-intl php8.0-readline php8.0-msgpack php8.0-igbinary php8.0-gmp

# Install Composer Package Manager

if [ ! -f /usr/local/bin/composer ]; then
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
fi

# Misc. PHP CLI Configuration

sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/8.0/cli/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php/8.0/cli/php.ini
sudo sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/8.0/cli/php.ini
sudo sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/8.0/cli/php.ini
sudo sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/8.0/cli/php.ini

# Ensure PHPRedis Extension Is Available

echo "Configuring PHPRedis"
echo "extension=redis.so" > /etc/php/8.0/mods-available/redis.ini
sudo apt install php-redis -y

# Ensure Imagick Is Available

echo "Configuring Imagick"

apt-get install -y libmagickwand-dev
echo "extension=imagick.so" > /etc/php/8.0/mods-available/imagick.ini
sudo apt install php-imagick -y

# Configure FPM Pool Settings

sed -i "s/^user = www-data/user = forge/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/^group = www-data/group = forge/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/;listen\.owner.*/listen.owner = forge/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/;listen\.group.*/listen.group = forge/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/;request_terminate_timeout.*/request_terminate_timeout = 60/" /etc/php/8.0/fpm/pool.d/www.conf

# Configure Sessions Directory Permissions

chmod 733 /var/lib/php/sessions
chmod +t /var/lib/php/sessions

# Write Systemd File For Linode

update-alternatives --set php /usr/bin/php8.0

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

sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/8.0/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/8.0/fpm/php.ini
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/8.0/fpm/php.ini
sed -i "s/memory_limit = .*/memory_limit = 32M/" /etc/php/8.0/fpm/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/8.0/fpm/php.ini

# Configure FPM Pool Settings

sed -i "s/^user = www-data/user = forge/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/^group = www-data/group = forge/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/;listen\.owner.*/listen.owner = forge/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/;listen\.group.*/listen.group = forge/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/8.0/fpm/pool.d/www.conf
sed -i "s/;request_terminate_timeout.*/request_terminate_timeout = 60/" /etc/php/8.0/fpm/pool.d/www.conf

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

#service nginx restart

# Install A Catch All Server

#cat > /etc/nginx/sites-available/000-catch-all << EOF
#server {
#    return 404;
#}
#EOF
#
#ln -s /etc/nginx/sites-available/000-catch-all /etc/nginx/sites-enabled/000-catch-all

service nginx restart

if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
then
    service php8.0-fpm restart > /dev/null 2>&amp;1
fi

# Add Forge User To www-data Group

usermod -a -G www-data forge
id forge
groups forge




curl --silent --location https://deb.nodesource.com/setup_16.x | bash -

apt-get update

sudo apt-get install -y nodejs

npm install -g pm2
npm install -g gulp
npm install -g yarn
npm install -g cross-env

#
# REQUIRES:
#		- server (the forge server instance)
#		- db_password (random password for mysql user)
#

# Set The Automated Root Password

export DEBIAN_FRONTEND=noninteractive

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
echo "extension=redis.so" > /etc/php/8.0/mods-available/redis.ini
sudo apt install php8.0-redis -y

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


#
#service apparmor stop
#update-rc.d -f apparmor remove
#apt-get remove apparmor apparmor-utils -y


# make able laravel work with next directories
chmod -R 777 /etc/nginx/sites-available /etc/nginx/sites-enabled /etc/supervisor/conf.d

# git clone to panel directory
PATH_TO_PANEL=/home/forge/panel
git clone https://github.com/moxyrus/laravel-web-panel-hosting.git $PATH_TO_PANEL

# mysql section
# Setup MariaDB Repositories

curl -LsS https://downloads.mariadb.com/MariaDB/mariadb_repo_setup | sudo bash

debconf-set-selections <<< "mariadb-server mysql-server/data-dir select ''"
debconf-set-selections <<< "mariadb-server mysql-server/root_password password secret"
debconf-set-selections <<< "mariadb-server mysql-server/root_password_again password secret"
touch /etc/mysql/debian.cnf

apt-get update && apt-get install mariadb-client mariadb-server -y

sed -i 's/bind-address/\#bind-address/g' /etc/mysql/mariadb.conf.d/50-server.cnf
#mysql_secure_installation

mysql -u root -e "UPDATE mysql.user SET Password=PASSWORD('$MYSQL_ROOT_PASSWORD') WHERE User='root'"
mysql -u root -e "DELETE FROM mysql.user WHERE User=''"
mysql -u root -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1')"
mysql -u root -e "DROP DATABASE IF EXISTS test"
mysql -u root -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%'"
mysql -u root -e "CREATE DATABASE IF NOT EXISTS panel CHARACTER SET = 'utf8' COLLATE = 'utf8_general_ci'"
mysql -u root -e "GRANT ALL privileges ON *.* TO 'forge'@'%' IDENTIFIED BY '$MYSQL_USER_PASSWORD'"
mysql -u root -e "FLUSH PRIVILEGES"

composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --working-dir=$PATH_TO_PANEL

npm install --prefix $PATH_TO_PANEL && npm run production --prefix $PATH_TO_PANEL

sed -i "s/DB_DATABASE=homestead/DB_DATABASE=panel/g" $PATH_TO_PANEL/.env
sed -i "s/homestead/forge/g" $PATH_TO_PANEL/.env
sed -i "s/secret/$MYSQL_USER_PASSWORD/g" $PATH_TO_PANEL/.env

php $PATH_TO_PANEL/artisan key:generate
php $PATH_TO_PANEL/artisan migrate
php $PATH_TO_PANEL/artisan make:admin $LOGIN $LOGIN_PASSWORD
# line below prevent issue when address to another laravel project
# and it has the same env because DOTENV
php $PATH_TO_PANEL/artisan config:cache
# line below prevent the problem described before but for queues (i.e. deploy)
php $PATH_TO_PANEL/artisan queue:restart


#mysql -u root -e "INSERT INTO panel.users (name, email, password) VALUES('$LOGIN', '$LOGIN', '$LOGIN_PASSWORD')"


# nginx default file for panel

rm /etc/nginx/sites-enabled/default
rm /etc/nginx/sites-available/default

cp $PATH_TO_PANEL/templates/panel /etc/nginx/sites-available/
sed -i "s/default/$IP_HOST/g" /etc/nginx/sites-available/panel
ln -s /etc/nginx/sites-available/panel /etc/nginx/sites-enabled/

chown -R forge:forge $PATH_TO_PANEL
chmod -R 775 $PATH_TO_PANEL

# fix problem when composer cannot make this folder in home directory
mkdir /home/forge/.composer
chown -R forge:forge /home/forge/.composer

cp $PATH_TO_PANEL/templates/panel-supervisor.conf /etc/supervisor/conf.d
supervisorctl reread
supervisorctl update
supervisorctl start all

(echo "* * * * * /usr/bin/php $PATH_TO_PANEL/artisan schedule:run >> /dev/null 2>&1") | crontab -u forge -

#service mysql restart
#service nginx restart
#service php8.0-fpm restart

reboot now

# after restart
# work for snap
sudo snap install core && sudo snap refresh core && sudo snap install --classic certbot && sudo ln -s /snap/bin/certbot /usr/bin/certbot
