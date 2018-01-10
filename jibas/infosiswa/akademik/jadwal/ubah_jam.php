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
require_once('../include/getheader.php');
require_once('../include/db_functions.php');

if (isset($_REQUEST['replid']))
	$replid=$_REQUEST['replid'];
if (isset($_REQUEST['jamkey']))
	$jamkey=$_REQUEST['jamkey'];
if (isset($_REQUEST['jam1y']))
	$jam1y=$_REQUEST['jam1y'];
if (isset($_REQUEST['menit1y']))
	$menit1y=$_REQUEST['menit1y'];
if (isset($_REQUEST['jam2y']))
	$jam2y=$_REQUEST['jam2y'];
if (isset($_REQUEST['menit2y']))	
	$menit2y=$_REQUEST['menit2y'];
if (isset($_REQUEST['departemen']))	
	$departemen=$_REQUEST['departemen'];
	
$ERROR_MSG = "";
if (isset($_REQUEST['simpan'])) {	
	$jum_awal=(int)$jam1y*60+(int)$menit1y;
	$jum_akhir=(int)$jam2y*60+(int)$menit2y;
	
	if ($jam1y<10){
		$jam1simpan="0".$jam1y;
	} else {
		$jam1simpan=$jam1y;
	}
	if ($menit1y<10){
		$menit1simpan="0".$menit1y;
	} else {
		$menit1simpan=$menit1y;
	}
	if ($jam2y<10){
		$jam2simpan="0".$jam2y;
	} else {
		$jam2simpan=$jam2y;
	}
	if ($menit2y<10){
		$menit2simpan="0".$menit2y;
	} else {
		$menit2simpan=$menit2y;
	}
	$jam1=$jam1simpan.":".$menit1simpan;
	$jam2=$jam2simpan.":".$menit2simpan;
	
	OpenDb();
	$sql = "SELECT * FROM jam WHERE jamke = '$jamkey' AND replid <> '$replid' AND departemen = '$departemen'";	
	$result = QueryDb($sql);
	if (mysql_num_rows($result) > 0) {
		CloseDb();
		$ERROR_MSG = "Sort of Time (hour) ".$jamkey." has been used";
	} else {	
		$jum_sebelumnya=0;
		$jum_sesudahnya=0;
		$sql_jam_sebelumnya="SELECT replid as replidsebelumnya, jamke as jamkesebelumnya, HOUR(jam2) As jamakhirsebelumnya, MINUTE(jam2) As menitakhirsebelumnya FROM jbsakad.jam WHERE departemen='$departemen' AND jamke<'$jamkey' ORDER BY jamke DESC LIMIT 1";
		$result_jam_sebelumnya=QueryDb($sql_jam_sebelumnya);				
		if (mysql_num_rows($result_jam_sebelumnya) > 0) {
			$row_jam_sebelumnya=@mysql_fetch_array($result_jam_sebelumnya);
			$jum_sebelumnya=((int)$row_jam_sebelumnya['jamakhirsebelumnya']*60)+(int)$row_jam_sebelumnya['menitakhirsebelumnya'];			
		} 
		
		$sql_jam_sesudahnya="SELECT replid as replidsesudahnya, jamke as jamkesesudahnya, HOUR(jam1) As jamawalsesudahnya, MINUTE(jam1) As menitawalsesudahnya FROM jbsakad.jam WHERE departemen='$departemen' AND jamke>'$jamkey' ORDER BY jamke ASC LIMIT 1";
		$result_jam_sesudahnya=QueryDb($sql_jam_sesudahnya);
		if (mysql_num_rows($result_jam_sesudahnya) > 0) {
			$row_jam_sesudahnya=@mysql_fetch_array($result_jam_sesudahnya);
			$jum_sesudahnya=((int)$row_jam_sesudahnya['jamawalsesudahnya']*60)+(int)$row_jam_sesudahnya['menitawalsesudahnya'];
		} 
		
		if ($jum_awal < $jum_sebelumnya ){
			$ERROR_MSG = "Start Time should not overlapping previous End Time";
		} else {
			
			if ($jum_akhir > $jum_sesudahnya){
				$ERROR_MSG = "End Time should not overlapping next Start Time";				
			} else {
				//proses simpan data
				$sql_jam_simpan="UPDATE jbsakad.jam SET jamke=$jamkey,jam1='$jam1',jam2='$jam2' WHERE replid = '$replid'";
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
}

OpenDb();
//Ambil dulu semua data recordnya yang replidnya udah diketahuin....
$sql_y="SELECT HOUR(jam1) as jam1y, MINUTE(jam1) as menit1y, HOUR(jam2) as jam2y, MINUTE(jam2) as menit2y, replid as replidy, jamke as jamkey, departemen FROM jbsakad.jam WHERE replid='$replid'";
$result_y=QueryDb($sql_y);
$row_y=@mysql_fetch_array($result_y);
if (!isset($jamkey))
	$jamkey = $row_y['jamkey'];
if (!isset($jam1y)) {
	$jam1y = $row_y['jam1y'];
	if ($jam1y<10)
		$jam1y="0".$jam1y;
} 
if (!isset($menit1y)) {
	$menit1y = $row_y['menit1y'];
	if ($menit1y<10)
		$menit1y="0".$menit1y;	
} 
if (!isset($jam2y)) {
	$jam2y = $row_y['jam2y'];
	if ($jam2y<10)
		$jam2y="0".$jam2y;
}
if (!isset($menit2y)) {
	$menit2y = $row_y['menit2y']; 
	if ($menit2y<10)
		$menit2y="0".$menit2y;
}
$departemen = $row_y['departemen'];
CloseDb();

?>
<html>
<head>
<title>JIBAS SIMAKA [Edit Session]</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script src="../script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="JavaScript" src="../script/tables.js"></script>
<script type="text/javascript" language="javascript" src="../script/tools.js"></script>
<script language="javascript">

function validate(){    
    var jamkey= document.tabel_jam.jamkey.value;  
    var jam1y= document.tabel_jam.jam1y.value;
    var menit1y= document.tabel_jam.menit1y.value;
    var jam2y= document.tabel_jam.jam2y.value;
    var menit2y= document.tabel_jam.menit2y.value;
    var jum1y=(jam1y * 60) + menit1y;
    var jum2y=(jam2y * 60) + menit2y;
	
	if (jamkey.length==0){
		alert('You must enter a value for Time');
		document.tabel_jam.jamkey.focus();
		return false;
	}
	if (isNaN(jamkey)){
		alert('Time must be numeric');
		document.tabel_jam.jamkey.focus();
		return false;
	}
	if (jam1y.length==0){
		alert('You must enter a value for Start Time');
		document.tabel_jam.jam1y.focus();
		return false;
	}
	if (isNaN(jam1y)){
		alert('Start Time must be numeric');
		document.tabel_jam.jam1y.focus();
		return false;
	}
	if (jam1y>23){
		alert('Start Time is a range between 00 to 23');
		document.tabel_jam.jam1y.focus();
		return false;			
	}
	if (menit1y.length==0){
		alert('You must enter a value for Minute Start');
		document.tabel_jam.menit1y.focus();
		return false;			
	}
	if (isNaN(menit1y)){
		alert('Start Minute must be numeric');
		document.tabel_jam.menit1y.focus();
		return false;
			
	}
	if (menit1y>59){
		alert('Start Minute is a range between 00 to 59');
		document.getElementById(menit1y).focus();
		return false;			
	}
	if (jam2y.length==0){
		alert('You must enter a value for End Time');
		document.tabel_jam.jam2y.focus();
		return false;			
	}
	if (isNaN(jam2y)){
		alert('End Time must be numeric');
		document.tabel_jam.jam2y.focus();
		return false;
	}
	if (jam2y>23){
		alert('End Time is a range between 00 to 23');
		document.tabel_jam.jam2y.focus();
		return false;
	}
	
	if (menit2y.length==0){
		alert('You must enter a value for Minute Start');
		document.tabel_jam.menit2y.focus();
		return false;
	}
	
	if (isNaN(menit2y)){
		alert('End Minute must be numeric');
		document.tabel_jam.menit2y.focus();
		return false;
			
	}
	if (menit2y>59){
		alert('End Minute is a range between 00 to 59');
		document.tabel_jam.menit2y.focus();
		return false;
	}
	
	if (jum1y>=jum2y){
		alert('Start Time should not bigger or equal to End Time');
		document.tabel_jam.menit2y.focus();
		return false;
	}
  
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

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#FFFFFF" onLoad="document.getElementById('jam1y').focus();">
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
    <input type="hidden" name="replid" id="replid" value="<?=$replid?>">
    <!-- ============================END MAIN VIEW============================ -->
   	<table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
	<!-- TABLE CONTENT -->
	<tr height="25">
    	<td colspan="2" class="header" align="center">Edit Session</td>
	</tr>    
	<tr>
		<td width="120"><strong>Department</strong></td>
    	<td><input type="text" name="dept" size="10" maxlength="50" class="disabled" readonly value="<?=$departemen?>"/> 
        <input type="hidden" name="departemen" id="departemen" value="<?=$departemen?>"></td>
	</tr>
    <tr>
    	<td width="40%"><strong>Hour</strong></td> 
        <td><input type="text" name="jamkey" id="jamkey" value="<?=$jamkey; ?>"  size="2" maxlength="2" onKeyPress="return focusNext('jamb1y', event)" >             
    		<!--<input type="hidden" name="jamkex" id="jamkex" value="<?=$jamkex;?>">
			<input type="hidden" name="jamkez" id="jamkez" value="<?=$jamkez;?>"> -->
        </td>
    </tr>
  	<tr>
    	<td><strong>Start Time</strong></td>
        <td><input type="text" name="jam1y" id="jam1y" size="2" maxlength="2" value="<?=$jam1y?>" onKeyPress="return focusNext('menit1y', event)"> :
        	<input type="text" name="menit1y" id="menit1y" size="2" maxlength="2" value="<?=$menit1y?>"  onKeyPress="return focusNext('jam2y', event)">
        </td>
 	</tr>
    <tr>
        <td><strong>End Time</strong></td>
        <td><input type="text" name="jam2y" id="jam2y" size="2" maxlength="2" value="<?=$jam2y?>"  onKeyPress="return focusNext('menit2y', event)"> :
        	<input type="text" name="menit2y" id="menit2y" size="2" maxlength="2" value="<?=$menit2y?>" onKeyPress="return focusNext('Simpan', event)">
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("jamkey");
var sprytextfield1 = new Spry.Widget.ValidationTextField("jam1y");
var sprytextfield1 = new Spry.Widget.ValidationTextField("menit1y");
var sprytextfield1 = new Spry.Widget.ValidationTextField("jam2y");
var sprytextfield1 = new Spry.Widget.ValidationTextField("menit2y");
</script>