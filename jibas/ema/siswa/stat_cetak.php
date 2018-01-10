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
require_once('../inc/sessionchecker.php');
require_once('../inc/config.php');
require_once('../inc/getheader.php');
require_once('../inc/db_functions.php');
require_once('../inc/common.php');

$departemen = '-1';
if (isset($_REQUEST[departemen]))
	$departemen = $_REQUEST[departemen];
$angkatan = '';
if (isset($_REQUEST[angkatan]))
	$angkatan = $_REQUEST[angkatan];
$kriteria = '1';
if (isset($_REQUEST[kriteria]))
	$kriteria = $_REQUEST[kriteria];
if ($departemen=='-1'){
	$ndepartemen = 'All Department';
} else {
	$ndepartemen = $departemen;
}	
if ($angkatan==''){
	$nangkatan = 'All Graduation';
} else {
	OpenDb();
	$sql = "SELECT * FROM angkatan WHERE replid=$angkatan";
	$result = QueryDb($sql);
	$row = @mysql_fetch_array($result);
	$nangkatan = $row[angkatan];
}	
$krit = array('','Religion','Past School','Blood Type','Gender','Citizenship','Student Post Code','Student Conditions','Father Occupation','Mother Occupation','Father Education','Mother Education','Parent Income','Status Active','Student Status','Ethnicity','Year of Birth','Age');
$nkriteria = $krit[$kriteria];
$dep = $departemen;
if ($departemen=='-1')
	$dep = "yayasan";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS EMA [Print Report Card]</title>
</head>

<body>

<table border="0" cellpadding="10" cellspacing="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">
<? getHeader($dep) ?>
	
<center>
  <font size="4"><strong>STUDENT STATISTIC</strong></font><br />
 </center><br /><br />
<table>
<tr>
	<td width="25%" class="news_content1"><strong>Department</strong></td>
    <td class="news_content1">: 
      <?=$ndepartemen?></td>
</tr>
<tr>
	<td class="news_content1"><strong>Graduates</strong></td>
    <td class="news_content1">: 
      <?=$nangkatan?></td>
</tr>
<tr>
	<td class="news_content1"><strong>Criteria</strong></td>
    <td class="news_content1">: 
      <?=$nkriteria ?></td>
