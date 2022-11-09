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



# Tarefas
- Diminuir fonte do menu
- Baixas Bancárias

# Tarefas concluidas
- Log de Baixas
- Emails enviados
- Manual do Usuário 
- Gerar Remessa 



