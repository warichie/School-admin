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
//require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/getheader.php');
require_once('../include/db_functions.php');

OpenDb();

$kelompokJam = NULL;
$jam = NULL;
$jadwal = NULL;

if (isset($_REQUEST['info']))
	$info = $_REQUEST['info'];
if (isset($_REQUEST['nip']))
	$nip = $_REQUEST['nip'];
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$op = $_REQUEST['op'];
if ($op == "xm8r389xemx23xb2378e23") {
	if ($_REQUEST['field']) 
		$filter = 'nipguru';
	else 
		$filter = 'replid';
	
	OpenDb();
	$sql = "DELETE FROM jadwal WHERE $filter = '$_REQUEST[replid]'";
	QueryDb($sql);
	CloseDb();
}	

OpenDb();	
$sql1 = "SELECT t.replid, t.departemen FROM infojadwal i, tahunajaran t  WHERE i.replid = '$info' AND t.replid = i.idtahunajaran";
$result1 = QueryDb($sql1);
$row1 = mysql_fetch_array($result1); 
$departemen = $row1['departemen'];
$tahunajaran = $row1['replid'];

function loadJam($id) {	
	$sql = "SELECT jamke, TIME_FORMAT(jam1, '%H:%i'), TIME_FORMAT(jam2, '%H:%i') ".
	       "FROM jam WHERE departemen = '$id' ORDER BY jamke";
	
	$result = QueryDb($sql);
	$GLOBALS[maxJam] = mysql_num_rows($result);
	
	while($row = mysql_fetch_array($result)) {
		$GLOBALS[jam][row][$row[0]][jam1] = $row[1];
		$GLOBALS[jam][row][$row[0]][jam2] = $row[2];
	}
	return true;
}

function loadJadwal() {		
	$sql = "SELECT j.replid AS id, j.hari AS hari, j.jamke AS jam, j.njam AS njam, j.keterangan AS ket, ".
	       "l.nama AS pelajaran, k.kelas, ".
	       "CASE j.status WHEN 0 THEN 'Mengajar' WHEN 1 THEN 'Asistensi' WHEN 2 THEN 'Tambahan' END AS status ".
	       "FROM jadwal j, pelajaran l, kelas k ".
	       "WHERE j.nipguru = '".$_REQUEST['nip'].
	       "' AND j.departemen = '".$_REQUEST['departemen'].
	       "' AND j.infojadwal = '".$_REQUEST['info'].
	       "' AND j.idkelas = k.replid ".
	       "AND j.idpelajaran = l.replid";
	
	$result = QueryDb($sql);
	
	while($row = mysql_fetch_assoc($result)) {
		$GLOBALS[jadwal][row][$row[hari]][$row[jam]][id] = $row[id];
		$GLOBALS[jadwal][row][$row[hari]][$row[jam]][njam] = $row[njam];
		$GLOBALS[jadwal][row][$row[hari]][$row[jam]][pelajaran] = $row[pelajaran];
		$GLOBALS[jadwal][row][$row[hari]][$row[jam]][kelas] = $row[kelas];
		$GLOBALS[jadwal][row][$row[hari]][$row[jam]][status] = $row[status];
		$GLOBALS[jadwal][row][$row[hari]][$row[jam]][ket] = $row[ket];
	}
	return true;
}

function getCell($r, $c) {
	global $mask, $jadwal;
	if($mask[$c] == 0) {
		if(isset($jadwal[row][$c][$r])) {
			$mask[$c] = $jadwal[row][$c][$r][njam] - 1;
			
			$s = "<td class='jadwal' rowspan='{$jadwal[row][$c][$r][njam]}' width='110px'>";
			$s.= "{$jadwal[row][$c][$r][kelas]}<br>";
			$s.= "<b>{$jadwal[row][$c][$r][pelajaran]}</b><br>";
			$s.= "<i>{$jadwal[row][$c][$r][status]}</i><br>{$jadwal[row][$c][$r][ket]}<br>";
			//$s.= "<img src='../images/ico/ubah.png' style='cursor:pointer' ";
			//$s.= " onclick='edit({$jadwal[row][$c][$r][id]})'> &nbsp;";
			//$s.= "<img src='../images/ico/hapus.png' style='cursor:pointer' ";
			//$s.= " onclick='hapus({$jadwal[row][$c][$r][id]},0)'>";
			$s.= "</td>";
			
			return $s;
		} else {
			$s = "<td class='jadwal' width='110px'>";			
			$s.= "[Empty]";
			$s.= "</td>";

			return $s;
		}
	} else {
		--$mask[$c];
	}
}

$mask = NULL;
for($i = 1; $i <= 6; $i++) {
	$mask[i] = 0;
}

loadJam($departemen);
loadJadwal();

?>

<html>
<head>
<title>Teacher Schedule</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<style>
	.jadwal {
		border: 1px solid black;
		text-align: center;
		vertical-align: middle;
	}

	.jam {
		border: 1px solid black;
		height: 90px;
		background-color: #A0A0A0;
		text-align: center;
		vertical-align: middle;
	}
