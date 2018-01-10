<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 3.0 (January 09, 2013)
 * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * Copyright (C) 2009 Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
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
require_once("../inc/config.php");
require_once("../inc/db_functions.php");
require_once("../inc/common.php");
require_once("../lib/chartfactory.php");

$type = $_REQUEST['type'];
$krit = $_REQUEST['krit'];


if ($krit == 1) 
{
	$bartitle = "Employee based on Sections";
	$pietitle = "Employee based on Sections Percentage";
	$xtitle = "Sections";
	$ytitle = "Sum";

	$sql = "SELECT bagian, count(replid) FROM 
	        $db_name_sdm.pegawai
			WHERE aktif=1 GROUP BY bagian";	
}
if ($krit == 2) 
{
	$bartitle = "Employee based on Religion";
	$pietitle = "Employee based on Religion Percentage";
	$xtitle = "Religion";
	$ytitle = "Sum";

	$sql = "SELECT agama, count(replid) FROM 
	        $db_name_sdm.pegawai
			WHERE aktif=1 GROUP BY agama";	
}
if ($krit == 3) 
{
	$bartitle = "Employee based on Academic Title";
	$pietitle = "Employee based on Academic Title Percentage";
	$xtitle = "Academic Title";
	$ytitle = "Sum";

	$sql = "SELECT gelar, count(replid) FROM 
	        $db_name_sdm.pegawai
			WHERE aktif=1 GROUP BY gelar";	
}

if ($krit == 4)
{
	$bartitle = "Employee based on Gender";
	$pietitle = "Employee based on Gender Percentage";
	$xtitle = "Gender";
	$ytitle = "Sum";
	$sql	=  "SELECT IF(kelamin='l','Male','Female') as X, COUNT(nip) FROM $db_name_sdm.pegawai  WHERE aktif=1 GROUP BY X";
}

if ($krit == 5)
{
	$bartitle = "Employee based on Active Status";
	$pietitle = "Employee based on Active Status Percentage";
	$xtitle = "Active Status";
	$ytitle = "Sum";
	$sql	=  "SELECT IF(aktif=1,'Active','Inactive') as X, COUNT(nip) FROM $db_name_sdm.pegawai GROUP BY X";
}

if ($krit == 6)
{
	$bartitle = "Employee based on Marital Status";
	$pietitle = "Employee based on Marital Status Percentage";
	$xtitle = "Marital Status";
	$ytitle = "Sum";
	$sql	=  "SELECT IF(nikah='menikah','Married','Not Married') as X, COUNT(nip) FROM $db_name_sdm.pegawai  WHERE aktif=1 GROUP BY X";
}
if ($krit == 7) 
{
	$bartitle = "Employee based on Ethnicity";
	$pietitle = "Employee based on Ethnicity Percentage";
	$xtitle = "Ethnicity";
	$ytitle = "Sum";

	$sql = "SELECT suku, count(replid) FROM 
	        $db_name_sdm.pegawai
			WHERE aktif=1 GROUP BY suku";	
}
if ($krit == 8)
{
	$bartitle = "Employee based on Year Birth";
	$pietitle = "Employee based on Year Birth Percentage";
	$xtitle = "Year Birth";
	$ytitle = "Sum";
	$sql = "SELECT YEAR(tgllahir) as X, count(replid) FROM 
	        $db_name_sdm.pegawai
			WHERE aktif=1 GROUP BY X ORDER BY X ";
}
if ($krit == 9)
{
	$bartitle = "Employee based on Age";
	$pietitle = "Employee based on Age Percentage";
	$xtitle = "Age (year)";
	$ytitle = "Sum";
	$sql = "SELECT G, COUNT(nip) FROM (
	          SELECT nip, IF(usia < 20, '<20',
                          IF(usia >= 20 AND usia <= 30, '20-30',
                          IF(usia >= 30 AND usia <= 40, '30-40',
                          IF(usia >= 40 AND usia <= 50, '40-50','>50')))) AS G,
						  IF(usia < 20, '1',
                          IF(usia >= 20 AND usia <= 30, '2',
                          IF(usia >= 30 AND usia <= 40, '3',
                          IF(usia >= 40 AND usia <= 50, '4','5')))) AS GG FROM
                (SELECT nip, YEAR(now())-YEAR(tgllahir) AS usia FROM $db_name_sdm.pegawai WHERE aktif=1) AS X) AS X GROUP BY G ORDER BY GG";
}
$CF = new ChartFactory();
$CF->SqlData($sql, $bartitle, $pietitle, $xtitle, $ytitle);
if ($type == "bar")
	$CF->DrawBarChart();
elseif($type == "pie")
	$CF->DrawPieChart();
?>