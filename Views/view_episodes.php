<?php 
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 19/10/2016 9:01 PM
 *Licence     : GNU GPL v3
 *Description : View CodeIgniter manage les episodes des chaînes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */	
	
		foreach ($Episodes as $labelShow=>$showID)
		{
			//
			//echo $Episodes;
			echo "<br><a href='http://192.168.0.18/ArrakisWeb/index.php/Episodes/index/".$Channels."_".$Shows."_".$labelShow."'>".$showID."</a></br>";
		}
		//echo "<div class='container'><video width='700' height='400'><source src='".$Episode."' type='application/x-mpegURL'></video></div>";
	
?>
