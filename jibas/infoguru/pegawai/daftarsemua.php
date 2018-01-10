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
require_once("../include/sessionchecker.php");
require_once("../include/config.php");
require_once("../include/db_functions.php");
require_once("../include/common.php");
require_once('../include/theme.php');
require_once("../include/sessioninfo.php");

OpenDb();

$nip = $_REQUEST['nip'];

$sql = "SELECT * FROM jbssdm.pegawai WHERE nip='$nip'";

$result = QueryDb($sql);
$row = mysql_fetch_array($result);

$nama = $row['nama'];
$gelarawal = $row['gelarawal'];
$gelarakhir = $row['gelarakhir'];
$pegawai = $nama;
$nip = $row['nip'];
$nuptk = $row['nuptk'];
$nrp = $row['nrp'];
$tmplahir = $row['tmplahir'];
$tgllahir = GetDatePart($row['tgllahir'], "d");
$blnlahir = GetDatePart($row['tgllahir'], "m");
$thnlahir = GetDatePart($row['tgllahir'], "y");
$agama = $row['agama'];
$suku = $row['suku'];
$alamat = $row['alamat'];
$hp = $row['handphone'];
$foto = $row['foto'];
$telpon = $row['telpon'];
$email = $row['email'];
$facebook = $row['facebook'];
$twitter = $row['twitter'];
$website = $row['website'];
$status = $row['status'];
$bagian = $row['bagian'];
$tglmulai = GetDatePart($row['mulaikerja'], "d");
$blnmulai = GetDatePart($row['mulaikerja'], "m");
$thnmulai = GetDatePart($row['mulaikerja'], "y");
$keterangan = $row['keterangan'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Employee Affair</title>
<link rel="stylesheet" href="../style/style<?=GetThemeDir2()?>.css" />
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" type="text/javascript">
function Refresh() {
	document.location.href = "daftarsemua.php?nip=<?=$nip?>";
}

function Cetak() {
	newWindow('daftarsemua_cetak.php?nip=<?=$nip?>', 'CetakDaftarSemua','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#ffffff">
<br />
<p align="center">
<font class="subtitle"><?=$gelarawal . " " . $nama . " " . $gelarakhir?> - <?=$nip?></font><br />
<a href="JavaScript:Refresh()"><img src="../images/ico/refresh.png" border="0" />&nbsp;Refresh</a>&nbsp;
<a href="JavaScript:Cetak()"><img src="../images/ico/print.png" border="0" />&nbsp;Print</a>&nbsp;
<br />
</p>
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Personal Data</font><br />
    </td>
</tr>
<tr><td>

<table border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<td align="right" valign="top"><strong>Status :</strong></td>
    <td width="*" colspan="2" align="left" valign="top"><?=$status?></td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Section :</strong></td>
    <td width="*" colspan="2" align="left" valign="top"><?=$bagian?></td>
</tr>
<tr>
	<td width="140" align="right" valign="top"><strong>Name </strong>:</td>
    <td width="0" align="left" valign="top"><?=$gelarawal . " " . $nama . " " . $gelarakhir?></td>
    <td width="113" rowspan="5" align="center" valign="top" ><img src="../include/gambar.php?nip=<?=$nip?>&table=jbssdm.pegawai&field=foto" height="120" alt="Foto" /></td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Employee ID </strong>:</td>
    <td width="0" align="left" valign="top"><?=$nip?></td>
</tr>
<tr>
	<td align="right" valign="top">NUPTK :</td>
    <td width="0" align="left" valign="top"><?=$nuptk?></td>
</tr>
<tr>
	<td align="right" valign="top">NRP :</td>
    <td width="0" align="left" valign="top"><?=$nrp?></td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Date of Birth </strong>:</td>
    <td width="0" align="left" valign="top">
    <?=$tmplahir?>, <?=$tgllahir?> <?= NamaBulan($blnlahir)?> <?=$thnlahir?>    </td>
</tr>
<tr>
	<td align="right" valign="top">Religion :</td>
    <td width="0" align="left" valign="top"><?=$agama?></td>
</tr>
<tr>
	<td align="right" valign="top">Ethnicity :</td>
    <td width="0" align="left" valign="top"><?=$suku?></td>
</tr>
<tr>
	<td align="right" valign="top">Address :</td>
    <td width="0" align="left" valign="top"><?=$alamat?></td>
</tr>
<tr>
	<td align="right" valign="top">Mobile :</td>
    <td width="0" align="left" valign="top"><?=$hp?></td>
</tr>
<tr>
	<td align="right" valign="top">Phone :</td>
    <td width="0" align="left" valign="top"><?=$telpon?></td>
</tr>
<tr>
	<td align="right" valign="top">Email :</td>
    <td width="*" colspan="2" align="left" valign="top"><?=$email?></td>
</tr>
<tr>
	<td align="right" valign="top">Facebook :</td>
    <td width="*" colspan="2" align="left" valign="top"><?=$facebook?></td>
</tr>
<tr>
	<td align="right" valign="top">Twitter :</td>
    <td width="*" colspan="2" align="left" valign="top"><?=$twitter?></td>
</tr>
<tr>
	<td align="right" valign="top">Website :</td>
    <td width="*" colspan="2" align="left" valign="top"><?=$website?></td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Start Working :</strong></td>
    <td width="*" colspan="2" align="left" valign="top">
	<?=$tglmulai?> <?=NamaBulan($blnmulai)?> <?=$thnmulai?>    </td>
</tr>
<tr>
	<td align="right" valign="top">Info :</td>
    <td width="*" colspan="2" align="left" valign="top">
	<?=$keterangan?>    </td>
</tr>
</table>

<br />
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Pension</font><br />
    </td>
</tr>
<tr><td>

<table border="1" id="table" style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%" class="tab" id="table">
<tr height="30">
	<td width="5%" align="center" class="header">#</td>
    <td width="35%" align="center" class="header">Retirement Schedule</td>
	<td width="45%" align="center" class="header">Info</td>
</tr>
<?
$sql = "SELECT replid, DATE_FORMAT(tanggal,'%d %M %Y') AS ftmt, keterangan FROM jbssdm.jadwal WHERE nip='$nip' AND jenis='pensiun'";
$result = QueryDb($sql);
if (mysql_num_rows($result) > 0) {
	$cnt = 0;
	while ($row = mysql_fetch_array($result)) { ?>
	<tr height="25">
		<td align="center"><?=++$cnt?></td>
	    <td align="center"><?=$row['ftmt']?></td>
	    <td align="left"><?=$row['keterangan']?></td>
	</tr>
<?	} // while 
} else { ?>
	<tr height="80">
    	<td colspan="3" align="center" valign="middle">
            <font color="#999999"><strong>This employee has no pension schedule.</font>
        </td>
    </tr>
<? 
} // end if
?>
</table>

</td></tr>
</table>

<br />
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Position Order History</font><br />
    </td>
</tr>
<tr><td>

<table border="1" id="table" style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%" class="tab">
<tr height="30">
	<td width="5%" align="center" class="header">#</td>
    <td width="15%" align="center" class="header">Level</td>
    <td width="18%" align="center" class="header">TMT</td>
    <td width="20%" align="center" class="header">Legal Number</td>
    <td width="25%" align="center" class="header">Info</td>
</tr>
<?
$sql = "SELECT replid, golongan, terakhir, DATE_FORMAT(tmt,'%d %M %Y') AS ftmt, sk, keterangan FROM jbssdm.peggol WHERE nip = '$nip' ORDER BY tmt DESC";
$result = QueryDb($sql);
$cnt = 0;
while ($row = mysql_fetch_array($result)) {
?>
<tr height="25">
	<td align="center"><?=++$cnt?></td>
    <td align="center"><?=$row['golongan']?></td>
    <td align="center"><?=$row['ftmt']?></td>
    <td align="left"><?=$row['sk']?></td>
    <td align="left"><?=$row['keterangan']?></td>
</tr>
<?
}
?>
</table>
</td></tr>
</table>
<br />
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Position History</font><br />
    </td>
</tr>
<tr><td>

<table border="1" id="table" style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%" class="tab">
<tr height="30">
	<td width="5%" align="center" class="header">#</td>
    <td width="25%" align="center" class="header">Position</td>
    <td width="18%" align="center" class="header">TMT</td>
    <td width="20%" align="center" class="header">Legal Number</td>
    <td width="15%" align="center" class="header">Info</td>
</tr>
<?
$sql = "SELECT p.replid, p.jenis, p.namajab, DATE_FORMAT(p.tmt,'%d %M %Y') AS ftmt, p.sk, p.keterangan, p.terakhir FROM jbssdm.pegjab p WHERE p.nip = '$nip' ORDER BY tmt DESC";
$result = QueryDb($sql);
$cnt = 0;
while ($row = mysql_fetch_array($result)) {
?>
<tr height="25">
	<td align="center"><?=++$cnt?></td>
    <td align="left"><?=$row['jenis'] . " " . $row['namajab']?></td>
    <td align="center"><?=$row['ftmt']?></td>
    <td align="left"><?=$row['sk']?></td>
    <td align="left"><?=$row['keterangan']?></td>
</tr>
<?
}
?>
</table>
</td></tr>
</table>
<br />
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Education and Training History</font><br />
    </td>
</tr>
<tr><td>

<table border="1" id="table" style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%" class="tab">
<tr height="30">
	<td width="5%" align="center" class="header">#</td>
    <td width="25%" align="center" class="header">Education and Training</td>
    <td width="5%" align="center" class="header">Year</td>
    <td width="20%" align="center" class="header">Legal Number</td>
    <td width="28%" align="center" class="header">Info</td>
</tr>
<?
$sql = "SELECT p.replid, p.iddiklat, d.diklat, p.tahun, p.sk, p.keterangan, p.terakhir FROM jbssdm.pegdiklat p, jbssdm.diklat d WHERE p.nip = '$nip' AND p.iddiklat = d.replid ORDER BY p.tahun DESC, p.replid DESC";
$result = QueryDb($sql);
$cnt = 0;
while ($row = mysql_fetch_array($result)) {
?>
<tr height="25">
	<td align="center"><?=++$cnt?></td>
    <td align="left"><?=$row['diklat']?></td>
    <td align="center"><?=$row['tahun']?></td>
    <td align="left"><?=$row['sk']?></td>
    <td align="left"><?=$row['keterangan']?></td>
</tr>
<?
}
?>
</table>
</td></tr>
</table>

<br />
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">School History</font><br />
    </td>
</tr>
<tr><td>

<table border="1" id="table" style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%" class="tab">
<tr height="30">
	<td width="5%" align="center" class="header">#</td>
    <td width="5%" align="center" class="header">Grade</td>
    <td width="25%" align="center" class="header">School</td>
    <td width="5%" align="center" class="header">Graduates</td>
    <td width="20%" align="center" class="header">Legal Number</td>
    <td width="23%" align="center" class="header">Info</td>
</tr>
<?
$sql = "SELECT ps.replid, ps.tingkat, ps.sekolah, ps.sk, ps.lulus, ps.keterangan, ps.terakhir FROM jbssdm.pegsekolah ps 
        WHERE ps.nip = '$nip' ORDER BY ps.lulus DESC";
$result = QueryDb($sql);
$cnt = 0;
while ($row = mysql_fetch_array($result)) {
?>
<tr height="25">
	<td align="center"><?=++$cnt?></td>
    <td align="center"><?=$row['tingkat']?></td>
    <td align="left"><?=$row['sekolah']?></td>
    <td align="center"><?=$row['lulus']?></td>
    <td align="left"><?=$row['sk']?></td>
    <td align="left"><?=$row['keterangan']?></td>
</tr>
<?
}
?>
</table>
</td></tr>
</table>

<br />
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Certificate History</font><br />
    </td>
</tr>
<tr><td>

<table border="1" id="table" style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%" class="tab">
<tr height="30">
	<td width="5%" align="center" class="header">#</td>
    <td width="22%" align="center" class="header">Certification</td>
    <td width="22%" align="center" class="header">Institution</td>
    <td width="7%" align="center" class="header">Year</td>
    <td width="*" align="center" class="header">Info</td>
</tr>
<?
$sql = "SELECT ps.replid, ps.sertifikat, ps.lembaga, ps.tahun, ps.keterangan, ps.terakhir
          FROM jbssdm.pegserti ps 
         WHERE ps.nip = '$nip'
         ORDER BY ps.tahun DESC";
$result = QueryDb($sql);
$cnt = 0;
while ($row = mysql_fetch_array($result)) {
?>
<tr height="25">
	<td align="center"><?=++$cnt?></td>
    <td align="left"><?=$row['sertifikat']?></td>
    <td align="left"><?=$row['lembaga']?></td>
    <td align="center"><?=$row['tahun']?></td>
    <td align="left"><?=$row['keterangan']?></td>
</tr>
<?
}
?>
</table>

</td></tr>
</table>

<br />
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Work History</font><br />
    </td>
</tr>
<tr><td>

<table border="1" id="table" style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%" class="tab">
<tr height="30">
	<td width="5%" align="center" class="header">#</td>
    <td width="10%" align="center" class="header">Start Year</td>
    <td width="10%" align="center" class="header">End Year</td>
    <td width="20%" align="center" class="header">Location</td>
    <td width="20%" align="center" class="header">Position</td>
    <td width="*" align="center" class="header">Info</td>
</tr>
<?
$sql = "SELECT ps.replid, ps.thnawal, ps.thnakhir, ps.tempat, ps.jabatan, ps.keterangan, ps.terakhir
          FROM jbssdm.pegkerja ps 
         WHERE ps.nip = '$nip'
         ORDER BY ps.thnawal DESC";
$result = QueryDb($sql);
$cnt = 0;
while ($row = mysql_fetch_array($result))
{
?>
<tr height="25">
	<td align="center"><?=++$cnt?></td>
    <td align="center"><?=$row['thnawal']?></td>
    <td align="center"><?=$row['thnakhir']?></td>
    <td align="left"><?=$row['tempat']?></td>
    <td align="left"><?=$row['jabatan']?></td>
    <td align="left"><?=$row['keterangan']?></td>
</tr>
<?
}
?>
</table>

</td></tr>
</table>

<br />
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Family List</font><br />
    </td>
</tr>
<tr><td>

<table border="1" id="table" style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%" class="tab">
<tr height="30">
	<td width="5%" align="center" class="header">#</td>
    <td width="20%" align="center" class="header">Name</td>
    <td width="12%" align="center" class="header">Relationship</td>
    <td width="12%" align="center" class="header">Date of Birth</td>
    <td width="12%" align="center" class="header">Mobile</td>
    <td width="15%" align="center" class="header">Email</td>
    <td width="*" align="center" class="header">Info</td>
</tr>
<?
$sql = "SELECT ps.replid, ps.nama, ps.alm, ps.hubungan, ps.tgllahir, ps.hp, ps.email, ps.keterangan
          FROM jbssdm.pegkeluarga ps 
         WHERE ps.nip = '$nip'
         ORDER BY ps.nama";
$result = QueryDb($sql);
$cnt = 0;
while ($row = mysql_fetch_array($result))
{
?>
<tr height="25">
	<td align="center"><?=++$cnt?></td>
    <td align="left">
	<?=$row['nama']?>
	<? if ((int)$row['alm'] == 1) echo " (alm)"; ?>
	</td>
    <td align="left"><?=$row['hubungan']?></td>
    <td align="left"><?=$row['tgllahir']?></td>
    <td align="left"><?=$row['hp']?></td>
	<td align="left"><?=$row['email']?></td>
    <td align="left"><?=$row['keterangan']?></td>
</tr>
<?
}
?>
</table>

</td></tr>
</table>

<?
CloseDb();
?>    
</td></tr>

</table>

</body>
</html>



