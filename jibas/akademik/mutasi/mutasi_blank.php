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
<html>
<head>
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../style/style.css"></head>
</html>
<html>
<head>
</head>
<body>
<table width="100%" border="0" height="100%">
<? if (isset($_REQUEST["from_left"])){?>
<tr>
  <td height="34" align="right" valign="top"><font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Student Mutation</font><br />
      <a href="../mutasi.php" target="content"> <font size="1" color="#000000"><b>Mutation</b></font></a>&nbsp;>&nbsp;<font size="1" color="#000000"><b>Student Mutation</b></font></td>
</tr>
<? } ?>
<tr>
    <td align="center" valign="middle" background="../images/ico/b_daftarmutasi.png"
    style="background-repeat:no-repeat;">
        <font size="2" color="#757575"><b>
        <? if (isset($_REQUEST["from_left"])){?>
        Select Student to be Mutated on the left panel 
        <? } else { ?>
        Select Department and Mutation Year according to Student Mutation List selected.
		<? } ?>
        </b></font> </td>
</tr>

</table>
</body>
</html>