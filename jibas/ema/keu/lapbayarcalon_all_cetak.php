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
require_once('../inc/common.php');
require_once('../inc/rupiah.php');
require_once('../inc/config.php');
require_once('../inc/sessionchecker.php');
require_once('../inc/getheader.php');
require_once('../inc/db_functions.php');

$replid = $_REQUEST['replid'];
$tanggal1 = $_REQUEST['tanggal1'];
$tanggal2 = $_REQUEST['tanggal2'];
OpenDb();
$sql = "SELECT p.departemen FROM prosespenerimaansiswa p, kelompokcalonsiswa k, calonsiswa c WHERE c.replid='$replid' AND c.idkelompok=k.replid AND k.idproses=p.replid";
$result = QueryDb($sql);
$row = @mysql_fetch_row($result);
$departemen = $row[0];
CloseDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Payment Reports</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
</head>

<body>
<table border="0" cellpadding="10" cellspacing="5" width="780" align="left">
<tr><td align="left" valign="top">

<? getHeader($departemen) ?>

<center><font size="4"><strong>STUDENT CANDIDATE PAYMENT DATA</strong></font><br /> </center><br /><br />

<?
OpenDb();
$sql = "SELECT s.nama, s.nopendaftaran, k.kelompok, p.proses FROM calonsiswa s, kelompokcalonsiswa k, prosespenerimaansiswa p WHERE s.replid = '$replid' AND s.idkelompok = k.replid AND s.idproses = p.replid";
$result = QueryDb($sql);
$row = mysql_fetch_row($result);
$namacalon = $row[0];
$kelompok = $row[2];
$proses = $row[3];
$no = $row[1];
?>
<table border="0">
<tr>
	<td class="news_content1"><strong>Student Candidate </strong></td>
    <td class="news_content1">: 
      <?=$no . " - " . $namacalon?></td>
</tr>
<tr>
	<td class="news_content1"><strong>Process </strong></td>
    <td class="news_content1">: 
      <?=$proses?></td>
</tr>
<tr>
	<td class="news_content1"><strong>Group </strong></td>
    <td class="news_content1">: 
      <?=$kelompok?></td>
</tr>

<tr>
	<td class="news_content1"><strong>Date </strong></td>
    <td class="news_content1">: 
      <?=LongDateFormat($tanggal1) . " to " . LongDateFormat($tanggal2) ?></td>
</tr>
</table>
<br />

<table border="1" style="border-collapse:collapse" width="100%" bordercolor="#000000"> 
<?
$sql = "SELECT DISTINCT b.replid AS id, b.besar, b.lunas, b.keterangan, d.nama FROM $db_name_fina.besarjttcalon b, $db_name_fina.penerimaanjttcalon p, $db_name_fina.datapenerimaan d WHERE p.idbesarjttcalon = b.replid AND b.idpenerimaan = d.replid AND b.idcalon='$replid' AND p.tanggal BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY nama";
$result = QueryDb($sql);
while ($row = mysql_fetch_array($result)) {
	$idbesarjtt = $row['id'];
	$namapenerimaan = $row['nama']; 
	$besar = $row['besar'];
	$lunas = $row['lunas'];
	$keterangan = $row['keterangan'];
	
	$sql = "SELECT SUM(jumlah) FROM $db_name_fina.penerimaanjttcalon WHERE idbesarjttcalon = '$idbesarjtt'";
	$result2 = QueryDb($sql);
	$pembayaran = 0;
	if (mysql_num_rows($result2)) {
		$row2 = mysql_fetch_row($result2);
		$pembayaran = $row2[0];
	};
	$sisa = $besar - $pembayaran;
	
	$sql = "SELECT jumlah, DATE_FORMAT(tanggal, '%d-%b-%Y') AS ftanggal FROM $db_name_fina.penerimaanjttcalon WHERE idbesarjttcalon='$idbesarjtt' ORDER BY tanggal DESC LIMIT 1";
	$result2 = QueryDb($sql);
	$byrakhir = 0;
	$tglakhir = "";
	if (mysql_num_rows($result2)) {
		$row2 = mysql_fetch_row($result2);
		$byrakhir = $row2[0];
		$tglakhir = $row2[1];
	};	?>
    <tr height="35">
        <td colspan="4" bgcolor="#99CC00"><font size="2"><strong><em><?=$namapenerimaan?></em></strong></font></td>
    </tr>    
    <tr height="25">
        <td width="20%" bgcolor="#CCFF66"><strong>Total Payment</strong> </td>
        <td width="15%" bgcolor="#FFFFFF" align="right"><?=FormatRupiah($besar) ?></td>
        <td width="22%" bgcolor="#CCFF66" align="center"><strong>Last Payment</strong></td>
        <td width="43%" bgcolor="#CCFF66" align="center"><strong>Info</strong></td>
    </tr>
    <tr height="25">
        <td bgcolor="#CCFF66"><strong>Payment Amount</strong> </td>
        <td bgcolor="#FFFFFF" align="right"><?=FormatRupiah($pembayaran) ?></td>
        <td bgcolor="#FFFFFF" align="center" valign="top" rowspan="2"><?=FormatRupiah($byrakhir) . "<br><i>" . $tglakhir . "</i>" ?> </td>
        <td bgcolor="#FFFFFF" align="left" valign="top" rowspan="2"><?=$keterangan ?></td>
    </tr>
    <tr height="25">
        <td bgcolor="#CCFF66"><strong>Remaining Payment</strong> </td>
        <td bgcolor="#FFFFFF" align="right"><?=FormatRupiah($sisa) ?></td>
    </tr>
    <tr height="3">
        <td colspan="4" bgcolor="#E8E8E8">&nbsp;</td>
    </tr>
<? 
} //while iuran wajib

