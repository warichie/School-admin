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

$jamke_asli=$_REQUEST['jamke_asli'];
$jamke=$_REQUEST['jamke'];
$departemen=$_REQUEST['departemen'];
$jam1baru=$_REQUEST['jam1baru'];
$menit1baru=$_REQUEST['menit1baru'];
$jam2baru=$_REQUEST['jam2baru'];
$menit2baru=$_REQUEST['menit2baru'];

$ERROR_MSG = "";
if (isset($_REQUEST['simpan'])) {	
	$jum_awal=(int)$jam1baru*60+(int)$menit1baru;
	$jum_akhir=(int)$jam2baru*60+(int)$menit2baru;
	
	if ($jam1baru<10){
		$jam1simpan="0".$jam1baru;
	} else {
		$jam1simpan=$jam1baru;
	}
	if ($menit1baru<10){
		$menit1simpan="0".$menit1baru;
	} else {
		$menit1simpan=$menit1baru;
	}
	if ($jam2baru<10){
		$jam2simpan="0".$jam2baru;
	} else {
		$jam2simpan=$jam2baru;
	}
	if ($menit2baru<10){
		$menit2simpan="0".$menit2baru;
	} else {
		$menit2simpan=$menit2baru;
	}
	$jam1=$jam1simpan.":".$menit1simpan;
	$jam2=$jam2simpan.":".$menit2simpan;
	
	OpenDb();
	$sql = "SELECT * FROM jam WHERE jamke = '$jamke' AND departemen = '$departemen'";
	$result = QueryDb($sql);
	if (mysql_num_rows($result) > 0) {
		CloseDb();
		$ERROR_MSG = "Sort of Time (hour) ".$jamke." has been used";		
	} else {
		if ($jamke_asli==$jamke){		
			$sql_jam_sebelumnya="SELECT replid as replidsebelumnya, jamke as jamkesebelumnya, HOUR(jam2) As jamakhirsebelumnya, MINUTE(jam2) As menitakhirsebelumnya FROM jbsakad.jam WHERE departemen='$departemen' AND jamke<'$jamke' ORDER BY jamke DESC LIMIT 1";
			$result_jam_sebelumnya=QueryDb($sql_jam_sebelumnya);
			$row_jam_sebelumnya=@mysql_fetch_array($result_jam_sebelumnya);
			$jum_sebelumnya=((int)$row_jam_sebelumnya['jamakhirsebelumnya']*60)+(int)$row_jam_sebelumnya['menitakhirsebelumnya'];
			if ($jum_awal<$jum_sebelumnya){			
				$ERROR_MSG = "Start Time should not overlapping previous End Time";				
			} else {	
				$sql_jam_simpan="INSERT INTO jbsakad.jam SET jamke='$jamke',jam1='$jam1',jam2='$jam2',departemen='$departemen'";
				$result_jam_simpan=QueryDb($sql_jam_simpan);
				if ($result_jam_simpan){
				?>
					<script language="javascript">
					parent.opener.refresh();
					window.close();
					</script>
				<?
				}
			}
			//kalo jamkenya ga brubah
		} else {
		
			//kalo jamkenya brubah
			$sql_jam_sebelumnya="SELECT replid as replidsebelumnya, jamke as jamkesebelumnya, HOUR(jam2) As jamakhirsebelumnya, MINUTE(jam2) As menitakhirsebelumnya FROM jbsakad.jam WHERE departemen='$departemen' AND jamke<'$jamke' ORDER BY jamke DESC LIMIT 1";
			$result_jam_sebelumnya=QueryDb($sql_jam_sebelumnya);				
			$row_jam_sebelumnya=@mysql_fetch_array($result_jam_sebelumnya);
			$jum_sebelumnya=((int)$row_jam_sebelumnya['jamakhirsebelumnya']*60)+(int)$row_jam_sebelumnya['menitakhirsebelumnya'];			
			
			$sql_jam_sesudahnya="SELECT replid as replidsesudahnya, jamke as jamkesesudahnya, HOUR(jam1) As jamawalsesudahnya, MINUTE(jam1) As menitawalsesudahnya FROM jbsakad.jam WHERE departemen='$departemen' AND jamke>'$jamke' ORDER BY jamke ASC LIMIT 1";
			$result_jam_sesudahnya=QueryDb($sql_jam_sesudahnya);
			$row_jam_sesudahnya=@mysql_fetch_array($result_jam_sesudahnya);
			$jum_sesudahnya=((int)$row_jam_sesudahnya['jamawalsesudahnya']*60)+(int)$row_jam_sesudahnya['menitawalsesudahnya'];
			
			if ($jum_awal < $jum_sebelumnya ){
				$ERROR_MSG = "Start Time should not overlapping previous End Time";
			} else {
				if ($jum_akhir > $jum_sesudahnya){
					$ERROR_MSG = "End Time should not overlapping next Start Time";				
				} else {
					//proses simpan data
					
					$sql_jam_simpan="INSERT INTO jbsakad.jam SET jamke='$jamke',jam1='$jam1',jam2='$jam2',departemen='$departemen'";
					$result_jam_simpan=QueryDb($sql_jam_simpan);
					if ($result_jam_simpan){
						?>
						<script language="javascript">
							parent.opener.refresh();
							window.close();
						</script>
						<?
					} 
				}
			}	
		}
	//kalo jamkenya brubah
	}
}


