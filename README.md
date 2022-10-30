# Configurar arquivo .env
cp .env.localhost .env
# baixar pacotes e executar a api
composer clearcache
composer update
php artisan config:cache
php artisan serve
npm run watch

# reiniciar a fila 
sudo supervisorctl stop all
php artisan queue:retry 43
php artisan queue:work

## Tarefas

-   Debitos
    a) Botao boleto e email errados 
-   Empresa ->
    a) Mostrar apenas a empresa do usuario 
    b) Quando o usuario for administrador, mostrar todas as empresas
-   Usuarios
    a) Opçào só deve ser exibida para administradores
-   Register
    a) solicitar dados da empresa

## Rotas

3 - verificar erro

Tarefas a realizar Felipe
#########################


3. Criar uma página para cada opçao do menu
   a) Criar o arquivo na pasta pages, copiar do Dashboard.vue
   b) Importar página
   c) Criar rota
   d) Alterar sidebar, link para rota
4. Diminuir fonte do menu
5. Paginas
6. Criar Pages (parecida com proprietario trocando os campos)
   a) Proprietário (ok)
   b) Unidade (ok)
   c) Taxa (ok)
   d) Debito (falta)
   e) Email
   f) Acordo (ok)

Tarefas Mauricio
################

1. Testar solução multitenant
2. Criar API
   a) Proprietário (ok)
   b) Unidade (ok)
   c) Taxa
   d) Debito
   e) Email
   f) Acordo
3. Componentes do Vue
   ok a) Mover routes.js
   ok b) Máscara para campos
   ok c) Cep
4. Rotinas Financeiras
   a) Gerar Mensalidades
   b) Gerar Remessa
   c) Baixas Bancárias
   d) Acordo
5. Utilidades
   a) Manual do Usuário
   b) Log de Baixas
   c) Emails enviados
