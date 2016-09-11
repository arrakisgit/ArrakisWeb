<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 3:19 AM
 *Licence     : GNU GPL v3
 *Description : Controller CodeIgniter manage les cat�gories des cha�nes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

include_once 'lib_php/Includer.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller
{

    public function index($Channel)
    {
    	if ($Channel=="Arte")
    	{
    		$ChannelCategories = new Arte("CAT");
    		$ArrayCat = $ChannelCategories->Categories();
    		$page_insert=$this->load->view('view_categories',array('ArrayCat'=>$ArrayCat),true);
    		$this->load->view('Template', array('page_insert' => $page_insert));
    	}
    }

}
?>