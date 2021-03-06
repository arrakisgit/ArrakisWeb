<?php

/*Auteur      : Amine El Ouazzani 
 *Projet      : Arrakis
 *Date        : 09/08/2016 O2:39 AM
 *Licence     : GNU GPL v3
 *Description : Classe de scrapping site web HTML/JSON
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */
include_once 'Includer.php';
require __DIR__.'/vendor/autoload.php';
use Masterminds\HTML5;
use GuzzleHttp\Client;
use Masterminds\HTML5\Parser\DOMTreeBuilder;
use Masterminds\HTML5\Parser\Scanner;
use Masterminds\HTML5\Parser\StringInputStream;
use Masterminds\HTML5\Parser\Tokenizer;
use Masterminds\HTML5\Tests\Parser;
$SERVEUR_PATH="http://".$_SERVER['HTTP_HOST'].'/ArrakisWeb/';

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
	//scrapping uniquement par IPHONE/IPAD
	
	public function Func_Get_Source_From_IPhone($pUrl)
	{
		$this->ch = curl_init($pUrl);
		//curl_setopt($this->ch, CURLOPT_URL, $pUrl);
		curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3');
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$resultat = curl_exec ($this->ch);
		curl_close($this->ch);
		$this->DOMResultat = new DOMDocument();
		$this->DOMResultat->loadHTML($resultat);
		return $this->DOMResultat;
		
	
	}
	
	public function Func_Get_Source_IPhone_HTML5($pUrl)
	{
		$client = new GuzzleHttp\Client();
		//$client->setUserAgent('Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3',true);
		$response = $client->get($pUrl,[
				'headers' => [
						'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1'
							 ]
									   ]);
		
		$responseHTML = $response->getBody();
		$html5=new HTML5();
		//$html5=new HTML5(array('disable_html_ns' => true,));
		$this->DOMResultat=$html5->loadHTML($responseHTML);
		return $this->DOMResultat;
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
		
		$file_name_with_full_path=str_replace('%20',' ',str_replace($SERVEUR_PATH,'///var/www/html/',$urlFile));
		
		$this->ch = curl_init($this->urlArrakisServices);
		
		if (function_exists('curl_file_create')) 
		{ // php 5.6+
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$typemim= finfo_file($finfo, $file_name_with_full_path); 
			$cFile = new CURLFile($file_name_with_full_path,$typemim);//,'video/avi','test');//,'video/avi','test');
		} 
		else 
		{ //
			$cFile = '@' . realpath($file_name_with_full_path);
		}
		//return $cFile;
		$post = array('extra_info' => 'videos file','file_contents'=> $cFile);
		//return $post;
		curl_setopt_array($this->ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_POSTFIELDS => $post
		));
		
		// Send the request
		$response = curl_exec($this->ch);
		
		// Check for errors
		/*if($response === FALSE)
		{
			die(curl_error($this->ch));
		}
		$returnFile=json_decode($response);*/
		
		//return $returnFile['UrlConverted'];
		return $response;
	}
	
}

?>