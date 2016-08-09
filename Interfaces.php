<?php

/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/08/2016 O8:45 PM
 *Licence     : GPL v3
 *Description : Interfaces de scrapping site web HTML/JSON
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

interface Channel
{
	
	public function Categories();
	public function Shows($categorySelected);
	public function Episodes($categorySelected,$showSelected);
	public function Live();
	public function Descriptions($categorySelected,$showSelected,$EpisodeSelected);
	public function Images($categorySelected,$showSelected,$EpisodeSelected);
	public function Durations($categorySelected,$showSelected,$EpisodeSelected);
	
}
?>