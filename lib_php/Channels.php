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
	public function Seasons($showSelected)
	{
	
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
			if ($programItem['PID']==$showSelected)
			{
				//$urlPath=$programItem['VDO']['videoStreamUrl'];
				return $this->File_Video_Url($programItem['VDO']['videoPlayerUrl']);
			}
		}
	}
	public function Durations($stream_url)
	{
		$jsonresult=parent::Func_Get_Source_Code_From_JSON($stream_url);
		foreach($jsonresult['video'] as $videos)
		{
			return $videos['videoDurationSeconds'];
		}
	}
	
	
	public function Images($stream_url)
	{
		$jsonresult=parent::Func_Get_Source_Code_From_JSON($stream_url);
		foreach($jsonresult['video'] as $videos)
		{
			return $videos['programImage'];
		}
	}
	
	public function Descriptions($stream_url)
	{
		$jsonresult=parent::Func_Get_Source_Code_From_JSON($stream_url);
		foreach($jsonresult['video'] as $videos)
		{
			return $videos['VDE'];
		}
	}
	
	public function File_Video_Url($stream_url)
	{
		$jsonresult=parent::Func_Get_Source_Code_From_JSON_SESSION($stream_url);
		$flag="vide___";
		foreach ($jsonresult['videoJsonPlayer']['VSR'] as $vsr)
		{
			$vformat=$vsr['videoFormat'];
			$vqu=$vsr['VQU'];
			$vurl=$vsr['url'];
			$vmediatype=$vsr['mediaType'];
			$vcode=$vsr['versionShortLibelle'];

			if ($vqu=="HQ" && $vformat=="HBBTV" && $vmediatype=="mp4" && $vcode=="VF")
			{
				$flag=$vurl;
				break;
			}
			else
			{
				$flag="no data available";
			}
			
		}
			
		return $flag;
		
	}
	
	public function Episodes($showSelected)
	{
		
	}
		
}

class NRJPlay extends ScrappingCURL implements IChannel
{
	private $NRJPLAY_URL;
	private $NRJPLAY_ARRAY_CATEGORIES;
	private $NRJPLAY_ARRAY_SHOWS;
	private $NTJPLAY_ARRAY_EPISODES;
	
	public function __construct($channel)
	{
		$this->NRJPLAY_URL='http://www.nrj-play.fr/'.$channel.'/replay';
		$this->NRJPLAY_ARRAY_SHOWS=Array();
		$this->NRJPLAY_ARRAY_CATEGORIES=Array();
		$this->NTJPLAY_ARRAY_EPISODES=Array();
	}
	public function Seasons($showSelected)
	{
		
	}
	public function Categories()
	{
		$html_result=parent::Func_Get_Source_Code_From_URL_HTML5_SESSION($this->NRJPLAY_URL);
		
		foreach($html_result->getElementsByTagName('li') as $elem_div)
		{
			if ($elem_div->getAttribute('class')=='subNav-menu-item')
			{
				foreach($elem_div->getElementsByTagName('a') as $elem_a)	
				{
					if(strpos($elem_a->getAttribute('class'),'active')===false)
					{
						if(array_key_exists($elem_a->nodeValue, $this->NRJPLAY_ARRAY_CATEGORIES)==false)
						{
							$this->NRJPLAY_ARRAY_CATEGORIES[$elem_a->nodeValue]=strrev(explode("/",strrev($elem_a->getAttribute('href')))[0]);
						}
					}
				}
			}
		}
		return $this->NRJPLAY_ARRAY_CATEGORIES;
	}
	
	public function Shows($categorySelected)
	{
		$NRJPLAY_URL_CATEGORIES=$this->NRJPLAY_URL."/".$categorySelected;
		$html_result=parent::Func_Get_Source_Code_From_URL_HTML5_SESSION($NRJPLAY_URL_CATEGORIES);
		foreach($html_result->getElementsByTagName('div') as $elem_div)
		{
			if($elem_div->getAttribute('class')=='row list-programs')
			{
				foreach($elem_div->getElementsByTagName('div') as $elem_details)
				{
					if ($elem_details->getAttribute('class')=='linkProgram-details')
					{
						$elem_a=$elem_details->getElementsByTagName('a');
						$elem_h=$elem_details->getElementsByTagName('h2');
						$title=strrev(explode('/',strrev($elem_a->item(0)->getAttribute('href')))[0]);
						$libelle=$elem_h->item(0)->nodeValue;
						if(array_key_exists($title, $this->NRJPLAY_ARRAY_SHOWS)==false)
						{
							$this->NRJPLAY_ARRAY_SHOWS[$title]=$libelle;
						}
					}
				}
			}
		}
		return $this->NRJPLAY_ARRAY_SHOWS;
	}
	
