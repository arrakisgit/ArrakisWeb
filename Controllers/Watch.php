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
    		$urlEpisode=str_replace('smb://ARRAKISNAS', '//192.168.0.14', $urlEpisode);
    		$cmdShell=new ScrappingCURL();
    		$comm='sh /var/www/html/ArrakisWeb/application/ArrakisWeb/script_shell/unmount_smb.sh';
    		$result=$cmdShell->ExcuteShell($comm);
    		$hostNas=str_replace('/'.strrev(explode('/',strrev($urlEpisode))[0]),$vide,$urlEpisode);
    		$folderNAS=str_replace('/'.strrev(explode('/',strrev($hostNas))[0]),$vide,$hostNas);
    		
    		$comm='sh /var/www/html/ArrakisWeb/application/ArrakisWeb/script_shell/mount_smb.sh \''.$folderNAS.'\'';
    		$urlPath='http://192.168.0.18/ArrakisWeb/NASSRV_WEB/'.str_replace(' ','%20',strrev(explode('/',strrev($hostNas))[0])).'/'.strrev(explode('/',strrev($urlEpisode))[0]);
    		$SRV_CONVERT='http://192.168.0.18/ArrakisWeb/ArrakisVideos/';
    		$extension=strtoupper(strrev(explode('.',strrev(strrev(explode('/',strrev($urlEpisode))[0])))[0]));
    		$NameVideos=str_replace('.'.strtolower($extension),$vide,strrev(explode('/',strrev($urlEpisode))[0]));
    		$URL_COVERT_VIDEOS=$SRV_CONVERT.$NameVideos.'.mp4';
    		$result=$cmdShell->ExcuteShell($comm);
    		
    		if ($extension=='AVI')
    		{
    			$commandeShell='sudo ffmpeg -i '.str_replace('http://192.168.0.18','/var/www/html',$urlPath).' -c:v libx264 -preset slow -crf 22 -preset slow -c:a aac -strict experimental -b:a 128k '.str_replace('http://192.168.0.18','/var/www/html',$URL_COVERT_VIDEOS);	
    			$result=$cmdShell->ExcuteShell($commandeShell);
    			$this->load->view('view_debug', array('result' => $commandeShell));
    			//$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$URL_COVERT_VIDEOS));
    			 
    			
    		}
    		elseif ($extension=="MKV")
    		{
    			$commandeShell='sudo ffmpeg -i '.$urlPath.' -vcodec copy -acodec copy '.$URL_COVERT_VIDEOS;
    			$result=$cmdShell->ExcuteShell($commandeShell);
    			//$this->load->view('view_debug', array('result' => $comm));
    			$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$URL_COVERT_VIDEOS));
    			 
    		}
    		else
    		{
    			//$this->load->view('view_debug', array('result' => $comm));
    			$this->load->view('view_watch',array('typeVid'=>$typeVid,'id'=>$Channel[0],'Channels'=>$Channel[0],'Shows'=>$Channel[1],'urlEpisode'=>$urlPath));
    		}
    		
    	}
		
	}
}
?>