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
		}
		
		$this->JSON_TOKEN_RESULT_BFM_TV=parent::Func_Get_Source_Code_From_JSON_SESSION($this->BFM_TV_URL_TOKEN);
		$this->BFM_TV_TOKEN=$this->JSON_TOKEN_RESULT_BFM_TV['session']['token'];
		$this->BFM_TV_URL_CATEGORIES=$this->BFM_TV_URL_TOKEN.$this->BFM_TV_TOKEN.'/getMainMenu';
		$this->BFM_TV_URL_SHOWS=$this->BFM_TV_URL_TOKEN.$this->BFM_TV_TOKEN.'/getVideosList?count=40&page=1&category=';
		$this->BFM_TV_URL_VIDEOS=$this->BFM_TV_URL_TOKEN.$this->BFM_TV_TOKEN.'/getVideo?idVideo=';
		
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
		


?>