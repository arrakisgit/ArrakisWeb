cd /var/www/html/ArrakisWeb/application/controllers
sudo rm -r lib_php/
sudo rm -r Categories.php
sudo rm -r Shows.php
sudo rm -r Episodes.php
sudo rm -r debug.php
cd /var/www/html/ArrakisWeb/application/views
sudo rm -r Template.php
sudo rm -r view_categories.php
sudo rm -r view_shows.php
sudo rm -r view_episodes.php
sudo rm -r view_debug.php
sudo rm -r bad_file.php
cd /var/www/html/ArrakisWeb/application/ArrakisWeb
sudo cp -R lib_php /var/www/html/ArrakisWeb/application/controllers
cd Controllers
sudo cp -R Categories.php /var/www/html/ArrakisWeb/application/controllers
sudo cp -R Shows.php /var/www/html/ArrakisWeb/application/controllers
sudo cp -R Episodes.php /var/www/html/ArrakisWeb/application/controllers
sudo cp -R debug.php /var/www/html/ArrakisWeb/application/controllers
cd /var/www/html/ArrakisWeb/application/ArrakisWeb/Views
sudo cp -R *.php /var/www/html/ArrakisWeb/application/views
cd /var/www/html/ArrakisWeb/application/ArrakisWeb
sudo rm -r /var/www/html/ArrakisWeb_Lib/libs_css
sudo rm -r /var/www/html/ArrakisWeb_Lib/libs_js
sudo cp -R libs_css /var/www/html/ArrakisWeb_Lib
sudo cp -R libs_js /var/www/html/ArrakisWeb_Lib