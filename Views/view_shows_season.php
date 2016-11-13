<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 01/11/2016 4:30 AM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les saisons des séries
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

//echo $ArrayShows;
foreach ($ArraySeason as $SeasonID=>$labelSeason)
{
	//echo
	echo "<br><a href='http://127.0.0.1/ArrakisWeb/index.php/Episodes/index/".$Channels."_".$Categories."_".$Shows."_".$SeasonID."'>".$labelSeason."</a></br>";
}

?>