<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 3:19 AM
 *Licence     : GNU GPL v3
 *Description : Controller CodeIgniter manage les catégories des chaînes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

include_once '../lib_php/Includer.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller
{

    public function index($Channel)
    {
    	if ($Channel=="Arte")
    	{
    		$ChannelCategories = new Arte("CAT");
    		$ArrayCat = $ChannelCategories->Categories();
    		$page_insert=$this->load->view('Categories_Channels',$ArrayCat,true);
    		$this->load->view('template', array('page_insert' => $page_insert));
    	}
    }

}
?>