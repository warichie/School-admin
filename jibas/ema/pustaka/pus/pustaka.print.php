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
//require_once('../inc/sessioninfo.php');
require_once('../inc/common.php');
require_once('../inc/config.php');
require_once('../inc/db_functions.php');
require_once('../lib/getHeaderCetak.php');
OpenDb();
$asal=$_REQUEST[asal];
$kategori=$_REQUEST[kategori];
$keywords=$_REQUEST[keywords];
$perpustakaan=$_REQUEST[perpustakaan];
switch ($kategori){
	case 'judul':
		$kat = "Library Title";
		$key = $keywords;
		break;
	case 'rak':
		$kat = "Shelf";
		$row = @mysql_fetch_row(QueryDb("SELECT rak FROM rak WHERE replid='$keywords'"));
		$key = $row[0];
		break;	
	case 'katalog':
		$kat = "Catalogue";
		$row = @mysql_fetch_row(QueryDb("SELECT kode,nama FROM katalog WHERE replid='$keywords'"));
		$key = $row[0]." - ".$row[1];
		break;
	case 'penerbit':
		$kat = "Publisher";
		$row = @mysql_fetch_row(QueryDb("SELECT kode,nama FROM penerbit WHERE replid='$keywords'"));
		$key = $row[0]." - ".$row[1];
		break;
	case 'penulis':
		$kat = "Author";
		$row = @mysql_fetch_row(QueryDb("SELECT kode,nama FROM penulis WHERE replid='$keywords'"));
		$key = $row[0]." - ".$row[1];
		break;	
	case 'tahun':
		$kat = "Date Published";
		$key = $keywords;
		break;
	case 'abstraksi':
		$kat = "Abstraction";
		$key = $keywords;
		break;
	case 'keteranganfisik':
		$kat = "Physical Info";
		$key = $keywords;
		break;	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../sty/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Library List</title>
<style type="text/css">
<!--
.style1 {
	color: #666666;
	font-weight: bold;
}
.style3 {color: #000000; font-weight: bold; }
-->
</style>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<? GetHeader($perpustakaan) //include("../lib/headercetak.php") ?>

<center><font size="4"><strong>LIBRARY LIST</strong></font><br /> </center><br /><br />

<br />
<div>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td width="13%" height="20"><span class="style3">Library</span></td>
    <td width="87%" height="20">
		<? 
		OpenDb();
		if ($perpustakaan!='-1'){
			$sql = "SELECT nama FROM perpustakaan WHERE replid='$perpustakaan'";
			$result = QueryDb($sql);
			$row = @mysql_fetch_row($result);
			echo $row[0];
		} else {
			echo "<i>All perpustakaan</i>";
		}
		?>
    </td>
  </tr>
  <? if ($asal=='cari') { ?>
  <tr>
    <td width="13%" height="20"><span class="style3">Sort by</span></td>
    <td width="87%" height="20"><?=$kat?></td>
  </tr>
  <tr>
    <td width="13%" height="20"><span class="style3">Keyword</span></td>
    <td width="87%" height="20"><?=$key?></td>
  </tr>
  <? } ?>
</table>

</div>
<br />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab" id="table">
  <tr class="header" height="30">
    <td height="30" align="center">#</td>
    <td height="30" align="center">Title</td>
    <td height="30" align="center">Available</td>
    <td height="30" align="center">Borrowed</td>
    <td align="center">Info</td>
  </tr>
  <?
  $sqlpus='';
  if ($perpustakaan!='-1')
		$sqlpus=" AND d.perpustakaan=".$perpustakaan;
  if ($asal=='cari'){
	  $filter = "";
	  if ($kategori=='judul')
		  $filter = "AND p.judul LIKE '%$keywords%' ";
	  if ($kategori=='tahun' && $keywords!='')
		  $filter = "AND p.tahun = $keyword ";
	  if ($kategori=='abstraksi')
		  $filter = "AND p.abstraksi LIKE '%$keywords%' ";
	  if ($kategori=='keteranganfisik')
		  $filter = "AND p.keteranganfisik LIKE '%$keywords%' ";
	  
	  $sql = "SELECT p.replid, p.judul, p.keterangan FROM pustaka p, daftarpustaka d WHERE d.pustaka=p.replid $sqlpus $filter  GROUP BY p.replid ORDER BY p.judul ";
	
	  if ($kategori=='rak')
			$sql = "SELECT p.replid, p.judul, p.keterangan FROM pustaka p, daftarpustaka d, rak r, katalog k WHERE d.pustaka=p.replid $sqlpus AND r.replid='$keywords' AND p.katalog=k.replid AND k.rak=r.replid GROUP BY p.replid ORDER BY p.judul ";
	  
	  if ($kategori=='katalog')
			$sql = "SELECT p.replid, p.judul, p.keterangan FROM pustaka p, daftarpustaka d, katalog k WHERE d.pustaka=p.replid $sqlpus AND k.replid='$keywords' AND p.katalog=k.replid  GROUP BY p.replid ORDER BY p.judul ";	
		
	  if ($kategori=='penerbit')
			$sql = "SELECT p.replid, p.judul, p.keterangan FROM pustaka p, daftarpustaka d, penerbit pb WHERE d.pustaka=p.replid $sqlpus AND pb.replid='$keywords' AND p.penerbit=pb.replid  GROUP BY p.replid ORDER BY p.judul ";
	  
	  if ($kategori=='penulis')
			$sql = "SELECT p.replid, p.judul, p.keterangan FROM pustaka p, daftarpustaka d, penulis pn WHERE d.pustaka=p.replid $sqlpus AND pn.replid='$keywords' AND p.penulis=pn.replid  GROUP BY p.replid ORDER BY p.judul ";	
  } else {					
  		$sql = "SELECT p.replid, p.judul, p.keterangan FROM pustaka p, daftarpustaka d WHERE d.pustaka=p.replid $sqlpus  GROUP BY p.replid ORDER BY p.judul ";
  }
  //echo $sql;
  $result = QueryDb($sql);
  $num = @mysql_num_rows($result);
  if ($num>0){
      $cnt=1;
      while ($row = @mysql_fetch_row($result)){
		   $rdipinjam = @mysql_num_rows(QueryDb("SELECT * FROM daftarpustaka d WHERE d.pustaka='$row[0]' $sqlpus AND d.status=0"));
		   $rtersedia = @mysql_num_rows(QueryDb("SELECT * FROM daftarpustaka d WHERE d.pustaka='$row[0]' $sqlpus AND d.status=1"));
      ?>
      <tr>
        <td height="25" align="center"><?=$cnt?></td>
        <td height="25"><?=$row[1]?></td>
        <td height="25" align="center"><?=$rtersedia?></td>
        <td height="25" align="center"><?=$rdipinjam?></td>
        <td align="center"><?=$row[2]?></td>
      </tr>
      <?
      $cnt++;
      }
  } else {
  ?>
  <tr>
    <td height="20" colspan="7" align="center" class="nodata">Data Not Found.</td>
  </tr>
  <? 
  }
  ?>
</table>


</td></tr></table>
</body>
<script language="javascript">
window.print();
</script>
</html>