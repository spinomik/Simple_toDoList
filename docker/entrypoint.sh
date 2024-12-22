#!/bin/bash


npm install
npm run build
composer install 

echo "Waiting for db starts.. "
sleep 10
php artisan migrate --force
php artisan db:seed --force

#run supervisord
exec supervisord -c /etc/supervisord.conf
exec "$@"
