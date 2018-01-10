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
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$op = $_REQUEST['op'];

if ($op == "xm8r389xemx23xb2378e23") {
	OpenDb();
	$sql = "DELETE FROM statusguru WHERE replid = '$_REQUEST[replid]'";
	QueryDb($sql);
	CloseDb();
}	
OpenDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teacher Status</title>
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function tambah() {
	newWindow('statusguru_add.php', 'TambahStatusGuru','500','250','resizable=1,scrollbars=0,status=0,toolbar=0')
}

function refresh() {	
	//document.location.reload();
	document.location.href="statusguru.php";	
}

function edit(replid) {
	newWindow('statusguru_edit.php?replid='+replid, 'UbahStatusGuru','500','250','resizable=1,scrollbars=0,status=0,toolbar=0')
}

function hapus(replid) {
	if (confirm('Are you sure want to delete this Teacher Status?'))
		document.location.href="statusguru.php?op=xm8r389xemx23xb2378e23&replid="+replid;	
}

function cetak() {
	newWindow('statusguru_cetak.php', 'CetakStatusGuru','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
</script>
</head>

<body >

<table border="0" width="100%" height="100%">
<!-- TABLE BACKGROUND IMAGE -->
<tr><td align="center" valign="top" background="../images/ico/b_statusguru.png" style="background-repeat:no-repeat">

<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr height="300">
  <td align="left" valign="top">

	<table border="0"width="95%" align="center">
    <!-- TABLE TITLE -->
    <tr>
        <td align="right"><font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Teacher Status</font></td>
        </tr>
    <tr>
      <td align="right"><a href="../guru.php?page=g" target="content"><font size="1" color="#000000"><b>Teacher and Class Subject</b></font></a>&nbsp;>&nbsp; <font size="1" color="#000000"><b>Status
        Guru</b></font></td>
      </tr>
    <tr>
        <td align="left">&nbsp;</td>
        </tr>
	</table>
    <br /><br />
<? 	OpenDb();
	$sql = "SELECT replid,status,keterangan FROM jbsakad.statusguru ORDER BY status";    
	$result = QueryDb($sql);
	if (@mysql_num_rows($result) > 0){
?>
    <table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="#" onclick="document.location.reload()" onMouseOver="showhint('Refresh', this, event, '50px')"><img src="../images/ico/refresh.png" border="0" /></a>
	
		<a href="#" onclick="refresh()">&nbsp;<strong>Refresh</strong></a>&nbsp;&nbsp; <a href="JavaScript:cetak()" onMouseOver="showhint('Print', this, event, '50px')"><img src="../images/ico/print.png" border="0"/></a>&nbsp;<a href="JavaScript:cetak()"><strong>Print</strong></a>&nbsp;&nbsp;
    <? //if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <a href="JavaScript:tambah()" onMouseOver="showhint('Add', this, event, '50px')"><img src="../images/ico/tambah.png" border="0" /></a>&nbsp;<a href="JavaScript:tambah()"><strong>Add
          Teacher Status</strong></a>
    <?	//} ?>
    </td>
  </tr>  
</table><br />
<table class="tab" id="table" border="1" style="border-collapse:collapse" width="95%" align="center" bordercolor="#000000">
    <!-- TABLE CONTENT -->
    
    <tr height="30">
    	<td width="4%" class="header" align="center">#</td>
        <td width="25%" class="header" align="center">Teacher Status</td>
        <td width="*" class="header" align="center">Info</td>
        <? //if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <td width="8%" class="header" align="center">&nbsp;</td>
        <? //} ?>
    </tr>
    
     <?	
		$cnt = 0;
		while ($row = @mysql_fetch_array($result)) {
		$status=$row['status'];
		$keterangan=$row['keterangan'];
		$replid=$row[replid];
	?>
    <tr height="25">   	
       	<td align="center"><?=++$cnt ?></td>
        <td><?=$row['status']?></td>
        <td><?=$row['keterangan']?></td>        
        
        

		<td align="center">
            <a href="JavaScript:edit(<?=$row['replid'] ?>)" onmouseover="showhint('Edit Teacher Status', this, event, '80px')" ><img src="../images/ico/ubah.png" border="0" /></a>&nbsp;
<?		//if (SI_USER_LEVEL() != $SI_USER_STAFF) {  ?> 
            <a href="JavaScript:hapus(<?=$row['replid'] ?>)" onMouseOver="showhint('Delete', this, event, '80px')"><img src="../images/ico/hapus.png" border="0" /></a>
        </td>
<?	//	} ?>
    </tr>
<?	} 
	CloseDb(); ?>	
    
    <!-- END TABLE CONTENT -->
    </table>
        <?	CloseDb() ?>    
        <script language='JavaScript'>
	    Tables('table', 1, 0);
        </script>
    
      </td>
</tr>
<!-- END TABLE CENTER -->    
</table>
<?	} else { ?>
<table width="100%" border="0" align="center"> 
       
<tr>
	<td align="center" valign="middle" height="200" colspan="2">
    	<font size = "2" color ="red"><b>Data Not Found. 
        <? //if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <br />Click <a href="JavaScript:tambah()" ><font size = "2" color ="green">here</font></a> to submit a new data. 
        <? //}?>
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