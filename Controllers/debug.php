<?php

/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
*Date        : 24/09/2016 10:25 PM
*Licence     : GNU GPL v3
*Description : Controller CodeIgniter manage les cat�gories des cha�nes
*git         : https://github.com/arrakisgit/ArrakisWeb.git
*/

include_once "lib_php/Includer.php";
$SERVEUR_PATH="http://".$_SERVER['HTTP_HOST'].'/ArrakisWeb/';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class debug extends CI_Controller
{

	public function index($Channel)
	{
		if ($Channel=="Arte")
		{
			$ChannelCategories = new Arte("CAT");
			$ArrayCat = $ChannelCategories->Categories();
			$this->load->view('view_categories',array('Channels'=>$Channel,'ArrayCat'=>$ArrayCat));
			//$this->load->view('Template', array('page_insert' => $page_insert));
		}
		if ($Channel=="France2")
		{
			$ChannelCategories = new FranceTV("France2");
			$result = $ChannelCategories->Categories();
			$this->load->view('view_debug',array('result'=>$result));
			//$this->load->view('Template', array('page_insert' => $page_insert));
		}
	}

}
?>