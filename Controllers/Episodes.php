<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/09/2016 3:19 AM
 *Licence     : GNU GPL v3
 *Description : Controller CodeIgniter manage les episodes des cha�nes
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

include_once "lib_php/Includer.php";
$SERVEUR_PATH="http://".$_SERVER['HTTP_HOST'].'/ArrakisWeb/';

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
    	elseif (substr($Channel[0], 0,6)=='France')
    	{
    		
    		$ChannelCategories = new FranceTV($Channel[0]);
    		$Episodes = $ChannelCategories->Episodes($Channel);
    		$this->load->view('view_episodes',array('Channels'=>$Channel[0],'Shows'=>$Channel[2],'Categories'=>$Channel[1],'Seasons'=>'Seasons','Episodes'=>$Episodes));
    		//$this->load->view('view_debug', array('result' => var_dump($Episodes)));
    	}
    	elseif (substr($Channel[0], 0,3)=='BFM')
    	{
    		$typeVid='m3u8';
    		$ChannelCategories = new BFMTV($Channel[0]);
    		$urlEpisode = $ChannelCategories->File_Video_Url($Channel[2]);
    		$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[2],'urlEpisode'=>$urlEpisode));
    	}
    	elseif ($Channel[0]=='Itele')
    	{
    		$typeVid='m3u8';
    		$ChannelCategories = new Itele();
    		$urlEpisode = $ChannelCategories->File_Video_Url($Channel);
    		$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[2],'urlEpisode'=>$urlEpisode));
    	}
    	elseif ($Channel[0]=='NRJ12')
    	{
    		$ChannelCategories = new NRJPlay(strtolower($Channel[0]));
    		$Episodes = $ChannelCategories->Episodes($Channel[2]);
    		
    		if (is_null($Episodes)==true || empty($Episodes)==true)
    		{
    			$urlsend='".$SERVEUR_PATH."index.php/Watch/index/'.$id."_".$Channel[2];
    			header('Location: '.$urlsend);
    		}
    		else
    		{
    			$this->load->view('view_episodes',array('Channels'=>$Channel[0],'Categories'=>$Channel[1],'Shows'=>$Channel[2],'Seasons'=>'Seasons','Episodes'=>$Episodes));
    		}
    		//$this->load->view('view_debug', array('result' => var_dump($Episodes)));
    	}
    	elseif($Channel[0]=='Cherie25')
    	{
    		$ChannelCategories = new NRJPlay(strtolower($Channel[0]));
    		$Episodes = $ChannelCategories->Episodes($Channel[2]);
    		
    		if (is_null($Episodes)==true || empty($Episodes)==true)
    		{
    			$urlsend='".$SERVEUR_PATH."index.php/Watch/index/'.$id."_".$Channel[2];
    			header('Location: '.$urlsend);
    		}
    		else
    		{
    			$this->load->view('view_episodes',array('Channels'=>$Channel[0],'Categories'=>$Channel[1],'Shows'=>$Channel[2],'Seasons'=>'Seasons','Episodes'=>$Episodes));
    		}
    		//$this->load->view('view_debug', array('result' => var_dump($Episodes)));
    	}
    	elseif($Channel[0]=='Kodi')
    	{
    		$ChannelCategories = new Kodi('http://192.168.0.30','8080');
    		$Episodes = $ChannelCategories->Episodes($Channel);
    		$this->load->view('view_episodes',array('Channels'=>$Channel[0],'Categories'=>$Channel[1],'Shows'=>$Channel[2],'Seasons'=>$Channel[3],'Episodes'=>$Episodes));
    		//$this->load->view('view_debug', array('result' => $Episodes));
    	}
    }

}
?>