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

$replid = $_REQUEST['replid'];
$tgl1 = $_REQUEST['tgl1'];
$tgl2 = $_REQUEST['tgl2'];
$bln = $_REQUEST['bln'];
$th = $_REQUEST['th'];
$kelas = $_REQUEST['kelas'];

OpenDb();
	
$sql = "SELECT t.departemen, a.tahunajaran, s.semester, k.kelas, t.tingkat, p.hariaktif
		FROM tahunajaran a, kelas k, tingkat t, semester s, presensiharian p
		WHERE p.replid = '$replid' AND p.idkelas = k.replid AND k.idtingkat = t.replid AND k.idtahunajaran = a.replid
		  AND p.idsemester = s.replid";   
$result = QueryDB($sql);

$row = mysql_fetch_array($result);
$hariaktif = $row['hariaktif'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Print Student Daily Presence Reports]</title>
</head>
<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">

<?=getHeader($row[departemen])?>
	
<center>
  <font size="4"><strong>CLASS DAILY PRESENCE REPORT CARD</strong></font><br />
 </center><br /><br />
<br />
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
	<td><strong>Class</strong></td>
    <td><strong>: <?=$row['tingkat']. ' - '.$row['kelas']?></strong></td>
</tr>
<tr>
	<td><strong>Period</strong></td>
    <td><strong>: <?=$tgl1.' '.NamaBulan($bln).' '.$th.' to '.$tgl2.' '.NamaBulan($bln).' '.$th ?></strong></td>
</tr>
</table>
<br />
<table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left" bordercolor="#000000">
   	<tr height="30">    	
    	<td class="header" align="center" width="5%">#</td>
		<td class="header" align="center" width="10%">Student ID</td>
		<td class="header" align="center" width="*">Name</td>            
		<td class="header" align="center" width="5%">Attend</td>
        <td class="header" align="center" width="5%">Consent</td>
        <td class="header" align="center" width="5%">Ill</td>
        <td class="header" align="center" width="5%">Absent</td>
        <td class="header" align="center" width="5%">Leave</td>            
        <td class="header" align="center" width="*">Info</td>    
    </tr>
<?	
	$sql = "SELECT s.nis, s.nama, s.idkelas, k.kelas, s.aktif
			FROM siswa s, kelas k
			WHERE s.idkelas = '$kelas' AND s.aktif = 1 AND s.alumni=0 AND k.replid = s.idkelas
			UNION
			SELECT s.nis, s.nama, s.idkelas, k.kelas, s.aktif
			FROM siswa s, phsiswa p, kelas k
			WHERE  p.nis = s.nis AND s.idkelas = k.replid AND p.idpresensi = '$replid' ORDER BY nama";
		
	$result = QueryDb($sql);
	$cnt = 0;
	
	while ($row = mysql_fetch_row($result)) { 
		$hadir = 0;
		$ijin = 0;
		$sakit = 0;
		$cuti = 0;
		$alpa = 0;
		$ket = "";
		
		$pesan = "";
		$tanda = "";
		if ($row[2] <> $kelas) {
			$tanda = "**";					
			$pesan = "Transfer to class ".$row[3];
		} else if ($row[4] == 0) {
			$tanda = "*";
			$pesan = "Student is inactive";
		} 
			
		$sql1 = "SELECT * FROM phsiswa WHERE idpresensi = '$replid' AND nis='$row[0]'";
		$result1 = QueryDb($sql1);
		$row1 = mysql_fetch_array($result1);
		
		if (mysql_num_rows($result1) > 0) {
			$hadir = $row1['hadir'];
			$ijin = $row1['ijin'];
			$sakit = $row1['sakit'];
			$cuti = $row1['cuti'];
			$alpa = $row1['alpa'];
			$ket = $row1['keterangan'];
		
			if ($row[4] == 1) {
				if ($row1['keterangan'] == "Student has just transferred to another class")
					$ket = "";
			}
		} else {
			$cuti = $hariaktif;
			$ket = "Student has just transferred to another class";
			
		}
		
	
	?>
    <tr height="25">    	
    	<td align="center"><?=++$cnt?></td>
		<td align="center"><?=$row[0]?><?=$tanda?></td>
        <td><?=$row[1]?></td>
  		<td align="center"><?=$hadir?></td>
        <td align="center"><?=$ijin?></td>
        <td align="center"><?=$sakit?></td>
        <td align="center"><?=$alpa?></td>
        <td align="center"><?=$cuti?></td>
		
        <td><?=$ket?></td>
    </tr>
<?	} 
	CloseDb() ?>	
    <!-- END TABLE CONTENT -->
</table>
</td>
</tr>
<tr>
	<td>PS: *Student is inactive; **Transfer to another class
    </td>
</tr> 
</table>
</body>
<script language="javascript">
window.print();
</script>
</html>