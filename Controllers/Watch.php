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
		if ($Channel[0]=="France2")
		{
			$typeVid="m3u8";
			$ChannelCategories = new FranceTV("France2");
			$Episodes = $ChannelCategories->File_Video_Url($Channel);
			$this->load->view('view_watch',array('typeVid'=>$typeVid,'Channels'=>$Channel[0],'Shows'=>$Channel[1],'Episodes'=>$Episodes));
			
		}
	}
}
?>