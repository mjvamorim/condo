cd c:\workspace\pegasus\condo
php artisan config:cache
start /b php artisan serve 
@REM start /b php artisan queue:work --queue=default --tries=3 --timeout=60
start http://localhost:8000
