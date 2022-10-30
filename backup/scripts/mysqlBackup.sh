#!/bin/bash
# mysqlBackup.sh

DATA=`/bin/date +%Y%m%d`

# variáveis do MySQL
HOST="localhost"
USER="root"
PASSWORD="root"

for DB in $(mysql -u$USER -p$PASSWORD -e "show databases like 'condo%' " -s --skip-column-names); do
   echo $DB;
   FILE="/home/ubuntu/backup/Backup-$DB-$DATA.sql"
   mysqldump -h $HOST -u $USER -p$PASSWORD $DB > $FILE
done

