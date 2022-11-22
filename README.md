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

- Listagem Unidades com (unidade, proprietario, telefone e ramal)
- Quando salvar acertar fonte
  - Vue
  - Php
  - JS
- Passar para Vite
- Colocar ampulheta quando acessar axios

# Tarefas concluidas

- Baixas Bancárias
- Proprietarios Remover mascara Telefone e Celular
- Emails enviados
- Manual do Usuário
- Gerar Remessa
