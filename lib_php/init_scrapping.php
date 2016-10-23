<?php

/*Auteur      : Amine El Ouazzani 
 *Projet      : Arrakis
 *Date        : 09/08/2016 O2:39 AM
 *Licence     : GNU GPL v3
 *Description : Classe de scrapping site web HTML/JSON
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

require '/vendor/autoload.php';
//use Masterminds\HTML5;
use Masterminds\HTML5\Tests\Parser;
use Masterminds\HTML5\Parser\StringInputStream;
use Masterminds\HTML5\Parser\Scanner;
use Masterminds\HTML5\Parser\Tokenizer;
use Masterminds\HTML5\Parser\DOMTreeBuilder;

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
	
		curl_setopt($this->ch, CURLOPT_URL, $pUrl);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$resultat = curl_exec ($this->ch);
		curl_close($this->ch);
		$this->DOMResultat = new DOMDocument();
		//$html5=new HTML5();
		$this->DOMResultat=$this->parse($resultat);
		return $this->DOMResultat;
	}
	
	public function Func_Get_Source_Code_From_URL_HTML5_SESSION($pUrl)
	{
	
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_URL, $pUrl);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$resultat = curl_exec ($this->ch);
		curl_close($this->ch);
		$this->DOMResultat = new DOMDocument();
		//$html5=new HTML5();
		$this->DOMResultat=$this->parse($resultat);
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