	public function Episodes($showSelected)
	{
		$NRJPLAY_URL_CATEGORIES=$this->NRJPLAY_URL."/".$showSelected;
		$html_result=parent::Func_Get_Source_Code_From_URL_HTML5_SESSION($NRJPLAY_URL_CATEGORIES);
		foreach($html_result->getElementsByTagName('div') as $elem_select)
		{
			if($elem_select->getAttribute('class')=='diaporama replay-carousel')
			{
				
				foreach($elem_select->getElementsByTagName('div') as $elem_div)
				{
					if ($elem_div->getAttribute('class')=='caption')
					{
						$elem_a=$elem_div->getElementsByTagName('a');
						$title=strrev(explode('/',strrev($elem_a->item(0)->getAttribute('href')))[0]);
						$libelle=$elem_a->item(0)->nodeValue;
						if (is_null($title)==false && empty($title)==false)
						{
							if(array_key_exists($title, $this->NTJPLAY_ARRAY_EPISODES)==false)
							{
								$this->NTJPLAY_ARRAY_EPISODES[$title]=$libelle;
							}
						}
					}
				}
			}
		}
		return $this->NTJPLAY_ARRAY_EPISODES;
	}
	public function StreamUrl($showSelected)
	{
		
	}
	public function Live()
	{
		
	}
	public function Descriptions($stream_url)
	{
		
	}
	public function Images($stream_url)
	{
		
	}
	public function Durations($stream_url)
	{
		
	}
	public function File_Video_Url($stream_url)
	{
		$NRJPLAY_URL_SHOWS=$this->NRJPLAY_URL."/".$stream_url;
		$html_result=parent::Func_Get_Source_Code_From_URL_HTML5_SESSION($NRJPLAY_URL_SHOWS);
		foreach($html_result->getElementsByTagName('div') as $elem_select)
		{
			if($elem_select->getAttribute('class')=='playerVideo replay')
			{
		
				foreach($elem_select->getElementsByTagName('meta') as $elem_meta)
				{
					if ($elem_meta->getAttribute('itemprop')=='contentUrl')
					{
						$url_videos=$elem_meta->getAttribute('content');
						
					}
				}
			}
		}
		return $url_videos;
	}
}
class BFMTV extends ScrappingCURL implements IChannel
{
	private $BFM_TV_TOKEN;
	private $BFM_TV_URL_TOKEN;
	private $BFM_TV_URL_CATEGORIES;
	private $BFM_TV_URL_SHOWS;
	private $BFM_TV_URL_VIDEOS;
	private $JSON_TOKEN_RESULT_BFM_TV;
	private $JSON_CATEGORIES_RESULT_BFM_TV;
	private $JSON_SHOWS_RESULT_BFM_TV;
	private $JSON_VIDEOS_RESULT_BFM_TV;
	
