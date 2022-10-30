#Tenant  1.0.1
This package provider a database tenant soluction which database connection is choice based on empresa/user select on login;

The view empresa references de adminlte master view, then before install this package you must install :
https://github.com/jeroennoten/Laravel-AdminLTE


Add to your composer.json
 "repositories": [
        {
            "type": "path",
            "url": "packages/mjvamorim/subscriptions",
            "options": {
                "symlink": true
            }
        },

cd packages
git clone https://github.com/mjvamorim/tenant.git

composer require mjvamorim/tenant
composer update

php artisan config:cache
php artisan vendor:publish --provider="Amorim\Tenant\TenantServiceProvider"

Edit "/config/database.php" and put your database conections defaults.

'main' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'mydb'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            //'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],
        'tenant' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'mydb').'1',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            //'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],
    





App/Http/Kernel.php

    protected $routeMiddleware = [
        'tenant' => \Amorim\Tenant\Middleware\Tenant::class,


    protected $routeMiddleware = [
        'tenant' => \Amorim\Tenant\Middleware\Tenant::class,

    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \App\Http\Middleware\Tenant::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
        \App\Http\Middleware\CheckPayment::class,
    ];

