sudo apt-get update
sudo apt-get upgrade
sudo -i
echo 'www-data   ALL=(ALL)   NOPASSWD: ALL'>>/etc/sudoers
sudo apt-get install libavcodec-extra-56
sudo apt-get install libav-tools
sudo apt-get install apache2
sudo sudo apt-get install git
sudo chown -R www-data:pi /var/www/html/
sudo chmod -R 770 /var/www/html/
sudo apt-get install samba
sudo mkdir /var/www/html/ArrakisWeb
sudo mkdir -p /var/www/html/ArrakisWeb/NASSRV
sudo apt-get install php5 mysql-server libapache2-mod-php5 php5-mysql php5-curl
sudo rm /var/www/html/index.html
sudo service apache2 start
cd /
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
php composer.phar