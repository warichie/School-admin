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
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/theme.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
if (isset($_REQUEST['nip']))
	$nip = $_REQUEST['nip'];
if (isset($_REQUEST['info']))
	$info = $_REQUEST['info'];
if (isset($_REQUEST['maxJam']))
	$maxJam = (int)$_REQUEST['maxJam'];
if (isset($_REQUEST['jam']))
	$jam = $_REQUEST['jam'];
if (isset($_REQUEST['hari']))
	$hari = $_REQUEST['hari'];

$pelajaran = "";
if (isset($_REQUEST['pelajaran']))
	$pelajaran = $_REQUEST['pelajaran'];
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];	
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];	
if (isset($_REQUEST['kelas']))
	$kelas = $_REQUEST['kelas'];	
if (isset($_REQUEST['keterangan']))
	$keterangan = CQ($_REQUEST['keterangan']);	
if (isset($_REQUEST['jam2']))
	$jam2 = (int)$_REQUEST['jam2'];		
if (isset($_REQUEST['status']))
	$status = $_REQUEST['status'];	

$ERROR_MSG = "";
if (isset($_REQUEST['Simpan'])) {			
	OpenDb();
	$sql1 = "SELECT replid, TIME_FORMAT(jam1, '%H:%i') AS jam1 FROM jam WHERE departemen = '$departemen' AND jamke = '$jam'";	
	
	$result1 = QueryDb($sql1);
	$row1 = mysql_fetch_array($result1);
	$rep1 = $row1['replid'];
	$jm1 = $row1['jam1'];
	
	$sql2 = "SELECT replid, TIME_FORMAT(jam2, '%H:%i') AS jam2 FROM jam WHERE departemen = '$departemen' AND jamke = '$jam2'";
	
	$result2 = QueryDb($sql2);
	$row2 = mysql_fetch_array($result2);
	$rep2 = $row2['replid'];
	$jm2 = $row2['jam2'];
	
	$jum = $jam2 - $jam + 1;
   
	$sql3 = "SELECT * FROM jadwal WHERE nipguru = '$nip' AND hari = '$hari' AND jam1 < '$jm2'";
	$result3 = QueryDb($sql3);
		
	$sql4 = "SELECT * FROM jadwal WHERE idkelas = '$kelas' AND hari = '$hari' AND jam2 > '$jm1'";
	$result4 = QueryDb($sql4);
	
	if (mysql_num_rows($result3) > 0) {
		CloseDb();		
		$ERROR_MSG = "Coincide schedule found";
	} else if (mysql_num_rows($result4) > 0) {
		CloseDb();		
		$ERROR_MSG = "Coincide schedule in this class found";
	} else {
		$sql = "INSERT INTO jadwal SET idkelas='$kelas', nipguru='$nip', idpelajaran = '$pelajaran', departemen = '$departemen', infojadwal = '$info', hari = '$hari', jamke = '$jam', njam = '$jum', sifat = 1, status = '$status', keterangan='$keterangan', jam1 = '$jm1', jam2 = '$jm2', idjam1 = '$rep1', idjam2 = '$rep2'";
		$result = QueryDb($sql);
		CloseDb();
	
		if ($result) { ?>
			<script language="javascript">
				opener.parent.footer.refresh();
				window.close();
			</script> 
<?		}
	}
}

OpenDb();	
$sql1 = "SELECT t.replid, t.tahunajaran, t.departemen, p.nama AS nama FROM jbsakad.infojadwal i, jbsakad.tahunajaran t, jbssdm.pegawai p WHERE i.replid = '$info' AND t.replid = i.idtahunajaran AND p.nip = '$nip' ";

$result1 = QueryDb($sql1);
$row1 = mysql_fetch_array($result1); 
$departemen = $row1['departemen'];
$tahun = $row1['tahunajaran'];
$tahunajaran = $row1['replid'];
$nama = $row1['nama'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Add Teacher Schedule]</title>
<script src="../script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../script/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="../script/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../script/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">

