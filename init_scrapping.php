<?php

/*Auteur      : Amine El Ouazzani 
 *Projet      : Arrakis
 *Date        : 09/08/2016 O2:39 AM
 *Licence     : GPL v3
 *Description : Classe de scrapping site web HTML/JSON
 */

class ScrappingCURL
{
	//initialisation variable session et traitement
	
	private $ch;
	private $DOMResultat;
	private $pURL;
	private $jsonresultat;
	
	//constructeur: initialisation de la variable $pURL et initialisation cURL
	
	public function __construct($initUrl)
	{
		$this->pURL=$initUrl;
		$this->ch = curl_init();
	}
	
	//scrapping uniquement par html
	
	public function Func_Get_Source_Code_From_URL()
	{
	
		curl_setopt($this->ch, CURLOPT_URL, $this->pUrl);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$resultat = curl_exec ($this->ch);
		curl_close($this->ch);
		$this->DOMResultat = new DOMDocument();
		$this->DOMResultat->loadHTML($resultat);
		return $this->DOMResultat;
	}
	
	//scrapping uniquement par json
	
	public function Func_Get_Source_Code_From_JSON()
	{
		curl_setopt($this->ch, CURLOPT_URL, $this->pUrl);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$resultat = curl_exec ($this->ch);
		curl_close($this->ch);
		$this->jsonresultat=json_decode($resultat, true);
		return $this->jsonresultat;
	}
}
?>