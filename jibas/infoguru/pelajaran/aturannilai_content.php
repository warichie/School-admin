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
//require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once("../include/sessionchecker.php");

$cetak = 0;
$id = $_REQUEST['id'];
$nip = $_REQUEST['nip'];
$idtingkat = $_REQUEST['idtingkat'];
$aspek = $_REQUEST['aspek'];

OpenDb();
$sql = "SELECT j.departemen, j.nama, p.nip, p.nama 
			 FROM guru g, jbssdm.pegawai p, pelajaran j 
			WHERE g.nip=p.nip AND g.idpelajaran = j.replid AND j.replid = '$id' AND g.nip = '$nip'"; 
$result = QueryDb($sql);
$row = @mysql_fetch_row($result);
$departemen = $row[0];
$pelajaran = $row[1];
$guru = $row[2].' - '.$row[3];

$op = $_REQUEST['op'];
if ($op == "xm8r389xemx23xb2378e23") 
{
	$sql = "DELETE FROM aturangrading WHERE idpelajaran = '$id' AND nipguru = '$nip' AND idtingkat = '$idtingkat' AND dasarpenilaian = '$aspek'"; 
	QueryDb($sql);	
	?>
   <script>refresh();</script> 
<?
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Grade Point Rules</title>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">

function refresh() {	
	document.location.reload();
}

function edit(idtingkat,aspek) {
	var id = document.getElementById('id').value;
	var nip = document.getElementById('nip').value;
	newWindow('aturannilai_edit.php?idtingkat='+idtingkat+'&nip='+nip+'&aspek='+aspek+'&id='+id, 'UbahAturanPenentuanGradingNilai','400','570','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function tambah(tingkat) {
	var id = document.getElementById('id').value;
	var nip = document.getElementById('nip').value;
	newWindow('aturannilai_add.php?idtingkat='+tingkat+'&id='+id+'&nip='+nip, 'TambahAturanPenentuanGradingNilai','400','570','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function hapus(idtingkat,aspek) {
	var id = document.getElementById('id').value;
	var nip = document.getElementById('nip').value;	
	if (confirm("Are you sure want to delete this Assessment Aspect?"))
		document.location.href = "aturannilai_content.php?op=xm8r389xemx23xb2378e23&id="+id+"&idtingkat="+idtingkat+"&nip="+nip+"&aspek="+aspek;		
}

function cetak() {
	var cetak = document.getElementById('cetak').value;	
	var id = document.getElementById('id').value;	
	var nip = document.getElementById('nip').value;

	if (cetak == '1') 
		newWindow('aturannilai_cetak.php?id='+id+'&nip='+nip, 'CetakAturanPenentuanGradingNilai','790','650','resizable=1,scrollbars=1,status=0,toolbar=0');
	else 
		alert ('No Printable data');
	
}
</script>
</head>
<body topmargin="0" leftmargin="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="top" background="../images/ico/b_penilaian.png" style="background-repeat:no-repeat; background-attachment:fixed">
<table width="100%" border="0" height="100%">
<tr>
	<td>
	<table width="100%" border="0">
    <!-- TABLE TITLE -->
	<tr>
		<td valign="top" align="right"><font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Report Card Calculation Rules</font></td>
	</tr>
    <tr>
        <td valign="top" align="right"><a href="../pelajaran.php" target="framecenter">
    <font size="1" color="#000000"><b>Class Subject</b></font></a>&nbsp;>&nbsp; <font size="1" color="#000000">Report Card Calculation Rules</font></td>
    </tr>
    </table>
    
    <br /><br />
	<table width="100%" border="0">
    <tr>
    	<td width="20%" rowspan="4"></td>
        <td width="10%"><strong>Department</strong></td>
    	<td><strong>: <?=$departemen ?>
        <input type="hidden" name="departemen" id="departemen" readonly value="<?=$departemen ?>" />
        <input type="hidden" name="id" id="id" value="<?=$id ?>" />
   		</strong></td>
        <td rowspan="2"></td>
  	</tr>
  	<tr>
    	<td><strong>Class Subject</strong></td>
    	<td><strong>: <?=$pelajaran ?>
    </strong></td>
    
  	</tr>
  	<tr>
    	<td><strong>Teacher</strong></td>
    	<td><strong>: <?=$guru ?>  
        <input type="hidden" name="nip" id="nip" value="<?=$nip ?>" />
         </strong></td>
      	 
	
	<?	
	$sql = "SELECT tingkat,replid FROM tingkat WHERE departemen = '$departemen' AND aktif=1 ORDER BY urutan";
	$result = QueryDb($sql);

	if (@mysql_num_rows($result) > 0){
	?>
	<td valign="top" align="right" colspan="2"> <a href="#" onClick="document.location.reload()"><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;
      <a href="JavaScript:cetak()"><img src="../images/ico/print.png" border="0" onMouseOver="showhint('Print', this, event, '50px')"/>&nbsp;Print</a>&nbsp;&nbsp;  
    	</td>
  	</tr>
    
  	</table>
<?	while ($row = @mysql_fetch_array($result)) 
	{
		$sql1 = "SELECT g.dasarpenilaian, dp.keterangan
					  FROM aturangrading g, tingkat t, dasarpenilaian dp 
					 WHERE t.replid = g.idtingkat AND t.departemen = '$departemen' AND g.idpelajaran = '$id' 
					   AND g.idtingkat = '$row[replid]' AND g.nipguru = '$nip' 
						AND g.dasarpenilaian = dp.dasarpenilaian
				 GROUP BY g.dasarpenilaian";
		$result1 = QueryDb($sql1);	?>
      <br />
    	<fieldset>
        <legend><b>Grade <?=$row['tingkat']?> &nbsp;&nbsp;&nbsp; 
        <input type="hidden" name="idtingkat" id="idtingkat" value="<?=$row['replid'] ?>" />
<?		if (@mysql_num_rows($result1) > 0)
		{ 
			$cetak = 1;	?>	    
	        <a href="JavaScript:tambah(<?=$row['replid']?>)" ><img src="../images/ico/tambah.png" border="0" onMouseOver="showhint('Add', this, event, '50px')"/>&nbsp;Input Grade Point Rules</a>
			</b>
         </legend><br />
			<table border="1" width="100%" id="table" class="tab" bordercolor="#000000">
			<tr>		
				<td class="header" align="center" height="30" width="10%">#</td>
				<td class="header" align="center" height="30" width="*">Assessment Aspect</td>
				<td class="header" align="center" height="30" width="*">Grade Rules</td>
            <td class="header" height="30" width="*">&nbsp;</td>
   		</tr>
<? 		$cnt= 0;
			while ($row1 = @mysql_fetch_row($result1)) 
			{
				?>	
			<tr>        			
				<td align="center" height="25"><?=++$cnt?></td>
				<td height="25"><?=$row1[1]?><input type="hidden" name="dasar" id="dasar" value="<?=$row1[0] ?>" /></td>
  				<td height="25">
<? 		$sql2 = "SELECT g.replid, grade, nmin, nmax 
						  FROM aturangrading g, tingkat t 
						 WHERE t.replid = g.idtingkat AND t.departemen = '$departemen' AND g.idpelajaran = $id 
						   AND g.idtingkat = '$row[replid]' AND g.dasarpenilaian = '$row1[0]' AND g.nipguru = '$nip' 
					 ORDER BY grade";
			$result2 = QueryDb($sql2);			
			while ($row2 = @mysql_fetch_row($result2)) {
				echo $row2[1].' : '.$row2[2].' to '.$row2[3]. '<br>'; 
			} ?>			
            </td>
            <td align="center" height="25" width="*">        
				 	<a href="JavaScript:edit('<?=$row['replid']?>','<?=$row1[0]?>')"><img src="../images/ico/ubah.png" border="0" onMouseOver="showhint('Edit', this, event, '50px')"/></a>&nbsp; 
				 	<a href="JavaScript:hapus('<?=$row['replid']?>','<?=$row1[0]?>')">
    <img src="../images/ico/hapus.png" border="0" onMouseOver="showhint('Delete', this, event, '50px')" /></a>
	        	</td>
		</tr>
<?		} ?>
		</table>
		<script language='JavaScript'>Tables('table', 1, 0);</script> 
<?
	} else { ?>
		</legend>	
		<table width="100%" border="0" align="center">          
		<tr>
			<td align="center" valign="middle">
    		<font size = "2" color ="red"><b>Data Not Found. 
           <? //if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>	    
           <br />Click <a href="JavaScript:tambah(<?=$row['replid']?>)" ><font size = "2" color ="green">here</font></a> to submit a new data on tingkat <?=$row['tingkat']?>. 
            <? //} ?>
            </b></font>
			</td>
		</tr>
	 	</table>
<? } ?> 
  </fieldset>
<? } ?>
 <input type="hidden" name="cetak" id="cetak" value="<?=$cetak ?>" />
    <!-- END TABLE CONTENT -->
 	</td>
  </tr>
</table>
<?	} else { ?>
</td><td width = "50%"></td>
</tr>
<tr height="60"><td colspan="4"><hr style="border-style:dotted" /></td>
</tr>
</table>
<table width="100%" border="0" align="center">          
<tr>
	<td align="center" valign="middle" height="200">
    	<font size = "2" color ="red"><b>Data Not Found.
        <br />Add class Grade on Department <?=$departemen?> in the Reference.
        </b></font>
	</td>
</tr>
</table>  
<? } ?>
</td>
  </tr>
</table>
</body>
</html>
<?
CloseDb();
?>