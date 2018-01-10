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
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/theme.php'); 
require_once('../library/departemen.php');

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
$tahunajaran = "";
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];

$jadwal = $_REQUEST['jadwal'];

$urut = "deskripsi";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$op = $_REQUEST['op'];

if ($op == "dw8dxn8w9ms8zs22") {	
	OpenDb();
	$sql = "UPDATE infojadwal SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
	QueryDb($sql);
	CloseDb();
	$jadwal = $_REQUEST['replid'];
} else if ($op == "xm8r389xemx23xb2378e23") {
	OpenDb();
	$sql = "DELETE FROM infojadwal WHERE replid = '$_REQUEST[replid]'";	
	QueryDb($sql);		
	CloseDb();	
	$jadwal = $_REQUEST['replid'];
}	
OpenDb();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../script/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../script/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript">
function change_departemen() {
	var departemen=document.getElementById("departemen").value;
	document.location.href = "info_jadwal.php?departemen="+departemen;
}

function change_tahunajaran() {
	var departemen=document.getElementById("departemen").value;
	var tahunajaran=document.getElementById("tahunajaran").value;
	document.location.href = "info_jadwal.php?departemen="+departemen+"&tahunajaran="+tahunajaran;
}

function tambah() {
	var departemen=document.getElementById("departemen").value;
	var tahunajaran=document.getElementById("tahunajaran").value;
	
	newWindow('info_jadwal_add.php?tahunajaran='+tahunajaran,'TambahInfoJadwal','380','250','resizable=1,scrollbars=1,status=0,toolbar=0')	
}


function refresh(jadwal) {	
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	document.location.href = "info_jadwal.php?jadwal="+jadwal+"&departemen="+departemen+"&tahunajaran="+tahunajaran+"&urut=<?=$urut?>&urutan=<?=$urutan?>";
}

function setaktif(aktif, replid) {
	var msg;
	var newaktif;
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	
	if (aktif == 1) {
		msg = "Are you sure want to change this schedule to INACTIVE?";
		newaktif = 0;
	} else	{	
		msg = "Are you sure want to change this schedule to ACTIVE?";
		newaktif = 1;
	}
	
	if (confirm(msg)) 
		document.location.href = "info_jadwal.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&departemen="+departemen+"&tahunajaran="+tahunajaran;
}

function hapus(replid) {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	
	
	if (confirm("Are you sure want to delete this Schedule Info?"))
		document.location.href = "info_jadwal.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen+"&tahunajaran="+tahunajaran+"&urut=<?=$urut?>&urutan=<?=$urutan?>";
		
}

function tutup() {
	var jadwal= document.getElementById('jadwal').value;
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	
	if (jadwal.length == 0){
		parent.opener.change(0);
		window.close();
	} else{			
		parent.opener.change(jadwal,tahunajaran,departemen);		
		window.close();
	}
}

function change_urut(urut,urutan) {		
	var departemen = document.getElementById('departemen').value;	
	var tahunajaran = document.getElementById('tahunajaran').value;	
	
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	
	document.location.href = "info_jadwal.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&urut="+urut+"&urutan="+urutan;
	
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

locnm=location.href;
pos=locnm.indexOf("indexb.htm");
locnm1=locnm.substring(0,pos);
function ByeWin() {

windowIMA=parent.opener.change(0);
}
</script>
<title>JIBAS SIMAKA [Schedule Info List]</title>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#FFFFFF" onUnload="ByeWin()">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF" height="335" valign="top">
    
<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr>	
	<td align="left" valign="top">

	<table border="0"width="100%">
    <!-- TABLE TITLE -->
    <tr>
        <td align="right"><font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Schedule Info List</font></td>
    </tr>
    <tr>
        <td align="left">&nbsp;</td>
    </tr>
    </table>
   
    
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- TABLE LINK -->
    <tr>
    	<td width="20%"><strong>Department </strong></td>
    	<td width="20%">
        <select name="departemen" id="departemen" onChange="change_departemen()" style="width:150px;" onKeyPress="return focusNext('tahunajaran', event)">
        <?	$dep = getDepartemen(SI_USER_ACCESS());    
		foreach($dep as $value) {
		if ($departemen == "")
			$departemen = $value; ?>
          <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> > 
            <?=$value ?> 
            </option>
              <?	} ?>
        </select>  		</td>
    </tr>
    <tr>
    	<td><strong>Year</strong></td>
        <td>  
        <select name="tahunajaran" id="tahunajaran" onChange="change_tahunajaran()" style="width:150px;">
   		 	<?
			OpenDb();
			$sql = "SELECT replid,tahunajaran,aktif FROM tahunajaran where departemen='$departemen' ORDER BY aktif DESC, replid DESC";
			$result = QueryDb($sql);
			CloseDb();
			while ($row = @mysql_fetch_array($result)) {
				if ($tahunajaran == "") 
					$tahunajaran = $row['replid'];
				if ($row['aktif']) 
					$ada = '(A)';
				else 
					$ada = '';			 
			?>
            
    		<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tahunajaran)?> ><?=$row['tahunajaran'].' '.$ada?></option>
    		<?
			}
    		?>
    	</select>   
        </td>
        <td align="right">
        	<a href="#" onClick="document.location.reload()"><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh', this, event, '80px')">&nbsp;Refresh</a>&nbsp;&nbsp;
            <a href="JavaScript:tambah()"><img src="../images/ico/tambah.png" border="0" onMouseOver="showhint('Add Schedule Info', this, event, '80px')">&nbsp;Add Schedule Info</a></td>
    </tr>
	</table>
	</td>
