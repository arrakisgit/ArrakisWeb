<?php 
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 19/10/2016 9:01 PM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les episodes des cha�nes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */	

//include_once "lib_php/Includer.php";
$SERVEUR_PATH="http://".$_SERVER['HTTP_HOST'].'/ArrakisWeb/';

		foreach ($Episodes as $labelShow=>$showID)
		{
			//
			//echo $Episodes;
			if ($Channels!='Kodi')
			{
				echo "<br><a href='".$SERVEUR_PATH."index.php/Watch/index/".$Channels."%".$Categories."%".$Shows."%".$showID."'>".$labelShow."</a></br>";
		
			}
			else
			{
				echo "<br><a href='".$SERVEUR_PATH."index.php/Watch/index/".$Channels."%".$Categories."%".$Shows."%".$Seasons."%".$showID."'>".$labelShow."</a></br>";
			}
		}
		//echo "<div class='container'><video width='700' height='400'><source src='".$Episode."' type='application/x-mpegURL'></video></div>";
	
?>