function validate() {
	var jam1 = document.getElementById('jam1').value; 
	var jam2 = document.getElementById('jam2').value; 
	var maxJam = document.getElementById('maxJam').value; 
	var ket = document.getElementById('keterangan').value; 
	var kelas = document.getElementById('kelas').value; 
	
	if (kelas.length == 0) {
		alert("Class should not leave empty");
		document.getElementById('kelas').focus();
		return false;
	} else if (jam2.length == 0) {
		alert("End Hour is required");
		document.getElementById('jam2').focus();
		return false;		
	} else if (ket.length > 255) {
		alert("Description length should not exceed 255 characters");		
		document.getElementById('keterangan').focus();
		return false;	
	} else if (isNaN(jam2)) {
		alert ('Child # must be numeric');
		document.getElementById('jam2').focus();
		return false;
	} else if (parseInt(jam1) > parseInt(jam2)) {
		alert ('End Time should not less than Start Time (hour)');
		document.getElementById('jam2').focus();
		return false;	
	} else if (parseInt(jam2) > parseInt(maxJam)) {
		alert ('End Time should not exceed total hours of the Class Schedule');
		document.getElementById('jam2').focus();
		return false;
	}
	return true;	
}

function change() {
	var departemen = document.getElementById("departemen").value;
	var tahunajaran = document.getElementById("tahunajaran").value;
	var pelajaran = document.getElementById("pelajaran").value;
	var kelas = document.getElementById("kelas").value;
	var tingkat = document.getElementById("tingkat").value;
	var hari = document.getElementById("hari").value;
	var jam = document.getElementById("jam").value;
	var jam2 = document.getElementById("jam2").value;
	var status = document.getElementById("status").value;		
	var keterangan = document.getElementById("keterangan").value;
	var maxJam = document.getElementById("maxJam").value;
	var nip = document.getElementById("nip").value;
	var info = document.getElementById("info").value;
	
	document.location.href = "jadwal_guru_add.php?departemen="+departemen+"&pelajaran="+pelajaran+"&tahunajaran="+tahunajaran+"&kelas="+kelas+"&tingkat="+tingkat+"&hari="+hari+"&jam="+jam+"&jam2="+jam2+"&status="+status+"&keterangan="+keterangan+"&maxJam="+maxJam+"&nip="+nip+"&info="+info;		
}

function change_tingkat() {
	var departemen = document.getElementById("departemen").value;
	var tahunajaran = document.getElementById("tahunajaran").value;
	var pelajaran = document.getElementById("pelajaran").value;	
	var tingkat = document.getElementById("tingkat").value;
	var hari = document.getElementById("hari").value;
	var jam = document.getElementById("jam").value;
	var jam2 = document.getElementById("jam2").value;
	var status = document.getElementById("status").value;		
	var keterangan = document.getElementById("keterangan").value;
	var maxJam = document.getElementById("maxJam").value;
	var nip = document.getElementById("nip").value;
	var info = document.getElementById("info").value;
	
	document.location.href = "jadwal_guru_add.php?departemen="+departemen+"&pelajaran="+pelajaran+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&hari="+hari+"&jam="+jam+"&jam2="+jam2+"&status="+status+"&keterangan="+keterangan+"&maxJam="+maxJam+"&nip="+nip+"&info="+info;		
}

function focusNext(elemName, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		document.getElementById(elemName).focus();
        return false;
    }
    return true;
}
</script>
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#FFFFFF" onLoad="document.getElementById('tingkat').focus();">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
    
<form name="main" onSubmit="return validate()">
<input type="hidden" name="info" id="info" value="<?=$info ?>"/>
<input type="hidden" name="hari" id="hari" value="<?=$hari ?>"/>
<input type="hidden" name="maxJam" id="maxJam" value="<?=$maxJam ?>"/>
<table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
<!-- TABLE CONTENT -->
<tr height="25">
	<td class="header" colspan="4" align="center">Add Teacher Schedule</td>
</tr>
<tr>
    <td><strong>Teacher</strong></td>
    <td colspan="3">
   	<input type="text" name="nipguru" id="nipguru" size="10" class="disabled" readonly value="<?=$nip?>"  /> 
    <input type="hidden" name="nip" id="nip" value="<?=$nip?>" /> 
    <input type="text" name="nama" id="nama" size="25" class="disabled" readonly value="<?=$nama?>" />  	</td>
</tr>
<tr>
	<td><strong>Department</strong></td>
    <td width="30%"><input type="text" name="dept" id="dept" size="10" value="<?=$departemen ?>" class="disabled" readonly/>
        <input type="hidden" name="departemen" id="departemen" value="<?=$departemen ?>"/></td>    
</tr>
<tr>
	<td width="100"><strong>Year</strong></td>
    <td><input type="text" name="tahun" size="10" value="<?=$tahun ?>" readonly class="disabled"/>
    	<input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$tahunajaran?>">    </td>
       
