<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 01/11/2016 4:30 AM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les saisons des s�ries
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

//echo $ArrayShows;

include_once "lib_php/Includer.php";

foreach ($ArraySeason as $SeasonID=>$labelSeason)
{
	//echo
	echo "<br><a href='".$SERVEUR_PATH."ArrakisWeb/index.php/Episodes/index/".$Channels."_".$Categories."_".$Shows."_".$SeasonID."'>".$labelSeason."</a></br>";
}

?>