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
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('../script/as-diagrams.php');
require_once('../include/getheader.php');
$kelas = $_REQUEST['kelas'];
$nis = $_REQUEST['nis'];

OpenDb();
$sql = "SELECT t.departemen, a.tahunajaran, k.kelas, t.tingkat, s.nama, a.tglmulai, a.tglakhir FROM tahunajaran a, kelas k, tingkat t, siswa s WHERE k.idtingkat = t.replid AND k.idtahunajaran = a.replid AND k.replid = $kelas AND s.nis = '$nis'";  

$result = QueryDB($sql);	
$row = mysql_fetch_array($result);
$tglmulai = $row['tglmulai'];
$tglakhir = $row['tglakhir'];
$nama = $row['nama'];
$departemen = $row['departemen'];
$tahunajaran = $row['tahunajaran'];
$kls = $row['kelas'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS TEACHERS INFO [Print Class Presence Statistic]</title>
</head>

<body>

<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">
<? getHeader($departemen) ?>
	
<center>
  <font size="4"><strong>CLASS PRESENCE STATISTIC</strong></font><br />
 </center><br /><br />
<table>
<tr>
	<td width="25%"><strong>Student</strong></td>
    <td><strong>: <?=$nis.' - '.$nama?></strong></td>
</tr>
<tr>
	<td width="25%"><strong>Department</strong></td>
    <td><strong>: <?=$departemen?></strong></td>
</tr>
<tr>
	<td><strong>Year</strong></td>
    <td><strong>: <?=$tahunajaran?></strong></td>
</tr>
<tr>
	<td><strong>Class</strong></td>
    <td><strong>: <?=$kls ?></strong></td>
</tr>

</table>
<br />
<table width="100%">
<tr>
	<td colspan="2" align="center"> 
<? 	OpenDb();
	$sql1 = "SELECT CONCAT(DATE_FORMAT(tanggal,'%b'),' ',YEAR(tanggal)) AS blnthn, SUM(IF(statushadir = 0,1,0)), SUM(IF(statushadir = 1,1,0)), SUM(IF(statushadir = 2,1,0)), SUM(IF(statushadir = 4,1,0)), SUM(IF(statushadir = 3,1,0)), MONTH(tanggal) FROM presensipelajaran p, ppsiswa pp WHERE pp.nis = '$nis' AND pp.idpp = p.replid AND p.idkelas = $kelas AND p.tanggal BETWEEN '$tglawal' AND '$tglakhir' GROUP BY blnthn ORDER BY YEAR(tanggal), MONTH(tanggal)";

	$result1 = QueryDb($sql1);
	$num = mysql_num_rows($result1);
	
	$data = array();

	while($row1 = mysql_fetch_row($result1)) {
		$data[] = array($row1[1],$row1[2],$row1[3],$row1[4],$row1[5]);
		$legend_x[] = $row1[0];			
    }
	
	$legend_y = array('Attend','Consent','Ill','Absent', 'Leave');

    $graph = new CAsBarDiagram;
    $graph->bwidth = 10; // set one bar width, pixels
    $graph->bt_total = 'Total'; // 'totals' column title, if other than 'Totals'
    // $graph->showtotals = 0;  // uncomment it if You don't need 'totals' column
    $graph->precision = 1;  // decimal precision
    // call drawing function
    $graph->DiagramBar($legend_x, $legend_y, $data, $data_title);
	
?>
	</td>
</tr>
<tr>
	<td colspan="2"><br />
    <table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="left" bordercolor="#000000">
   	<tr height="30" align="center">		
        <td width="*" class="header">Month</td>
        <td width="15%" class="header">Attend</td>
        <td width="15%" class="header">Consent</td>
        <td width="15%" class="header">Ill</td>
        <td width="15%" class="header">Absent</td>
        <td width="15%" class="header">Leave</td>
    </tr>
	<? 
    
    $result2 = QueryDb($sql1);
    while ($row2 = @mysql_fetch_row($result2)) {		
        $waktu = explode(" ",$row2[0]);
    ?>	
    <tr height="25">        			
        <td align="center"><?=NamaBulan($row2[6]).' '.$waktu[1]?></td>
        <td align="center"><?=$row2[1]?></td>
        <td align="center"><?=$row2[2]?></td>
        <td align="center"><?=$row2[3]?></td>
        <td align="center"><?=$row2[4]?></td>
        <td align="center"><?=$row2[5]?></td>
    </tr>
			
<?	} 
	CloseDb() ?>	
	<!-- END TABLE CONTENT -->
	</table>
	</td>
</tr>    
</table>
</body>
<script language="javascript">
window.print();
</script>

</html>