</tr>
</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td align="center"><img src="<?="statimage.php?type=bar&dep=$departemen&angkatan=$angkatan&krit=$kriteria" ?>" /></td>
      </tr>
      <tr>
        <td align="center"><img src="<?="statimage.php?type=pie&dep=$departemen&angkatan=$angkatan&krit=$kriteria" ?>" /></td>
      </tr>
      <tr>
        <td align="center">
        <?
		$filter = "";
		if ($departemen == "-1")
			$filter="AND a.replid=s.idangkatan ";
		if ($departemen != "-1" && $angkatan == "")
			$filter="AND a.departemen='$departemen' AND a.replid=s.idangkatan ";
		if ($departemen != "-1" && $angkatan != "")
			$filter="AND s.idangkatan=$angkatan AND a.replid=s.idangkatan AND a.departemen='$departemen' ";
		
		if ($kriteria == 1) 
		{
			$xtitle = "Religion";
			$ytitle = "Sum";
		
			$sql = "SELECT s.agama, count(s.replid), s.agama AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.agama";	
		}
		elseif ($kriteria == 2) 
		{
			$xtitle = "Past School";
			$ytitle = "Sum";
		
			$sql = "SELECT s.asalsekolah, count(s.replid), s.asalsekolah AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.asalsekolah";	
		}
		elseif ($kriteria == 3) 
		{
			$xtitle = "Blood Type";
			$ytitle = "Sum";
		
			$sql = "SELECT s.darah, count(s.replid), s.darah AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.darah";	
		}
		elseif ($kriteria == 4)
		{
			$xtitle = "Gender";
			$ytitle = "Sum";
			$sql	=  "SELECT IF(s.kelamin='l','Male','Female') as X, COUNT(s.nis), s.kelamin AS XX FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X";
		}
		elseif ($kriteria == 5)
		{
			$xtitle = "Citizenship";
			$ytitle = "Sum";
			$sql = "SELECT s.warga, count(s.replid), s.warga AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.warga ORDER BY s.warga DESC";
		}
		elseif ($kriteria == 6)
		{
			$xtitle = "Postal Code";
			$ytitle = "Sum";
			$sql = "SELECT s.kodepossiswa, count(s.replid), s.kodepossiswa AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.kodepossiswa ";
		}
		elseif ($kriteria == 7)
		{
			$xtitle = "Conditions";
			$ytitle = "Sum";
			$sql = "SELECT s.kondisi, count(s.replid), s.kondisi AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.kondisi ";
		}
		elseif ($kriteria == 8)
		{
			$xtitle = "Father Occupation";
			$ytitle = "Sum";
			$sql = "SELECT s.pekerjaanayah, count(s.replid), s.pekerjaanayah AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pekerjaanayah ";
		}
		elseif ($kriteria == 9)
		{
			$xtitle = "Mother Occupation";
			$ytitle = "Sum";
			$sql = "SELECT s.pekerjaanibu, count(s.replid), s.pekerjaanibu AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pekerjaanibu ";
		}
		elseif ($kriteria == 10)
		{
			$xtitle = "Father Education";
			$ytitle = "Sum";
			$sql = "SELECT s.pendidikanayah, count(s.replid), s.pendidikanayah AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pendidikanayah ";
		}
		elseif ($kriteria == 11)
		{
			$xtitle = "Mother Education";
			$ytitle = "Sum";
			$sql = "SELECT s.pendidikanibu, count(s.replid), s.pendidikanibu AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pendidikanibu ";
		}
		elseif ($kriteria == 12)
		{
			$xtitle = "Income";
			$ytitle = "Sum";
			$sql = "SELECT G, COUNT(nis), XX FROM (
					  SELECT nis, IF(peng < 1000000, '< 1 juta',
								  IF(peng >= 1000001 AND peng <= 2500000, '1 juta - 2,5 juta',
								  IF(peng >= 2500001 AND peng <= 5000000, '2,5 juta - 5 juta',
								  IF(peng >= 5000001 , '> 5 juta', 'No data.')))) AS G,
								  IF(peng < 1000000, '1',
								  IF(peng >= 1000001 AND peng <= 2500000, '2',
								  IF(peng >= 2500001 AND peng <= 5000000, '3',
								  IF(peng >= 5000001 , '4', '5')))) AS GG, 
								  IF(peng < 1000000, '(s.penghasilanayah__s.penghasilanibu)<1000000',
								  IF(peng >= 1000001 AND peng <= 2500000, '(s.penghasilanayah__s.penghasilanibu)>=1000001 AND (s.penghasilanayah__s.penghasilanibu)<=2500000',
								  IF(peng >= 2500001 AND peng <= 5000000, '(s.penghasilanayah__s.penghasilanibu)>=2500001 AND (s.penghasilanayah__s.penghasilanibu)<=5000001',
								  IF(peng >= 5000001 , '(s.penghasilanayah__s.penghasilanibu)>=5000001', '(s.penghasilanayah__s.penghasilanibu)=0')))) AS XX FROM
						(SELECT s.nis, FLOOR(s.penghasilanibu + s.penghasilanayah) AS peng FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter ) AS X) AS X GROUP BY G ORDER BY GG";
		}
		elseif ($kriteria == 13)
		{
			$xtitle = "Status Active";
			$ytitle = "Sum";
			$sql	=  "SELECT IF(s.aktif=1,'Active','Inactive') as X, COUNT(s.nis), s.aktif AS XX FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X";
		}
		elseif ($kriteria == 14)
		{
			$xtitle = "Student Status";
			$ytitle = "Sum";
			$sql = "SELECT s.status as X, count(s.replid), s.status AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X ";
		}
		elseif ($kriteria == 15)
		{
			$xtitle = "Ethnicity";
			$ytitle = "Sum";
			$sql = "SELECT s.suku as X, count(s.replid), s.suku AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X ";
		}
		elseif ($kriteria == 16)
		{
			$xtitle = "Year of Birth";
			$ytitle = "Sum";
			$sql = "SELECT YEAR(s.tgllahir) as X, count(s.replid), YEAR(s.tgllahir) AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X ORDER BY X ";
		}
		elseif ($kriteria == 17)
		{
			$xtitle = "Age";
			$ytitle = "Sum";
			$sql = "SELECT G, COUNT(nis), XX FROM (
					  SELECT nis, IF(usia < 6, '<6',
								  IF(usia >= 6 AND usia <= 12, '6-12',
								  IF(usia >= 13 AND usia <= 15, '13-15',
								  IF(usia >= 16 AND usia <= 18, '16-18','>18')))) AS G,
								  IF(usia < 6, '1',
								  IF(usia >= 6 AND usia <= 12, '2',
								  IF(usia >= 13 AND usia <= 15, '3',
								  IF(usia >= 16 AND usia <= 18, '4','5')))) AS GG, 
								  IF(usia < 6, 'YEAR(now())__YEAR(s.tgllahir)<6',
								  IF(usia >= 6 AND usia <= 12, 'YEAR(now())__YEAR(s.tgllahir)>=6 AND YEAR(now())__YEAR(s.tgllahir)<=12',
								  IF(usia >= 13 AND usia <= 15, 'YEAR(now())__YEAR(s.tgllahir)>=13 AND YEAR(now())__YEAR(s.tgllahir)<=15',
								  IF(usia >= 16 AND usia <= 18, 'YEAR(now())__YEAR(s.tgllahir)>=16 AND YEAR(now())__YEAR(s.tgllahir)<=18','YEAR(now())__YEAR(s.tgllahir)>=18')))) AS XX FROM
						(SELECT nis, YEAR(now())-YEAR(s.tgllahir) AS usia FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter ) AS X) AS X GROUP BY G ORDER BY GG";
		}
		
		?>
        <table width="100%" border="1" class="tab" align="center">
          <tr>
            <td height="25" align="center" class="header">#</td>
            <td width="377" height="25" align="center" class="header"><?=$xtitle?></td>
            <td width="760" height="25" align="center" class="header"><?=$ytitle?></td>
            </tr>
          <?
		  OpenDb();
		  $result = QueryDb($sql);
		  $cnt=1;
		  while ($row = @mysql_fetch_row($result)){
		  ?>
          <tr>
            <td width="45" height="20" align="center"><?=$cnt?></td>
            <td height="20">&nbsp;&nbsp;<?=$row[0]?></td>
            <td height="20" align="center"><?=$row[1]?> student</td>
            </tr>
          <?
		  $cnt++;
		  }
		  ?>
        </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>

	</td>
</tr>    
</table>
</body>
<script language="javascript">
window.print();
</script>

</html>