</style>
<script language="javascript" src="../script/tools.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/tables.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/common.js"></script>
<script type="text/javascript" language="javascript">

function tambah(jam, hari) {		
	var nip = document.getElementById('nip').value;
	var info = document.getElementById('info').value;
	var maxJam = document.getElementById('maxJam').value;
			
	newWindow('jadwal_guru_add.php?nip='+nip+'&info='+info+'&maxJam='+maxJam+'&jam='+jam+'&hari='+hari, 'TambahJadwalGuru', '500', '460', 'resizable=1,scrollbars=1,status=0,toolbar=0');
}

function hapus(replid, field) {
	var departemen = document.getElementById('departemen').value;
	var nip = document.getElementById('nip').value;
	var info = document.getElementById('info').value;
	
	if (confirm("Are you sure want to delete this Class Schedule?"))
		document.location.href = "jadwal_guru_footer.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&field="+field+"&nip="+nip+"&info="+info+"&departemen="+departemen;
}

function edit(replid) {
	var maxJam = document.getElementById('maxJam').value;	
	newWindow('jadwal_guru_edit.php?maxJam='+maxJam+'&replid='+replid, 'UbahJadwalGuru','500','460','resizable=1,scrollbars=1,status=0,toolbar=0')
		
}

function cetak() {
	var departemen = document.getElementById('departemen').value;
	var nip = document.getElementById('nip').value;
	var info = document.getElementById('info').value;
	
	newWindow('jadwal_guru_cetak.php?nip='+nip+'&info='+info+'&departemen='+departemen, 'CetakJadwalGuru','790', '650', 'resizable=1,scrollbars=1,status=0,toolbar=0');
}

function refresh() {	
	document.location.reload();
}

</script>
</head>

<body>
<form id="reqForm" name="reqForm" method="post">
<input type="hidden" name="departemen" id="departemen" value="<?=$departemen ?>">
<input type="hidden" name="nip" id="nip" value="<?=$nip ?>">
<input type="hidden" name="info" id="info" value="<?=$info ?>">
<input type="hidden" name="maxJam" id="maxJam" value="<?=$maxJam ?>">

</form>

<table border="0" width="100%" align="center" style="background-repeat:no-repeat; background-attachment:fixed; background-image:url(../images/ico/b_jadwalguru.png);">
<!-- TABLE CENTER -->
<tr>
	<td> 
<?	OpenDb(); 
	$sql = "SELECT * FROM pelajaran p, guru g WHERE g.nip = '$nip' AND p.departemen = '$departemen' AND g.idpelajaran = p.replid";	
	
	$result = QueryDb($sql);
	CloseDb();      
	if (@mysql_num_rows($result)>0){			
?>
    <table width="95%" border="0" align="center">
  	<tr>
		<td align="right">
       <a href="#" onClick="document.location.reload()"><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;
       	<a href="JavaScript:cetak()">
        <img src="../images/ico/print.png" border="0" onMouseOver="showhint('Print', this, event, '50px')"/>&nbsp;Print</a>&nbsp;&nbsp;
    	</td>
    </tr>
    </table>
    <br>
    <table border="1" width="95%" id="table" class="tab" align="center" cellpadding="2" style="border-collapse:collapse" cellspacing="2">
    <tr>
        <td width="110px" class="header" align="center">Time</td>
        <td width="110px" class="header" align="center">Monday</td>
        <td width="110px" class="header" align="center">Tuesday</td>
        <td width="110px" class="header" align="center">Wednesday</td>
        <td width="110px" class="header" align="center">Thursday</td>
        <td width="110px" class="header" align="center">Friday</td>
        <td width="110px" class="header" align="center">Saturday</td>
    </tr>
	<?
	
		if(isset($jam[row])) {
			
			foreach($jam[row] as $k => $v) {
	?> 
    <tr>
        <td class="jam" width="110px"><b><?=++$j ?>.</b> <?=$v[jam1] ?> - <?=$v[jam2] ?></td>
        <? for($i = 1; $i <= 6; $i++) {?> 
        <?=getCell($k, $i); ?> 
        <? }?>  
    </tr>
        
	<?	} ?> 	
	
    <!-- END TABLE CONTENT -->
    </table>
   
	
<? 		} else { ?> 
	<table width="100%" border="0" align="center">          
	<tr>
		<td align="center" valign="middle" height="200">
    	<font size = "2" color ="red"><b>No session data for department <?=$departemen?>. 
        <br> Please make a new one in the Session on Schedule and Class Subject section.</font>
		</td>
	</tr>
	</table> 
<?
		}
	} else {
	
?> 	
	<table width="100%" border="0" align="center">          
	<tr>
		<td align="center" valign="middle" height="200">
    	<font size = "2" color ="red"><b>No Data Found. <br /><br />Add Teaching data by Teacher <?=$_REQUEST['nama']?> on Department <?=$departemen?><br> in the Teacher Data menu on Teacher and Class Subject section.</b></font>
		</td>
	</tr>
	</table> 
<? } ?>     
     </td></tr>
<!-- END TABLE CENTER -->    
</table>
</body>

</html>