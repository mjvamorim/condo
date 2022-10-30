#Subscriptions  1.0.1
This package ...
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
git clone https://github.com/mjvamorim/subscriptions.git

composer require mjvamorim/subscriptions
composer update

php artisan config:cache

php artisan vendor:publish --provider="Amorim\Tenant\SubscriptionsServiceProvider"

...