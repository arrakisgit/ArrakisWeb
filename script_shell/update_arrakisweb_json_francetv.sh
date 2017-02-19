#!/bin/sh

sudo cd /var/www/html/ArrakisWeb_Lib/libs_json
sudo wget http://webservices.francetelevisions.fr/catchup/flux/flux_main.zip
sudo rm /var/www/html/ArrakisWeb_Lib/libs_json/FranceTV/*.json
sudo unzip flux_main.zip -d /var/www/html/ArrakisWeb_Lib/libs_json/FranceTV
sudo rm flux_main.zip
