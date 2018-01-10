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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=Data_Siswa.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

$kelas=$_REQUEST[kelas];
$tahunajaran=$_REQUEST[tahunajaran];
$tingkat=$_REQUEST[tingkat];
$urut= $_REQUEST[urut];
$urutan = $_REQUEST[urutan];

OpenDb();
$sql="SELECT * FROM jbsakad.siswa s, jbsakad.kelas k, jbsakad.tahunajaran t WHERE s.idkelas = '$kelas' AND k.idtahunajaran = '$tahunajaran' AND k.idtingkat = '$tingkat' AND s.idkelas = k.replid AND t.replid = k.idtahunajaran AND s.alumni=0 ORDER BY $urut $urutan";
$result=QueryDb($sql);

if (@mysql_num_rows($result)<>0){
?>
<html>
<head>
<title>
Student Data by Classes
</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {font-size: 14px}
-->
</style>
</head>
<body>
<table width="700" border="0">
  <tr>
    <td>
    <table width="100%" border="0">
  <tr>
    <td colspan="2"><div align="center">Student Data by Classes</div></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  <?
  	$sql_TA="SELECT * FROM jbsakad.tahunajaran WHERE replid='$tahunajaran'"; 
	$result_TA=QueryDb($sql_TA);
	$row_TA=@mysql_fetch_array($result_TA);
  ?>
    <td width="9%">Department</td>
    <td width="91%"><strong>:</strong>&nbsp;<?=$row_TA['departemen']?></td>
  </tr>
  <tr>
    <td>Year of Teaching</td>
    <td><strong>:</strong>&nbsp;
    <?=$row_TA['tahunajaran'];
	?>    </td>
  </tr>
  <tr>
    <td>Grade</td>
    <td><strong>:</strong>&nbsp;<?
	$sql_Tkt="SELECT * FROM jbsakad.tingkat WHERE replid='$tingkat'"; 
	$result_Tkt=QueryDb($sql_Tkt);
	$row_Tkt=@mysql_fetch_array($result_Tkt);
	echo $row_Tkt[tingkat];
	?></td>
  </tr>
  <tr>
    <td>Class</td>
    <td><strong>:</strong>&nbsp;<?
	$sql_Kls="SELECT * FROM jbsakad.kelas WHERE replid='$kelas'"; 
	$result_Kls=QueryDb($sql_Kls);
	$row_Kls=@mysql_fetch_array($result_Kls);
	echo $row_Kls[kelas];
	?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td><table border="1">
<tr height="30">
<td width="3" valign="middle" bgcolor="#666666"><div align="center" class="style1">#</div></td>
<td width="20" valign="middle" bgcolor="#666666"><div align="center" class="style1">Student ID</div></td>
<td width="20" valign="middle" bgcolor="#666666"><div align="center" class="style1">National Student ID</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">PIN</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Name</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Gender</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Year Joining</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Past School</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Place and Date of Birth</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Address</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Post Code</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Phone</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Mobile</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Email</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Status</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Conditions</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Health</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Language</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Ethnicity</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Religion</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Citizenship</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Body Weight</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Body Height</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Blood Type</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Child #</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Siblings</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Father</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Email</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Father PIN</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Education</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Occupation</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Income</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Mother</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Email</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Mother PIN</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Education</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Occupation</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Income</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Address</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Phone</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Mobile</div></td>
</tr>
<?
	$cnt=1;
	while ($row=@mysql_fetch_array($result)){
	?>
	<tr height="25">
	<td width="3" align="center"><?=$cnt?></td>
	<td align="left"><?=$row['nis']?></td>
    <td align="left"><?=$row['nisn']?></td>
   <td align="left"><?=$row['pinsiswa']?></td>
	<td align="left"><?=$row['nama']?></td>
	<td align="left"><?=$row['kelamin']?></td>
   <td align="left"><?=$row['tahunmasuk']?></td>
   <td align="left"><?=$row['asalsekolah']?></td>
	<td align="left"><?=$row['tmplahir']?>, <?=format_tgl($row['tgllahir'])?></td>
	<td align="left"><?=$row['alamatsiswa']?></td>
   <td align="left"><?=$row['kodepossiswa']?></td>
   <td align="left"><?=$row['telponsiswa']?></td>
   <td align="left"><?=$row['hpsiswa']?></td>
   <td align="left"><?=$row['emailsiswa']?></td>
   <td align="left"><?=$row['status']?></td> 
   <td align="left"><?=$row['kondisi']?></td> 
   <td align="left"><?=$row['kesehatan']?></td> 
   <td align="left"><?=$row['bahasa']?></td> 
   <td align="left"><?=$row['suku']?></td> 
   <td align="left"><?=$row['agama']?></td> 
   <td align="left"><?=$row['warga']?></td> 
   <td align="left"><?=$row['berat']?></td> 
   <td align="left"><?=$row['tinggi']?></td> 
   <td align="left"><?=$row['darah']?></td> 
   <td align="left"><?=$row['anakke']?></td> 
   <td align="left"><?=$row['jsaudara']?></td> 
   <td align="left"><?=$row['namaayah']?></td>
   <td align="left"><?=$row['emailayah']?></td>
   <td align="left"><?=$row['pinortu']?></td>  
   <td align="left"><?=$row['pendidikanayah']?></td> 
   <td align="left"><?=$row['pekerjaanayah']?></td> 
   <td align="left"><?=$row['penghasilanayah']?></td> 
   <td align="left"><?=$row['namaibu']?></td> 
   <td align="left"><?=$row['emailibu']?></td> 
   <td align="left"><?=$row['pinortuibu']?></td> 
   <td align="left"><?=$row['pendidikanibu']?></td> 
   <td align="left"><?=$row['pekerjaanibu']?></td> 
   <td align="left"><?=$row['penghasilanibu']?></td> 
   <td align="left"><?=$row['alamatortu']?></td> 
   <td align="left"><?=$row['telponortu']?></td> 
   <td align="left"><?=$row['hportu']?></td> 
	</tr>
	<?
		$cnt++;
}
	?>
</table></td>
  </tr>
</table>


</body>
</html>
<?
}
CloseDb();
?>