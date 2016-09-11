<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 10:25 PM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les catégories des chaînes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

foreach ($ArrayCat as $labelCat=>$channelID)
{
	echo "<br><a href='http://192.168.1.20/ArrakisWeb/index.php/Shows/index/".$Channels."_".$labelCat."'>".$labelCat."</a></br>";
}

?>