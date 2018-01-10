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
require_once('../include/getheader.php');
OpenDb();
$departemen='yayasan';
$replid=$_REQUEST['replid'];

$sql_pegawai="SELECT * FROM jbssdm.pegawai WHERE replid='$replid'";
$result_pegawai=QueryDb($sql_pegawai);
$row_pegawai=@mysql_fetch_array($result_pegawai);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style/style.css">
<title>JIBAS SIMAKA [Print Employee Data]</title>
</head>
<body leftmargin="0">
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">

<?=getHeader($departemen)?>
<center>
  <font size="4"><strong>EMPLOYEE DATA</strong></font><br />
 </center><br /><br />
<br />
<strong>Section : <?=$row_pegawai['bagian']?></strong></font>
<br /><br /> 	
	
    <table width="100%">
    <tr>    	
    	<td align="center" width="150" valign="top">
        <img src="../library/gambar.php?replid=<?=$row_pegawai['replid']?>&table=jbssdm.pegawai" border="0"/>
        <div align="center"><br /><br />Signature<br /><br /><br /><br /><br /><br /><br />
        <strong>(<?=$row_pegawai['nama']?><? if ($row_pegawai['gelar'] <> "")
			  		echo ", ".$row_pegawai['gelar'];
			  	?>)</strong></div>
        </td>
        <td>
    
    <table border="1" class="tab" id="table" width="100%" cellpadding="0" style="border-collapse:collapse" cellspacing="0" >
    <tr>
    	<td valign="top">
        <table border="0" cellpadding="0" style="border-collapse:collapse" cellspacing="0" width="100%">
          <tr class="header" height="30">
            <td align="center"><strong>A. </strong></td>
            <td colspan="4"><strong>EMPLOYEE PERSONAL DATA</strong></td>
          </tr>
          <tr height="20">
          	<td rowspan="12"></td>
            <td width="5%">1.</td>
            <td>Employee ID</td>
            <td>: 
				<?=$row_pegawai['nip']?></td>
          </tr>
          
          <tr height="20">
            <td>2.</td>
            <td colspan="2">Employee Name</td>           
            <td rowspan="11">&nbsp;</td>
            
          </tr>
          <tr height="20">
            <td>&nbsp;</td>
            <td width="20%">a. Full Name</td>
            <td>:
              <?=$row_pegawai['nama']?>
              <? if ($row_pegawai['gelar'] <> "")
			  		echo ", ".$row_pegawai['gelar'];
			  ?></td>
          </tr>
          <tr height="20">
            <td>&nbsp;</td>
            <td>b. Nickname</td>
            <td>:
              <?=$row_pegawai['panggilan']?></td>
          </tr>
          <tr height="20">
            <td>3.</td>
            <td>Gender</td>
            <td>:
              <? 	if ($row_pegawai['kelamin']=="l")
				echo "Male"; 
			if ($row_pegawai['kelamin']=="p")
				echo "Female"; 
		?></td>
          </tr>
          <tr height="20">
            <td>4.</td>
            <td>Birth Place</td>
            <td>:
              <?=$row_pegawai['tmplahir']?></td>
          </tr>
          <tr height="20">
            <td>5.</td>
            <td>Date of Birth</td>
            <td>:
              <?=format_tgl($row_pegawai['tgllahir']) ?></td>
          </tr>
          <tr height="20">
            <td>6.</td>
            <td>Religion</td>
            <td>:
              <?=$row_pegawai['agama']?></td>
          </tr>
          <tr height="20">
            <td>7.</td>
            <td>Ethnicity</td>
            <td>:
              <?=$row_pegawai['suku']?></td>
            
          </tr>
          <tr height="20">
            <td>8.</td>
            <td>Employee ID</td>
            <td>:
              <?=$row_pegawai['noid']?></td>
            
          </tr>
          <tr height="20">
            <td>9.</td>
            <td>Status</td>
            <td>:
              <? 	if($row_pegawai['nikah']=="menikah")
					echo "Married";
				if($row_pegawai['nikah']=="belum")
					echo "Not Married";
				if($row_pegawai['nikah']=="tak_ada")
					echo "";?></td>
           
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr class="header" height="30">
            <td width="5%" align="center"><strong>B. </strong></td>
            <td colspan="5"><strong>RESIDENCY INFO</strong></td>
          </tr>
          <tr height="20">
            <td rowspan="5"></td>
            <td>10.</td>
            <td>Address</td>
            <td colspan="2">:
              <?=$row_pegawai['alamat']?></td>
           
          </tr>
          <tr height="20">
            <td>11.</td>
            <td>Phone</td>
            <td colspan="2">:
              <?=$row_pegawai['telpon']?></td>
            
          </tr>
          <tr height="20">
            <td>12.</td>
            <td>Mobile</td>
            <td colspan="2">:
              <?=$row_pegawai['handphone']?></td>
            
          </tr>
          <tr height="20">
            <td>13.</td>
            <td>Email</td>
            <td colspan="2">:
              <?=$row_pegawai['email']?></td>
           
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr height="30" class="header">
            <td align="center"><strong>C.</strong></td>
            <td colspan="5"><strong>OTHERS</strong></td>
          </tr>
          <tr height="20">
          	<td></td>
            <td>14.</td>
            <td>Info</td>
            <td colspan="2">: <?=$row_pegawai['keterangan']?></td>
          </tr>        
        </table></td>
  	</tr>
	</table>
    </td>
    </tr>
    </table>
  	</td>
</tr>
</table>
<script language="javascript">
	window.print();
</script>
</body>
</html>