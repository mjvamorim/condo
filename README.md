# Configurar arquivo .env
cp .env.localhost .env
# baixar pacotes e executar a api
composer clearcache
composer update
php artisan config:cache
php artisan serve
npm install
npm run watch

# reiniciar a fila 
sudo supervisorctl stop all
php artisan queue:retry 43
php artisan queue:work

## Tarefas
Proprietarios
   - Conjuge
   

## Vue passo a passo
Criar uma página para cada opçao do menu
   a) Criar o arquivo na pasta pages, copiar do Dashboard.vue
   b) Importar página
   c) Criar rota
   d) Alterar sidebar, link para rota


# Tarefas
- Diminuir fonte do menu
- Baixas Bancárias
- Log de Baixas

# Tarefas concluidas
- Emails enviados
- Manual do Usuário 
- Gerar Remessa 



