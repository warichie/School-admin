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
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/theme.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
//require_once('../cek.php');

$replid = $_REQUEST['replid'];
$ERROR_MSG = "";
if (isset($_REQUEST['Simpan'])) {
	OpenDb();
	$sql = "SELECT * FROM jenisujian WHERE jenisujian = '$_REQUEST[jenisujianbaru]' AND replid<>'$replid' AND idpelajaran = '$_REQUEST[idpelajaran]' AND info1='$_REQUEST[singkatan]'";
	$result = QueryDb($sql);
	if (mysql_num_rows($result) > 0) {
		$jenisujian=$_REQUEST['jenisujianbaru'];
		CloseDb();
		$ERROR_MSG = "Exam Type $jenisujian has been used";
	} else {
		$sql = "UPDATE jenisujian SET replid='$_REQUEST[replid]',jenisujian='$_REQUEST[jenisujianbaru]',keterangan='$_REQUEST[keterangan]',info1='$_REQUEST[singkatan]' WHERE jenisujian='$_REQUEST[jenisujian]' AND replid='$_REQUEST[replid]'";
		$result = QueryDb($sql);
		CloseDb();
	
		if ($result) { ?>
			<script language="javascript">
				opener.refresh();
				window.close();
			</script> 
<?		
	}
}
}

OpenDb();

$sql = "SELECT j.replid,j.jenisujian,j.idpelajaran,j.keterangan,p.replid,p.nama,p.departemen,j.info1 FROM jenisujian j, pelajaran p WHERE j.replid = '$replid' AND j.idpelajaran = p.replid";   
$result = QueryDb($sql);
$row = mysql_fetch_row($result);
$jenisujian = $row[1];
if (isset($_REQUEST['jenisujian']))
	$jenisujian = $_REQUEST['jenisujian'];
$keterangan = $row[3];
if (isset($_REQUEST['keterangan']))
	$keterangan = $_REQUEST['keterangan'];
$pelajaran = $row[5];
$idpelajaran = $row[2];
$departemen = $row[6];
$singkatan = $row[7];


CloseDb();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Edit Exam Type]</title>
<script src="../script/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="../script/SpryValidationTextfield.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextfield.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">

function validate() {
	return validateEmptyText('jenisujianbaru', 'Exam Type') && 
		   validateEmptyText('singkatan', 'Code') && 
		   validateMaxText('keterangan', 255, 'Info');
}

function focusNext(elemName, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		document.getElementById(elemName).focus();
		return false;
    } 
    return true;
}
</script>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#FFFFFF" onLoad="document.getElementById('jenisujianbaru').focus();">
<form name="main" onSubmit="return validate()">
<input type="hidden" name="replid" id="replid" value="<?=$replid ?>" />
<input type="hidden" name="idpelajaran" id="idpelajaran" value="<?=$idpelajaran ?>" />
<table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
<!-- TABLE CONTENT -->
<tr height="25">
<td class="header" colspan="2" align="center">Edit Exam Type</td>
</tr>
<tr>
  <td><strong>Department</strong></td>
  <td><input type="text" name="departemen" id="departemen" size="10" maxlength="10" value="<?=$departemen ?>"  class="disabled" readonly/></td>
</tr>
<tr>
  <td><strong>Class Subject</strong></td>
  <td><input type="text" name="pelajaran" id="pelajaran" size="30" maxlength="50" value="<?=$pelajaran ?>" class="disabled" readonly/></td>
</tr>
<tr>
	<td><strong>Exam Type</strong></td>
	<td>
    	<input type="text" name="jenisujianbaru" id="jenisujianbaru" size="30" maxlength="50" value="<?=$jenisujian ?>" onFocus="showhint('Exam Type Name should not exceed 50 characters', this, event, '120px')" onKeyPress="return focusNext('singkatan', event)" /> <input type="hidden" name="jenisujian" id="jenisujian" size="30" maxlength="50" value="<?=$jenisujian ?>" />   </td>
</tr>
<tr>
	<td><strong>Code</strong></td>
	<td>
    	<input type="text" name="singkatan" id="singkatan" size="10" maxlength="10" value="<?=$singkatan ?>" onFocus="showhint('Code should not exceed 10 characters', this, event, '120px')" onKeyPress="return focusNext('keterangan', event)" />  </td>
</tr>
<tr>
	<td valign="top">Info</td>
	<td>
    	<textarea name="keterangan" id="keterangan" rows="3" cols="45" onKeyPress="return focusNext('Simpan', event)"><?=$keterangan ?></textarea>    </td>
</tr>
<tr>
	<td colspan="2" align="center">
    <input type="submit" name="Simpan" id="Simpan" value="Save" class="but" />&nbsp;
    <input type="button" name="Tutup" id="Tutup" value="Close" class="but" onClick="window.close()" />    </td>
</tr>
<!-- END OF TABLE CONTENT -->
</table>
</form>
<? if (strlen($ERROR_MSG) > 0) { ?>
<script language="javascript">
	alert('<?=$ERROR_MSG?>');
</script>
<? } ?>
</body>
</html>
<script language="javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("jenisujianbaru");
var sprytextfield2 = new Spry.Widget.ValidationTextField("singkatan");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("keterangan");
</script>