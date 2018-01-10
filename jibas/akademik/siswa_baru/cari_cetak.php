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
$jenis=$_REQUEST['jenis'];
$departemen=$_REQUEST['departemen'];
$cari=$_REQUEST['cari'];

$tipe = array("nopendaftaran" => "Registration Number", "nisn" => "National Student ID", "nama" => "Name","panggilan" => "Nickname", "agama" =>"Religion", "suku" => "Ethnicity", "status" => "Status", "kondisi"=>"Student Conditions", "darah"=>"Blood Type", "alamatsiswa" => "Student Address", "asalsekolah" => "Past School", "namaayah" => "Father Name", "namaibu" => "Mother Name", "alamatortu" => "Parent Address", "keterangan" => "Info");

$urut = $_REQUEST['urut'];
$urutan = $_REQUEST['urutan'];
$varbaris = $_REQUEST['varbaris'];	
$page = $_REQUEST['page'];
$total = $_REQUEST['total'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Print Search Student Candidate]</title>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center>
  <font size="4"><strong>SEARCH STUDENT CANDIDATE DATA</strong></font><br />
 </center><br /><br />
<br />
<table>
<tr>
	<td><strong>Department :&nbsp;<?=$departemen?></strong></td>
</tr>
<tr>
	<td>Search by <strong><?=$tipe[$jenis]?></strong> within keywords <strong><?=$cari?></strong></td>
</table>
<br />
</span>
	<table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left" bordercolor="#000000">
    <tr height="30">
    	<td width="4%" class="header" align="center">#</td>
        <td width="20%" class="header" align="center">Group</td>
        <td width="18%" class="header" align="center">Registration Number</td>
		<td width="18%" class="header" align="center">National Student ID</td>
		<td width="*" class="header" align="center">Student Candidate Name</td>
        
    </tr>
<? 	OpenDb();
	if ($jenis != "kondisi" && $jenis != "status" && $jenis != "agama" && $jenis != "suku" && $jenis != "darah"){
		//$sql = "SELECT c.replid,c.nopendaftaran,c.nama,p.departemen,k.kelompok FROM calonsiswa c,kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.$jenis like '%$cari%' AND c.aktif = 1 AND p.departemen='$departemen' AND c.idkelompok = k.replid AND c.idproses = p.replid AND p.replid = k.idproses ORDER BY $urut $urutan, nama ASC LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
		$sql = "SELECT c.replid,c.nopendaftaran,c.nama,p.departemen,k.kelompok,c.nisn FROM calonsiswa c,kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.$jenis like '%$cari%' AND c.aktif = 1 AND p.departemen='$departemen' AND c.idkelompok = k.replid AND c.idproses = p.replid AND p.replid = k.idproses ORDER BY $urut $urutan, nama ASC";
	} else { 
		//$sql = "SELECT c.replid,c.nopendaftaran,c.nama,p.departemen,k.kelompok FROM calonsiswa c,kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.$jenis = '$cari' AND c.aktif = 1 AND p.departemen='$departemen' AND c.idkelompok = k.replid AND c.idproses = p.replid AND p.replid = k.idproses ORDER BY $urut $urutan, nama ASC LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
		$sql = "SELECT c.replid,c.nopendaftaran,c.nama,p.departemen,k.kelompok,c.nisn FROM calonsiswa c,kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.$jenis = '$cari' AND c.aktif = 1 AND p.departemen='$departemen' AND c.idkelompok = k.replid AND c.idproses = p.replid AND p.replid = k.idproses ORDER BY $urut $urutan, nama ASC";
	}	
	$result = QueryDB($sql);
	if ($page==0)
		$cnt = 0;
	else
		$cnt = (int)$page*(int)$varbaris;
		
	while ($row = mysql_fetch_array($result)) { 
		?>
    <tr height="25">    	
    	<td align="center"><?=++$cnt ?></td>
        <td><?=$row['kelompok'] ?></td>
        <td align="center"><?=$row['nopendaftaran'] ?></td>
		<td align="center"><?=$row['nisn'] ?></td>
        <td><?=$row['nama']?></td>   
    </tr>
<?	} 
	CloseDb() ?>	
    </table>
<!--<tr>
    <td align="right">Page <strong><?=$page+1?></strong> from <strong><?=$total?></strong> halaman</td>
</tr>-->
<!-- END TABLE CENTER -->    
</table>
</body>
<script language="javascript">
window.print();
</script>
</html>