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
	
	//constructeur: initialisation de la variable $pURL et initialisation cURL
	
	public function __construct()
	{
		$this->ch = curl_init();
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
	public function Func_Send_JSON_POST_KODI($pHost,$pPort,$pLib)
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
		
		// Setup cURL
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
		$responseData = json_decode($response, TRUE);
		
		return $responseData;
		
		
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
}
?>