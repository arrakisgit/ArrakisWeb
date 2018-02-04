<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 01/11/2016 4:30 AM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les saisons des s�ries
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

//echo $ArrayShows;

//include_once "lib_php/Includer.php";
$SERVEUR_PATH="http://".$_SERVER['HTTP_HOST'].'/ArrakisWeb/';

foreach ($ArraySeason as $SeasonID=>$labelSeason)
{
	//echo
	echo "<br><a href='".$SERVEUR_PATH."index.php/Episodes/index/".$Channels."~".$Categories."~".$Shows."~".$SeasonID."'>".$labelSeason."</a></br>";
}

?>