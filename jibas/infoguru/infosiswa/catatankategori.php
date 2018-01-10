<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 2.6.0 (January 14, 2012)
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
require_once('../include/errorhandler.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once("../include/sessionchecker.php");

OpenDb();
$op = "";
if (isset($_REQUEST['op']))
	$op = $_REQUEST['op'];

if ($op == "dw8dxn8w9ms8zs22") {
	$sql = "UPDATE jbsvcr.catatankategori SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
	QueryDb($sql);
} 
if ($op == "xm8r389xemx23xb2378e23") {
	$sql = "DELETE FROM jbsvcr.catatankategori WHERE replid = '$_REQUEST[replid]'";
	$result = QueryDb($sql);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function tambah() {
	newWindow('catatankategori_add.php', 'TambahCatatanKategori','390','160','resizable=1,scrollbars=0,status=0,toolbar=0')
}

function refresh() {
	document.location.reload();
}

function setaktif(replid, aktif) {
	var msg;
	var newaktif;
	
	if (aktif == 1) {
		msg = "Are you sure want to change this category to INACTIVE?";
		newaktif = 0;
	} else	{	
		msg = "Are you sure want to change this category to ACTIVE?";
		newaktif = 1;
	}
	
	if (confirm(msg)) 
		document.location.href = "catatankategori.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif;
}

function edit(replid) {
	newWindow('catatankategori_edit.php?replid='+replid, 'UbahCatatanKejadian','385','149','resizable=1,scrollbars=0,status=0,toolbar=0')
}

function hapus(replid) {
	if (confirm("Are you sure want to delete this category?"))
		document.location.href = "catatankategori.php?op=xm8r389xemx23xb2378e23&replid="+replid;
}

function cetak() {
	newWindow('catatankategori_cetak.php', 'CetakKategori','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
</script>
</head>

<body>

<table border="0" width="100%" height="100%">
<!-- TABLE BACKGROUND IMAGE -->
<tr><td align="center" valign="top" background="../images/b_departemen.png" style="margin:0;padding:0;background-repeat:no-repeat;">

<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr height="300">
  <td align="left" valign="top">

	<table border="0"width="95%" align="center">
    <tr>
        <td align="right"><font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Notes Category </font></td>
    </tr>
    <tr>
        <td align="right">
         <a href="../catatankejadian.php" target="framecenter">
          <font size="1" face="Verdana" color="#000000"><b>Student Attendance Notes</b></font></a>
          &nbsp;>&nbsp; <font size="1" face="Verdana" color="#000000">Notes Category </font>
        </td>
    </tr>
     <tr>
      <td align="left">&nbsp;</td>
      </tr>
	</table>
	<br /><br />
    <?
	$sql = "SELECT * FROM jbsvcr.catatankategori ORDER BY replid";
	//echo $sql;    
	$result = QueryDb($sql);
	if (@mysql_num_rows($result) > 0){
	?>
    <table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
    <!-- TABLE CONTENT -->
    <tr><td align="right">
    
    <a href="#" onClick="document.location.reload()"><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;
    <a href="JavaScript:cetak()"><img src="../images/ico/print.png" border="0" onMouseOver="showhint('Print', this, event, '50px')" />&nbsp;Print</a>&nbsp;&nbsp;    
<?	if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
	    <a href="JavaScript:tambah()"><img src="../images/ico/tambah.png" border="0" onMouseOver="showhint('Add', this, event, '50px')" />&nbsp;Add</a>
<?	} ?>    
    </td></tr>
    </table><br />
    <table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="95%" align="center" bordercolor="#000000">
    <tr height="30">
    	<td width="4%" class="header" align="center">#</td>
        <td width="49%" class="header" align="center">Category</td>
        <td width="7%" class="header" align="center">Active</td>
        <td width="30%" class="header" align="center">Info</td>
        <?		if (SI_USER_LEVEL() != $SI_USER_STAFF) {  ?> <td width="10%" class="header" align="center"></td><? } ?>
    </tr>
<? 	
	
	$cnt = 0;
	while ($row = mysql_fetch_array($result)) { ?>
    <tr height="25">
    	<td align="center"><?=++$cnt ?></td>
        <td><?=$row[kategori] ?></td>
        
        <td align="center">
        
<?		if (SI_USER_LEVEL() == $SI_USER_STAFF) {  
			if ($row[aktif] == 1) { ?> 
            	<img src="../images/ico/aktif.png" border="0" onMouseOver="showhint('Status Active', this, event, '50px')"/>
<?			} else { ?>                
				<img src="../images/ico/nonaktif.png" border="0" onMouseOver="showhint('Status Inactive', this, event, '50px')"/>
<?			}
		} else { 
			if ($row[aktif] == 1) { ?>
				<a href="JavaScript:setaktif(<?=$row[replid] ?>, <?=$row[aktif] ?>)"><img src="../images/ico/aktif.png" border="0" onMouseOver="showhint('Status Active', this, event, '50px')"/></a>
<?			} else { ?>
				<a href="JavaScript:setaktif(<?=$row[replid] ?>, <?=$row[aktif] ?>)"><img src="../images/ico/nonaktif.png" border="0" onMouseOver="showhint('Status Inactive', this, event, '50px')"/></a>
<?			} //end if
		} //end if ?>        
        
        </td>
        <td><?=$row[keterangan] ?></td>
<?		if (SI_USER_LEVEL() != $SI_USER_STAFF) {  ?>         
		<td align="center">
            <a href="JavaScript:edit(<?=$row[replid] ?>)"><img src="../images/ico/ubah.png" border="0" onMouseOver="showhint('Edit Category', this, event, '75px')" /></a>&nbsp;
            <a href="JavaScript:hapus(<?=$row[replid] ?>)"><img src="../images/ico/hapus.png" border="0" onMouseOver="showhint('Delete Category', this, event, '75px')"/></a>
        </td>
<?		} ?>  
    </tr>
<?	} 
	 ?>	
	
    
    <!-- END TABLE CONTENT -->
    </table>
    <script language='JavaScript'>
	    Tables('table', 1, 0);
    </script>
	<br>
	<div align="left" style="margin-left:20px">
		* Student Notes category managed only by a JIBAS Teacher Info Administrator 
	</div>
	</td></tr>
<!-- END TABLE CENTER -->    
</table>
<?	} else { ?>

<table width="100%" border="0" align="center">

<tr>
	<td align="center" valign="middle" height="250" colspan="2">
    	<font size = "2" color ="red"><b>Data Not Found.
       <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <br />Click <a href="JavaScript:tambah()" ><font size = "2" color ="green">here</font></a> to submit a new data.
        <? } ?>
        </p></b></font>
	</td>
</tr>
</table>  
<? } ?> 
</td></tr>
<!-- END TABLE BACKGROUND IMAGE -->
</table>    

</body>
</html>
<? CloseDb();?>