echo off
set "backup_dir=f:/backup/"

set "current_date=%date%"

set "day=%date:~0,2%"
set "month=%date:~3,2%"
set "year=%date:~6,4%"

set "ymd=%year%-%month%-%day%"

set "condo=%backup_dir%/condo-%ymd%.sql"
set "condo3=%backup_dir%/condo3-%ymd%.sql"
echo %condo%
echo %condo3%
mariadb-dump --user=root --password=root --lock-tables --databases condo > %condo%
mariadb-dump --user=root --password=root --lock-tables --databases condo3 > %condo3%