</tr>
<tr>
	<td> 
    <br />  
<?	
if ($tahunajaran <> "" && $departemen <> "") {	
	OpenDb();	
	$sql = "SELECT i.deskripsi, i.aktif, i.replid FROM jbsakad.infojadwal i, jbsakad.tahunajaran t WHERE t.departemen ='$departemen' AND i.idtahunajaran = '$tahunajaran' AND i.idtahunajaran = t.replid ORDER BY $urut $urutan";
	
	$result = QueryDb($sql);
	if (@mysql_num_rows($result) > 0) {
	?>
	<table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="left">
	<tr class="header" height="30" align="center">
        <td width="10%">#</td>
        <td width="*" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('deskripsi','<?=$urutan?>')">Schedule Info <?=change_urut('deskripsi',$urut,$urutan)?></td>        
        <td width="20%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('i.aktif','<?=$urutan?>')">Status <?=change_urut('i.aktif',$urut,$urutan)?></td>
        <td width="*">&nbsp;</td>
	</tr>
    <?
	$cnt=1;
	while ($row = @mysql_fetch_array($result)) {				
		$replid=$row['replid'];
	?>
    <tr height="25">
        <td align="center"><?=$cnt?></td>
        <td><?=$row['deskripsi']?></td>
        <td align="center">
        <? if ($row['aktif']==1){ ?>
            <img src="../images/ico/aktif.png" onClick="setaktif(<?=$row['aktif']?>,<?=$row['replid']?>)" onMouseOver="showhint('Status Active', this, event, '120px')">
        <? } else { ?>
            <img src="../images/ico/nonaktif.png" onClick="setaktif(<?=$row['aktif']?>,<?=$row['replid']?>)" onMouseOver="showhint('Status Inactive', this, event, '120px')">
        <? } ?> 
		</td>
        <td align="center">
        	<a href="#" onClick="newWindow('info_jadwal_edit.php?replid=<?=$row['replid']?>',     'UbahInfoJadwal','380','250','resizable=1,scrollbars=1,status=0,toolbar=0')"><img src="../images/ico/ubah.png" border="0" onMouseOver="showhint('Edit Schedule Info', this, event, '80px')"></a>&nbsp;
        	<a href="JavaScript:hapus(<?=$row['replid']?>)" ><img src="../images/ico/hapus.png" border="0" onMouseOver="showhint('Delete', this, event, '80px')"></a>        </td>
        
	</tr> 
     
    <?
	$cnt++;	
	} //while
	CloseDb();
	?>
    
    <script language='JavaScript'>
	    Tables('table', 1, 0);
    </script>
  
	</table>
  
<?	} else { ?>
	<table width="100%" border="0" align="center">
   	<tr>
    	<td colspan="3"><hr style="border-style:dotted" /> 
       	</td>
   	</tr>
	<tr>
		<td align="center" valign="middle" height="200">
    	
        <font size = "2" color ="red"><b>Data Not Found. 
        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <br />Click <a href="JavaScript:tambah()" ><font size = "2" color ="green">here</font></a> to submit a new data. 
        <? } ?>
        </b></font>  
   
        </td>
   	</tr>
   	</table>

<?	}
} else { ?>

	<table width="100%" border="0" align="center">
   	<tr>
    	<td colspan="3"><hr style="border-style:dotted" /> 
       	</td>
   	</tr>
	<tr>
		<td align="center" valign="middle" height="200">
    
    <? if ($departemen == "") { ?>
		<font size = "2" color ="red"><b>No Department yet.
        <br />Please make a new one in Department menu on Reference section.
        </b></font>
    <? } elseif ($tahunajaran == "") {?>
    	<font size = "2" color ="red"><b>No Year data yet.
        <br />Please make a new one in Year of Teaching menu on Reference section.
        </b></font>
    <? } ?>
        </td>
   	</tr>
   	</table>
<? } ?> 
	</td>
</tr>
<tr height="35">
	<td colspan="3" align="center">   	
       <input class="but" type="button" value="Close" onClick="tutup()">
       <input type="hidden" name="jadwal" id="jadwal" value="<?=$jadwal?>" />
   	</td>
</tr>  
</table>
</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_06a.jpg">&nbsp;</td>
</tr>
<tr height="28">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_07.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_08a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_09.jpg">&nbsp;</td>
</tr>
</table>
</body>
</html>
<script language="javascript">
	var spryselect1 = new Spry.Widget.ValidationSelect("departemen");
	var spryselect1 = new Spry.Widget.ValidationSelect("tahunajaran");
</script>