	public function __construct($Channel)
	{
		switch($Channel)
		{
			case 'BFMTV':
				$this->BFM_TV_URL_TOKEN='http://api.nextradiotv.com/bfmtv-android/4/';
			case 'BFMBUSINESS':
				$this->BFM_TV_URL_TOKEN='http://api.nextradiotv.com/bfmbusiness-iphone/3/';
			case 'RMC':
				$this->BFM_TV_URL_CATEGORIES='http://api.nextradiotv.com/rmc-android/';
		}
		
		$this->JSON_TOKEN_RESULT_BFM_TV=parent::Func_Get_Source_Code_From_JSON_SESSION($this->BFM_TV_URL_TOKEN);
		$this->BFM_TV_TOKEN=$this->JSON_TOKEN_RESULT_BFM_TV['session']['token'];
		$this->BFM_TV_URL_CATEGORIES=$this->BFM_TV_URL_TOKEN.$this->BFM_TV_TOKEN.'/getMainMenu';
		$this->BFM_TV_URL_SHOWS=$this->BFM_TV_URL_TOKEN.$this->BFM_TV_TOKEN.'/getVideosList?count=40&page=1&category=';
		$this->BFM_TV_URL_VIDEOS=$this->BFM_TV_URL_TOKEN.$this->BFM_TV_TOKEN.'/getVideo?idVideo=';
		
	}
	public function Seasons($showSelected)
	{
	
	}
	public function Categories()
	{
		$ArrayCategories=Array();
		$json_result=parent::Func_Get_Source_Code_From_JSON_SESSION($this->BFM_TV_URL_CATEGORIES);
		foreach($json_result['menu']['right'] as $menu)
		{
			if ($menu['type']=='REPLAY')
			{
				if(array_key_exists($menu['title'], $ArrayCategories)==false)
				{
					$ArrayCategories[$menu['title']]=$menu['category'];
				}
			}
		}
		return $ArrayCategories;
	}
	public function Shows($categorySelected)
	{
		$ArrayShows=Array();
		$json_result=parent::Func_Get_Source_Code_From_JSON_SESSION($this->BFM_TV_URL_SHOWS.$categorySelected);
		foreach($json_result['videos'] as $videolist)
		{
			if(array_key_exists($videolist['video'], $ArrayShows)==false)
			{
				$ArrayShows[$videolist['video']]=$videolist['title'];
			}
			
		}
		return $ArrayShows;
	}
	public function Episodes($showSelected)
	{
		
	}
	public function StreamUrl($showSelected)
	{
		
	}
	public function Live()
	{
		
	}
	public function Descriptions($stream_url)
	{
		
	}
	public function Images($stream_url)
	{
		
	}
	public function Durations($stream_url)
	{
		
	}
	public function File_Video_Url($stream_url)
	{
		$url_video='';
		$quality=0;
		$json_result=parent::Func_Get_Source_Code_From_JSON_SESSION($this->BFM_TV_URL_VIDEOS.$stream_url.'&quality=2');
		foreach($json_result['video']['medias'] as $media)
		{
			if(intval($media['encoding_rate']>$quality))
			{
				$quality=intval($media['encoding_rate']);
				$url_video=$media['video_url'];
			}
				
		}
		return $url_video;
	}
}

class Itele extends ScrappingCURL implements IChannel
{
	private $ITELE_ARRAY_CATEGORIES;
	private $ITELE_ARRAY_SHOWS;
	private $ITELE_ARRAY_EPISODES;
	private $ITELE_URL;
	private $ITELE_FOLDER_CATEGORIES;
	
	public function __construct()
	{
		$this->ITELE_ARRAY_CATEGORIES=Array();
		$this->ITELE_URL='http://service.itele.fr/iphone/';
		$this->ITELE_FOLDER_CATEGORIES='categorie_news?query=';
		$this->ITELE_ARRAY_CATEGORIES['Alaune']=$this->ITELE_URL.'topnews';
		$this->ITELE_ARRAY_CATEGORIES['Dernieresemissions']=$this->ITELE_URL.'dernieres_emissions';
		$this->ITELE_ARRAY_CATEGORIES['France']=$this->ITELE_URL.$this->ITELE_FOLDER_CATEGORIES.'france';
		$this->ITELE_ARRAY_CATEGORIES['Monde']=$this->ITELE_URL.$this->ITELE_FOLDER_CATEGORIES.'monde';
		$this->ITELE_ARRAY_CATEGORIES['Politique']=$this->ITELE_URL.$this->ITELE_FOLDER_CATEGORIES.'politique';
		$this->ITELE_ARRAY_CATEGORIES['Justice']=$this->ITELE_URL.$this->ITELE_FOLDER_CATEGORIES.'justique';
		$this->ITELE_ARRAY_CATEGORIES['Economie']=$this->ITELE_URL.$this->ITELE_FOLDER_CATEGORIES.'economie';
		$this->ITELE_ARRAY_CATEGORIES['Sport']=$this->ITELE_URL.$this->ITELE_FOLDER_CATEGORIES.'sport';
		$this->ITELE_ARRAY_CATEGORIES['Culture']=$this->ITELE_URL.$this->ITELE_FOLDER_CATEGORIES.'culture';
		$this->ITELE_ARRAY_CATEGORIES['Insolite']=$this->ITELE_URL.$this->ITELE_FOLDER_CATEGORIES.'insolite';
		$this->ITELE_ARRAY_SHOWS=Array();
		$this->ITELE_ARRAY_EPISODES=Array();

	}
	public function Categories()
	{
		$Array_Categories=Array();
		$Array_Categories['A la une']='Alaune';
		$Array_Categories['Dernieres emissions']='Dernieresemissions';
		$Array_Categories['France']='France';
		$Array_Categories['Monde']='Monde';
		$Array_Categories['Politique']='Politique';
		$Array_Categories['Justice']='Justique';
		$Array_Categories['Economie']='Economie';
		$Array_Categories['Sport']='Sport';
		$Array_Categories['Culture']='Culture';
		$Array_Categories['Insolite']='Insolite';
		
		return $Array_Categories;
		
	}
	public function Seasons($showSelected)
	{
	
	}
	public function Shows($categorySelected)
	{
		$json_result=parent::Func_Get_Source_Code_From_JSON_SESSION($this->ITELE_ARRAY_CATEGORIES[$categorySelected]);
		
		if ($categorySelected=='Alaune')
		{
			$elem='topnews';
		}
		elseif($categorySelected=='Dernieresemissions')
		{
			$elem='videos';
		}
		else
		{
			$elem='news';
		}
		
		foreach($json_result[$elem] as $cat)
		{
			$this->ITELE_ARRAY_SHOWS[$cat['uid']]=$cat['title'];
		}
		
		return $this->ITELE_ARRAY_SHOWS;
		//return $this->ITELE_ARRAY_CATEGORIES[$categorySelected];
	}
	public function Episodes($showSelected)
	{
		
	}
	public function StreamUrl($showSelected)
	{
		
	}
	public function Live()
	{
		
	}
	public function Descriptions($stream_url)
	{
		
	}
	public function Images($stream_url)
	{
		
	}
	public function Durations($stream_url)
	{
		
	}
	public function File_Video_Url($stream_url)
	{
		$json_result=parent::Func_Get_Source_Code_From_JSON_SESSION($this->ITELE_ARRAY_CATEGORIES[$stream_url[1]]);
		if ($stream_url[1]=='Alaune')
		{
			$elem='topnews';
		}
		elseif($stream_url[1]=='Dernieresemissions')
		{
			$elem='videos';
		}
		else
		{
			$elem='news';
		}
		foreach($json_result[$elem] as $cat)
		{
			if ($cat['uid']==$stream_url[2])
			{
				return $cat['video_url'];
			}
		}
		
		return $this->ITELE_ARRAY_SHOWS;
	}
}

