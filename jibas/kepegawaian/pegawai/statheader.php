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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Employee Affair</title>
<link rel="stylesheet" href="../style/style.css" />
<script language="javascript">
function ShowStat() {
	var stat = document.getElementById("cbStatistik").value;
	parent.statcontent.location.href = "statcontent.php?stat="+stat;	
}
</script>
</head>

<body onload="parent.statcontent.location.href = 'statcontent.php?stat=1'">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td width="60%" align="left">
    	Amount of Employee Statistic based on 
        <select name="cbStatistik" id="cbStatistik" onchange="JavaScript:ShowStat()">
        	<option value="1">Work Unit</option>
            <option value="2">Educational Background</option>
            <option value="3">Level</option>
            <option value="4">Age</option>
            <option value="6">Gender Per Work Unit</option>
            <option value="7">Marital Status Per Work Unit</option>
        </select>
    </td>
    <td width="40%" align="right">
	    <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Employee Affair Statistic</font><br />
        <a href="pegawai.php" target="_parent">Employee Affair</a> &gt; Employee Affair Statistic
    </td>
</tr>
</table>
</body>
</html>