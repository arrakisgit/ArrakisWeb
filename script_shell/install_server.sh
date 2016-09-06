sudo apt-get update
sudo apt-get upgrade
sudo apt-get install apache2
sudo chown -R www-data:pi /var/www/html/
sudo chmod -R 770 /var/www/html/
sudo apt-get install php5 mysql-server libapache2-mod-php5 php5-mysql php5-curl
sudo rm /var/www/html/index.html
sudo service apache2 start
