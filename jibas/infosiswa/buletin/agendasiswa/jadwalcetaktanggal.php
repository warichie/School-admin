<?
/**[N]**
 * JIBAS Road To Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 2.5.2 (October 5, 2011)
 * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * Copyright (C) 2009 PT.Galileo Mitra Solusitama (http://www.galileoms.com)
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
require_once('include/common.php');
require_once('include/config.php');
require_once('include/db_functions.php');

$tgl = $_REQUEST['tgl'];
$bln = $_REQUEST['bln'];
$thn = $_REQUEST['thn'];

$namabulan = array("January","February","March","April","May","June","July","August","September","October","November","December");
$fulltgl = $tgl . " " . $namabulan[$bln - 1] . " " . $thn;
$fulltgl = strtoupper($fulltgl);

$tanggal = "$thn-$bln-$tgl";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Marital Schedule</title>
<link rel="stylesheet" type="text/css" href="style/tooltips.css">
</head>
<body>

<table width="720" border="0" cellpadding="0" cellspacing="0" align="left">
<tr><td align="left" valign="top">

<? include("include/header.php"); ?>

<table border="0"width="100%" align="center">
<tr>
    <td align="left"><div align="center"><font size="2" color="#660000"><b>MARITAL SCHEDULE<BR />DATE <?=$fulltgl ?></b></font></div></td>
</tr>
</table>
<br />

<table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="center">
<tr height="30">
    <td width="7%" class="header" align="center">#</td>
    <td width="20%" align="center" class="header">Place/Time</td>
    <td width="25%" class="header">Headman</td>
    <td width="25%" class="header">Couples</td>
    <td width="*" class="header">Info</td>
</tr>
<? 	OpenDb();
$sql = "SELECT j.replid,jam,penghulu,nama,pasangan,tempat,keterangan FROM jadwal j, penghulu p WHERE j.penghulu = p.nip AND tanggal='$tanggal' ORDER BY jam ASC";    
$result = QueryDB($sql);
$cnt = 0;
while ($row = mysql_fetch_array($result)) { ?>
<tr height="25">
    <td align="center"><?=++$cnt ?></td>
    <td align="center"><?=$row['tempat'] . "<br>" . $row['jam'] ?></td>
    <td><?=$row['penghulu'] . " " . $row['nama'] ?></td>
    <td><?=$row['pasangan'] ?></td>
    <td><?=$row['keterangan'] ?></td>
</tr>
<?	} 
CloseDb(); ?>	

<!-- END TABLE CONTENT -->
</table>

</td></tr>
</table>

<script language="javascript">
	window.print();
</script>


</body>
</html>