OpenDb();
$sql_ambil_jamke_terakhir="SELECT jamke, departemen FROM jbsakad.jam WHERE departemen='$departemen' ORDER BY jamke DESC LIMIT 1";
$result_ambil_jamke_terakhir=QueryDb($sql_ambil_jamke_terakhir);
$row_ambil_jamke_terakhir=@mysql_fetch_array($result_ambil_jamke_terakhir);

if (!isset($jamke)) 
	$jamke = (int)$row_ambil_jamke_terakhir['jamke']+1;

	
//}
?>
<html>
<head>
<title>JIBAS SIMAKA [Add Session]</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script src="../script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="JavaScript" src="../script/tables.js"></script>
<script type="text/javascript" language="javascript" src="../script/validasi.js"></script>
<script language="javascript">

function validate(){
	var jamke_asli=document.tabel_jam.jamke_asli.value;	
	var jamke=document.tabel_jam.jamke.value;
	var jam1baru=document.tabel_jam.jam1baru.value;
	var menit1baru=document.tabel_jam.menit1baru.value;
	var jam2baru=document.tabel_jam.jam2baru.value;
	var menit2baru=document.tabel_jam.menit2baru.value;	
	var jum_awal = (jam1baru*60) + menit1baru;
	var jum_akhir = (jam2baru*60) + menit2baru;
	
	if (jamke.length==0){
		alert('You must enter a value for Time');
		document.tabel_jam.jamke.focus();
		return false;
	}
	if (isNaN(jamke)){
		alert('Time must be numeric');
		document.tabel_jam.jamke.focus();
		return false;
	}
	if (jam1baru.length==0){
		alert('You must enter a value for Start Time');
		document.tabel_jam.jam1baru.focus();
		return false;
	}
	if (isNaN(jam1baru)){
		alert('Start Time must be numeric');
		document.tabel_jam.jam1baru.focus();
		return false;
	}
	if (jam1baru>23){
		alert('Start Time is a range between 00 to 23');
		document.tabel_jam.jam1baru.focus();
		return false;			
	}
	if (menit1baru.length==0){
		alert('You must enter a value for Minute Start');
		document.tabel_jam.menit1baru.focus();
		return false;			
	}
	if (isNaN(menit1baru)){
		alert('Start Minute must be numeric');
		document.tabel_jam.menit1baru.focus();
		return false;
			
	}
	if (menit1baru>59){
		alert('Start Minute is a range between 00 to 59');
		document.getElementById(menit1baru).focus();
		return false;			
	}
	if (jam2baru.length==0){
		alert('You must enter a value for End Time');
		document.tabel_jam.jam2baru.focus();
		return false;			
	}
	if (isNaN(jam2baru)){
		alert('End Time must be numeric');
		document.tabel_jam.jam2baru.focus();
		return false;
	}
	if (jam2baru>23){
		alert('End Time is a range between 00 to 23');
		document.tabel_jam.jam2baru.focus();
		return false;
	}
	
	if (menit2baru.length==0){
		alert('You must enter a value for Minute Start');
		document.tabel_jam.menit2baru.focus();
		return false;
	}
	
	if (isNaN(menit2baru)){
		alert('End Minute must be numeric');
		document.tabel_jam.menit2baru.focus();
		return false;
			
	}
	if (menit2baru>59){
		alert('End Minute is a range between 00 to 59');
		document.tabel_jam.menit2baru.focus();
		return false;
	}
	if (jum_awal>=jum_akhir){
		alert('Start Time should not bigger or equal to End Time');
		document.tabel_jam.menit2baru.focus();
		return false;
	}
	
	//document.location.href="tambah_jam.php?jamke_asli="+jamke_asli+"&jamke="+jamke+"&jam1baru="+jam1baru+"&menit1baru="+menit1baru+"&jam2baru="+jam2baru+"&menit2baru="+menit2baru+"&departemen="+departemen;
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

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#FFFFFF" onLoad="document.getElementById('jam1baru').focus();">
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

    <form name="tabel_jam" id="tabel_jam" onSubmit="return validate()">
    <!-- ============================END MAIN VIEW============================ -->
    <table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
	<!-- TABLE CONTENT -->
	<tr height="25">
    	<td colspan="2" class="header" align="center">Add Session</td>	        
  	</tr>
    <tr>
		<td width="120"><strong>Department</strong></td>
    	<td><input type="text" name="dept" size="10" maxlength="50" class="disabled" readonly value="<?=$departemen?>"/> 
        <input type="hidden" name="departemen" id="departemen" value="<?=$departemen?>"></td>
	</tr>
    <tr>
    	<td width="40%"><strong>Hour</strong></td>        
        <td><input type="text" name="jamke" id="jamke" value="<?=$jamke; ?>"  size="2" maxlength="2" onKeyPress="return focusNext('jamb1baru', event)" > 
            <input type="hidden" name="jamke_asli" id="jamke_asli" value="<?=(int)$row_ambil_jamke_terakhir[jamke]+1; ?>">
        </td>
    </tr>
    <tr>
    	<td><strong>Start Time</strong></td>
        <td><input type="text" name="jam1baru" id="jam1baru" size="2" maxlength="2" value="<?=$jam1baru?>" onKeyPress="return focusNext('menit1baru', event)"> :
        	<input type="text" name="menit1baru" id="menit1baru" size="2" maxlength="2" value="<?=$menit1baru?>"  onKeyPress="return focusNext('jam2baru', event)">
        </td>
   </tr>
   <tr>
        <td><strong>End Time</strong></td>
        <td><input type="text" name="jam2baru" id="jam2baru" size="2" maxlength="2" value="<?=$jam2baru?>"  onKeyPress="return focusNext('menit2baru', event)"> :
        	<input type="text" name="menit2baru" id="menit2baru" size="2" maxlength="2" value="<?=$menit2baru?>" onKeyPress="return focusNext('Simpan', event)">
        </td>
 	</tr>
    <tr>        
        <td colspan="2" align="center">*format (HH:MM-HH:MM) </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
          <input type="submit" value="Save" name="simpan" id="Simpan" class="but">         
          <input type="button" value="Close" onClick="window.close()" class="but">
        </td>
    </tr>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("jamke");
var sprytextfield1 = new Spry.Widget.ValidationTextField("jam1baru");
var sprytextfield1 = new Spry.Widget.ValidationTextField("menit1baru");
var sprytextfield1 = new Spry.Widget.ValidationTextField("jam2baru");
var sprytextfield1 = new Spry.Widget.ValidationTextField("menit2baru");
</script>