<?php

/*Auteur      : Amine El Ouazzani 
 *Projet      : Arrakis
 *Date        : 09/08/2016 O2:39 AM
 *Licence     : GNU GPL v3
 *Description : Classe de scrapping site web HTML/JSON
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

require '/vendor/autoload.php';
use Masterminds\HTML5;
use GuzzleHttp\Client;
use Masterminds\HTML5\Parser\DOMTreeBuilder;
use Masterminds\HTML5\Parser\Scanner;
use Masterminds\HTML5\Parser\StringInputStream;
use Masterminds\HTML5\Parser\Tokenizer;
use Masterminds\HTML5\Tests\Parser;
 
class ScrappingCURL
{
	//initialisation variable session et traitement
	
	private $ch;
	private $DOMResultat;
	private $jsonresultat;
	private $urlArrakisServices;
	
	//constructeur: initialisation de la variable $pURL et initialisation cURL
	
	public function __construct()
	{
		$this->ch = curl_init();
		$this->urlArrakisServices='http://192.168.0.44/ArrakisServices/ArrakisServices/index.php/Actions';
	}
	
	//scrapping uniquement par html 4
	
	public function Func_Get_Source_Code_From_URL($pUrl)
	{
	
		curl_setopt($this->ch, CURLOPT_URL, $pUrl);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$resultat = curl_exec ($this->ch);
		curl_close($this->ch);
		$this->DOMResultat = new DOMDocument();
		$this->DOMResultat->loadHTML($resultat);
		return $this->DOMResultat;
	}
	
	public function Func_Get_Source_Code_From_URL_SESSION($pUrl)
	{
	
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_URL, $pUrl);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$resultat = curl_exec ($this->ch);
		curl_close($this->ch);
		$this->DOMResultat = new DOMDocument();
		$this->DOMResultat->loadHTML($resultat);
		return $this->DOMResultat;
	}
	
	
	//scrapping uniquement par html 5
	
	public function Func_Get_Source_Code_From_URL_HTML5($pUrl)
	{
	
		$client = new GuzzleHttp\Client();
		$response = $client->get($pUrl);
		$responseHTML = $response->getBody();
		$html5=new HTML5(array('disable_html_ns' => true,));
		$this->DOMResultat=$html5->loadHTML($responseHTML);
		return $this->DOMResultat;
	}
	
	public function Func_Get_Source_Code_From_URL_HTML5_SESSION($pUrl)
	{
		$client = new GuzzleHttp\Client();
		$response = $client->get($pUrl);
		$responseHTML = $response->getBody();
		$html5=new HTML5(array('disable_html_ns' => true,));
		$this->DOMResultat=$html5->loadHTML($responseHTML);
		return $this->DOMResultat;
	}
	
	//scrapping uniquement par json
	
	public function Func_Get_Source_Code_From_JSON($pUrl)
	{
		curl_setopt($this->ch, CURLOPT_URL, $pUrl);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$resultat = curl_exec ($this->ch);
		curl_close($this->ch);
		$this->jsonresultat=json_decode($resultat, true);
		return $this->jsonresultat;
	}
	public function Func_Get_Source_Code_From_JSON_SESSION($pUrl)
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_URL, $pUrl);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$resultat = curl_exec ($this->ch);
		curl_close($this->ch);
		$this->jsonresultat=json_decode($resultat, true);
		return $this->jsonresultat;
	}
	
	// module de requetage JSON-RPC en POST
	public function Func_Send_JSON_POST_KODI($pHost,$pPort,$pLib,$idShow)
	{
		$urlSRV=$pHost.':'.$pPort.'/jsonrpc';
		if($pLib=='tvshows')
		{
			$postData = array(
					'jsonrpc' => '2.0',
					'method' => 'VideoLibrary.GetTVShows',
					'params' => array(
							'filter'=> array(
									'field'=>'playcount',
									'operator'=>'is',
									'value'=>'0'),
							'limits'=>array(
									'start'=>0,
									'end'=>75),
							'properties'=>array(
									'art',
									'genre',
									'plot',
									'title',
									'originaltitle',
									'year',
									'rating',
									'thumbnail',
									'playcount',
									'file',
									'fanart'),
							'sort'=>array(
									'order'=>'ascending',
									'method'=>'label'),
							),
					'id'=>'libTvShows');
							
		}
		elseif ($pLib=='tvshows_episodes')
		{
			//$params='tvshowid'=> .$idShow.')',
			$postData = array(
					'jsonrpc'=> '2.0',
					'id'=>1,
					'method'=> 'VideoLibrary.GetSeasons',
					'params'=> array(
							'tvshowid'=> (int) $idShow, 
							'properties'=>array(
									'playcount', 
									'season', 
									'episode', 
									'showtitle', 
									'thumbnail'), 
							'limits'=>array(
									'start'=>0,
									'end'=>500)
							)
					);
			
			//"VideoLibrary.GetEpisodes", {"tvshowid": int(show_id)}))
			//"VideoLibrary.GetEpisodes", {"limits":{"end":1},"tvshowid": int(show_id), "filter":{"field":"lastplayed", "operator":"greaterthan", "value":"0"}, "properties":["season", "episode", "lastplayed", "firstaired", "resume"], "sort":{"method":"lastplayed", "order":"descending"}})
		}
		elseif ($pLib=='tvshows_episodes_details')
		{
			$params=explode('_', $idShow);
			$postData = array(
					'jsonrpc'=> '2.0',
					'id'=>1,
					'method'=> 'VideoLibrary.GetEpisodes',
					'params'=> array(
							'tvshowid'=> (int) $params[0],
							'season'=> (int) $params[1],
							'properties'=>array(
									'playcount',
									'season',
									'episode',
									'file',
									'title',
									'showtitle',
									'thumbnail'),
							'limits'=>array(
									'start'=>0,
									'end'=>500)
					)
			);
		}
		
		// Setup cURL
		//return $postData;
		$this->ch = curl_init($urlSRV);
		curl_setopt_array($this->ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json'
				),
				CURLOPT_POSTFIELDS => json_encode($postData)
		));
		
		// Send the request
		$response = curl_exec($this->ch);
		
		// Check for errors
		if($response === FALSE){
			die(curl_error($this->ch));
		}
		
		// Decode the response
		$this->jsonresultat = json_decode($response, TRUE);
		
		return $this->jsonresultat;
		
		
	}
	protected function parse($string, array $options = array())
	{
		$treeBuilder = new DOMTreeBuilder(false, $options);
		$input = new StringInputStream($string);
		$scanner = new Scanner($input);
		$parser = new Tokenizer($scanner, $treeBuilder);
		$parser->parse();
		$this->errors = $treeBuilder->getErrors();
		return $treeBuilder->document();
	}
	public function ExcuteShell($cmd)
	{
		$output = shell_exec($cmd);
	
	}
	public function SendCallArrakisServices($urlFile)
	{
		
		$file_name_with_full_path=$urlFile;
		if (function_exists('curl_file_create')) 
		{ // php 5.6+
			$cFile = curl_file_create(str_replace('http://192.168.0.18/','/var/www/html/',$file_name_with_full_path));
		} 
		else 
		{ //
			$cFile = '@' . realpath($file_name_with_full_path);
		}
		return $cFile;
		$post = array('extra_info' => 'videos file','file_contents'=> $cFile);
		//return $post;
		$this->ch = curl_init($this->urlArrakisServices);
		curl_setopt_array($this->ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_HTTPHEADER => array(
						'Content-Type: application/xml'),
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_POSTFIELDS => $post,
				CURLOPT_SAFE_UPLOAD => false
		));
		
		// Send the request
		$response = curl_exec($this->ch);
		
		// Check for errors
		if($response === FALSE)
		{
			die(curl_error($this->ch));
		}
		$returnFile=json_decode($response);
		
		//return $returnFile['UrlConverted'];
		return $response;
	}
	
}

?>