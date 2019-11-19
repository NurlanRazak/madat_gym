#!/bin/bash
PATH=$PATH:/home/nurik/.nvm/versions/node/v12.8.0/bin/:xxx
export PATH

if [ "$1" = "-p" ]; then
    echo "Deploy in PRODUCTION mode"
    composer install --optimize-autoloader --no-dev
else
    echo "Deploy in DEVELOPMENT mode"
    composer dump-autoload
fi

sudo chmod 777 -R storage
sudo chmod 777 -R bootstrap

#php artisan key:generate

if [ "$1" = "-d" ]; then
    php artisan migrate:fresh --force
    php artisan migrate --force
    php artisan db:seed --force
fi

php artisan cache:clear
php artisan config:clear

sudo chmod 777 -R storage
sudo chmod 777 -R bootstrap

#pm2 start queue-worker.yml
