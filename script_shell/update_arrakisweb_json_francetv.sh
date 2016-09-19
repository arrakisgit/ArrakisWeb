cd /var/www/html/ArrakisWeb_Lib/libs_json
wget http://webservices.francetelevisions.fr/catchup/flux/flux_main.zip
rm /var/www/html/ArrakisWeb_Lib/libs_json/FranceTV/*.json
unzip flux_main.zip -d /var/www/html/ArrakisWeb_Lib/libs_json/FranceTV
rm flux_main.zip