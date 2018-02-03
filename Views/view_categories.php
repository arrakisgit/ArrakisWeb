<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 10:25 PM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les cat�gories des cha�nes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

//echo $ArrayCat;
header('Content-type: text/html; charset=UTF-8');
foreach ($ArrayCat as $labelCat=>$channelID)
{
	echo "<br><a href='http://localhost/ArrakisWeb/index.php/Shows/index/".$Channels."_".$channelID."'>".$labelCat."</a></br>";
}

?>