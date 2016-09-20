<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 3:19 AM
 *Licence     : GNU GPL v3
 *Description : Controller CodeIgniter manage les catégories des chaînes
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
    		$this->load->view('view_categories',array('Channels'=>$Channel,'ArrayCat'=>$ArrayCat));
    		//$this->load->view('Template', array('page_insert' => $page_insert));
    	}
    	if ($Channel=="France2")
    	{
    		$ChannelCategories = new FranceTV("France2");
    		$ArrayCat = $ChannelCategories->Categories();
    		$this->load->view('view_categories',array('Channels'=>$Channel,'ArrayCat'=>$ArrayCat));
    		//$this->load->view('Template', array('page_insert' => $page_insert));
    	}
    }

}
?>