</tr>
<tr>
    <td><strong>Grade</strong> </td>
    <td>
		<select name="tingkat" id="tingkat" onChange="change_tingkat()"  style="width:80px;" onKeyPress="return focusNext('kelas', event)">
    	<?	OpenDb();
			$sql = "SELECT replid,tingkat FROM tingkat WHERE aktif=1 AND departemen='$departemen' ORDER BY urutan";	
			$result = QueryDb($sql);
			CloseDb();
	
			while($row = mysql_fetch_array($result)) {
			if ($tingkat == "")
				$tingkat = $row['replid'];				
			?>
          <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tingkat) ?>>
            <?=$row['tingkat']?>
            </option>
          <?
			} //while
			?>
        </select></td>
    
</tr>
<tr>
   	<td><strong>Class</strong> </td>
    <td>
       	<select name="kelas" id="kelas" onChange="change()"  style="width:180px;" onKeyPress="return focusNext('pelajaran', event)">
		<?	OpenDb();
			$sql = "SELECT replid,kelas FROM kelas WHERE aktif=1 AND idtahunajaran = '$tahunajaran' AND idtingkat = '$tingkat' ORDER BY kelas";	
			$result = QueryDb($sql);
			CloseDb();
	
			while($row = mysql_fetch_array($result)) {
			if ($kelas == "")
				$kelas = $row['replid'];				 
			?>
    	<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $kelas) ?>><?=$row['kelas']?></option>
             
    		<?
			} //while
			?>
    	</select>        
	</td>    
</tr>
<tr>
	<td><strong>Class Subject</strong></td>
 	<td colspan="3">
      	<select name="pelajaran" id="pelajaran" onChange="change()" style="width:180px;" onKeyPress="return focusNext('jam2', event)">
   	<?	OpenDb();
		$sql = "SELECT l.replid,l.nama FROM pelajaran l, guru g WHERE g.nip = '$nip' AND g.idpelajaran = l.replid AND l.aktif=1 AND l.departemen = '$departemen' ORDER BY l.nama";
		$result = QueryDb($sql);
		CloseDb();
		while ($row = @mysql_fetch_array($result)) {
			if ($pelajaran == "") 				
				$pelajaran = $row['replid'];			
		?>
        
    	<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $pelajaran)?> ><?=$row['nama']?></option>
                  
    <?	} ?>
    	</select>		</td>  
</tr>

<tr>
	<td><strong>Day</strong> </td>
    <td colspan="3"><input type="text" name="namahari" id ="namahari" size="10" readonly value = "<?=NamaHari($hari)?>" class="disabled"/>	</td>
</tr>
<tr>
	<td><strong>Hour</strong></td>
    <td colspan="3"><input type="text" name="jam1" id ="jam1" size="2" readonly value = "<?=$jam?>" class="disabled" />
        <input type="hidden" name="jam" id="jam" value="<?=$jam ?>"/> to 
    	<input type="text" name="jam2" id ="jam2" size="2" value="<?=$jam2 ?>" onKeyPress="return focusNext('status', event)" />   	</td>
</tr>
<tr>
	<td><strong>Status</strong></td> 
    <td colspan="3"><select name="status" id="status" onkeypress="return focusNext('keterangan', event)">
      <option value=0 selected>Teaching</option>
      <option value=1>Assistance</option>
      <option value=2>Extra</option>
    </select></td>
</tr>
<tr>
	<td valign="top">Info</td>
	<td colspan="3">
    	<textarea name="keterangan" id="keterangan" rows="3" cols="45" onKeyPress="return focusNext('Simpan', event)"><?=$keterangan ?></textarea>    </td>
</tr>
<tr>
	<td colspan="2" align="center">
    <input type="submit" name="Simpan" id="Simpan" value="Save" class="but" />&nbsp;
    <input type="button" name="Tutup" id="Tutup" value="Close" class="but" onClick="window.close()" />    </td>
</tr>
<!-- END OF TABLE CONTENT -->
</table>
</form>
<!-- END OF CONTENT //--->
    </td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_06a.jpg">&nbsp;</td>
</tr>
<tr height="28">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_07.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_08a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_09.jpg">&nbsp;</td>
</tr>
</table>

<!-- Tamplikan error jika ada -->
<? if (strlen($ERROR_MSG) > 0) { ?>
<script language="javascript">
	alert('<?=$ERROR_MSG?>');
</script>
<? } ?>

</body>
</html>
<script language="javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("jam2");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("keterangan");
var spryselect1 = new Spry.Widget.ValidationSelect("tingkat");
var spryselect2 = new Spry.Widget.ValidationSelect("kelas");
var spryselect3 = new Spry.Widget.ValidationSelect("pelajaran");
var spryselect4 = new Spry.Widget.ValidationSelect("status");
</script>