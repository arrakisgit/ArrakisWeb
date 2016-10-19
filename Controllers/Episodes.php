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
    	elseif ($Channel[0]=="France2")
    	{
    		
    		$ChannelCategories = new FranceTV("France2");
    		$Episodes = $ChannelCategories->Episodes($Channel);
    		$this->load->view('view_episodes',array('Channels'=>$Channel[0],'Shows'=>$Channel[1],'Episodes'=>$Episodes));
    		
    	}
    	elseif ($Channel[0]=="France3")
    	{
    		
    		$ChannelCategories = new FranceTV("France3");
    		$Episodes = $ChannelCategories->Shows($Channel);
    		$this->load->view('view_episodes',array('Channels'=>$Channel[0],'Shows'=>$Channel[1],'Episodes'=>$Episodes));
    		
    	}
    	elseif ($Channel[0]=="France4")
    	{
    		
    		$ChannelCategories = new FranceTV("France4");
    		$Episodes = $ChannelCategories->Shows($Channel);
    		$this->load->view('view_episodes',array('typeVid'=>$typeVid,'Channels'=>$Channel[0],'Shows'=>$Channel[1],'Episodes'=>$Episodes));
    		
    	}
    	elseif ($Channel[0]=="France5")
    	{
    		
    		$ChannelCategories = new FranceTV("France5");
    		$Episodes = $ChannelCategories->Shows($Channel);
    		$this->load->view('view_shows',array('Channels'=>$Channel[0],'Shows'=>$Channel[1],'Episodes'=>$Episodes));
    		
    	}
    	elseif ($Channel[0]=="FranceO")
    	{
    		
    		$ChannelCategories = new FranceTV("FranceO");
    		$Episodes = $ChannelCategories->Shows($Channel);
    		$this->load->view('view_shows',array('Channels'=>$Channel[0],'Shows'=>$Channel[1],'Episodes'=>$Episodes));
    		
    	}
    	else 
    	{
    		$this->load->view('bad_file');
    	}
    }

}
?>