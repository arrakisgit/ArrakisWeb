#!/bin/sh

cd /var/www/html/ArrakisWeb/application/ArrakisWeb
sudo git pull
cd /var/www/html/ArrakisWeb
sudo rm -r Panel.php
cd /var/www/html/ArrakisWeb/application/ArrakisWeb/ihm
sudo cp -R Panel.php /var/www/html/ArrakisWeb
cd /
sudo rm -r composer.json
cd /var/www/html/ArrakisWeb/application/ArrakisWeb
sudo cp -R composer.json /
cd /var/www/html/ArrakisWeb/application/controllers
sudo rm -r lib_php/
sudo rm -r Categories.php
sudo rm -r Shows.php
sudo rm -r Episodes.php
sudo rm -r Seasons.php
sudo rm -r Watch.php
sudo rm -r debug.php
cd /var/www/html/ArrakisWeb/application/views
sudo rm -r Template.php
sudo rm -r view_categories.php
sudo rm -r view_shows.php
sudo rm -r view_shows_season.php
sudo rm -r view_episodes.php
sudo rm -r view_watch.php
sudo rm -r view_debug.php
sudo rm -r bad_file.php
cd /var/www/html/ArrakisWeb/application/ArrakisWeb
sudo cp -R lib_php /var/www/html/ArrakisWeb/application/controllers
cd Controllers
sudo cp -R Categories.php /var/www/html/ArrakisWeb/application/controllers
sudo cp -R Shows.php /var/www/html/ArrakisWeb/application/controllers
sudo cp -R Seasons.php /var/www/html/ArrakisWeb/application/controllers
sudo cp -R Episodes.php /var/www/html/ArrakisWeb/application/controllers
sudo cp -R Watch.php /var/www/html/ArrakisWeb/application/controllers
sudo cp -R debug.php /var/www/html/ArrakisWeb/application/controllers
cd /var/www/html/ArrakisWeb/application/ArrakisWeb/Views
sudo cp -R *.php /var/www/html/ArrakisWeb/application/views
cd /var/www/html/ArrakisWeb/application/ArrakisWeb
sudo rm -r /var/www/html/ArrakisWeb_Lib/libs_css
sudo rm -r /var/www/html/ArrakisWeb_Lib/libs_js
sudo cp -R libs_css /var/www/html/ArrakisWeb_Lib
sudo cp -R libs_js /var/www/html/ArrakisWeb_Lib
cd /var/www/html/ArrakisWeb/application/controllers/lib_php/
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
cd /var/www/html/ArrakisWeb/application/controllers/lib_php/
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');")
sudo php -r "if (hash_file('SHA384', 'composer-setup.php') === ACTUAL_SIGNATURE) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php
sudo php -r "unlink('composer-setup.php');"
sudo cp -R /var/www/html/ArrakisWeb/application/ArrakisWeb/composer.json /var/www/html/ArrakisWeb/application/controllers/lib_php/
sudo php composer.phar install
cd /var/www/html/ArrakisWeb/application/ArrakisWeb
