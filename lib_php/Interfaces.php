<?php

/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/08/2016 O8:45 PM
 *Licence     : GNU GPL v3
 *Description : Interfaces de scrapping site web HTML/JSON
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

interface IChannel
{
	
	public function Categories();
	public function Shows($categorySelected);
	public function StreamUrl($showSelected);
	public function Live();
	public function Descriptions($stream_url);
	public function Images($stream_url);
	public function Durations($stream_url);
	
}
?>