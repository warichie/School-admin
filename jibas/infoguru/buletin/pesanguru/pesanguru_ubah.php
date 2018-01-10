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
$replid="";
if (isset($_REQUEST['replid']))
	$replid=$_REQUEST['replid'];
$idguru=SI_USER_ID();	
OpenDb();
$sql="SELECT judul,pesan,replid,DATE_FORMAT(tanggaltampil,'%d-%m-%Y') as tanggal FROM jbsvcr.pesanguru WHERE replid='$replid'";
$result=QueryDb($sql);
$row=@mysql_fetch_array($result);

$sql1="SELECT replid,namafile FROM jbsvcr.lampiranpesanguru WHERE idpesan='$replid' LIMIT 0,1";
$result1=QueryDb($sql1);
$row1=@mysql_fetch_array($result1);

$sql2="SELECT replid,namafile FROM jbsvcr.lampiranpesanguru WHERE idpesan='$replid' LIMIT 1,1";
$result2=QueryDb($sql2);
$row2=@mysql_fetch_array($result2);

$sql3="SELECT replid,namafile FROM jbsvcr.lampiranpesanguru WHERE idpesan='$replid' LIMIT 2,1";
$result3=QueryDb($sql3);
$row3=@mysql_fetch_array($result3);
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
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,forecolor,backcolor,fullscreen,print",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,image",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		content_css : "style/content.css"
	});
	
	
	function OpenUploader() {
	    var addr = "UploaderMain.aspx";
	    newWindow(addr, 'Uploader','720','630','resizable=1,scrollbars=1,status=0,toolbar=0');
    }
