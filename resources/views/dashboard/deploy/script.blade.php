<?php
/** @var \App\Models\Site $site */
?>
ROOT_PATH=/home/{{ getHostUser() }}/{{ $site->getUrl() }}
DEPLOY_DIR=$(date "+%d.%m.%y-%H:%M.%s")

git clone {{ $site->getRepository() }} --single-branch $ROOT_PATH/$DEPLOY_DIR 2>&1

export COMPOSER_HOME="$HOME/.config/composer";
COMPOSER_MEMORY_LIMIT=-1 composer install --no-interaction --prefer-dist --working-dir=$ROOT_PATH/$DEPLOY_DIR 2>&1
COMPOSER_MEMORY_LIMIT=-1 composer dump-autoload --no-interaction --optimize-autoloader --no-dev --working-dir=$ROOT_PATH/$DEPLOY_DIR 2>&1

yarn --cwd $ROOT_PATH/$DEPLOY_DIR install 2>&1 && yarn --cwd $ROOT_PATH/$DEPLOY_DIR run production 2>&1

# handle storage directory
if [ ! -d $ROOT_PATH/storage ]; then
    cp -r $ROOT_PATH/$DEPLOY_DIR/storage $ROOT_PATH/storage
fi

rm -rf $ROOT_PATH/$DEPLOY_DIR/storage
ln -sfn $ROOT_PATH/storage $ROOT_PATH/$DEPLOY_DIR

ln -sfn $ROOT_PATH/.env $ROOT_PATH/$DEPLOY_DIR

sudo service php7.4-fpm reload 2>&1

# todo opcache enable
php $ROOT_PATH/$DEPLOY_DIR/artisan migrate --force 2>&1
php $ROOT_PATH/$DEPLOY_DIR/artisan config:cache 2>&1
php $ROOT_PATH/$DEPLOY_DIR/artisan route:cache 2>&1
php $ROOT_PATH/$DEPLOY_DIR/artisan view:cache 2>&1

rm -rf $ROOT_PATH/www
ln -sfn -T $ROOT_PATH/$DEPLOY_DIR $ROOT_PATH/www
