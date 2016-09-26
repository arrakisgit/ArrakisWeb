<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 3:19 AM
 *Licence     : GNU GPL v3
 *Description : Controller CodeIgniter manage les episodes des chaînes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

include_once 'lib_php/Includer.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Episodes extends CI_Controller
{

    public function index($id)
    {
    	$Channel=explode('_',$id);
    	if ($Channel[0]=="Arte")
    	{
    		$typeVid="mp4";
    		$ChannelCategories = new Arte("CAT");
    		$urlEpisode = $ChannelCategories->StreamUrl($Channel[1]);
    		$this->load->view('view_episodes',array('typeVid'=>$typeVid,'id'=>$id,'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$urlEpisode));
    		//$this->load->view('Template', array('page_insert' => $page_insert));
    	}
    	else 
    	{
    		$this->load->view('bad_file');
    	}
    }

}
?>