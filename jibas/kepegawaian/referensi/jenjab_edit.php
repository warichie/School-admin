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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/theme.php');
require_once("../include/sessioninfo.php");

if (isset($_REQUEST['jenis']))
	$jenis = $_REQUEST['jenis'];

if (isset($_REQUEST['jenisasli']))
	$jenisasli = $_REQUEST['jenisasli'];
	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

if (isset($_REQUEST['keterangan']))
	$keterangan = $_REQUEST['keterangan'];		
$cek = 0;
$ERROR_MSG = "";
if (isset($_REQUEST['Simpan'])) {
	OpenDb();
	if ($jenis!=$jenisasli){
	$sql = "SELECT * FROM jenisjabatan WHERE jenis = '$_REQUEST[jenis]'";
	$result = QueryDb($sql);
			
	if (mysql_num_rows($result) > 0) {
		CloseDb();
		$ERROR_MSG = "Position Type $_REQUEST[jenis] has been used";
		$cek = 0;	
	} else {
		$sql = "UPDATE jenisjabatan SET jenis='$_REQUEST[jenis]',urutan=$_REQUEST[urutan],keterangan='$_REQUEST[keterangan]' WHERE jenis='$jenisasli'";
		$result = QueryDb($sql);
		CloseDb();
	
		if ($result) { ?>
			<script language="javascript">
				opener.refresh();
				window.close();
			</script> 
	<?		}
		exit();
	}
	} else {
	$sql = "UPDATE jenisjabatan SET jenis='$_REQUEST[jenis]',urutan=$_REQUEST[urutan],keterangan='$_REQUEST[keterangan]' WHERE jenis='$jenisasli'";
		$result = QueryDb($sql);
		CloseDb();
	
		if ($result) { ?>
			<script language="javascript">
				opener.refresh();
				window.close();
			</script> 
	<?		}
		exit();
	}
};


switch ($cek) {
	case 0 : $input_awal = "onload=\"document.getElementById('jenis').focus()\"";
		break;
	case 1 : $input_awal = "onload=\"document.getElementById('urutan').focus()\"";
		break;
}

OpenDb();
$sql = "SELECT jenis,urutan,keterangan FROM jenisjabatan WHERE jenis = '$jenis'"; 
$result = QueryDb($sql);
$row = mysql_fetch_row($result);
$jenis = $row[0];
$urutan = $row[1];
$keterangan = $row[2];


CloseDb();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style<?=GetThemeDir2()?>.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Employee Affair</title>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">
function tutup() {
	document.getElementById('urutan').focus();
}

function validate() {
	return validateEmptyText('jenis', 'Position Type') && 
		   validateEmptyText('urutan', 'Urutan Position Type') && 
		   validateNumber('urutan', 'Urutan Position Type') &&
		   validateMaxText('keterangan', 255, 'Info');
}


</script>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#FFFFFF" <?=$input_awal?>>
<form name="main" onSubmit="return validate()">
<input type="hidden" name="jenisasli" id="jenisasli" value="<?= $jenis ?>" />


<table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
<!-- TABLE CONTENT -->
<tr height="25">
<td class="header" colspan="2" align="center">Edit Position Type</td>
</tr>
<tr>
	<td width="120"><strong>Position Type</strong></td>
	<td>
    	<input type="text" name="jenis" id="jenis" size="10" maxlength="50" value="<?= $jenis ?>" onFocus="showhint('Position Type should not exceed 50 characters', this, event, '120px');" />    </td>
</tr>
<tr>
	<td><strong>Sort</strong></td>
	<td>
    	<input type="text" name="urutan" id="urutan" size="3" maxlength="5" value="<?= $urutan ?>" onFocus="showhint('Position type display order', this, event, '120px');" />    </td>
</tr>
<tr>
	<td valign="top">Info</td>
	<td>
    	<textarea name="keterangan" id="keterangan" rows="3" cols="40" ><?= $keterangan ?></textarea>    </td>
</tr>
<tr>
	<td colspan="2" align="center">
    <input type="submit" name="Simpan" id="Simpan" value="Save" class="but"/>&nbsp;
    <input type="button" name="Tutup" id="Tutup" value="Close" class="but" onClick="window.close()" />    </td>
</tr>
<!-- END OF TABLE CONTENT -->
</table>
</form>
<!-- Tamplikan error jika ada -->
<? if (strlen($ERROR_MSG) > 0) { ?>
<script language="javascript">
	alert('<?=$ERROR_MSG?>');
</script>
<? } ?>

</body>
</html>