# Configurar arquivo .env

cp .env.localhost .env

# baixar pacotes e executar a api

composer clearcache
composer update
php artisan config:cache
php artisan serve
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

- UnidadesDetalhes: obs, proprietario e salvar na tela inicial, fechar também
  Não, apenas agua e luz - Verificar possibilidade de colocar no débito automático os boletos

- Listagem Unidades com (unidade, proprietario, telefone e ramal)
- Passar para Vite
