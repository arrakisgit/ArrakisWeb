<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 10:25 PM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les cat�gories des cha�nes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

//include_once "lib_php/Includer.php";
$SERVEUR_PATH="http://".$_SERVER['HTTP_HOST'].'/ArrakisWeb/';

//echo $ArrayCat;
header('Content-type: text/html; charset=UTF-8');
foreach ($ArrayCat as $labelCat=>$channelID)
{
	echo "<br><a href='".$SERVEUR_PATH."index.php/Shows/index/".$Channels."~".$channelID."'>".$labelCat."</a></br>";
}

?>