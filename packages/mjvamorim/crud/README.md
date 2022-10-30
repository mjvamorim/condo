#Crud  1.0.1
This is based on datatables 

Add to your composer.json
 "repositories": [
        {
            "type": "path",
            "url": "packages/mjvamorim/crud",
            "options": {
                "symlink": true
            }
        },

cd packages/mjvamorim

git clone https://github.com/mjvamorim/crud.git

cd ../..

composer require mjvamorim/crud

Add in your config/app.php

    Amorim\Crud\CrudServiceProvider::class,
       



composer update

php artisan config:cache


Edit "/config/crud.php" and put your modelName and full_Qualifier_Class

ex:

    return [
        'example' => 'Amorim\Crud\Models\Example',
        'user' => 'App\User',
        'yourmodel' => 'App\YourModel',
    ];


php artisan migrate
php artisan db:seed --class=ExamplesTableSeeder

Run your app and call this route

http://your_site/crud/yourmodel

