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
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
/**/
header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=Statistik_Calon_Siswa.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

OpenDb();
$idproses=(int)$_REQUEST['idproses'];
$departemen=$_REQUEST['departemen'];
$dasar = $_REQUEST['dasar'];
$judul = $_REQUEST['judul'];
$keyword = $_REQUEST['keyword'];

$str = array("'","+");
$str_replace = array("\'","x123x");	

$query1 = str_replace($str_replace,$str, $_REQUEST['sql']);
$result1 = QueryDb($query1);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Statistic Display</title>

<style type="text/css">
<!--
.style5 {
	font-family: Verdana;
	font-size: 16px;
	font-weight: bold;
}
.style6 {font-family: Verdana; font-size: 12px; }
.style9 {color: #FFFFFF; font-weight: bold; font-family: Verdana; font-size: 12px; }
.style13 {font-family: Verdana; font-size: 12px; font-weight: bold; }
.style14 {font-weight: bold}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" border="1" cellspacing="0" class="tab" id="table" align="center">
<tr><td colspan="4" align="center"><span class="style5">Student Candidate List based on 
      <?=$dasar?>
</span>
 </td>
</tr>
<tr>
  <td colspan="5">
  <table width="100%" border="0" cellspacing="0">
  <tr>
    <th width="23%" class="style14" scope="row"><div align="left" class="style6">Department</div></th>
    <td width="77%"><span class="style6">
      <? if ($departemen!="-1") echo $departemen; else echo "(All Department)"; ?>
    </span></td>
  </tr>
  <tr>
    <th scope="row"><div align="left" class="style6">Admission Process</div></th>
    <td><span class="style6">
    <? 	if ($idproses!="-1"){
			OpenDb();
			$sql_p="SELECT proses FROM jbsakad.prosespenerimaansiswa WHERE replid='$idproses'";
			$res_p=QueryDb($sql_p);
			$row_p=@mysql_fetch_array($res_p);
			echo $row_p['proses'];
			CloseDb();
		} else {
			echo "(All Admission Process yang Aktif)";
		}
	?>
    </span></td>
  </tr>
  <tr>
    <th bgcolor="#CCCCCC" scope="row"><div align="left" class="style6">Criteria</div></th>
  	<td><span class="style6"><?=$judul?></span></td>
  </tr>
</table>  </td>
</tr>
<tr height="30">
  		<td width="5%"  align="center" bgcolor="#666666"><span class="style9">#</span></td>
    <td width="10%"  align="center" bgcolor="#666666"><span class="style9">Registration Number</span></td>
	<td width="10%"  align="center" bgcolor="#666666"><span class="style9">National Student ID</span></td>
    <td width="*"  align="center" bgcolor="#666666"><span class="style9">Name</span></td>
    <td width="15%"  align="center" bgcolor="#666666"><span class="style9">Department</span></td>
    <td width="15%"  align="center" bgcolor="#666666"><span class="style9">Group</span></td>
  </tr> <?  
	 if (@mysql_num_rows($result1) < 1) {
				?> 
					<td colspan="4" align="center"><span class="style13">Data Not Found</span></td>
					 
  	<? } else{
	
    while ($row1 = @mysql_fetch_row($result1)) { ?>
	<tr>
  		<td align="center"><span class="style13">
	    <?=++$cnt?>
  		</span></td>
     	<td align="center"><span class="style13">
   	    <?=$row1[0] ?>
     	</span></td>
		<td align="center"><span class="style13">
   	    <?=$row1[6] ?>
     	</span></td>
    	<td><span class="style13">
   	    <?=$row1[1] ?>
    	</span></td>
        <td align="center"><span class="style13">
   	     <?=$row1[5]?>
    	</span></td>
    	<td align="center"><span class="style13">
   	    <?=$row1[3] ?>
    	</span></td>
   </tr>
  						<? }
					}
		CloseDb();
  	?>
	</table>
	
	
</body>
</html>