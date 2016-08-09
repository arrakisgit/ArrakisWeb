<?php
$ArrayShows=array();
$wikipediaURL = 'http://www.numero23.fr/replay/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $wikipediaURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resultat = curl_exec ($ch);
curl_close($ch);
$wikipediaPage = new DOMDocument();
$wikipediaPage->loadHTML($resultat);
foreach($wikipediaPage->getElementsByTagName('div') as $div){
	if ($div->getAttribute('class')=='videos replay')
	{
		foreach ($div->getElementsByTagName('div') as $divUnder1)
		{
			if ($divUnder1->getAttribute('class')=='program sticky video')
			{
				foreach ($divUnder1->getElementsByTagName('div') as $divUnder2)
				{
					if ($divUnder2->getAttribute('class')=='figcaption')
					{
						$showName=$divUnder2->getElementsByTagName('h3')->item(0)->nodeValue;
						if(array_key_exists($showName, $ArrayShows)==false)
						{
							echo '<p>'.$showName.'</p>';
							$ArrayShows[$showName]='category';
						}
					}
				}
			}
		}
	}
	
}
?>