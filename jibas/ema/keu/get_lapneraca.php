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

$tanggal1 = "";
if (isset($_REQUEST['tanggal1']))
	$tanggal1 = $_REQUEST['tanggal1'];
	
$tanggal2 = "";
if (isset($_REQUEST['tanggal2']))
	$tanggal2 = $_REQUEST['tanggal2'];

$bln = 0;
if (isset($_REQUEST['bln']))
	$bln = (int)$_REQUEST['bln'];

$thn = 0;
if (isset($_REQUEST['thn']))
	$thn = (int)$_REQUEST['thn'];
	
$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$idtahunbuku = 0;
if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = (int)$_REQUEST['idtahunbuku'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-size:14px;
	
	}
-->
</style>
</head>
<body>
<table border="0" width="100%" align="center" >
<!-- TABLE CENTER -->
<tr>
	<td>
<?
	OpenDb();
	$sql = "SELECT jd.koderek, ra.nama, sum(jd.debet - jd.kredit) FROM $db_name_fina.jurnal j, $db_name_fina.jurnaldetail jd, $db_name_fina.rekakun ra WHERE j.replid = jd.idjurnal AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND j.tanggal BETWEEN '$tanggal1' AND '$tanggal2' AND ra.kategori IN ('WEALTH', 'DEBT') GROUP BY jd.koderek, ra.nama ORDER BY jd.koderek";
	$result = QueryDb($sql);   
	if (mysql_num_rows($result) > 0) {
?>    
    <table border="0" width="100%" align="center" cellpadding="10" cellspacing="5" >
    <tr>
        <td>
        <font size="4"><strong>Balance Sheet Reports</strong></font><br />
        <font size="2">by Date <?=LongDateFormat($tanggal2) ?></font>
        </td>
        <td align="right" valign="top">
        <!--<a href="#" onClick="document.location.reload()"><img src="../img/refresh.png" border="0" onMouseOver="showhint('Refresh', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;-->
        <a href="JavaScript:cetak()"><img src="../img/print.png" border="0" onMouseOver="showhint('Print', this, event, '50px')"/>&nbsp;Print</a>&nbsp;        </td>
    </tr>
    </table>
    
    <table border="0" width="100%" cellpadding="10" cellspacing="5" align="center" background="../img/bttablelong.png">
    <!--<tr>
        <td colspan="2">
        <font size="4"><strong>Balance Sheet Reports</strong></font><br />
        <font size="2">by Date <?=LongDateFormat($tanggal2) ?></font>
        <br />
        </td>
    </tr>-->
    <tr>
        <td width="50%" valign="top">
        	<font size="2"><strong>WEALTH</strong></font><br />
            <table border="0" style="border-collapse:collapse" cellpadding="2" width="100%" align="center">
            <tr height="28">
                <td width="2%">&nbsp;</td>
                <td colspan="6"><strong>CURRENT ASSETS</strong><br /></td>
            </tr>
            <?
            
            $totalaktivalancar = 0;
            while ($row = mysql_fetch_row($result)) {
                $totalaktivalancar += (float)$row[2];
            ?>
            <tr height="23">
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="5%" align="left"><?=$row[0] ?></td>
                <td width="*" align="left"><?=$row[1] ?></td>
                <td width="28%" align="right"><?=FormatRupiah($row[2]) ?></td>
                <td width="30%"  align="right">&nbsp;</td>
                <td width="13">&nbsp;</td>
            </tr>
            <?
            }
            ?>
            <tr height="23">
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td colspan="3" align="left"><strong><em>Current Assets Subtotal:</em></strong><br /></td>
                <td align="right"><span class="news_title2 style1"><?=FormatRupiah($totalaktivalancar) ?></span></td>
                <td>&nbsp;</td>
            </tr>
            </table>
            <br />
    
            <table border="0" style="border-collapse:collapse" cellpadding="2" width="100%" align="center">
            <tr height="28">
                <td width="2%">&nbsp;</td>
                <td colspan="6"><strong>FIXED ASSETS</strong><br /></td>
            </tr>
            <?
            $sql = "SELECT jd.koderek, ra.nama, sum(jd.debet - jd.kredit) FROM $db_name_fina.jurnal j, $db_name_fina.jurnaldetail jd, $db_name_fina.rekakun ra WHERE j.replid = jd.idjurnal AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND j.tanggal BETWEEN '$tanggal1' AND '$tanggal2' AND ra.kategori = 'INVESTMENT' GROUP BY jd.koderek, ra.nama ORDER BY jd.koderek";
            $result = QueryDb($sql);
            $totalaktivatetap = 0;
            while ($row = mysql_fetch_row($result)) {
                $totalaktivatetap += (float)$row[2];
            ?>
            <tr height="23">
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="5%" align="left"><?=$row[0] ?></td>
                <td width="*" align="left"><?=$row[1] ?></td>
                <td width="28%" align="right"><?=FormatRupiah($row[2]) ?></td>
                <td width="30%"  align="right">&nbsp;</td>
                <td width="13">&nbsp;</td>
            </tr>
            <?
            }
            ?>
            <tr height="23">
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td colspan="3" align="left"><strong><em>Fixed Assets Subtotal:</em></strong><br /></td>
                <td align="right"><span class="news_title2 style1"><?=FormatRupiah($totalaktivatetap) ?></strong></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6"><hr width="100%" style="border-style:dashed" /></td>
                <td align="right">+</td>
            </tr>
            <tr height="28">
                <td colspan="5" align="left"><font size="2"><strong>TOTAL WEALTH</strong></font><br /></td>
                <td align="right"><font size="2"><span class="news_title2 style1"><?=FormatRupiah($totalaktivatetap + $totalaktivalancar) ?></strong></font></td>
                <td>&nbsp;</td>
            </tr>
            </table>
        </td>
        <td width="50%" valign="top">
        	<font size="2"><strong>OBLIGATIONS</strong></font><br />
            <table border="0" style="border-collapse:collapse" cellpadding="2" width="100%" align="center">
            <tr height="28">
                <td width="2%">&nbsp;</td>
                <td colspan="6"><strong>DEBT</strong><br /></td>
            </tr>
            <?
            $sql = "SELECT jd.koderek, ra.nama, sum(jd.kredit - jd.debet) FROM $db_name_fina.jurnal j, $db_name_fina.jurnaldetail jd, $db_name_fina.rekakun ra WHERE j.replid = jd.idjurnal AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND j.tanggal BETWEEN '$tanggal1' AND '$tanggal2' AND ra.kategori = 'UTANG' GROUP BY jd.koderek, ra.nama ORDER BY jd.koderek";
            $result = QueryDb($sql);
            $totalhutang = 0;
            while ($row = mysql_fetch_row($result)) {
                $totalhutang += (float)$row[2];
            ?>
            <tr height="23">
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="5%" align="left"><?=$row[0] ?></td>
                <td width="*" align="left"><?=$row[1] ?></td>
                <td width="28%" align="right"><?=FormatRupiah($row[2]) ?></td>
                <td width="30%"  align="right">&nbsp;</td>
                <td width="13">&nbsp;</td>
            </tr>
            <?
            }
            ?>
            <tr height="23">
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td colspan="3" align="left"><strong><em>Debt Subtotal:</em></strong><br /></td>
                <td align="right"><span class="news_title2 style1"><?=FormatRupiah($totalhutang) ?></span></td>
                <td>&nbsp;</td>
            </tr>
            </table>
            <br />
            <table  border="0" style="border-collapse:collapse" cellpadding="2" width="100%" align="center">
            <tr height="28">
                <td width="2%">&nbsp;</td>
                <td colspan="6"><strong>CAPITAL</strong><br /></td>
            </tr>
            <?
            $sql = "SELECT tanggalmulai FROM $db_name_fina.tahunbuku WHERE replid = '$idtahunbuku'";
            $result = QueryDb($sql);
            $row = mysql_fetch_row($result);
            $tanggal1 = $row[0];
            
            $sql = "SELECT SUM(jd.kredit - jd.debet) FROM $db_name_fina.rekakun ra,
            $db_name_fina.jurnal j, $db_name_fina.jurnaldetail jd WHERE jd.idjurnal = j.replid AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND j.tanggal BETWEEN '$tanggal1' AND '$tanggal2' AND ra.kategori IN ('INCOME', 'CAPITAL')";
            //echo "$sql<br>";
            $result = QueryDb($sql);
            $row = mysql_fetch_row($result);
            $totalpendapatan = (float)$row[0];
            //echo "$totalpendapatan<br>";
            
            $sql = "SELECT SUM(jd.debet - jd.kredit) FROM $db_name_fina.rekakun ra, $db_name_fina.jurnal j, $db_name_fina.jurnaldetail jd WHERE jd.idjurnal = j.replid AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND j.tanggal BETWEEN '$tanggal1' AND '$tanggal2' AND ra.kategori = 'COST'";
            //echo "$sql<br>";
            $result = QueryDb($sql);
            $row = mysql_fetch_row($result);
            $totalbiaya = (float)$row[0];
            //echo "$totalbiaya<br>";
            $modalusaha = $totalpendapatan - $totalbiaya;
            //echo "$modalusaha<br>"; ?>
            <tr height="23">
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="5%" align="left">&nbsp;</td>
                <td width="*" align="left">Venture Capital</td>
                <td width="28%" align="right"><?=FormatRupiah($modalusaha) ?></td>
                <td width="30%"  align="right">&nbsp;</td>
                <td width="13">&nbsp;</td>
            </tr>
            <tr height="23">
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td colspan="3" align="left"><strong><em>Venture Capital Subtotal:</em></strong><br /></td>
                <td align="right"><span class="news_title2 style1"><?=FormatRupiah($modalusaha) ?></span></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6"><hr width="100%" style="border-style:dashed" /></td>
                <td align="right">+</td>
            </tr>
            <tr height="28">
                <td colspan="5" align="left"><font size="2"><strong>TOTAL OBLIGATIONS AND CAPITAL</strong></font><br /></td>
                <td align="right"><font size="2"><span class="news_title2 style1"><?=FormatRupiah($modalusaha + $totalhutang) ?></span></font></td>
                <td>&nbsp;</td>
            </tr>
            </table>
        </td>
    </tr>
    </table>
<? } else { ?>
    <table width="100%" border="0" align="center">          
    <tr>
        <td align="center" valign="middle" height="300">
            <font size = "2" color ="red"><b><span class="err">No transactions found keuangan on departemen 
            <?=$departemen?> 
            between 
            <?=LongDateFormat($tanggal1)?> 
            to 
            <?=LongDateFormat($tanggal2)?>
            </span><br />
          .</font>        </td>
    </tr>
    </table>  
<? } ?>
    </td>
</tr>
</table>
</body>
</html>