function validate(){
	//alert ('Masuk validate');
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
function hapusfile1(){
	var d1 = document.getElementById('d1').value ;
	if(d1 == 0){
	   document.getElementById('d1').value = 1;
	   document.getElementById('tr1').style.background = "#FF8080" ;
	} else {
	   document.getElementById('d1').value = 0;
	   document.getElementById('tr1').style.background = "#FFFFFF" ;
	}
}
function hapusfile2(){
	var d2 = document.getElementById('d2').value ;
	if(d2 == 0){
	   document.getElementById('d2').value = 1;
	   document.getElementById('tr2').style.background = "#FF8080" ;
	} else {
	   document.getElementById('d2').value = 0;
	   document.getElementById('tr2').style.background = "#FFFFFF" ;
	}
}
function hapusfile3(){
	var d3 = document.getElementById('d3').value ;
	if(d3 == 0){
	   document.getElementById('d3').value = 1;
	   document.getElementById('tr3').style.background = "#FF8080" ;
	} else {
	   document.getElementById('d3').value = 0;
	   document.getElementById('tr3').style.background = "#FFFFFF" ;
	}
}
function simpan(){
	document.getElementById('receiver').value="";;
	var jumpeg=parent.pesanguru_ubah_tujuan.document.getElementById('numpegawai').value;
	var numpegawaikirim=parent.pesanguru_ubah_tujuan.document.getElementById('numpegawaikirim').value;
	var tahun=parent.pesanguru_ubah_tujuan.document.getElementById('tahun').value;
	var bulan=parent.pesanguru_ubah_tujuan.document.getElementById('bulan').value;
	var bagian=parent.pesanguru_ubah_tujuan.document.getElementById('bagian').value;
	document.getElementById('tahun').value=tahun;
	document.getElementById('bulan').value=bulan;
	document.getElementById('jum').value=numpegawaikirim;
	var x=1;
	while (x<=jumpeg){
		var nip = parent.pesanguru_ubah_tujuan.document.getElementById('nip'+x).value;
		var ceked = parent.pesanguru_ubah_tujuan.document.getElementById('ceknip'+x).checked;
		if (ceked==true){
		var rec=document.getElementById('receiver').value;
		document.getElementById('receiver').value=rec+nip+"|";
		}
	x++;
	}
	document.getElementById('pesanguru').submit();
}
</script>
</head>
<body onload="document.getElementById('judul').focus();">
<form name="pesanguru" id="pesanguru" action="pesanubahsimpan.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="replid" id="replid" value="<?=$replid?>" />
<input type="hidden" name="bulan" id="bulan" value="<?=$bulan?>" />
<input type="hidden" name="jum" id="jum" value="<?=$jum?>"/>
<input type="hidden" name="op" id="op" value="<?=$op?>"/>
<input type="hidden" name="receiver" id="receiver" size="300"/>
<input type="hidden" name="tahun" id="tahun" value="<?=$tahun?>" />
<input type="hidden" name="sender" id="sender" value="tambah" />
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td scope="row" align="left"><strong>New Message :</strong></td>
  </tr>
  <tr>
    <td scope="row" align="left" bgcolor="#FFFFFF">
    <table width="100%" border="1" cellspacing="0">
  <tr style="background-color:#e7e7cf;">
    <th width="14%" scope="row">Title</th>
    <td colspan="2"><input type="text" name="judul" id="judul" size="50" value="<?=$row['judul']?>" /></td>
  </tr>
  <tr>
    <th scope="row">Publish Date</th>
    <td colspan="2"><input title="Click to open the Calendar" type="text" name="tanggal" id="tanggal" size="25" readonly="readonly" class="disabled"  value="<?=$row['tanggal']?>"/><img title="Click to open the Calendar" src="../../images/ico/calendar_1.png" name="btntanggal" width="16" height="16" border="0" id="btntanggal"/></td>
  </tr>
  <tr style="background-color:#e7e7cf;">
    <th valign="top" scope="row">Message</th>
    <td colspan="2"><textarea name="pesan" id="pesan"><?=$row['pesan']?></textarea></td>
  </tr>
  <tr>
    <th colspan="3" scope="row" align="left"><fieldset><legend>Attachment</legend>
    
    <table width="100%" border="1" cellspacing="0">
  <tr id="tr1" >
    <th width="2%" scope="row">#1</th>
    <th width="36%" scope="row"><?=$row1['namafile']?></th>
    <th width="62%" scope="row"><div align="left"><? if ($row1['namafile']!="") { ?><img src="../../images/ico/hapus.png" onclick="hapusfile1()" title="Delete this file" style="cursor:pointer" /><? } ?><input type="hidden" size="1" name="d1" id="d1" value="0"/><input type="hidden" name="repd1" id="repd1" value="<?=$row1[replid]?>" /></div></th>
  </tr>
  <tr id="tr2" >
    <th scope="row">#2</th>
    <th scope="row"><?=$row2['namafile']?></th>
    <th scope="row"><div align="left"><? if ($row2['namafile']!="") { ?><img src="../../images/ico/hapus.png" onclick="hapusfile2()" title="Delete this file" style="cursor:pointer" /><? } ?><input type="hidden" name="d2" id="d2" size="1" value="0" /><input type="hidden" name="repd2" id="repd2" value="<?=$row2[replid]?>" /></div></th>
  </tr>
  <tr id="tr3" >
    <th scope="row">#3</th>
    <th scope="row"><?=$row3['namafile']?></th>
    <th scope="row"><div align="left"><? if ($row3['namafile']!="") { ?><img src="../../images/ico/hapus.png" onclick="hapusfile3()" title="Delete this file" style="cursor:pointer" /><? } ?>
<input type="hidden" name="d3" size="1" id="d3" value="0" /><input type="hidden" name="repd3" id="repd3" value="<?=$row3[replid]?>" /></div></th>
  </tr>
</table>
    
    </fieldset></th>
    </tr>
  <tr>
    <td colspan="2"><strong>New Attachment :</strong></td>
    </tr>
  <tr>
    <td width="2%"><div align="center"><strong>#1</strong></div></td>
    <td width="84%"><input size="25" type="file" id="file1" name="file1"/>      &nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><strong>#2</strong></div></td>
    <td><input size="25" type="file" name="file2" id="file3" />      &nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><strong>#3</strong></div></td>
    <td><input size="25" type="file" name="file3" id="file3" />      &nbsp;</td>
  </tr>
  <tr>
    <th colspan="3" scope="row">&nbsp;</th>
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
</script>