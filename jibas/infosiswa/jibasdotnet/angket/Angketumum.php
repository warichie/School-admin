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
require_once('../../include/errorhandler.php');
require_once('../../include/sessioninfo.php');
require_once('../../include/common.php');
require_once('../../include/config.php');
require_once('../../include/getheader.php');
require_once('../../include/db_functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="200" border="0">
  <tr>
    <td width="50">Questionnaire</td>
    <td width="12">&nbsp;:</td>
    <td width="124">
        <? 
			OpenDb();
			$sql="SELECT a.replid, a.judul FROM jbsvcr.angket a WHERE jenis='2'";
			$result = QueryDb($sql);
			$row = mysql_fetch_array($result);
		?>
    	<select id="angket" name="angket">
            <?  
				while($row = mysql_fetch_array($result)){
			?>
        	<option value="<?=$row[0]?>"><?=strtoupper($row[1]) ?></option>
			<?
			  }
			?>
        </select>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;:</td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>