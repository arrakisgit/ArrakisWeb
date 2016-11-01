<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 01/11/2016 4:35 AM
 *Licence     : GNU GPL v3
 *Description : Controller CodeIgniter manage les saisons des séries
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

include_once 'lib_php/Includer.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shows extends CI_Controller
{

	public function index($id)
	{
		$Channel=explode('_',$id);
		if ($Channel[0]=='Kodi')
		{
			$ChannelCategories = new Kodi('http://192.168.0.30','8080');
			$ArrayShows = $ChannelCategories->Episodes($Channel);
			$this->load->view('view_shows',array('Channels'=>$Channel[0],'Shows'=>$Channel[1],'ArrayShows'=>$ArrayShows));
			//$this->load->view('view_debug', array('result' => $ArrayShows));
		}
			
	}
}