$sql = "SELECT DISTINCT p.idpenerimaan, d.nama FROM $db_name_fina.penerimaaniurancalon p, $db_name_fina.datapenerimaan d WHERE p.idpenerimaan = d.replid AND p.idcalon='$replid' AND p.tanggal BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY nama";
$result = QueryDb($sql);
while ($row = mysql_fetch_array($result)) {
	$idpenerimaan = $row['idpenerimaan'];
	$namapenerimaan = $row['nama'];
	
	$sql = "SELECT SUM(jumlah) FROM $db_name_fina.penerimaaniurancalon WHERE idpenerimaan='$idpenerimaan' AND idcalon='$replid'";
	$result2 = QueryDb($sql);
	$pembayaran = 0;
	if (mysql_num_rows($result2)) {
		$row2 = mysql_fetch_row($result2);
		$pembayaran = $row2[0];
	};

	$sql = "SELECT jumlah, DATE_FORMAT(tanggal, '%d-%b-%Y') AS ftanggal FROM $db_name_fina.penerimaaniurancalon WHERE idpenerimaan='$idpenerimaan' AND idcalon='$replid' ORDER BY tanggal DESC LIMIT 1";
	$result2 = QueryDb($sql);
	$byrakhir = 0;
	$tglakhir = "";
	if (mysql_num_rows($result2)) {
		$row2 = mysql_fetch_row($result2);
		$byrakhir = $row2[0];
		$tglakhir = $row2[1];
	};	
?>
 	<tr height="35">
        <td colspan="4" bgcolor="#99CC00"><font size="2"><strong><em><?=$namapenerimaan?></em></strong></font></td>
    </tr>  
   	<tr height="25">
        <td width="22%" bgcolor="#CCFF66" align="center"><strong>Total Payment</strong> </td>
        <td width="22%" bgcolor="#CCFF66" align="center"><strong>Last Payment</strong></td>
        <td width="50%" colspan="2" bgcolor="#CCFF66" align="center"><strong>Info</strong></td>
    </tr>
    <tr height="25">
        <td bgcolor="#FFFFFF" align="center"><?=FormatRupiah($pembayaran) ?></td>
        <td bgcolor="#FFFFFF" align="center"><?=FormatRupiah($byrakhir) . "<br><i>" . $tglakhir . "</i>" ?></td>
        <td colspan="2" bgcolor="#FFFFFF" align="left">&nbsp;</td>
    </tr>
    <tr height="3">
        <td colspan="4" bgcolor="#E8E8E8">&nbsp;</td>
    </tr>
<?
} //while iuran sukarela
?>

</table>

<?
CloseDb();
?>

</table>

</td></tr></table>
</body>
</html>
<script language="javascript">window.print();</script>