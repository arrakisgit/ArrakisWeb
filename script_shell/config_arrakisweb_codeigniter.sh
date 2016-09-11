cd /var/www/html/ArrakisWeb/application/controllers
sudo rm -r lib_php/
sudo rm -r Categories.php
cd /var/www/html/ArrakisWeb/application/views
sudo rm -r Template.php
sudo rm -r view_categories.php
cd /var/www/html/ArrakisWeb/application/ArrakisWeb
sudo cp -R lib_php /var/www/html/ArrakisWeb/application/controllers
cd Controllers
sudo cp -R Categories.php /var/www/html/ArrakisWeb/application/controllers
cd /var/www/html/ArrakisWeb/application/ArrakisWeb/Views
sudo cp -R *.php /var/www/html/ArrakisWeb/application/views