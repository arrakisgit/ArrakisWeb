sudo apt-get update
sudo apt-get upgrade
sudo apt-get install apache2
sudo chown -R www-data:pi /var/www/html/
sudo chmod -R 770 /var/www/html/
sudo apt-get install samba
sudo mkdir -p /var/www/html/ArrakisWeb/NASSRV
sudo apt-get install php5 mysql-server libapache2-mod-php5 php5-mysql php5-curl
sudo rm /var/www/html/index.html
sudo service apache2 start
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php
sudo php -r "unlink('composer-setup.php');"
sudo php composer.phar