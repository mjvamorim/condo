#! /bin/bash
composer clearcache
composer update
php artisan config:cache
php artisan serve