class FranceTV extends ScrappingCURL implements IChannel
{
	private $URL_BASE_VIDEOS;
	private $URL_BASE_IMAGES;
	private $ROOT_JSON_FILES;
	private $FILE_JSON_FRANCE2;
	private $FILE_JSON_FRANCE3;
	private $FILE_JSON_FRANCE4;
	private $FILE_JSON_FRANCE5;
	private $FILE_JSON_FRANCEO;
	private $JSON_RESULT_FRANCETV;
	private $JSON_RESULT_CATEGORIES_FRANCETV;
	private $FRANCETV_CATEGORIES;
	private $FRANCETV_SHOWS;
	private $FRANCETV_EPISODES;
	
	public function __construct($FranceTvChannel)
	{
		$this->ROOT_JSON_FILES="http://192.168.0.18/ArrakisWeb_Lib/libs_json/FranceTV/";
		$this->FILE_JSON_FRANCE2=$this->ROOT_JSON_FILES."catch_up_france2.json";
		$this->FILE_JSON_FRANCE3=$this->ROOT_JSON_FILES."catch_up_france3.json";
		$this->FILE_JSON_FRANCE4=$this->ROOT_JSON_FILES."catch_up_france4.json";
		$this->FILE_JSON_FRANCE5=$this->ROOT_JSON_FILES."catch_up_france5.json";
		$this->FILE_JSON_FRANCEO=$this->ROOT_JSON_FILES."catch_up_franceo.json";
		$jsonresult=parent::Func_Get_Source_Code_From_JSON_SESSION($this->ROOT_JSON_FILES."message_FT.json");
		$this->URL_BASE_VIDEOS=$jsonresult['configuration']['url_base_videos'];
		$this->URL_BASE_IMAGES=$jsonresult['configuration']['url_base_images'];
		$this->JSON_RESULT_CATEGORIES_FRANCETV=parent::Func_Get_Source_Code_From_JSON_SESSION($this->ROOT_JSON_FILES."categories.json");
		$this->FRANCETV_CATEGORIES=Array();
		$this->FRANCETV_EPISODES=Array();
		$this->FRANCETV_SHOWS=Array();
		
		switch ($FranceTvChannel)
		{
			case 'France2':
				$this->JSON_RESULT_FRANCETV=parent::Func_Get_Source_Code_From_JSON_SESSION($this->FILE_JSON_FRANCE2);
				break;
			case 'France3':
				$this->JSON_RESULT_FRANCETV=parent::Func_Get_Source_Code_From_JSON_SESSION($this->FILE_JSON_FRANCE3);
				break;
			case 'France4':
				$this->JSON_RESULT_FRANCETV=parent::Func_Get_Source_Code_From_JSON_SESSION($this->FILE_JSON_FRANCE4);
				break;
			case 'France5':
				$this->JSON_RESULT_FRANCETV=parent::Func_Get_Source_Code_From_JSON_SESSION($this->FILE_JSON_FRANCE5);
				break;
			case 'FranceO':
				$this->JSON_RESULT_FRANCETV=parent::Func_Get_Source_Code_From_JSON_SESSION($this->FILE_JSON_FRANCEO);
				break;
		}
	}
	public function Seasons($showSelected)
	{
	
	}
	public function Categories()
	{
		$ARRAY_CATEGORIES=Array();
		foreach($this->JSON_RESULT_CATEGORIES_FRANCETV['categories'] as $categories)
		{
			foreach($categories['genres'] as $genres)
			{
				if(array_key_exists($genres['genre'], $this->FRANCETV_CATEGORIES)==false)
				{
					$this->FRANCETV_CATEGORIES[str_replace('é','e',$genres['genre'])]=str_replace('é','e',$categories['titre']);
				}
			}

			foreach($categories['formats'] as $formats)
			{
				if(array_key_exists($formats['format'], $this->FRANCETV_CATEGORIES)==false)
				{
					$this->FRANCETV_CATEGORIES[str_replace('é','e',$formats['format'])]=str_replace('é','e',$categories['titre']);
				}
			}
					
		}
		
		foreach($this->FRANCETV_CATEGORIES as $gender=>$title)
		{
			if(array_key_exists($title, $ARRAY_CATEGORIES)==false)
			{
					$title=str_replace('é','e',$title);
					
					if ($title=="Serie & Fiction")
					{
						$ARRAY_CATEGORIES["Serie"]="Serie";
					}
					else
					{
						$ARRAY_CATEGORIES[$title]=$title;
					}
				
			}
		}
		
		return $ARRAY_CATEGORIES;//var_dump($this->JSON_RESULT_CATEGORIES_FRANCETV['categories'][0]['genres'][0]['genre']);//
	}
	
