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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$flag = 0;
if (isset($_REQUEST['flag']))
	$flag = (int)$_REQUEST['flag'];
$nama = $_REQUEST['nama'];
$nip = $_REQUEST['nip'];

?>
<table border="0" width="100%" cellpadding="2" cellspacing="2" align="center">
<tr>
	<td>
	<input type="hidden" name="flag" id="flag" value="<?=$flag ?>" />
	<font size="2" color="#000000"><strong>Search Employee</strong></font>
 	</td>
</tr>
<tr>
	<td>
    	<form name="main">
        <font color="#000000"><b>Name</b></font>
    	<input type="text" name="nama" id="nama" value="<?=$_REQUEST['nama'] ?>" size="20" onKeyPress="return focusNext('submit', event)" />&nbsp;&nbsp;
		<font color="#000000"><b>Employee ID</b></font>
    	<input type="text" name="nip" id="nip" value="<?=$_REQUEST['nip'] ?>" size="20" onKeyPress="return focusNext('submit', event)" />&nbsp;
		<input type="button" class="but" name="submit" id="submit" value="Search" onclick="carilah()" style="width:80px;"/>&nbsp;	
	</form>
    </td>
</tr>
<tr>
	<td align="center">
    <div id = "caritabel">
<?
if (isset($_REQUEST['submit']) || $_REQUEST['submit'] == 1) { 
	OpenDb();
	if ((strlen($nama) > 0) && (strlen($nip) > 0))
		$sql = "SELECT nip, nama, bagian FROM jbssdm.pegawai WHERE nama LIKE '%$nama%' AND nip LIKE '%$nip%' ORDER BY nama"; 
	else if (strlen($nama) > 0)
		$sql = "SELECT nip, nama, bagian FROM jbssdm.pegawai WHERE nama LIKE '%$nama%' ORDER BY nama"; 
	else if (strlen($nip) > 0)
		$sql = "SELECT nip, nama, bagian FROM jbssdm.pegawai WHERE nip LIKE '%$nip%' ORDER BY nama"; 
	//else if ((strlen($nama) == 0) || (strlen($nip) == 0))
	//	$sql = "SELECT nip, nama FROM jbssdm.pegawai ORDER BY nama"; 
	$result = QueryDb($sql);
	if (@mysql_num_rows($result)>0){ ?>
<br />
    <table width="100%" class="tab" align="center" cellpadding="2" cellspacing="0" id="table1" border="1">
    <tr height="30">
        <td class="header" width="7%" align="center">#</td>
        <td class="header" width="15%" align="center">Employee ID</td>
        <td class="header" align="center" >Name</td>
        <td class="header" align="center" >Section</td>       
        <td class="header" width="10%">&nbsp;</td>
    </tr>
<?	$cnt = 0;
	while($row = mysql_fetch_row($result)) { ?>
    <tr height="25"  onclick="pilih('<?=$row[0]?>', '<?=$row[1]?>')" style="cursor:pointer"> 
        <td align="center"><?=++$cnt ?></td>
        <td align="center"><?=$row[0] ?></td>
        <td><?=$row[1] ?></td>
        <td><?=$row[2] ?></td>
        <td align="center">
        <input type="button" name="pilih" class="but" id="pilih" value="Select" onclick="pilih('<?=$row[0]?>', '<?=$row[1]?>')" />
        </td>
    </tr>
<? } CloseDb(); ?>
 	</table>
<? } else { ?>    		
	<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0" id="table1">
	<tr height="30" align="center">
		<td>   
   
	<br /><br />	
	<font size = "2" color ="red"><b>Data Not Found. <br /><br />            
		Add this employee data in the Employee Affair Menu on Reference section. </b></font>	
	<br /><br />
   		</td>
    </tr>
    </table>
<? 	} 
}?>	
	</div>
    </td>    
</tr>
<tr>
	<td align="center" >
	<input type="button" class="but" name="tutup" id="tutup" value="Close" onclick="window.close()" style="width:80px;"/>
	</td>
</tr>
</table></table>

</body>
</html>