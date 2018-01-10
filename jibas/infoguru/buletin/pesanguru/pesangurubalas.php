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
require_once('../../include/common.php');
require_once('../../include/sessioninfo.php');
require_once('../../include/config.php');
require_once('../../include/db_functions.php');
$idpesan="";
if (isset($_REQUEST['idpesan']))
	$idpesan=$_REQUEST['idpesan'];
$idguru=SI_USER_ID();
OpenDb();
$sql = "SELECT p.judul,p.pesan,p.idguru,peg.nama FROM jbsvcr.pesan p, jbssdm.pegawai peg WHERE p.replid='$idpesan' AND p.idguru=peg.nip";
$result = QueryDb($sql);
$row = @mysql_fetch_array($result);
$judul = $row[judul];
$pesan = $row[pesan];
$receiver = $row[idguru];
$nama = $row[nama];

CloseDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../style/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../style/calendar-win2k-1.css">
<script type="text/javascript" src="../../script/calendar.js"></script>
<script type="text/javascript" src="../../script/lang/calendar-en.js"></script>
<script type="text/javascript" src="../../script/calendar-setup.js"></script>
<script language="javascript" src="../../script/tables.js"></script>
<script src="../../script/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../script/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../../script/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		skin_variant : "silver",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",		
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "forecolor,backcolor,fullscreen,print,|,cut,copy,paste,pastetext,|,search,replace,|,bullist,numlist,|,hr,removeformat,|,sub,sup,|,charmap,image",
		theme_advanced_buttons3 : "tablecontrols",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		content_css : "../../style/content.css"
	});
	
	
	function OpenUploader() {
	    var addr = "UploaderMain.aspx";
	    newWindow(addr, 'Uploader','720','630','resizable=1,scrollbars=1,status=0,toolbar=0');
    }
function validate(){
	var judul=document.getElementById('judul').value;
	var pesan=tinyMCE.get('pesan').getContent();
	if (judul.length==0){
		alert ('Message Title should not leave empty');
		document.getElementById('judul').focus();
		return false;
	}
	if (pesan.length==0){
		alert ('Message should not leave empty');
		document.getElementById('pesan').focus();
		return false;
	}
	simpan();
}
function hapusfile(field){
	document.getElementById(field).value="";
}
</script>
</head>
<body onload="document.getElementById('judul').focus();">
<form name="pesanguru" id="pesanguru" action="pesansimpan.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="idpesan" id="idpesan" value="<?=$idpesan?>" />
<input type="hidden" name="receiver" id="receiver" value="<?=$receiver?>"/>
<input type="hidden" name="balas" id="balas" value="1"/>
<input type="hidden" name="jum" id="jum" value="1"/>
<input type="hidden" name="idguru" id="idguru" value="<?=$idguru?>" />
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td scope="row" align="left"><strong><font size="2" color="#999999">Reply Message :</font></strong><br /><br /></td>
  </tr>
  <tr>
    <td scope="row" align="left">
    <table width="100%" border="0" cellspacing="2" cellpadding="2"  >
  <tr>
    <th width="134" scope="row"><div align="left">To</div></th>
    <td colspan="2"><input type="text" maxlength="254" name="receiver2" id="receiver2" size="50" value="[<?=$receiver?>] <?=$nama?>" /></td>
  </tr>
  <tr>
    <th width="134" scope="row"><div align="left">Title</div></th>
    <td colspan="2"><input type="text" maxlength="254" name="judul" id="judul" size="50" value="Balasan : <?=$judul?>" /></td>
  </tr>
  <tr>
    <th scope="row"><div align="left">Publish Date</div></th>
    <td colspan="2"><input title="Click to open the Calendar" type="text" name="tanggal" id="tanggal" size="25" readonly="readonly" class="disabled" value="<?=date(d)."-".date(m)."-".date(Y); ?>"/><img title="Click to open the Calendar" src="../../images/ico/calendar_1.png" name="btntanggal" width="16" height="16" border="0" id="btntanggal"/></td>
  </tr>
  <tr>
    <th colspan="3" valign="top" align="left" scope="row"  ><div align="left">Message<br />
        <textarea name="pesan" rows="27" id="pesan">Original message : <?=$pesan?><hr style="border:dashes;"><br />Reply message :</textarea>
    </div></th>
    </tr>
  <tr>
    <th colspan="3" scope="row"></th>
    </tr>
  <tr>
    <th colspan="3" scope="row">
      <table width="100%" align="left" border="0" cellspacing="0">
        <tr>
          <th rowspan="3" scope="row"><div align="left">Attachment</div></th>
            <td><div align="center">#1</div></td>
            <td><input size="25" type="file" id="file1" name="file1"/><img src="../../images/ico/hapus.png" onclick="hapusfile('file1')" title="Delete this file" style="cursor:pointer" />&nbsp;</td>
          </tr>
        <tr>
          <td><div align="center">#2</div></td>
            <td><input size="25" type="file" name="file2" id="file3" /><img src="../../images/ico/hapus.png" onclick="hapusfile('file2')" title="Delete this file" style="cursor:pointer" />&nbsp;</td>
          </tr>
        <tr>
          <td><div align="center">#3</div></td>
            <td><input size="25" type="file" name="file3" id="file3" /><img src="../../images/ico/hapus.png" onclick="hapusfile('file3')" title="Delete this file" style="cursor:pointer" />&nbsp;</td>
          </tr>
      </table></th>
    </tr>
  <tr>
    <td colspan="3" scope="row"><div align="center">
      <input name="kirim" type="submit" class="but" id="kirim" value="Send" style="width:100px;" />
    </div></td>
    </tr>
</table>
    </td>
  </tr>
</table>
</form>
</body>
<script type="text/javascript">
  Calendar.setup(
    {
	  inputField  : "tanggal",         
      ifFormat    : "%d-%m-%Y",  
      button      : "btntanggal"    
    }
   );
   Calendar.setup(
    {
	  inputField  : "tanggal",      
      ifFormat    : "%d-%m-%Y",   
      button      : "tanggal"     
    }
   );
  
</script>
</html>
<script language="javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("judul");
var sprytextfield2 = new Spry.Widget.ValidationTextField("receiver2");
</script>