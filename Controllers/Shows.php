<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 3:19 AM
 *Licence     : GNU GPL v3
 *Description : Controller CodeIgniter manage les emissions des chaînes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

include_once 'lib_php/Includer.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shows extends CI_Controller
{

    public function index($id)
    {
    	$Channel=explode('_',$id);
    	if ($Channel[0]=="Arte")
    	{
    		$ChannelCategories = new Arte("CAT");
    		$ArrayShows = $ChannelCategories->Shows($Channel[1]);
    		$this->load->view('view_shows',array('Channels'=>$Channel[0],'Shows'=>$Channel[0],'ArrayShows'=>$ArrayShows));
    		//$this->load->view('Template', array('page_insert' => $page_insert));
    	}
    }

}
?>