	public function Shows($categorySelected)
	{
		$arrayDump = Array();
		if ($categorySelected=="Serie")
		{
			$categorySelected="Serie & Fiction";
		}
		
		$arrayDump=$this->Categories();
		foreach($this->JSON_RESULT_FRANCETV['programmes'] as $program)
		{
			$currentprog='vide';
			$genreprg=str_replace('\\u00e9','e',str_replace('é','e',$program['genre_simplifie']));
			$formatprg=str_replace('\\u00e9','e',str_replace('é','e',$program['format']));
			
			if(array_key_exists($genreprg, $this->FRANCETV_CATEGORIES)==true)
			{
				$currentprog=$genreprg;
			}
			elseif(array_key_exists($formatprg, $this->FRANCETV_CATEGORIES)==true)
			{
				$currentprog=$formatprg;
			}
			
			if ($currentprog!='vide')
			{
				if($this->FRANCETV_CATEGORIES[$currentprog]==$categorySelected)
				{
					if(array_key_exists($program['id_programme'], $this->FRANCETV_SHOWS)==false)
					{
						$this->FRANCETV_SHOWS[$program['id_programme']]=$program['titre'];
					}
				}
			}
		}
		return $this->FRANCETV_SHOWS;
	}
	
	public function Episodes($showSelected)
	{
		//$categShow=explode('_', $showSelected);
		$this->FRANCETV_SHOWS=$this->Shows($showSelected[1]);
		
		foreach($this->JSON_RESULT_FRANCETV['programmes'] as $program)
		{
			if($program['id_programme']==$showSelected[2])
			{
				if(array_key_exists($program['id_diffusion'], $this->FRANCETV_EPISODES)==false)
				{
					$this->FRANCETV_EPISODES[$program['id_diffusion']]=$program['titre'];
				}
			}
		}
		return $this->FRANCETV_EPISODES;
	}
	
	public function StreamUrl($showSelected)
	{
		
	}
	
	public function Live()
	{
		
	}
	
	public function Descriptions($stream_url)
	{
		
	}
	
	public function Images($stream_url)
	{
		
	}
	
