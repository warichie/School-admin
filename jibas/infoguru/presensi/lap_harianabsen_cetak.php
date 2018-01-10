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
$departemen = $_REQUEST['departemen'];
$semester = $_REQUEST['semester'];
$kelas = $_REQUEST['kelas'];
$tingkat = $_REQUEST['tingkat'];
$tglawal = $_REQUEST['tglawal'];
$tglakhir = $_REQUEST['tglakhir'];
$urut = $_REQUEST['urut'];
$urutan = $_REQUEST['urutan'];

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
<title>JIBAS TEACHERS INFO [Print Absent Student Daily Reports]</title>
</head>

<body>

<table border="0" cellpadding="10" cellspacing="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">
<?=getHeader($row[departemen])?>
	
<center>
  <font size="4"><strong>ABSENT STUDENT DAILY REPORT CARD</strong></font><br />
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
<? 	OpenDb();
	$sql = "SELECT s.nis, s.nama, SUM(ph.hadir), SUM(ph.ijin) AS ijin, SUM(ph.sakit) AS sakit, SUM(ph.alpa) AS alpa, SUM(ph.cuti) AS cuti, k.kelas, s.hportu, s.emailayah, s.alamatortu, s.telponortu, s.hpsiswa, s.emailsiswa, s.aktif, s.emailibu FROM siswa s LEFT JOIN (phsiswa ph INNER JOIN presensiharian p ON p.replid = ph.idpresensi) ON ph.nis = s.nis, kelas k, tingkat t WHERE k.replid = s.idkelas AND k.idtingkat = t.replid $filter1 $filter2 AND p.idsemester = '$semester' AND (((p.tanggal1 BETWEEN '$tglawal' AND '$tglakhir') OR (p.tanggal2 BETWEEN '$tglawal' AND '$tglakhir')) OR (('$tglawal' BETWEEN p.tanggal1 AND p.tanggal2) OR ('$tglakhir' BETWEEN p.tanggal1 AND p.tanggal2))) GROUP BY s.nis HAVING ijin>0 OR sakit>0 OR cuti>0 OR alpa>0 ORDER BY $urut $urutan";
	
	$result = QueryDb($sql);
	$jum = mysql_num_rows($result);
	if ($jum > 0) { 
?>
	<table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="left" bordercolor="#000000">
   	<tr height="30" align="center">
    	<td width="5%" class="header">#</td>
		<td width="10%" class="header">Student ID</td>
        <td width="10%" class="header">Name</td>
   		<td width="5%" class="header">Class</td>
        <td width="*" class="header">Parent</td>
   		<td width="5%" class="header">Attend</td>
		<td width="5%" class="header">Consent</td>            
		<td width="5%" class="header">Ill</td>
        <td width="5%" class="header">Absent</td>
        <td width="5%" class="header">Leave</td>
        
    </tr>
<?		
	$cnt = 0;
	while ($row = mysql_fetch_row($result)) { 
		$tanda = "";
		if ($row[14] == 0) 
			$tanda = "*";
	
	?>
    <tr height="25">    	
    	<td align="center"><?=++$cnt?></td>
		<td align="center"><?=$row[0]?><?=$tanda?></td>
        <td><?=$row[1]?></td>
        <td align="center"><?=$row[7]?></td>
         <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="27%" >Mobile</td>
                <td>:</td>
                <td width="90%" ><?=$row[8]?> </td>  
            </tr>                
            <tr>
                <td>Email</td>
                <td>:</td>
              	<td>
				<? 	if ($row[9] <> "" && $row[15] <> "")
						echo $row[9].", ".$row[15];
				 	elseif ($row[15] == "")
						echo $row[9];
					else 
						echo $row[15];
				?>	</td>
            </tr>
            <tr>
                <td valign="top">Address</strong></td>
                <td valign="top">:</td>
              	<td><?=$row[10]?></td>
            </tr>
            <tr>
                <td>Phone</strong></td>
              	<td>:</td>  
                <td><?=$row[11]?></td>
            </tr>
            <tr>
                <td>Student Mobile</strong></td>
              	<td>:</td>   
                <td><?=$row[12]?></td>
            </tr>
            <tr>
                <td>Student Email</strong></td>
              	<td>:</td>  
                <td><?=$row[13]?></td>
            </tr>
            </table>    
           	</td> 
  		<td align="center"><font size="4"><b><?=$row[2]?></br></td>
        <td align="center"><font size="4"><b><?=$row[3]?></br></td>    
        <td align="center"><font size="4"><b><?=$row[4]?></br></td>
        <td align="center"><font size="4"><b><?=$row[5]?></br></td>    
        <td align="center"><font size="4"><b><?=$row[6]?></br></td>
    </tr>
<?	} 
	CloseDb() ?>	
    <!-- END TABLE CONTENT -->
    </table>	
<? 	} ?>
	</td>
</tr>
<tr>
	<td><? 	if ($row[8] == 0) 
			$tanda = "*";
			echo "PS: *Student Status back to inactive";
    	?>
    </td>
</tr>      
</table>
</body>
<script language="javascript">
window.print();
</script>

</html>