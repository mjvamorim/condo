# meu_arquivo_de_lote
#!/bin/sh
DATA=`/bin/date +%Y%m%d`
# variáveis do MySQL
HOST="localhost"
USER="root"
PASSWORD="root"
DB=$1
FILE=$2
echo $DB
echo $FILE
mysql -u $USER -p$PASSWORD -e "drop database if exists $DB" > /dev/null
mysql -u $USER -p$PASSWORD -e "create database $DB" > /dev/null
mysql -u $USER -p$PASSWORD  $DB < $FILE> /dev/null
