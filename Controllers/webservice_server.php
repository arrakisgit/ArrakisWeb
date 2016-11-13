<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 11/11/2016 O4:54 PM
 *Licence     : GNU GPL v3
 *Description : Webservice - serveur convertion video
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */
include_once 'lib_php/Includer.php';


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class webservice_sever extends CI_Controller
{
	public function index($id)
	{
		$serveur = new soap_server;
		$serveur->register('convert_mp4');
		$serveur->service($HTTP_RAW_POST_DATA);
	}
	public function convert_mp4($inFile)
	{
		$inFile=str_replace('smb://ARRAKISNAS', '//192.168.0.14', $inFile);
		$cmdShell=new ScrappingCURL();
		$comm='sh /var/www/html/ArrakisWeb/application/ArrakisWeb/script_shell/unmount_smb.sh';
		$result=$cmdShell->ExcuteShell($comm);
		$hostNas=str_replace('/'.strrev(explode('/',strrev($inFile))[0]),'',$inFile);
		$folderNAS=str_replace('/'.strrev(explode('/',strrev($hostNas))[0]),'',$hostNas);
		
		$comm='sh /var/www/html/ArrakisWeb/application/ArrakisWeb/script_shell/mount_smb.sh \''.$folderNAS.'\'';
		$urlPath='http://192.168.0.44/ArrakisWeb/NASSRV_WEB/'.str_replace(' ','%20',strrev(explode('/',strrev($hostNas))[0])).'/'.strrev(explode('/',strrev($inFile))[0]);
		$SRV_CONVERT='http://192.168.0.44/ArrakisWeb/ArrakisVideos/';
		$extension=strtoupper(strrev(explode('.',strrev(strrev(explode('/',strrev($inFile))[0])))[0]));
		$NameVideos=str_replace('.'.strtolower($extension),$vide,strrev(explode('/',strrev($inFile))[0]));
		$URL_COVERT_VIDEOS=$SRV_CONVERT.$NameVideos.'.mp4';
		$result=$cmdShell->ExcuteShell($comm);
		
		if ($extension=='AVI')
		{
			$commandeShell='sudo avconv -i '.str_replace('http://192.168.0.44','/var/www/html',$urlPath).' -c:v libx264 -c:a copy '.str_replace('http://127.0.0.1','/var/www/html',$URL_COVERT_VIDEOS);
			$result=$cmdShell->ExcuteShell($commandeShell);
			return $URL_COVERT_VIDEOS;
			 
		}
		/*elseif ($extension=="MKV")
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
		}*/
		return "No file";
	}
}
?>