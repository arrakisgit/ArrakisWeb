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
    	$typeVid="FRTV";
    	$Channel=explode('_',$id);
    	if ($Channel[0]=="Arte")
    	{
    		$typeVid="mp4";
    		$ChannelCategories = new Arte("CAT");
    		$urlEpisode = $ChannelCategories->StreamUrl($Channel[2]);
    		$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[2],'urlEpisode'=>$urlEpisode));
    		
    	}
    	else
    	{
    		
    		$ChannelCategories = new FranceTV($Channel[0]);
    		$Episodes = $ChannelCategories->Episodes($Channel);
    		$this->load->view('view_episodes',array('Channels'=>$Channel[0],'Shows'=>$Channel[1],'Episodes'=>$Episodes));
    		
    	}
    	
    }

}
?>