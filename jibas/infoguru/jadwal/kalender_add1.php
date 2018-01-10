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

$departemen=$_REQUEST['departemen'];
$op=$_REQUEST['op'];
if ($op=="simpan"){
OpenDb();
$sql_cek="SELECT * FROM jbsakad.kalenderakademik WHERE departemen='$_REQUEST[departemen]' AND kalender='$_REQUEST[kalender]'";
$result_cek=QueryDb($sql_cek);
if (@mysql_num_rows($result_cek)>0){
?>
<script language="javascript">
alert ('Calendar name has been used ');
document.location.href="kalender_add.php?kalender=<?=$_REQUEST[kalender]?>&tglmulai=<?=$_REQUEST[tglmulai]?>&tglakhir=<?=$_REQUEST[tglakhir]?>&departemen=<?=$_REQUEST[departemen]?>";
</script>
<?
} else {
$tglmulai=TglDb($_REQUEST[tglmulai]);
$tglakhir=TglDb($_REQUEST[tglakhir]);
$sql_simpan="INSERT INTO jbsakad.kalenderakademik SET kalender='$_REQUEST[kalender]',tglmulai='$tglmulai',tglakhir='$tglakhir',departemen='$_REQUEST[departemen]',aktif=1";
$result_simpan=QueryDb($sql_simpan);
if ($result_simpan){
	$sql_idterakhir="SELECT LAST_INSERT_ID(replid) as idterakhir FROM jbsakad.kalenderakademik ORDER BY replid DESC LIMIT 1";
	$result_idterakhir=QueryDb($sql_idterakhir);
	$row_idterakhir=@mysql_fetch_array($result_idterakhir);
?>
<script language="javascript">
//alert ('Berhasil ');
parent.opener.refresh_with_dept('<?=$_REQUEST[departemen]?>');
window.close();
</script>
<?
} else {
?>
<script language="javascript">
alert ('Failed to save data');
document.location.href="kalender_add.php?kalender=<?=$_REQUEST[kalender]?>&tglmulai=<?=$_REQUEST[tglmulai]?>&tglakhir=<?=$_REQUEST[tglakhir]?>&departemen=<?=$_REQUEST[departemen]?>";
</script>
<?
}
}
}
CloseDb();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/calendar-win2k-1.css">
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="../script/tools.js"></script>
<script type="text/javascript" src="../script/calendar.js"></script>
<script type="text/javascript" src="../script/lang/calendar-en.js"></script>
<script type="text/javascript" src="../script/calendar-setup.js"></script>
<script type="text/javascript">
function simpan(){
var departemen=document.getElementById("departemen").value;
var kalender=document.getElementById("kalender").value;
var tglmulai=document.getElementById("tglmulai").value;
var tglakhir=document.getElementById("tglakhir").value;
if (kalender.length<1){
	alert ('Calendar name is required');
	document.getElementById("kalender").focus();
	return false;
	}
if (tglmulai.length<1){
	alert ('Start date is required');
	document.getElementById("tglmulai").focus();
	return false;
	}
if (tglakhir.length<1){
	alert ('End date is required');
	document.getElementById("tglakhir").focus();
	return false;
	}
document.location.href="kalender_add.php?op=simpan&kalender="+kalender+"&tglmulai="+tglmulai+"&tglakhir="+tglakhir+"&departemen="+departemen;	
}
</script>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#FFFFFF">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
    <form name="inputkalender"  id="inputkalender" >
   <table width="95%" border="0" class="tab" id="table">
  <tr>
    <td height="25" colspan="2" class="header"><div align="left">Add Academic Calendar</div></td>
    </tr>
  <tr>
    <td width="39%">Academic Calendar</td>
    <td width="61%"><input type="text" name="kalender" id="kalender"  value="<?=$_REQUEST['kalender']?>"/>
    <input type="hidden" name="departemen" id="departemen" value="<?=$_REQUEST['departemen']?>" /></td>
    </tr>
  <tr>
    <td colspan="2"><fieldset><legend>Period</legend>
    <table width="100%" border="0">
  <tr>
    <td width="46%">Start Date</td>
    <td width="19%"><input type="text" name="tglmulai" id="tglmulai" readonly="readonly" value="<?=$_REQUEST['tglmulai']?>"/></td>
    <td width="35%"><img src="../images/ico/calendar_1.png" alt="Show Table" name="tabel" width="22" height="22" border="0" id="btntglmulai" onMouseOver="showhint('Open calendar', this, event, '120px')"/></td>
  </tr>
  <tr>
    <td>End Date</td>
    <td><input type="text" name="tglakhir" id="tglakhir"  readonly="readonly" value="<?=$_REQUEST['tglakhir']?>"/></td>
    <td><img src="../images/ico/calendar_1.png" alt="Show Table" name="tabel" width="22" height="22" border="0" id="btntglakhir" onMouseOver="showhint('Open calendar', this, event, '120px')"/></td>
  </tr>
</table>

    </fieldset></td>
    </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input class="but" type="button" name="Simpan" id="Simpan" value="Save" onClick="simpan();"/>
      <input class="but" type="button" name="Tutup" id="Tutup" value="Close" onClick="window.close();"/>
    </div></td>
    </tr>
</table>
</form>
   
   
   
    <!-- END OF CONTENT //--->
    </td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_06a.jpg">&nbsp;</td>
</tr>
<tr height="28">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_07.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_08a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_09.jpg">&nbsp;</td>
</tr>
</table>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "tglmulai",         // ID of the input field
      ifFormat    : "%d-%m-%Y",    // the date format
      button      : "btntglmulai"       // ID of the button
    }
  );
   Calendar.setup(
    {
      inputField  : "tglakhir",         // ID of the input field
      ifFormat    : "%d-%m-%Y",    // the date format
      button      : "btntglakhir"       // ID of the button
    }
  );
</script>
</body>
</html>