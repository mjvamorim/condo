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
pasta backup/*.sql

# reiniciar a fila 
sudo supervisorctl stop all
php artisan queue:retry 43
php artisan queue:work



# Tarefas
- Diminuir fonte do menu
- Baixas Bancárias
- Log de Baixas

# Tarefas concluidas
- Emails enviados
- Manual do Usuário 
- Gerar Remessa 



