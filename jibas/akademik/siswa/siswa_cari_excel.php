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
/**/
header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=Data_Siswa.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

$cari=$_REQUEST['cari'];
$jenis=$_REQUEST['jenis'];
$departemen=$_REQUEST['departemen'];
$urut = "nama";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$tipe = array("nisn" => "National Student ID","nis" => "Student ID", "nama" => "Name","panggilan" => "Nickname", "agama" =>"Religion", "suku" => "Ethnicity", "status" => "Status", "kondisi"=>"Student Conditions", "darah"=>"Blood Type", "alamatsiswa" => "Student Address", "asalsekolah" => "Past School", "namaayah" => "Father Name", "namaibu" => "Mother Name", "alamatortu" => "Parent Address", "keterangan" => "Info");

if ($cari=="")
$namacari="";
else
$namacari=$cari;


OpenDb();
$sql = "SELECT s.replid,s.nis,s.nama,s.asalsekolah,s.tmplahir,DATE_FORMAT(s.tgllahir,'%d %M %Y') as tgllahir,s.status,t.tingkat,k.kelas,s.aktif,s.nisn from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.".$jenis." LIKE '%$cari%' AND k.replid=s.idkelas AND k.idtingkat=t.replid AND t.departemen='$departemen' ORDER BY $urut $urutan";
$result=QueryDb($sql);

if (@mysql_num_rows($result)<>0){
?>
<html>
<head>
<title>
Student Data
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
    <td colspan="7"><div align="center">SEARCH STUDENT</div></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td colspan="7"><strong>Department :&nbsp;<?=$departemen?></strong></td>
  </tr>
  <tr>
    <td colspan="7">Search by <strong><?=$tipe[$jenis]?></strong> within keywords <strong><?=$cari?></strong></td>
  </tr>
  <tr>
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
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Name</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Place and Date of Birth</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Grade</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Class</div></td>
<td valign="middle" bgcolor="#666666"><div align="center" class="style1">Status</div></td>
</tr>
<?
	$cnt=1;
	while ($row_siswa=@mysql_fetch_array($result)){
	?>
	<tr height="25">
	<td width="3" align="center"><?=$cnt?></td>
	<td align="left"><?=$row_siswa[nis]?></td>
	<td align="left"><?=$row_siswa[nisn]?></td>
	<td align="left"><?=$row_siswa[nama]?></td>
	<td align="left"><?=$row_siswa[tmplahir]?>, <?=LongDateFormat($row_siswa[tgllahir])?></td>
	<td align="center"><?=$row_siswa[tingkat]?></td>
	<td align="center"><?=$row_siswa[kelas]?></td>
	<td align="center"><?
		if ($row_siswa['aktif']==1){
			echo "Active";
		} elseif ($row_siswa['aktif']==0){
			echo "Inactive";
			if ($row_siswa['alumni']==1){
				$sql_get_al="SELECT DATE_FORMAT(a.tgllulus, '%d %M %Y') as tgllulus FROM jbsakad.alumni a WHERE a.nis='$row_siswa[nis]'";	
				$res_get_al=QueryDb($sql_get_al);
				$row_get_al=@mysql_fetch_array($res_get_al);
				echo "<br><a style='cursor:pointer;' title='Lulus Tgl: ".$row_get_al[tgllulus]."'><u>[Alumnus]</u></a>";
			}
			if ($row_siswa['statusmutasi']!=NULL){
				$sql_get_mut="SELECT DATE_FORMAT(m.tglmutasi, '%d %M %Y') as tglmutasi,j.jenismutasi FROM jbsakad.jenismutasi j, jbsakad.mutasisiswa m WHERE j.replid='$row_siswa[statusmutasi]' AND m.nis='$row_siswa[nis]' AND j.replid=m.jenismutasi";	
				$res_get_mut=QueryDb($sql_get_mut);
				$row_get_mut=@mysql_fetch_array($res_get_mut);
				//echo "<br><a href=\"NULL\" onmouseover=\"showhint('".$row_get_mut[jenismutasi]."<br>".$row_get_mut['tglmutasi']."', this, event, '50px')\"><u>[Mutated]</u></a>";
				echo "<br><a style='cursor:pointer;' title='".$row_get_mut[jenismutasi]."\n Tgl : ".$row_get_mut['tglmutasi']."'><u>[Mutated]</u></a>";
			}
		}
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