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
    	elseif (substr($Channel, 0,6)=='France')
    	{
    		$ChannelCategories = new FranceTV($Channel);
    		$ArrayCat = $ChannelCategories->Categories();
    		$this->load->view('view_categories',array('Channels'=>$Channel,'ArrayCat'=>$ArrayCat));
    		//$this->load->view('Template', array('page_insert' => $page_insert));
    	}
    	elseif(substr($Channel, 0,3)=='BFM')
    	{
    		$ChannelCategories = new BFMTV($Channel);
    		$ArrayCat = $ChannelCategories->Categories();
    		$this->load->view('view_categories',array('Channels'=>$Channel,'ArrayCat'=>$ArrayCat));
    	}
    	elseif($Channel=='Itele')
    	{
    		$ChannelCategories = new Itele();
    		$ArrayCat = $ChannelCategories->Categories();
    		$this->load->view('view_categories',array('Channels'=>$Channel,'ArrayCat'=>$ArrayCat));
    	}
    	elseif($Channel=='NRJ12')
    	{
    		$ChannelCategories = new NRJPlay(strtolower($Channel));
    		$ArrayCat = $ChannelCategories->Categories();
    		$this->load->view('view_categories',array('Channels'=>$Channel,'ArrayCat'=>$ArrayCat));
    		//$this->load->view('view_debug', array('result' => $ArrayCat));
    	}
    	elseif($Channel=='Cherie25')
    	{
    		$ChannelCategories = new NRJPlay(strtolower($Channel));
    		$ArrayCat = $ChannelCategories->Categories();
    		$this->load->view('view_categories',array('Channels'=>$Channel,'ArrayCat'=>$ArrayCat));
    		//$this->load->view('view_debug', array('result' => $ArrayCat));
    	}
    	elseif($Channel=='Kodi')
    	{
    		$ChannelCategories = new Kodi('http://192.168.0.30','8080');
    		$ArrayCat = $ChannelCategories->Categories();
    		//$this->load->view('view_categories',array('Channels'=>$Channel,'ArrayCat'=>$ArrayCat));
    		$this->load->view('view_debug', array('result' => var_dump($ArrayCat)));
    	}
    	    
    }

}
?>