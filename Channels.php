<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 09/08/2016 O9:13 PM
 *Licence     : GNU GPL v3
 *Description : Chaînes scrapping site web HTML/JSON
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

class Arte extends ScrappingCURL implements IChannel
{
	private $URL_CATEGORIES;
	private $URL_MOST_VIEWED;
	private $URL_LAST_CHANCE;
	private $ArrayCategories;
	private $ResultJSON;
	private $ArrayShows;
	private $ArrayEpisodes;
	
	public function __construct()
	{
		parent::__construct();
		$this->URL_CATEGORIES='http://www.arte.tv/papi/tvguide/videos/plus7/program/F/L2/XXX/ALL/-1/AIRDATE_DESC/0/0/DE_FR.json';
		$this->URL_MOST_VIEWED='http://www.arte.tv/papi/tvguide/videos/plus7/program/F/L2/ALL/ALL/-1/VIEWS/0/0/DE_FR.json';
		$this->URL_LAST_CHANCE='http://www.arte.tv/papi/tvguide/videos/plus7/program/F/L2/ALL/ALL/-1/LAST_CHANCE/0/0/DE_FR.json';
		$this->ArrayCategories=Array();
		$this->ArrayShows=Array();
		$this->ArrayEpisodes=Array();
		$this->ResultJSON = parent::Func_Get_Source_Code_From_JSON($this->URL_CATEGORIES);
	}
	
	public function Categories()
	{
		foreach($this->ResultJSON->programFRList as $programItem)
		{
			foreach($programItem->VDO as $VDO_item)
			{
				if(array_key_exists($VDO_item->VCH->label, $this->ArrayCategories)==false)
					{
						$this->ArrayCategories[$VDO_item->VCH->label]=$VDO_item->VCH->channelID;
					}
					
			}
		}
		return $this->ArrayCategories;
	}
	
	public function Shows($categorySelected)
	{
		foreach($this->ResultJSON->programFRList as $programItem)
		{
			foreach($programItem->VDO as $VDO_item)
			{
				if($VDO_item->VCH->label==$categorySelected)
				{
					if(array_key_exists($programItem->PID, $this->ArrayShows)==false)
					{
						$this->ArrayShows[$programItem->PID]=$programItem->TIT;
					}
				}	
			}
		}
		return $this->ArrayShows;
	}
	
	public function StreamUrl($showSelected)
	{
		foreach($this->ResultJSON->programFRList as $programItem)
		{
			if ($programItem->PID=$showSelected)
			{
				return File_Video_Url($programItem->VDO->videoStreamUrl);
					
			}
		}
	}
	
	private function File_Video_Url($stream_url)
	{
		$jsonresult=parent::Func_Get_Source_Code_From_JSON($stream_url);
		foreach($jsonresult->video as $videos)
		{
			foreach($videos->VSR as $VSR_Item)
			{
				if($VSR_Item->VFO=='HBBTV' && $VSR_Item->VQU=='HQ')
				{
					return $VSR_Item->VUR;
				}
			}
		}
	}
		
}

		


?>