	public function Durations($stream_url)
	{
		
	}
	
	public function File_Video_Url($showSelected)
	{
		$this->FRANCETV_SHOWS=$this->Shows($showSelected[1]);
		foreach($this->JSON_RESULT_FRANCETV['programmes'] as $program)
		{
			if($program['id_diffusion']==$showSelected[2])
			{
				return $this->URL_BASE_VIDEOS.$program['url_video'];
			}
		}
	}
	
}

class Kodi extends ScrappingCURL implements IChannel
{
	private $KODI_URL_HOST;
	private $KODI_HOST_PORT;
	private $KODI_ARRAY_CATEGORIES;
	private $KODI_ARRAY_SHOWS;
	private $KODI_ARRAY_SEASONS;
	private $KODI_ARRAY_EPISODES;
	
	public function __construct($host,$port)
	{
		$this->KODI_URL_HOST=$host;
		$this->KODI_HOST_PORT=$port;
		$this->KODI_ARRAY_CATEGORIES=array();
		$this->KODI_ARRAY_SHOWS=array();
		$this->KODI_ARRAY_SEASONS=array();
		$this->KODI_ARRAY_EPISODES=array();
		
	}
	public function Categories()
	{
		$resulJSON=parent::Func_Send_JSON_POST_KODI($this->KODI_URL_HOST, $this->KODI_HOST_PORT, 'tvshows','');
		//return $resulJSON;
		foreach($resulJSON['result']['tvshows'] as $tvshow)
		{
			foreach ($tvshow['genre'] as $genre_item)
			{
				if (array_key_exists($genre_item, $this->KODI_ARRAY_CATEGORIES)==false)
				{
					$this->KODI_ARRAY_CATEGORIES[$genre_item]=$genre_item;
				}
			}
		}
		return $this->KODI_ARRAY_CATEGORIES;
	}
	
	public function Shows($categorySelected)
	{
		$resulJSON=parent::Func_Send_JSON_POST_KODI($this->KODI_URL_HOST, $this->KODI_HOST_PORT, 'tvshows','');
		//return $resulJSON;
		foreach($resulJSON['result']['tvshows'] as $tvshow)
		{
			foreach ($tvshow['genre'] as $genre_item)
			{
				if ($genre_item==$categorySelected)
				{
					if (array_key_exists($tvshow['title'],$this->KODI_ARRAY_SHOWS)==false)
					{
						$this->KODI_ARRAY_SHOWS[$tvshow['tvshowid']]=$tvshow['title'];
					}
				}
			}
		}
		return $this->KODI_ARRAY_SHOWS;
	}
	public function Episodes($showSelected)
	{
		$idShow=$showSelected[2];
		$idSeason=$showSelected[3];
		$pConcat=$idShow.'_'.$idSeason;
		
		$resulJSON=parent::Func_Send_JSON_POST_KODI($this->KODI_URL_HOST, $this->KODI_HOST_PORT, 'tvshows_episodes_details',$pConcat);
		//return $resulJSON;
		foreach($resulJSON['result']['episodes'] as $tvshow_result)
		{
			//if ($tvshow_result['seasonid']==$idSeason)
			//{
				if(array_key_exists($tvshow_result['episodeid'], $this->KODI_ARRAY_EPISODES)==false)
				{
					$this->KODI_ARRAY_EPISODES[$tvshow_result['episodeid']]=$tvshow_result['label'];
				}
			//}
		}
		return $this->KODI_ARRAY_EPISODES;
		
	}
	public function Seasons($showSelected)
	{
		$resulJSON=parent::Func_Send_JSON_POST_KODI($this->KODI_URL_HOST, $this->KODI_HOST_PORT, 'tvshows_episodes',$showSelected);
		//return $resulJSON;
		foreach($resulJSON['result']['seasons'] as $tvshow_season)
		{
			if(array_key_exists($tvshow_season['season'], $this->KODI_ARRAY_SEASONS)==false)
			{
				$this->KODI_ARRAY_SEASONS[$tvshow_season['season']]=$tvshow_season['label'];
			}
		}
		return $this->KODI_ARRAY_SEASONS;
	}
	public function StreamUrl($showSelected)
	{
		
	}
	public function Live()
	{
		
	}
	public function Descriptions($stream_url)
	{
		
	}
	public function Images($stream_url)
	{
		
	}
	public function Durations($stream_url)
	{
		
	}
	public function File_Video_Url($stream_url)
	{
		
	}
}
		


?>