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
require_once('../include/sessionchecker.php');
require_once("../include/config.php");
require_once("../include/db_functions.php");
require_once("../include/common.php");
require_once("../library/chartfactory.php");

$type = $_REQUEST['type'];
$dep = $_REQUEST['dep'];
$angkatan = $_REQUEST['angkatan'];
$krit = $_REQUEST['krit'];

$filter = "";
if ($dep == "-1")
	$filter="AND a.replid=s.idangkatan ";
if ($dep != "-1" && $angkatan == "")
	$filter="AND a.departemen='$dep' AND a.replid=s.idangkatan ";
if ($dep != "-1" && $angkatan != "")
	$filter="AND s.idangkatan='$angkatan' AND a.replid=s.idangkatan AND a.departemen='$dep' ";

if ($krit == 1) 
{
	$bartitle = "Student Data based on Religion";
	$pietitle = "Student Data based on Religion Percentage";
	$xtitle = "Religion";
	$ytitle = "Sum";

	$sql = "SELECT s.agama, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.agama";	
}
elseif ($krit == 2) 
{
	$bartitle = "Student Data based on Past School";
	$pietitle = "Student Data based on Past School Percentage";
	$xtitle = "School";
	$ytitle = "Sum";

	$sql = "SELECT s.asalsekolah, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.asalsekolah";	
}
elseif ($krit == 3) 
{
	$bartitle = "Student Data based on Blood Type";
	$pietitle = "Student Data based on Blood Type Percentage";
	$xtitle = "Blood Type";
	$ytitle = "Sum";

	$sql = "SELECT s.darah, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.darah";	
}
elseif ($krit == 4)
{
	$bartitle = "Student Data based on Gender";
	$pietitle = "Student Data based on Gender Percentage";
	$xtitle = "Gender";
	$ytitle = "Sum";
	$sql	=  "SELECT IF(s.kelamin='l','Male','Female') as X, COUNT(s.nis) FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X";
}
elseif ($krit == 5)
{
	$bartitle = "Student Data based on Citizenship";
	$pietitle = "Student Data based on Citizenship Percentage";
	$xtitle = "Citizenship";
	$ytitle = "Sum";
	$sql = "SELECT s.warga, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.warga ORDER BY s.warga DESC";
}
elseif ($krit == 6)
{
	$bartitle = "Student Data based on Postal Code";
	$pietitle = "Student Data based on Postal Code Percentage";
	$xtitle = "Postal Code";
	$ytitle = "Sum";
	$sql = "SELECT s.kodepossiswa, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.kodepossiswa ";
}
elseif ($krit == 7)
{
	$bartitle = "Student Data based on Student Conditions";
	$pietitle = "Student Data based on Student Conditions Percentage";
	$xtitle = "Conditions";
	$ytitle = "Sum";
	$sql = "SELECT s.kondisi, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.kondisi ";
}
elseif ($krit == 8)
{
	$bartitle = "Student Data based on Father Occupation";
	$pietitle = "Student Data based on Father Occupation Percentage";
	$xtitle = "Occupation";
	$ytitle = "Sum";
	$sql = "SELECT s.pekerjaanayah, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pekerjaanayah ";
}
elseif ($krit == 9)
{
	$bartitle = "Student Data based on Mother Occupation";
	$pietitle = "Student Data based on Mother Occupation Percentage";
	$xtitle = "Occupation";
	$ytitle = "Sum";
	$sql = "SELECT s.pekerjaanibu, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pekerjaanibu ";
}
elseif ($krit == 10)
{
	$bartitle = "Student Data based on Father Education";
	$pietitle = "Student Data based on Father Education Percentage";
	$xtitle = "Educational Level";
	$ytitle = "Sum";
	$sql = "SELECT s.pendidikanayah, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pendidikanayah ";
}
elseif ($krit == 11)
{
	$bartitle = "Student Data based on Mother Education";
	$pietitle = "Student Data based on Mother Education Percentage";
	$xtitle = "Educational Level";
	$ytitle = "Sum";
	$sql = "SELECT s.pendidikanibu, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pendidikanibu ";
}
elseif ($krit == 12)
{
	$bartitle = "Student Data based on \nParent Income";
	$pietitle = "Prosentase Student Data based on \nParent Income";
	$xtitle = "Income";
	$ytitle = "Sum";
	$sql = "SELECT G, COUNT(nis) FROM (
	          SELECT nis, IF(peng < 1000000, '< 1 juta',
                          IF(peng >= 1000001 AND peng <= 2500000, '1 juta - 2,5 juta',
                          IF(peng >= 2500001 AND peng <= 5000000, '2,5 juta - 5 juta',
                          IF(peng >= 5000001 , '> 5 juta', 'No data.')))) AS G,
						  IF(peng < 1000000, '1',
                          IF(peng >= 1000001 AND peng <= 2500000, '2',
                          IF(peng >= 2500001 AND peng <= 5000000, '3',
                          IF(peng >= 5000001 , '4', '5')))) AS GG FROM
                (SELECT s.nis, FLOOR(s.penghasilanibu + s.penghasilanayah) AS peng FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter ) AS X) AS X GROUP BY G ORDER BY GG";
}
elseif ($krit == 13)
{
	$bartitle = "Student Data based on Active Status";
	$pietitle = "Student Data based on Active Status Percentage";
	$xtitle = "Active / Inactive";
	$ytitle = "Sum";
	$sql	=  "SELECT IF(s.aktif=1,'Active','Inactive') as X, COUNT(s.nis) FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X";
}
elseif ($krit == 14)
{
	$bartitle = "Student Data based on Status";
	$pietitle = "Student Data based on Status Percentage";
	$xtitle = "Student Status";
	$ytitle = "Sum";
	$sql = "SELECT s.status as X, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X ";
}
elseif ($krit == 15)
{
	$bartitle = "Student Data based on Ethnicity";
	$pietitle = "Student Data based on Ethnicity Percentage";
	$xtitle = "Ethnicity";
	$ytitle = "Sum";
	$sql = "SELECT s.suku as X, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X ";
}
elseif ($krit == 16)
{
	$bartitle = "Student Data based on Year of Birth";
	$pietitle = "Student Data based on Year of Birth Percentage";
	$xtitle = "Year of Birth";
	$ytitle = "Sum";
	$sql = "SELECT YEAR(s.tgllahir) as X, count(s.replid) FROM 
	        siswa s, angkatan a 
			WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X ORDER BY X ";
}
elseif ($krit == 17)
{
	$bartitle = "Student Data based on Age";
	$pietitle = "Student Data based on Age Percentage";
	$xtitle = "Age";
	$ytitle = "Sum";
	$sql = "SELECT G, COUNT(nis) FROM (
	          SELECT nis, IF(usia < 6, '<6',
                          IF(usia >= 6 AND usia <= 12, '6-12',
                          IF(usia >= 13 AND usia <= 15, '13-15',
                          IF(usia >= 16 AND usia <= 18, '16-18','>18')))) AS G,
						  IF(usia < 6, '1',
                          IF(usia >= 6 AND usia <= 12, '2',
                          IF(usia >= 13 AND usia <= 15, '3',
                          IF(usia >= 16 AND usia <= 18, '4','5')))) AS GG FROM
                (SELECT nis, YEAR(now())-YEAR(s.tgllahir) AS usia FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter ) AS X) AS X GROUP BY G ORDER BY GG";
}
$CF = new ChartFactory();
$CF->SqlData($sql, $bartitle, $pietitle, $xtitle, $ytitle);
if ($type == "bar")
	$CF->DrawBarChart();
elseif($type == "pie")
	$CF->DrawPieChart();
?>