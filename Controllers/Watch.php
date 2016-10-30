<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 19/10/2016 9:01 PM
 *Licence     : GNU GPL v3
 *Description : Controller CodeIgniter manage le visionnages des chaînes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

include_once 'lib_php/Includer.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Watch extends CI_Controller
{
	public function index($id)
	{
		$Channel=explode('_',$id);
		
		if (substr($Channel[0], 0,6)=='France')
    	{
			$typeVid="m3u8";
			$ChannelCategories = new FranceTV($Channel[0]);
			$urlEpisode = $ChannelCategories->File_Video_Url($Channel);
			$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$urlEpisode));
    	}
    	elseif ($Channel[0]=='NRJ12')
    	{
    		$ChannelCategories = new NRJPlay(strtolower($Channel[0]));
    		$urlEpisode = $ChannelCategories->File_Video_Url($Channel[2]);
    		$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$urlEpisode));
    		//$this->load->view('view_debug', array('result' => var_dump($Episodes)));
    	}
    	elseif($Channel[0]=='Cherie25')
    	{
    		$ChannelCategories = new NRJPlay(strtolower($Channel[0]));
    		$urlEpisode = $ChannelCategories->File_Video_Url($Channel[2]);
    		$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$urlEpisode));
    		//$this->load->view('view_debug', array('result' => var_dump($Episodes)));
    	}
		
	}
}
?>