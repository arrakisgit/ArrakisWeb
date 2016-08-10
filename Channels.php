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
	
	public function __construct()
	{
		parent::__construct();
		$this->URL_CATEGORIES='http://www.arte.tv/papi/tvguide/videos/plus7/program/F/L2/XXX/ALL/-1/AIRDATE_DESC/0/0/DE_FR.json';
		$this->URL_MOST_VIEWED='http://www.arte.tv/papi/tvguide/videos/plus7/program/F/L2/ALL/ALL/-1/VIEWS/0/0/DE_FR.json';
		$this->URL_LAST_CHANCE='http://www.arte.tv/papi/tvguide/videos/plus7/program/F/L2/ALL/ALL/-1/LAST_CHANCE/0/0/DE_FR.json';
		$this->ArrayCategories=Array();
	}
	
	public function Categories()
	{
		$ResultJSON = parent::Func_Get_Source_Code_From_JSON($this->URL_CATEGORIES);
		foreach($ResultJSON->programFRList as $programItem)
		{
			foreach($programItem->VDO as $VDO_item)
			{
				if(array_key_exists($VDO_item->VCH->label,$this->ArrayCategories)==false)
				{
					$ArrayItem=Array();
					
					if(array_key_exists($programItem->PID, $ArrayItem)==false)
					{
						$ArrayItem[$programItem->PID]=$VDO_item->VCH->V7T;
						$this->ArrayCategories[$VDO_item->VCH->label]=$ArrayItem;
					}
					
				}
				else 
				{
					if(array_key_exists($programItem->PID, $ArrayItem)==false)
					{
						$ArrayItem=$this->ArrayCategories[$VDO_item->VCH->label];
						$ArrayItem[$programItem->PID]=$VDO_item->VCH->V7T;
						$this->ArrayCategories[$VDO_item->VCH->label]=$ArrayItem;
					}
					
				}
			}
		}
	}
		
}

?>