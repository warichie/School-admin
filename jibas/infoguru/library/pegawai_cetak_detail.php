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

$replid=$_REQUEST['replid'];
OpenDb();
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
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">

<? include("../library/headercetak.php") ?>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <th colspan="2" scope="row"><div align="center"><font size="4"><strong>EMPLOYEE DATA</strong></font></div></th>
    </tr>
  <tr>
    <th width="10%" scope="row"><div align="left"><strong>Section :</strong></div></th>
    <td width="90%">&nbsp;<?=$row_pegawai['bagian']?></td>
  </tr>
</table>
<br />
<table border="1" class="tab" id="table" width="100%" align="left">
<tr>
    <td valign="top">
    <table border="0" cellpadding="0" style="border-collapse:collapse" cellspacing="0" width="100%">
    <tr height="30">
    	<td colspan="6" align="left">
        <font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Personal Data</strong></font>
        <hr width="300" style="line-height:1px; border-style:dashed" align="left" />
        </td>
    	</tr>
  	<tr height="20">
    	<td width="5%" rowspan="11">&nbsp;</td>
    	<td width="5%">1.</td>
    	<td width="20%">Employee ID</td>
    	<td height="25" >:&nbsp;<?=$row_pegawai['nip']?></td>
    	<td rowspan="19" valign="bottom" ><div align="center"><img src="../library/gambar.php?replid=<?=$row_pegawai['replid']?>&table=jbssdm.pegawai" width="120" height="150" border="0"/>
    	      <br />
  	  </div>
    	  <div align="center"><br />Signature<br /><br /><br /><br /><br />
    <strong>(<?=$row_pegawai['nama']?>, <?=$row_pegawai['gelar']?>)</strong></div>        </td>
    	<!--<td rowspan="7" align="center" width="150">
    	<img src="../library/gambar.php?replid=<?=$row_pegawai['replid']?>&table=jbssdm.pegawai" width="120" height="120" border="0"/>		
        </td>-->
  	</tr>
  	<tr height="20">
    	<td>2.</td>
    	<td>Employee Name</td><td></td>
  	</tr>
  	<tr height="20" >    
    	<td>&nbsp;</td>    
    	<td>a. Full Name </td>
    	<td>:&nbsp;<?=$row_pegawai['nama']?> ,<?=$row_pegawai['gelar']?></td>
        </tr>
  	<tr height="20">
	    <td>&nbsp;</td>
    	<td>b. Nickname </td>
    	<td>:&nbsp;<?=$row_pegawai['panggilan']?></td>
        </tr>
  	<tr height="20">    	
    	<td>3.</td>
    	<td>Birth Place</td>
    	<td>:&nbsp;<?=$row_pegawai['tmplahir']?></td>
        </tr>
  	<tr height="20">    	
    	<td>4.</td>
    	<td>Date of Birth</td>
    	<td>:&nbsp;<?=format_tgl($row_pegawai['tgllahir'])?></td>
  	    </tr>
  	<tr height="20">    	
	    <td>5.</td>
    	<td>Religion</td>
    	<td height="25" >:&nbsp;<?=$row_pegawai['agama']?></td>
        </tr>
  	<tr height="20" >    	
    	<td>6.</td>
    	<td>Ethnicity</td>
    	<td>:&nbsp;<?=$row_pegawai['suku']?></td>
  	    </tr>
  	<tr height="20" >    	
	    <td>7.</td>
    	<td>Employee ID</td>
    	<td>:&nbsp;<?=$row_pegawai['noid']?></td>
  	    </tr>
  	<tr height="20">
    	<td>8.</td>
    	<td>Status</td>
    	<td>:&nbsp;
			<? 	if($row_pegawai['nikah']=="menikah")
					echo "Married";
				if($row_pegawai['nikah']=="belum")
					echo "Not Married";
				if($row_pegawai['nikah']=="tak_ada")
					echo "";?></td>
  	    </tr>
  	<tr>
    	<td bgcolor="#FFFFFF" >&nbsp;</td><td bgcolor="#FFFFFF" >&nbsp;</td><td bgcolor="#FFFFFF" >&nbsp;</td> 
  	</tr>
  	<tr height="30" >
    	<td colspan="4" align="left">
        <font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Residency Info</strong></font>
        <hr width="300" style="line-height:1px; border-style:dashed" align="left" />
        </td>
    	</tr>
  	<tr height="20">
    	<td rowspan="5">&nbsp;</td>    	
    	<td>9.</td>
    	<td>Address</td>
    	<td>:&nbsp;<?=$row_pegawai['alamat']?></td>
 	    </tr>
 	<tr height="20" >    	
    	<td>10.</td>
    	<td>Phone</td>
    	<td>:&nbsp;<?=$row_pegawai['telpon']?></td>
  	    </tr>
  	<tr height="20" >    	
	    <td>11.</td>
    	<td>Mobile</td>
    	<td>:&nbsp;<?=$row_pegawai['handphone']?></td>
  	    </tr>
  	<tr height="20">    	
    	<td>12.</td>
    	<td>Email</td>
   	 	<td>:&nbsp;<?=$row_pegawai['email']?></td>
  	    </tr>
  	<tr>
    	<td  colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
  	</tr>
  	<tr height="30">
    	<td colspan="4" align="left">
        <font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Others</strong></font>
        <hr width="300" style="line-height:1px; border-style:dashed" align="left" />
        </td>
    	</tr>
   	<tr height="20">
    	<td>&nbsp;</td>
    	<td>13.</td>
    	<td>Info</td>
    	<td>:&nbsp;<?=$row_pegawai['keterangan']?></td>
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