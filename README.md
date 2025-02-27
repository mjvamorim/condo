# Configurar arquivo .env

cp .env.localhost .env

# baixar pacotes e executar a api

composer clearcache
composer update
php artisan config:cache
php artisan serve

export NODE_OPTIONS=--openssl-legacy-provider
npm install
npm run watch

# restaurar o backup dos banco de dados

pasta backup/\*.sql

# reiniciar a fila

sudo supervisorctl stop all
php artisan queue:retry 43
php artisan queue:work

# Tarefas

Ok - Unidades -> click -> UnidadesDetalhes

Ok - UnidadesDetalhes: obs, proprietario e salvar na tela inicial, fechar também
