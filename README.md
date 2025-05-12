# Configurar arquivo .env

cp .env.localhost .env

# baixar pacotes e executar a api

composer self-update --2
https://stackoverflow.com/questions/61177995/laravel-packagemanifest-php-undefined-index-name (tutorial para problema de atualizacao composer 1-> 2)

composer clearcache
composer update

php artisan route:clear
php artisan config:clear
#php artisan cache:clear
php artisan config:cache
php artisan serve

export NODE_OPTIONS=--openssl-legacy-provider
npm install
npm run watch

# Testar conexao com bd

php artisan tinker
DB::connection()->getPdo()

# restaurar o backup dos banco de dados

pasta backup/\*.sql

# reiniciar a fila

sudo supervisorctl stop all
php artisan queue:retry 43
php artisan queue:work

# Tarefas

Ok - Unidades -> click -> UnidadesDetalhes

Ok - UnidadesDetalhes: obs, proprietario e salvar na tela inicial, fechar também
