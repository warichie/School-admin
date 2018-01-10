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

header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=LaporanPresensiSiswa.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

$nis = $_REQUEST['nis'];
$tglawal = $_REQUEST['tglawal'];
$tglakhir = $_REQUEST['tglakhir'];
$urut = $_REQUEST['urut'];	
$urutan = $_REQUEST['urutan'];	
$urut1 = $_REQUEST['urut1'];	
$urutan1 = $_REQUEST['urutan1'];	


OpenDb();
$sql = "SELECT nama FROM siswa WHERE nis='$nis'";   
$result = QueryDB($sql);	
$row = mysql_fetch_array($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Print Student Presence Report]</title>
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-family: Verdana;
}
.style4 {font-family: Verdana; font-weight: bold; font-size: 12px; }
.style5 {font-family: Verdana}
.style6 {font-size: 12px}
.style7 {font-family: Verdana; font-size: 12px; }
-->
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="0">
  <tr>
    <th scope="row" colspan="8"><span class="style1">Student Presence Report</span></th>
  </tr>
</table>
<br />
<table width="27%">
<tr>
	<td><span class="style4">Student</span></td>
    <td width="57%" colspan="7"><span class="style4">: <?=$nis.' - '.$row['nama']?></span></td>
</tr>
<!--<tr>
	<td><strong>Name</strong></td>
    <td><strong>: <?=$row['nama']?></strong></td>
</tr>-->
<tr>
	<td><span class="style4">Period</span></td>
    <td colspan="7"><span class="style4">: <?=format_tgl($tglawal).' to '. format_tgl($tglakhir) ?></span></td>
</tr>
</table>
<br />
<? 		
	OpenDb();
	$sql = "SELECT k.kelas, DAY(p.tanggal), MONTH(p.tanggal), YEAR(p.tanggal), p.jam, pp.catatan, l.nama, g.nama, p.materi, pp.replid FROM presensipelajaran p, ppsiswa pp, jbssdm.pegawai g, kelas k, pelajaran l WHERE pp.idpp = p.replid AND p.idkelas = k.replid AND p.idpelajaran = l.replid AND p.gurupelajaran = g.nip AND pp.nis = '$nis' AND p.tanggal BETWEEN '$tglawal' AND '$tglakhir' AND pp.statushadir = 0 ORDER BY $urut $urutan" ;
	$result = QueryDb($sql);			 
	$jum_hadir = mysql_num_rows($result);
	
	$sql1 = "SELECT k.kelas, DAY(p.tanggal), MONTH(p.tanggal), YEAR(p.tanggal), p.jam, pp.catatan, l.nama, g.nama, p.materi, pp.replid FROM presensipelajaran p, ppsiswa pp, jbssdm.pegawai g, kelas k, pelajaran l WHERE pp.idpp = p.replid AND p.idkelas = k.replid AND p.idpelajaran = l.replid AND p.gurupelajaran = g.nip AND pp.nis = '$nis' AND p.tanggal BETWEEN '$tglawal' AND '$tglakhir' AND pp.statushadir <> 0 ORDER BY $urut $urutan" ;
	$result1 = QueryDb($sql1);			 
	$jum_absen = mysql_num_rows($result1);

	if ($jum_hadir > 0) { 
	?>
	
    <strong>Attendance Data</strong>
    <table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="center">
   	<tr height="30" align="center">		
    	<td width="5%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>#</strong></td>
      	<td width="5%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Date</strong></td>            
      	<td width="5%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Time</strong></td>
        <td width="5%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Class</strong></td>
      	<td width="25%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Notes</strong></td>
      	<td width="15%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Class Subject</strong></td>
      	<td width="15%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Teacher</strong></td>
      	<td width="25%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Class Subject</strong></td>       
    </tr>
	<? 
    $cnt = 1;
    while ($row = @mysql_fetch_row($result)) {					
    ?>	
     <tr height="25" valign="middle">        			
        <td align="center" valign="middle"><span class="style7"><?=$cnt?></span></td>
      	<td align="center" valign="middle"><span class="style7">
		<?=$row[1].'-'.$row[2].'-'.substr($row[3],2,2)?></span></td>
      	<td align="center" valign="middle"><span class="style7"><?=substr($row[4],0,5)?></span></td>
        <td align="center" valign="middle"><span class="style7"><?=$row[0]?></span></td>
      	<td valign="middle"><span class="style7"><?=$row[5]?></span></td>
      	<td valign="middle"><span class="style7"><?=$row[6]?></span></td>
      	<td valign="middle"><span class="style7"><?=$row[7]?></span></td>
      	<td valign="middle"><span class="style7"><?=$row[8]?></span></td>    
    </tr>
<?		$cnt++;
    } 
    CloseDb();	?>
    </table>
<? 	} 
	if ($jum_absen > 0) { 
	?>
   	<br /><strong>Absent Data</strong>
    
    <table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="center">
    <tr height="30" align="center">		
		<td width="5%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>#</strong></td>
      	<td width="5%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Class</strong></td>
      	<td width="5%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Date</strong></td>            
      	<td width="5%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Time</strong></td>
      	<td width="25%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Notes</strong></td>
      	<td width="15%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Class Subject</strong></td>
   	  <td width="15%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Teacher</strong></td>
      	<td width="25%" bgcolor="#CCCCCC" class="style6 style5 header"><strong>Class Subject</strong></td>      	
    </tr>
	<? 
    $cnt = 1;
    while ($row1 = @mysql_fetch_row($result1)) {					
    ?>	
    <tr height="25">        			
        <td valign="middle" align="center"><span class="style7"><?=$cnt?></span></td>
        <td valign="middle" align="center"><span class="style7"><?=$row1[0]?></span></td>
        <td valign="middle" align="center"><span class="style7">
		<?=$row1[1].'-'.$row1[2].'-'.substr($row1[3],2,2)?></span></td>
        <td valign="middle" align="center"><span class="style7"><?=substr($row1[4],0,5)?></span></td>
        <td valign="middle"><span class="style7"><?=$row1[5]?></span></td>
        <td valign="middle"><span class="style7"><?=$row1[6]?></span></td>
        <td valign="middle"><span class="style7"><?=$row1[7]?></span></td>
        <td valign="middle"><span class="style7"><?=$row1[8]?></span></td>        
    </tr>
<?		$cnt++;
    } 
    CloseDb();	?>
	  </table>	 
<? 	} ?> 
	
	<br />
    <table width="100%" border="0" align="center">
    <tr>
        <td width="21%" ><span class="style7"><b>Sum Attend</b></span></td>
        <td><span class="style7"><b>: <?=$jum_hadir ?></b></span></td>
    </tr>
    <tr>
        <td><span class="style7"><b>Sum Absent</b></span></td>
        <td><span class="style7"><b>: <?=$jum_absen ?></b></span></td>
    </tr>
    <tr>
        <td><span class="style7"><b>Due</b></span></td>
        <td><span class="style7"><b>: <? $total = $jum_hadir+$jum_absen;
                echo $total ?></b></span></td>
    </tr>
    <tr>
        <td><span class="style7"><b>Attendance Percentage</b></span></td>
        <td><span class="style7"><b>: <? 	if ($total == 0) 
                    $total = 1;
                $prs = (( $jum_hadir/$total)*100) ;
                echo (int)$prs ?>%</b></span></td>
    </tr>
	</table>

</body>
<script language="javascript">
window.print();
</script>
</html>