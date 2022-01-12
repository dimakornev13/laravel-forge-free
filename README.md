## Free simple alternative for Laravel Forge

Free simple alternative for Laravel Forge. In other words it configure vps pretty fast from zero to ready state manage (web panel):
- sites (domains);
- some config for projects (.env)
- queues
- https for domains (letsencrypt)


### Install
```
wget https://raw.githubusercontent.com/moxyrus/laravel-web-panel-hosting/master/install.sh && sudo bash install.sh
```

### Features
- Non limited domains
- git pull by one click
- Zero down deployment (new directory and then symlink to pulibc dir).
- Easy manager new hosts.
- Default environment: php 8.0, MariaDB, redis, memcache, Nginx.
- Local queues by supervisor.
- Sites certificates by Letsencrypt.

### Todo
- Metrics;
- Manage opcache;
- check cache prefix constant for several diifferent versions;
- bugs;
