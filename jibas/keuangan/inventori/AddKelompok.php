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
require_once('../include/config.php');
require_once('../include/db_functions.php');
OpenDb();
$idgroup = $_REQUEST[idgroup];
if (isset($_REQUEST['Simpan'])){
	$sql = "SELECT * FROM jbsfina.kelompokbarang WHERE kelompok='".addslashes(trim($_REQUEST[kelompokname]))."' AND idgroup='$_REQUEST[idgroup]'";
	if (@mysql_num_rows(QueryDb($sql))>0){
		?>
        <script language="javascript">
			alert ('Group <?=$_REQUEST[kelompokname]?> has been used');
        </script>
        <?
	} else {
		QueryDb("INSERT INTO jbsfina.kelompokbarang SET kelompok='".addslashes(trim($_REQUEST[kelompokname]))."', keterangan='".addslashes(trim($_REQUEST[keterangan]))."',idgroup='$_REQUEST[idgroup]'");
		?>
        <script language="javascript">
			parent.opener.GetFresh();
			window.close();
        </script>
        <?
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../style/style.css" />
<title>Add Item Group</title>
<script language="javascript">
function validate(){
	var namakelompok = document.getElementById('kelompokname').value;
	if (namakelompok.length==0){
		alert ('Anda harus mengisikan Group Name'); 
		document.getElementById('kelompokname').focus();
		return false;
	}
	return true;
}
</script>
</head>
<body onLoad="document.getElementById('kelompokname').focus()">
<fieldset style="border:#336699 1px solid; background-color:#eaf4ff" >
<legend style="background-color:#336699; color:#FFFFFF; font-size:12px; font-weight:bold; padding:5px; ">&nbsp;Add&nbsp;Group&nbsp;</legend>
<form action="AddKelompok.php" onSubmit="return validate()" method="post">
<input type="hidden" name="idgroup" id="idgroup" value="<?=$_REQUEST[idgroup]?>" />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>Group Name</td>
    <td><input name="kelompokname" id="kelompokname" type="text" maxlength="45" style="width:100%" value="<?=stripslashes($_REQUEST[kelompokname])?>" /></td>
  </tr>
  <tr>
    <td>Info</td>
    <td><textarea name="keterangan" id="keterangan" style="width:100%" rows="5"><?=stripslashes($_REQUEST[keterangan])?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input class="but" type="submit" name="Simpan" value="Save" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.close()" class="but" /></td>
  </tr>
</table>
</form>
</fieldset>
</body>
<?
CloseDb();
?>
</html>