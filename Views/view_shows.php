<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 10:25 PM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les cat�gories des emissions
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

//echo $ArrayShows;

include_once "lib_php/Includer.php";

foreach ($ArrayShows as $labelShow=>$showID)
{
	if($Channels!='Kodi')
	{
		echo "<br><a href='".$SERVEUR_PATH."ArrakisWeb/index.php/Episodes/index/".$Channels."_".$Shows."_".$labelShow."'>".$showID."</a></br>";
	}
	else
	{
		echo "<br><a href='".$SERVEUR_PATH."ArrakisWeb/index.php/Seasons/index/".$Channels."_".$Shows."_".$labelShow."'>".$showID."</a></br>";
	}
}

?>