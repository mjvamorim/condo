Mac arquivos de configuração
----------------------------
php -> /usr/local/etc;php/7.4/php.ini
    -> /usr/local/etc;php/7.4/conf.d/
    -> /usr/local/etc;php/7.4/php-fpm.conf
    -> /usr/local/etc;php/7.4/php-fpm.d/

Nginx   -> /usr/local/etc/Nginx


Tarefas Dev-Ops:
#################
1 - atualizar ubuntu
2 - atualizar php7.4
sudo apt update
sudo apt upgrade

sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update

sudo apt install php7.4
sudo apt install php7.4-fpm
sudo apt install php7.4-mysql
sudo apt install php7.4-xml

sudo php-fpm7.4 -t
sudo service php7.4-fpm restart
sudo nginx restart

#User 'www' senha sudo 'www'
