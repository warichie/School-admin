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

$tipe = array("nisn" => "National Student ID","nis" => "Student ID", "nama" => "Name","panggilan" => "Nickname", "agama" =>"Religion", "suku" => "Ethnicity", "status" => "Status", "kondisi"=>"Student Conditions", "darah"=>"Blood Type", "alamatsiswa" => "Student Address", "asalsekolah" => "Past School", "namaayah" => "Father Name", "namaibu" => "Mother Name", "alamatortu" => "Parent Address", "keterangan" => "Info");

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
<title>JIBAS SIMAKA [Print Search Student]</title>
</head>

<body>
<table border="0" cellpadding="10" cellspacing="5" width="780" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center>
  <font size="4"><strong>SEARCH STUDENT DATA</strong></font><br />
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
        <td width="15%" class="header" align="center">Student ID</td>
        <td width="15%" class="header" align="center">National Student ID</td>
        <td width="*" class="header" align="center">Name</td>
		<td width="25%" class="header" align="center">Birth Place</td>
        <td width="8%" class="header" align="center">Grade</td>
        <td width="8%" class="header" align="center">Class</td>
        <td width="8%" class="header" align="center">Status</td>
    </tr>
<? 	OpenDb();
	if ($jenis != "kondisi" && $jenis != "status" && $jenis != "agama" && $jenis != "suku" && $jenis != "darah") {		
		//$sql_siswa = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, t.tingkat from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.$jenis LIKE '%$cari%' AND k.replid=s.idkelas AND k.idtingkat=t.replid AND t.departemen='$departemen' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
		//$sql_siswa = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, t.tingkat from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.$jenis LIKE '%$cari%' AND k.replid=s.idkelas AND k.idtingkat=t.replid AND t.departemen='$departemen' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
		$sql_siswa = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, t.tingkat, s.nisn from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.$jenis LIKE '%$cari%' AND k.replid=s.idkelas AND k.idtingkat=t.replid AND t.departemen='$departemen' ORDER BY $urut $urutan";
	} else {
		//$sql_siswa = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, t.tingkat from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.$jenis = '%$cari%' AND k.replid=s.idkelas AND k.idtingkat=t.replid AND t.departemen='$departemen' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
		//$sql_siswa = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, t.tingkat from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.$jenis = '$cari' AND k.replid=s.idkelas AND k.idtingkat=t.replid AND t.departemen='$departemen' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
		$sql_siswa = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, t.tingkat, s.nisn from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.$jenis = '$cari' AND k.replid=s.idkelas AND k.idtingkat=t.replid AND t.departemen='$departemen' ORDER BY $urut $urutan";
	}
	//echo $sql_siswa;
	$result = QueryDB($sql_siswa);
	if ($page==0)
		$cnt = 0;
	else
		$cnt = (int)$page*(int)$varbaris;
		
	while ($row_siswa = mysql_fetch_array($result)) { 
		?>
    <tr height="25">    	
    	<td align="center"><?=++$cnt?></td>
    	<td align="center"><?=$row_siswa['nis']?></td>
        <td align="center"><?=$row_siswa['nisn']?></td>
    	<td><?=$row_siswa['nama']?></td>
        <td><?=$row_siswa['tmplahir']?>, <?=LongDateFormat($row_siswa['tgllahir'])?></td>
    	<td align="center"><?=$row_siswa ['tingkat']?></td>
    	<td align="center"><?=$row_siswa['kelas']?></td>
        <td align="center">
		<?
		if ($row_siswa['aktif']==1){
			echo "Active";
		} elseif ($row_siswa['aktif']==0){
			echo "Inactive";
			if ($row_siswa['alumni']==1){
				$sql_get_al="SELECT a.tgllulus FROM jbsakad.alumni a WHERE a.nis='$row_siswa[nis]'";	
				$res_get_al=QueryDb($sql_get_al);
				$row_get_al=@mysql_fetch_array($res_get_al);
				echo "<br><a style='cursor:pointer;' title='Lulus Tgl: ".LongDateFormat($row_get_al[tgllulus])."'>[Alumnus]</a>";
			}
			if ($row_siswa['statusmutasi']!=NULL){
				$sql_get_mut="SELECT m.tglmutasi,j.jenismutasi FROM jbsakad.jenismutasi j, jbsakad.mutasisiswa m WHERE j.replid='$row_siswa[statusmutasi]' AND m.nis='$row_siswa[nis]' AND j.replid=m.jenismutasi";	
				$res_get_mut=QueryDb($sql_get_mut);
				$row_get_mut=@mysql_fetch_array($res_get_mut);
				//echo "<br><a href=\"NULL\" onmouseover=\"showhint('".$row_get_mut[jenismutasi]."<br>".$row_get_mut['tglmutasi']."', this, event, '50px')\"><u>[Mutated]</u></a>";
				echo "<br><a style='cursor:pointer;' title='".$row_get_mut[jenismutasi]."\n Tgl ".LongDateFormat($row_get_mut['tglmutasi'])."'>[Mutated]</a>";
			}
		}
		?></td>  
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