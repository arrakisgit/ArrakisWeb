<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 16/08/2016 O1:35 AM
 *Licence     : GNU GPL v3
 *Description : Fonctions de gestion des fichiers HTML/JSON
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

function ExcuteShell($cmd)
{
	$output = shell_exec($cmd);

}

function FileCopy($fileUrl,$zipPath)
{
	
	$newfile = $zipPath.basename($fileUrl);
	
	if ( copy($fileUrl, $newfile) )
	{
		return $newfile;
	}
	else
	{
		return "Copy failed.";
	}
}

function unzip_file($file, $destination) 
{
	
	$zip = new ZipArchive() ;
	if ($zip->open($file) !== true)
	{
		return false;
	}
	$zip->extractTo($destination);
	$zip->close();
	return true;
	
}

function FileDelete($pathFile)
{
	if (file_exists($value)) 
	{
		unlink($value);
		return true;
	} 
	else 
	{
		return false;
	}
}

function DirectoryScan($pathFolder)
{
	if ($handle = opendir($pathFolder))
	{
	
		while (false !== ($entry = readdir($handle))) 
		{
	
			if ($entry != "." && $entry != "..") 
			{
	
				echo "$entry\n";
			}
		}
	
		closedir($handle);
	}
}

?>