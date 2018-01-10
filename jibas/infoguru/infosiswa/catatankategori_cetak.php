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
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/getheader.php');
require_once("../include/sessionchecker.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS TEACHERS INFO [Print Notes]</title>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<? getHeader('yayasan') ?>

<center><font size="4"><strong>STUDENT ATTENDANCE NOTES CATEGORY DATA</strong></font><br /> </center><br /><br />

<br />

	<table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="left">
    <tr height="30">
    	<td width="4%" class="header" align="center">#</td>
        <td width="15%" class="header" align="center">Category</td>
        <td width="*" class="header" align="center">Info</td>
        <td width="10%" class="header" align="center">Status</td>
    </tr>
<? 	OpenDb();
	$sql = "SELECT * FROM jbsvcr.catatankategori ORDER BY replid";    
	$result = QueryDB($sql);
	$cnt = 0;
	while ($row = mysql_fetch_array($result)) { ?>
    <tr height="25">
    	<td align="center"><?=++$cnt ?></td>
        <td><?=$row['kategori'] ?></td>
        <td><?=$row['keterangan'] ?></td>
        <td align="center">
			<? if ($row['aktif'] == 1) 
					echo 'Active';
				else
					echo 'Inactive';
			?>		
        </td> 
    </tr>
<?	} 
	CloseDb() ?>	
    <!-- END TABLE CONTENT -->
    </table>

</td></tr></table>
</body>
<script language="javascript">
window.print();
</script>
</html>