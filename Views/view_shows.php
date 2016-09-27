<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 10:25 PM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les catégories des emissions
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

//echo $ArrayShows;
foreach ($ArrayShows as $labelShow=>$showID)
{
	echo "<br><a href='http://192.168.1.20/ArrakisWeb/index.php/Episodes/index/".$Channels."_".$labelShow."'>".$showID."</a></br>";
}

?>