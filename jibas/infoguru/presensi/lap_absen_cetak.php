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
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/getheader.php');
$semester = $_REQUEST['semester'];
$tingkat = $_REQUEST['tingkat'];
$kelas = $_REQUEST['kelas'];
$departemen = $_REQUEST['departemen'];
$tglawal = $_REQUEST['tglawal'];
$tglakhir = $_REQUEST['tglakhir'];
$urut = $_REQUEST['urut'];
$urutan = $_REQUEST['urutan'];

OpenDb();

$filter1 = "AND t.departemen = '$departemen'";
if ($tingkat <> -1) 
	$filter1 = "AND k.idtingkat = '$tingkat'";

$filter2 = "";
if ($kelas <> -1) 
	$filter2 = "AND k.replid = '$kelas'";

	
OpenDb();
$sql = "SELECT t.departemen, a.tahunajaran, s.semester, k.kelas, t.tingkat FROM tahunajaran a, kelas k, tingkat t, semester s, presensiharian p WHERE p.idkelas = k.replid AND k.idtingkat = t.replid AND k.idtahunajaran = a.replid AND p.idsemester = s.replid AND s.replid = '$semester' $filter1 $filter2";  

$result = QueryDB($sql);	
$row = mysql_fetch_array($result);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS TEACHERS INFO [Print Absent Student Data Reports]</title>
</head>

<body>

<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">
<?=getHeader($row[departemen])?>
	
<center>
  <font size="4"><strong>ABSENT STUDENT DATA REPORT CARD</strong></font><br />
 </center><br /><br />
<table>
<tr>
	<td width="25%"><strong>Department</strong></td>
    <td><strong>: <?=$row['departemen']?></strong></td>
</tr>
<tr>
	<td><strong>Year</strong></td>
    <td><strong>: <?=$row['tahunajaran']?></strong></td>
</tr>
<tr>
	<td><strong>Semester</strong></td>
    <td><strong>: <?=$row['semester']?></strong></td>
</tr>
<tr>
	<td><strong>Grade</strong></td>
    <td><strong>: <? if ($tingkat == -1) echo "All Tingkat"; else echo $row['tingkat']; ?></strong></td>
</tr>
<tr>
	<td><strong>Class</strong></td>
    <td><strong>: <? if ($kelas == -1) echo "All Classes"; else echo $row['kelas']; ?></strong></td>
</tr>
<tr>
	<td><strong>Period</strong></td>
    <td><strong>: <?=format_tgl($tglawal).' to '. format_tgl($tglakhir) ?></strong></td>
</tr>
</table>
<br />
<? 		
	
	$sql = "SELECT DISTINCT s.nis, s.nama, l.nama, DAY(p.tanggal), MONTH(p.tanggal), YEAR(p.tanggal), pp.statushadir, pp.catatan, s.telponsiswa, s.hpsiswa, s.namaayah, s.telponortu, s.hportu, k.kelas FROM siswa s, presensipelajaran p, ppsiswa pp, pelajaran l, kelas k, tingkat t WHERE pp.idpp = p.replid AND s.idkelas = k.replid AND p.idsemester = '$semester' AND pp.nis = s.nis AND k.idtingkat = t.replid $filter1 $filter2 AND p.tanggal BETWEEN '$tglawal' AND '$tglakhir' AND p.idpelajaran = l.replid AND pp.statushadir <> 0 ORDER BY $urut $urutan";
	//echo $sql;
	$result = QueryDb($sql);			 
	$jum_hadir = mysql_num_rows($result);
	if ($jum_hadir > 0) { 
	
?>      

    <table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left" bordercolor="#000000">
   	<tr height="30">
    	<td class="header" align="center" width="5%">#</td>
		<td class="header" align="center" width="8%">Student ID</td>
		<td class="header" align="center" width="15%">Name</td>
        <? if ($kelas == -1) { ?>
        <td class="header" align="center" width="8%">Class</td>
       	<? } ?>            
		<td class="header" align="center" width="10%">Class Subject</td>
        <td class="header" align="center" width="5%">Date</td>
        <td class="header" align="center">Presence</td>
        <td class="header" align="center" width="10%">Info</td>            
        <td class="header" align="center" width="7%">Student Phone</td>
        <td class="header" align="center" width="10%">Student Mobile</td>
        <td class="header" align="center" width="15%">Parent</td>
        <td class="header" align="center" width="7%">Parent Phone</td>
        <td class="header" align="center" width="10%">Parent Mobile</td>     
    </tr>
<?		
	$cnt = 0;
	while ($row = mysql_fetch_row($result)) { 
		switch ($row[6]){
			case 1 : $st="Consent";
			break;
			case 2 : $st="Ill";
			break;	
			case 3 : $st="Absent";
			break;
			case 4 : $st="Leave";
			break;
		}	
?>
    <tr height="25">    	
    	<td align="center"><?=++$cnt?></td>
		<td align="center"><?=$row[0]?></td>
        <td><?=$row[1]?></td>
          <? if ($kelas == -1) { ?>
            <td align="center"><?=$row[13]?></td>
            <? } ?>
        <td><?=$row[2]?></td>
        <td align="center"><?=$row[3].'-'.$row[4].'-'.substr($row[5],2,2)?></td>
        <td align="center"><?=$st ?></td>
        <td><?=$row[7] ?></td>
        <td><?=$row[8]?></td>
        <td><?=$row[9]?></td>
        <td><?=$row[10]?></td>
        <td><?=$row[11]?></td>
        <td><?=$row[12]?></td>     
    </tr>
<?	} 
	CloseDb() ?>	
    <!-- END TABLE CONTENT -->
    </table>
<? 	} ?>	
	</td>
</tr>
</table>
</body>
<script language="javascript">
window.print();
</script>
</html>