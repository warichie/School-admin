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
require_once('../include/sessionchecker.php');
require_once('../include/config.php');
require_once('../include/getheader.php');
require_once('../include/common.php');
require_once('../include/db_functions.php');
require_once('siswa.class.php');

OpenDb();
$SP = new CSiswa();
?>
<link href="../style/style.css" rel="stylesheet" type="text/css" />
<form name="frmPilih">
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td width="8%" class="tab2">Department</td>
    <td width="92%">
    <div id="depInfo">
    <?
	$SP->GetDep();
	?>
    </div>
    </td>
  </tr>
  <tr>
    <td class="tab2">Grade</td>
    <td>
    <div id="tktInfo">
    <?
	$SP->GetTkt();
	?>
    </div>
    </td>
  </tr>
  <tr>
    <td class="tab2">Class</td>
    <td>
    <div id="klsInfo">
    <?
	$SP->GetKls();
	?>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="2">
    <div id="sisInfo">
    <?
	$SP->GetSis();
	?>
    </div>
    </td>
  </tr>
</table>
</form>