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
header('Content-Disposition: attachment; filename=Data_Calon_Siswa.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

$departemen=$_REQUEST[departemen];
$proses=$_REQUEST[proses];
$kelompok=$_REQUEST[kelompok];
$urut= $_REQUEST[urut];
$urutan = $_REQUEST[urutan];

OpenDb();

$sql = "SELECT * FROM calonsiswa c, kelompokcalonsiswa k, prosespenerimaansiswa p ".
		  "WHERE c.idproses = '$proses' AND c.idkelompok = '$kelompok' AND k.idproses = p.replid ".
		  "AND c.idproses = p.replid AND c.idkelompok = k.replid ORDER BY $urut $urutan";
		$result = QueryDb($sql);
		
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
  	$sql_proses = "SELECT proses FROM prosespenerimaansiswa where replid='$proses'";
	$result_proses = QueryDb($sql_proses);
	$row_proses = @mysql_fetch_array($result_proses);
  ?>
    <td width="24%">Department</td>
    <td width="76%"><strong>:</strong>&nbsp;<?=$departemen?></td>
  </tr>
  <tr>
    <td>Admission Process</td>
    <td><strong>:</strong>&nbsp;
    <?=$row_proses['proses'];
	?>    </td>
  </tr>
  <tr>
    <td>Student Candidate Group</td>
    <td><strong>:</strong>&nbsp;<?
	$sql_kel = "SELECT kelompok FROM kelompokcalonsiswa WHERE replid='$kelompok'";
	$result_kel = QueryDb($sql_kel);
	$row_kel=@mysql_fetch_array($result_kel);
	echo $row_kel[kelompok];
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
<td width="3" rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">#</div></td>
<td width="20" rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Registration Number</div></td>
<td width="20" rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">National Student ID</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Name</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Gender</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Year Joining</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Past School</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Place and Date of Birth</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Address</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Post Code</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Phone</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Mobile</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Email</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Status</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Conditions</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Health</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Language</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Ethnicity</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Religion</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Citizenship</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Body Weight</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Body Height</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Blood Type</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Child #</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Siblings</div></td>
<td colspan="5" valign="middle" bgcolor="#666666"><div align="center" class="style1">Father</div></td>
<td colspan="5" valign="middle" bgcolor="#666666"><div align="center" class="style1">Mother</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Address</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Phone</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Mobile</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Contribution 1</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Contribution 2</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Exam 1</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Exam 2</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Exam 3</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Exam 4</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Exam 5</div></td>
<td rowspan="2" valign="middle" bgcolor="#666666"><div align="center" class="style1">Status Active</div></td>
</tr>
<tr height="30">
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Name</div></td>
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Email</div></td>
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Education</div></td>
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Occupation</div></td>
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Income</div></td>
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Name</div></td>
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Email</div></td>
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Education</div></td>
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Occupation</div></td>
  <td valign="middle" bgcolor="#666666"><div align="center" class="style1">Income</div></td>
</tr>
<?
	$cnt=1;
	while ($row=@mysql_fetch_array($result)){
		$siswa = "";
		if ($row['replidsiswa'] <> 0) {
			$sql3 = "SELECT nis FROM jbsakad.siswa WHERE replid = $row[replidsiswa]";
			$result3 = QueryDb($sql3);
			$row3 = @mysql_fetch_array($result3);
			$siswa = "<br>Student ID: <b>".$row3['nis']."</b>";
		}
	?>
	<tr height="25">
	<td width="3" align="center"><?=$cnt?></td>
	<td align="left"><?=$row['nopendaftaran']?></td>
	<td align="left"><?=$row['nisn']?></td>
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
   <td align="left"><?=$row['pendidikanayah']?></td>
   <td align="left"><?=$row['pekerjaanayah']?></td>
   <td align="left"><?=$row['penghasilanayah']?></td>
   <td align="left"><?=$row['namaibu']?></td>
   <td align="left"><?=$row['emailibu']?></td> 
   <td align="left"><?=$row['pendidikanibu']?></td>
   <td align="left"><?=$row['pekerjaanibu']?></td>
   <td align="left"><?=$row['penghasilanibu']?></td>
   <td align="left"><?=$row['alamatortu']?></td> 
   <td align="left"><?=$row['telponortu']?></td> 
   <td align="left"><?=$row['hportu']?></td> 
   <td align="left"><?=$row['sum1']?></td> 
   <td align="left"><?=$row['sum2']?></td> 
   <td align="left"><?=$row['ujian1']?></td> 
   <td align="left"><?=$row['ujian2']?></td> 
   <td align="left"><?=$row['ujian3']?></td> 
   <td align="left"><?=$row['ujian4']?></td> 
   <td align="left"><?=$row['ujian5']?></td> 
         
	<td align="center"><?
		
	if ($row[aktif]==1)
	echo "Aktif".$siswa;
	if ($row[aktif]==0)
	echo "Tidak aktif".$siswa;
	?></td>
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