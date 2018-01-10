<?
/**[N]**
 * JIBAS Road To Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 2.5.2 (October 5, 2011)
 * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * Copyright (C) 2009 PT.Galileo Mitra Solusitama (http://www.galileoms.com)
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 **[N]**/ ?>
<?
function CheckUpgradeMainConfig($relPath)
{
	if (!file_exists("$relPath/include/database.config.php"))
		if (file_exists("$relPath/include/mainconfig.php"))
			UpgradeMainConfig($relPath);
}

function UpgradeMainConfig($relPath)
{
	$license = "<? \r\n/**[N]** \r\n * JIBAS Road To Community \r\n * Jaringan Informasi Bersama Antar Sekolah \r\n *  \r\n * @version: 2.5.2 (October 5, 2011) \r\n * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net) \r\n *  \r\n * Copyright (C) 2009 PT.Galileo Mitra Solusitama (http://www.galileoms.com) \r\n *  \r\n * This program is free software: you can redistribute it and/or modify \r\n * it under the terms of the GNU General Public License as published by \r\n * the Free Software Foundation, either version 3 of the License, or \r\n * (at your option) any later version. \r\n *  \r\n * This program is distributed in the hope that it will be useful, \r\n * but WITHOUT ANY WARRANTY; without even the implied warranty of \r\n * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the \r\n * GNU General Public License for more details. \r\n *  \r\n * You should have received a copy of the GNU General Public License \r\n **[N]**/ ?>\r\n";	
	
	$fConfig = "$relPath/include/mainconfig.php";
	$fHandle = fopen($fConfig, "r");
	$content = fread($fHandle, filesize($fConfig));
	fclose($fHandle);
	
	$varname = array("\$db_host", "\$db_user", "\$db_pass", "\$db_name");
	$varcomment = array("/* Alamat basis data MySQL JIBAS */", 
						"/* User basis data MySQL JIBAS */", 
						"/* Password basis data MySQL JIBAS */", 
						"/* Basis data default JIBAS */");
	CreateSubConfig($license, $content, "$relPath/include/database.config.php", $varname, $varcomment);
	
	$varname = array("\$G_VERSION", "\$G_BUILDDATE", "\$G_COPYRIGHT");
	$varcomment = array("/* Versi SISFO JIBAS */", 
						"/* Build date SISFO JIBAS */", 
						"/* Hak Cipta SISFO JIBAS */");
	CreateSubConfig($license, $content, "$relPath/include/version.config.php", $varname, $varcomment);
	
	$varname = array("\$G_START_YEAR", "\$G_SERVER_ADDR", "\$FS_UPLOAD_DIR", "\$IG_GALLERY_DIR", "\$IS_GALLERY_DIR", "\$G_OS", "\$G_LOKASI");
	$varcomment = array("/* Early year data collection uses SISFO JIBAS */", 
						"/* Application server address is SISFO JIBAS \r\n This address is used to show print header for every reports served by SISFO JIBAS \r\n Use IP address or domain name, do not use localhost */", 
						"/* The directory is used to save uploaded files from Teacher Info application */",
						"/* The directory where image galleries placed for Teacher Info application */",
						"/* The directory where image galleries placed for Student Info application */",
						"/* Operating system ( win | lin ) */", 
						"/* School location */");
	CreateSubConfig($license, $content, "$relPath/include/application.config.php", $varname, $varcomment);
	
	RewriteMainConfig($license, $relPath);		 
}

function SearchLastQuote($line)
{
	$lastquote = -1;
	
	$pos = strpos($line, "=", 0);
	if ($pos !== FALSE)
	{
		$pos = strpos($line, "'", $pos);
		if ($pos !== FALSE)
		{
			$quote = "'";
			$pos = strpos($line, "'", $pos + 1);
			if ($pos !== FALSE)
				$lastquote = $pos;
		}
		else	
		{
			$pos = strpos($line, "\"", 0);
			if ($pos !== FALSE)
			{
				$quote = "\"";
				$pos = strpos($line, "\"", $pos + 1);
				if ($pos !== FALSE)
					$lastquote = $pos;
			}
		}
	}
	
	return $lastquote;
}

function CreateSubConfig($license, $content, $configPath, $varname, $varcomment)
{
	$fHandle = fopen($configPath, "w");
	fwrite($fHandle, $license);
	fwrite($fHandle, "<?\r\n\r\n");
	for($i = 0; $i < count($varname); $i++)
	{
		$var = $varname[$i];
		$cmt = $varcomment[$i];
		
		$pos1 = strpos($content, $var, 0);
		if ($pos1 !== FALSE)
		{
			$pos2 = strpos($content, "\n", $pos1 + 1);
			if ($pos2 !== FALSE)
			{
				$line = substr($content, $pos1, $pos2 - $pos1 + 1);			
				$lastquote = $pos1 + SearchLastQuote($line);
				
				if ($lastquote > $pos1)
				{
					$pos2 = strpos($content, ";", $lastquote);
					if ($pos2 !== FALSE)
					{
						$config = substr($content, $pos1, $pos2 - $pos1 + 1);
						
						fwrite($fHandle, $cmt . "\r\n");
						fwrite($fHandle, $config . "\r\n\r\n");
					}
				}			
			}
		}
	}
	fwrite($fHandle, "?>");
	fclose($fHandle);
	
	chmod($configPath, 0755);
}

function RewriteMainConfig($license, $relPath)
{
	$fHandle = fopen("$relPath/include/mainconfig.php", "w");
	fwrite($fHandle, $license);
	fwrite($fHandle, "<?\r\n\r\n");
	fwrite($fHandle, "require_once('database.config.php');\r\n");
	fwrite($fHandle, "require_once('version.config.php');\r\n");
	fwrite($fHandle, "require_once('application.config.php');\r\n");
	fwrite($fHandle, "\r\n?>");
	fclose($fHandle);
}
?>