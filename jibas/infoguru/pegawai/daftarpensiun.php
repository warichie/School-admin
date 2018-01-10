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
require_once("daftarpensiun.class.php");

OpenDb();
$DPS = new DaftarPensiun();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Employee Affair</title>
<link rel="stylesheet" href="../style/style<?=GetThemeDir2()?>.css" />
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="daftarpensiun.js"></script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#ffffff">
<br />
<input type="hidden" name="nip" id="nip" value="<?=$DPS->nip?>">
<p align="center">
<font class="subtitle"><?=$DPS->nama?> - <?=$DPS->nip?></font><br />
<a href="JavaScript:Refresh()"><img src="../images/ico/refresh.png" border="0" />&nbsp;Refresh</a>&nbsp;
<a href="JavaScript:Cetak()"><img src="../images/ico/print.png" border="0" />&nbsp;Print</a>&nbsp;
<br />
</p>

<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Retirement Schedule</font><br />
    </td>
</tr>
<tr><td>

<table border="1" id="table" style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%" class="tab" id="table">
<tr height="30">
	<td width="5%" align="center" class="header">#</td>
    <td width="35%" align="center" class="header">Retirement Schedule</td>
	<td width="45%" align="center" class="header">Info</td>
	<td width="10%" align="center" class="header">&nbsp;</td>
</tr>
<?
$sql = "SELECT replid, DATE_FORMAT(tanggal,'%d %M %Y') AS ftmt, keterangan FROM jbssdm.jadwal WHERE nip='$DPS->nip' AND jenis='pensiun'";
$result = QueryDb($sql);
if (mysql_num_rows($result) > 0) {
	$cnt = 0;
	while ($row = mysql_fetch_array($result)) { ?>
	<tr height="25">
		<td align="center"><?=++$cnt?></td>
	    <td align="center"><?=$row['ftmt']?></td>
	    <td align="left"><?=$row['keterangan']?></td>
	    <td align="center">
		    &nbsp;
	    </td>
	</tr>
<?	} // while 
} else { ?>
	<tr height="80">
    	<td colspan="4" align="center" valign="middle">
			
            <font color="#999999"><strong>This employee has no pension schedule. Please contact the employement staff.</strong></font>
                    
        </td>
    </tr>
<? 
} // end if
?>
</table>

</td></tr>
</table>
<?
CloseDb();
?>    

<script language='JavaScript'>
	Tables('table', 1, 0);
</script>


</body>
</html>



