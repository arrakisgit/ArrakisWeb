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
			$typeVid="swf";
			$ChannelCategories = new FranceTV($Channel[0]);
			$urlEpisode = $ChannelCategories->File_Video_Url($Channel);
			$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$urlEpisode));
    	}
    	elseif ($Channel[0]=='NRJ12')
    	{
    		$typeVid="mp4";
    		$ChannelCategories = new NRJPlay(strtolower($Channel[0]));
    		$urlEpisode = $ChannelCategories->File_Video_Url($Channel[2]);
    		$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$urlEpisode));
    		//$this->load->view('view_debug', array('result' => var_dump($Episodes)));
    	}
    	elseif($Channel[0]=='Cherie25')
    	{
    		$typeVid="mp4";
    		$ChannelCategories = new NRJPlay(strtolower($Channel[0]));
    		$urlEpisode = $ChannelCategories->File_Video_Url($Channel[2]);
    		$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$urlEpisode));
    		//$this->load->view('view_debug', array('result' => var_dump($Episodes)));
    	}
    	elseif ($Channel[0]=='Kodi')
    	{
    		
    		$typeVid="mp4";
    		$vide='';
    		$ChannelCategories=new Kodi('http://192.168.0.30','8080');
    		$urlEpisode = $ChannelCategories->File_Video_Url($Channel);
    		$urlEpisode=str_replace('smb://ARRAKISNAS', '//192.168.0.41', $urlEpisode);
    		$cmdShell=new ScrappingCURL();
    		$comm='sh /var/www/html/ArrakisWeb/application/ArrakisWeb/script_shell/unmount_smb.sh';
    		$result=$cmdShell->ExcuteShell($comm);
    		$hostNas=str_replace('/'.strrev(explode('/',strrev($urlEpisode))[0]),$vide,$urlEpisode);
    		$folderNAS=str_replace('/'.strrev(explode('/',strrev($hostNas))[0]),$vide,$hostNas);
    		
    		$comm='sh /var/www/html/ArrakisWeb/application/ArrakisWeb/script_shell/mount_smb.sh \''.$folderNAS.'\'';
    		$result=$cmdShell->ExcuteShell($comm);
    		$urlPath='http://192.168.0.18/ArrakisWeb/NASSRV_WEB/'.str_replace(' ','%20',strrev(explode('/',strrev($hostNas))[0])).'/'.strrev(explode('/',strrev($urlEpisode))[0]);
    		$typeVid=strrev(explode('.',strrev($urlEpisode))[0]);
    		$result=$cmdShell->SendCallArrakisServices($urlPath);
    		$this->load->view('view_debug', array('result' => $result));
    		//$this->load->view('view_watch',array('typeVid'=>$typeVid,'urlEpisode'=>$urlPath));
    		    		
    	}
		
	}
}
?>