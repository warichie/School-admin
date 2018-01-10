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
require_once('../inc/config.php');
require_once('../inc/sessionchecker.php');
require_once('../inc/getheader.php');
require_once('../inc/db_functions.php');
require_once('../inc/common.php');
require_once('../inc/rupiah.php');
$tanggal1 = $_REQUEST['tanggal1'];
$tanggal2 = $_REQUEST['tanggal2'];
$idpengeluaran = $_REQUEST['idpengeluaran'];
$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$idtahunbuku = "";
if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = $_REQUEST['idtahunbuku'];

OpenDb();
$sql = "SELECT nama FROM $db_name_fina.datapengeluaran WHERE replid = '$idpengeluaran'";
$result = QueryDb($sql);
$row = mysql_fetch_row($result);
$nama = $row[0];


$ndepartemen = $departemen;
$ntahunbuku = getname2('tahunbuku',$db_name_fina.'.tahunbuku','replid',$idtahunbuku);
$npengeluaran = getname2('nama',$db_name_fina.'.datapengeluaran','replid',$idpengeluaran);	
$nperiode = LongDateFormat($tanggal1)." to ".LongDateFormat($tanggal2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS EMA [Print Admission Journal]</title>
</head>

<body>

<table border="0" cellpadding="10" cellspacing="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">
<? getHeader($departemen) ?>
	
<center>
  <font size="4"><strong>EXPENDITURE REPORTS</strong></font><br />
 </center><br /><br />
<table width="100%">
<tr>
	<td width="8%" class="news_content1"><strong>Department</strong></td>
    <td width="35%" class="news_content1">: 
      <?=$departemen ?></td>
    <td width="7%" class="news_content1"><strong><strong>Expenditure</strong></strong></td>
    <td width="50%" class="news_content1">: 
      <?=$npengeluaran ?></td>
</tr>
<tr>
  <td class="news_content1"><strong>Fiscal Year</strong></td>
  <td class="news_content1">: 
      <?=$ntahunbuku ?></td>
  <td class="news_content1"><strong>Period</strong></td>
  <td class="news_content1">: 
      <?=$nperiode ?></td>
</tr>
</table>
<br />
<table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="center" bordercolor="#000000">
    <tr height="30" align="center" >
        <td class="header" width="4%" >#</td>
        <td class="header" width="10%">Date</td>
        <td class="header" width="20%">Applicant</td>
        <td class="header" width="10%">Recipient</td>
        <td class="header" width="11%">Sum</td>
        <td class="header" width="*">Necessities</td>
        <td class="header" width="7%">Officer</td>
        </tr>
<?
	$sql = "SELECT p.replid AS id, p.keperluan, p.keterangan, p.jenispemohon, p.nip, p.nis, p.pemohonlain, p.penerima, date_format(p.tanggal, '%d-%b-%Y') as tanggal, date_format(p.tanggalkeluar, '%d-%b-%Y') as tanggalkeluar, p.petugas, p.jumlah FROM $db_name_fina.pengeluaran p, $db_name_fina.datapengeluaran d WHERE p.idpengeluaran = d.replid AND d.replid = '$idpengeluaran' AND d.departemen = '$departemen' AND p.tanggal BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY p.tanggal";
	//echo $sql;
	OpenDb();
	$result = QueryDb($sql);
	$cnt = 0;
	$total = 0;
	while ($row = mysql_fetch_array($result)) {
		
		if ($row['jenispemohon'] == 1) {
			$idpemohon = $row['nip'];
			$sql = "SELECT nama FROM $db_name_sdm.pegawai WHERE nip = '$idpemohon'";
			$jenisinfo = "pegawai";
		} else if ($row['jenispemohon'] == 2) {
			$idpemohon = $row['nis'];
			$sql = "SELECT nama FROM siswa WHERE nis = '$idpemohon'";
			$jenisinfo = "siswa";
		} else {
			$idpemohon = "";
			$sql = "SELECT nama FROM $db_name_fina.pemohonlain WHERE replid = '$row[pemohonlain]'" ;
			$jenisinfo = "pemohon lain";
		}
		$result2 = QueryDb($sql);
		$row2 = mysql_fetch_row($result2);
		$namapemohon = $row2[0];
		
		$total += $row['jumlah'];
?>
    <tr height="30">
        <td align="center" valign="top"><?=++$cnt ?></td>
        <td align="center" valign="top"><?=$row['tanggal'] ?></td>
        <td valign="top"><?=$idpemohon?> <?=$namapemohon ?><br />
        <em>(<?=$jenisinfo ?>)</em>        </td>
        <td valign="top"><?=$row['penerima'] ?></td>
        <td align="right" valign="top"><?=FormatRupiah($row['jumlah']) ?></td>
        <td valign="top">
        <strong>Necessities: </strong><?=$row['keperluan'] ?><br />
        <strong>Info: </strong><?=$row['keterangan'] ?>        </td>
        <td valign="top" align="center"><?=$row['petugas'] ?></td>
        </tr>
<? } ?>
    <tr height="30">
        <td colspan="3" align="center" bgcolor="#999900">
        <font color="#FFFFFF"><strong>Total</strong></font>        </td>
        <td align="right" bgcolor="#999900" colspan="2"><font color="#FFFFFF"><strong><?=FormatRupiah($total) ?></strong></font></td>
        <td colspan="3" bgcolor="#999900">&nbsp;</td>
    </tr>
    </table>
  </td>
</tr>    
</table>
</body>
<script language="javascript">
window.print();
</script>

</html>