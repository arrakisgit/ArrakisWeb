<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 01/11/2016 4:30 AM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les saisons des s�ries
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

//echo $ArrayShows;
foreach ($ArrayShows as $SeasonID=>$labelSeason)
{
	//echo
	echo "<br><a href='http://192.168.0.18/ArrakisWeb/index.php/Seasons/index/".$Channels."_".$Categories."_".$Shows."_".$SeasonID."'>".$labelSeason."</a></br>";
}

?>