<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/08/2016 O9:13 PM
 *Licence     : GNU GPL v3
 *Description : Chaînes scrapping site web HTML/JSON
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

include_once 'Interfaces.php';
include_once 'init_scrapping.php';
include_once 'Utils_Functions.php';

class Arte extends ScrappingCURL implements IChannel
{
	private $URL_CATEGORIES;
	private $URL_MOST_VIEWED;
	private $URL_LAST_CHANCE;
	private $ArrayCategories;
	private $ResultJSON;
	private $ArrayShows;
	private $ArrayEpisodes;
	
	public function __construct($ViewMode)
	{
		parent::__construct();
		
		$this->URL_CATEGORIES='http://www.arte.tv/papi/tvguide/videos/plus7/program/F/L2/XXX/ALL/-1/AIRDATE_DESC/0/0/DE_FR.json';
		$this->URL_MOST_VIEWED='http://www.arte.tv/papi/tvguide/videos/plus7/program/F/L2/ALL/ALL/-1/VIEWS/0/0/DE_FR.json';
		$this->URL_LAST_CHANCE='http://www.arte.tv/papi/tvguide/videos/plus7/program/F/L2/ALL/ALL/-1/LAST_CHANCE/0/0/DE_FR.json';
		
		$this->ArrayCategories=Array();
		$this->ArrayShows=Array();
		$this->ArrayEpisodes=Array();
		
		if ($ViewMode=='CAT')
		{
			$this->ResultJSON = parent::Func_Get_Source_Code_From_JSON($this->URL_CATEGORIES);
		}
		elseif ($ViewMode=='MOV')
		{
			$this->ResultJSON = parent::Func_Get_Source_Code_From_JSON($this->URL_MOST_VIEWED);
		}
		elseif ($ViewMode=='LST')
		{
			$this->ResultJSON = parent::Func_Get_Source_Code_From_JSON($this->URL_LAST_CHANCE);
		}
		
	}
	
	public function Live()
	{
		
	}
	
	public function Categories()
	{
		foreach($this->ResultJSON['programFRList'] as $programItem)
		{
				if(array_key_exists($programItem['VDO']['VCH'][0]['label'], $this->ArrayCategories)==false)
					{
						$this->ArrayCategories[$programItem['VDO']['VCH'][0]['label']]=$programItem['VDO']['VCH'][0]['channelID'];
					}
					
		}
		return $this->ArrayCategories;
	}
	
	public function Shows($categorySelected)
	{
		foreach($this->ResultJSON['programFRList'] as $programItem)
		{
				if($programItem['VDO']['VCH'][0]['channelID']==$categorySelected)
				{
					if(array_key_exists($programItem['PID'], $this->ArrayShows)==false)
					{
						$this->ArrayShows[$programItem['PID']]=$programItem['TIT'];
					}
				}	
			}
		return $this->ArrayShows;
	}
	
	public function StreamUrl($showSelected)
	{
		foreach($this->ResultJSON['programFRList'] as $programItem)
		{
			if ($programItem['PID']=$showSelected)
			{
				return $$programItem['VDO']['videoStreamUrl'];//$this->File_Video_Url($programItem['VDO']['videoStreamUrl']);
			}
		}
	}
	public function Durations($stream_url)
	{
		$jsonresult=parent::Func_Get_Source_Code_From_JSON($stream_url);
		foreach($jsonresult->video as $videos)
		{
			return $videos->videoDurationSeconds;
		}
	}
	
	
	public function Images($stream_url)
	{
		$jsonresult=parent::Func_Get_Source_Code_From_JSON($stream_url);
		foreach($jsonresult->video as $videos)
		{
			return $videos->programImage;
		}
	}
	
	public function Descriptions($stream_url)
	{
		$jsonresult=parent::Func_Get_Source_Code_From_JSON($stream_url);
		foreach($jsonresult->video as $videos)
		{
			return $videos->VDE;
		}
	}
	
	public function File_Video_Url($stream_url)
	{
		$jsonresult=parent::Func_Get_Source_Code_From_JSON($stream_url);
		foreach($jsonresult['video']['VSR']['VFO'] as $vfo)
		{
			if (($vfo['VQU']=="HD") && ($vfo=="HBBTV"))
			{
				return $vfo['VUR'];
			}
		}
		
	}
		
}

		


?>