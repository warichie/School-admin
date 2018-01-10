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
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/theme.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$proses = "";
if (isset($_REQUEST['proses']))
	$proses = $_REQUEST['proses'];

$kelompok = $_REQUEST['kelompok'];

$varbaris=10;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];

$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
	
$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];

$urut = "kelompok";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$op = $_REQUEST['op'];

if ($op == "xm8r389xemx23xb2378e23") {
	OpenDb();
	$sql = "DELETE FROM kelompokcalonsiswa WHERE replid = '$_REQUEST[replid]'";
	QueryDb($sql);
	CloseDb();	
	$kelompok = $_REQUEST['replid'];
$page=0;
$hal=0;
}	
OpenDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Student Candidate Group]</title>
<script src="../script/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../script/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function tambah() {
	var departemen = document.getElementById('departemen').value;
	var id = document.getElementById('proses').value;
	newWindow('kelompok_add.php?departemen='+departemen+'&id='+id, 'TambahKelompokCalonSiswa','500','340','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function tampil() {
	var departemen = document.getElementById('departemen').value;
	document.location.href = "kelompok_tampil.php?departemen="+departemen+"&varbaris=<?=$varbaris?>";
}

function edit(replid) {
	newWindow('kelompok_edit.php?replid='+replid, 'UbahKelompokCalonSiswa','500','340','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function hapus(replid) {
	var departemen = document.getElementById('departemen').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
	
	if (confirm("Are you sure want to delete this group?"))
		document.location.href = "kelompok_tampil.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function refresh_all() {
	var departemen = document.getElementById('departemen').value;
	var proses= document.getElementById('proses').value;
	
	document.location.href = "kelompok_tampil.php?departemen="+departemen+"&proses="+proses;	
}


function refresh(kelompok) {	
	var departemen = document.getElementById('departemen').value;
	//var proses = document.getElementById('proses').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
	
	document.location.href = "kelompok_tampil.php?departemen="+departemen+"&kelompok="+kelompok+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function lihat(replid) {
	var departemen = document.getElementById('departemen').value;
	var proses = document.getElementById('proses').value;
	newWindow('kelompok_detail.php?replid='+replid+'&departemen='+departemen+'&proses='+proses, 'DaftarCalonSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function change_urut(urut,urutan) {		
	var departemen = document.getElementById('departemen').value;
	var varbaris=document.getElementById("varbaris").value;
		
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	
	document.location.href = "kelompok_tampil.php?departemen="+departemen+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris="+varbaris;
}

function change_page(page) {
	var departemen=document.getElementById("departemen").value;
	var proses= document.getElementById('proses').value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="kelompok_tampil.php?departemen="+departemen+"&proses="+proses+"&page="+page+"&hal="+page+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

function change_hal() {
	var departemen = document.getElementById("departemen").value;
	var proses= document.getElementById('proses').value;
	var hal = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="kelompok_tampil.php?departemen="+departemen+"&proses="+proses+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

function change_baris() {
	var departemen = document.getElementById("departemen").value;
	var proses= document.getElementById('proses').value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="kelompok_tampil.php?departemen="+departemen+"&proses="+proses+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

function tutup() {
	var departemen = document.getElementById('departemen').value;
	var proses=document.getElementById('proses').value;
	var kelompok = document.getElementById('kelompok').value;
		
	if (kelompok.length == 0)
		parent.opener.change_kelompok(0);
	else
		parent.opener.kelompok_kiriman(kelompok,proses,departemen);
		
	window.close();
	
}

locnm=location.href;
pos=locnm.indexOf("indexb.htm");
locnm1=locnm.substring(0,pos);
function ByeWin() {
	windowIMA=opener.change_kelompok(0);
}
</script>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" onUnload="ByeWin()" onload="document.getElementById('departemen').focus()">
<input type="hidden" name="urut" id="urut" value="<?=$urut ?>" />
<input type="hidden" name="urutan" id="urutan" value="<?=$urutan ?>" />
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Student Candidate Group :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF" height = "360" valign="top">
    <!-- CONTENT GOES HERE //--->

<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr>
	
	<td align="left" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- TABLE LINK -->
    <tr>
    	<td align="left" width="20%"><strong>Department </strong></td>
    	<td width="25%">
        <select name="departemen" id="departemen" onChange="tampil()" style="width:155px;" onKeyPress="return focusNext('Tutup', event)">
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
    	<td><strong>Admission Process </strong></td>
    	<td><?	$sql = "SELECT replid,proses FROM prosespenerimaansiswa WHERE aktif=1 AND departemen='$departemen'";				
				$result = QueryDb($sql);
				$row = mysql_fetch_array($result);
				$proses = $row['replid'];
			?>
            <input type="text" name="nama_proses" id="nama_proses" style="width:150px;" class="disabled" value="<?=$row['proses']?>" readonly />
            <input type="hidden" name="proses" id="proses"  value="<?=$proses?>" />
        </td>
<?  if ($proses!=""){
		OpenDb();
		$sql_tot = "SELECT replid,kelompok,kapasitas,keterangan FROM kelompokcalonsiswa WHERE idproses='$proses'";
		$result_tot = QueryDb($sql_tot);
		$total = ceil(mysql_num_rows($result_tot)/(int)$varbaris);
		$jumlah = mysql_num_rows($result_tot);
						
		$sql = "SELECT replid,kelompok,kapasitas,keterangan FROM kelompokcalonsiswa WHERE idproses='$proses' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 						
		$akhir = ceil($jumlah/5)*5;
	  
		$result = QueryDb($sql);
		if (@mysql_num_rows($result) > 0) {
	?>
    	<td align="right">
        <a href="#" onClick="refresh_all()"><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;    
	<?	if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
	    <a href="JavaScript:tambah()"><img src="../images/ico/tambah.png" border="0" onMouseOver="showhint('Add Group', this, event, '50px')"/>&nbsp;Add Group</a>
	<?	} ?>    </td>
    </tr>
    </table>
	</td>
</tr>
<tr>
	<td>
    <br />
    <table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left">
    
      <!-- TABLE CONTENT -->
      <tr height="30" align="center" class="header">
        <td width="4%">#</td>
        <td width="25%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('kelompok','<?=$urutan?>')">Group <?=change_urut('kelompok',$urut,$urutan)?></td>
        <td width="15%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('kapasitas','<?=$urutan?>')">Capacity <?=change_urut('kapasitas',$urut,$urutan)?></td>
        <td width="8%" class="header" align="center">Filled</td>
        <td width="*" class="header" align="center">Info</td>
        <td width="8%" class="header">&nbsp;</td>
      </tr>
      <?
		if ($page==0)
			$cnt = 0;
		else 
			$cnt = (int)$page*(int)$varbaris;
		while ($row = @mysql_fetch_array($result)) {
	?>
      <tr>
        <td height="25" align="center"><?=++$cnt ?></td>
        <td height="25"><?=$row['kelompok']?></td>
        <td height="25" align="center"><?=$row['kapasitas']?></td>
        <td height="25" align="center">
		<?	OpenDb();
			$sql1 = "SELECT COUNT(*) FROM calonsiswa WHERE idkelompok='$row[replid]' AND aktif = 1";    
			$result1 = QueryDb($sql1);
			$row1 = @mysql_fetch_row($result1);
			echo $row1[0];			
			if ($row1[0] > 0 ) {
		?>    
        	&nbsp;<a href="JavaScript:lihat(<?=$row['replid']?>)"><img src="../images/ico/lihat.png" border="0" onMouseOver="showhint('See Student Candidate', this, event, '65px')"/></a>        
        <? 	} ?>        </td>        
        <td height="25"><?=$row['keterangan']?></td>
        <td height="25" align="center">
<?		if (SI_USER_LEVEL() != $SI_USER_STAFF) {  ?>
            <a href="JavaScript:edit(<?=$row['replid'] ?>)" ><img src="../images/ico/ubah.png" border="0" onMouseOver="showhint('Edit Group', this, event, '80px')"/></a>&nbsp; <a href="JavaScript:hapus(<?=$row['replid'] ?>)" ><img src="../images/ico/hapus.png" border="0" onMouseOver="showhint('Delete Group', this, event, '80px')"/></a>
<?		} ?>		</td>
   	</tr>
<?		} CloseDb(); ?>
      <!-- END TABLE CONTENT -->
    </table>
    <script language='JavaScript'>
	    Tables('table', 1, 0);
    </script>	
	<?	if ($page==0){ 
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:visible;'";
		}
		if ($page<$total && $page>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:visible;'";
		}
		if ($page==$total-1 && $page>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:hidden;'";
		}
		if ($page==$total-1 && $page==0){
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:hidden;'";
		}
	?>
    </td>
</tr> 
<tr>
    <td>
    <table border="0"width="100%" align="center"cellpadding="0" cellspacing="0">	
    <tr>
       	<td width="30%" align="left">Page
        <select name="hal" id="hal" onChange="change_hal()">
        <?	for ($m=0; $m<$total; $m++) {?>
             <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
        <? } ?>
     	</select>
	  	from <?=$total?> pages
		
		<? 
     // Navigasi halaman berikutnya and sebelumnya
        ?>
        </td>
    	<!--td align="center">
    <input <?=$disback?> type="button" class="but" name="back" value=" << " onClick="change_page('<?=(int)$page-1?>')" onMouseOver="showhint('Previous', this, event, '75px')">
		<?
		/*for($a=0;$a<$total;$a++){
			if ($page==$a){
				echo "<font face='verdana' color='red'><strong>".($a+1)."</strong></font> "; 
			} else { 
				echo "<a href='#' onClick=\"change_page('".$a."')\">".($a+1)."</a> "; 
			}
				 
	    }*/
		?>
	     <input <?=$disnext?> type="button" class="but" name="next" value=" >> " onClick="change_page('<?=(int)$page+1?>')" onMouseOver="showhint('Next', this, event, '75px')">
 		</td-->
        <td width="30%" align="right">Row per page
      	<select name="varbaris" id="varbaris" onChange="change_baris()">
        <? 	for ($m=5; $m <= $akhir; $m=$m+5) { ?>
        	<option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
        <? 	} ?>
       
      	</select></td>
    </tr>
    </table>
<?	} else { ?>
</td><td width="55%"></td>
</tr>
<tr>
  	<td colspan="3"><hr style="border-style:dotted" color="#000000"/>
	<table width="100%" border="0" align="center"> 
	<tr>
		<td align="center" valign="middle" height="135">
        
    	<font size = "2" color ="red"><b>Data Not Found. 
        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <br />Click <a href="JavaScript:tambah()" ><font size = "2" color ="green">here</font></a> to submit a new data. 
        <? } ?>
        </b></font>
	
	</table>
  	</td>
</tr>
</table>
<? } 
} else {

?>
</td><td width="55%"></td>
</tr>
<tr>
  	<td colspan="3"><hr style="border-style:dotted" color="#000000"/>
	<table width="100%" border="0" align="center"> 
	<tr>
		<td align="center" valign="middle" height="135">
    	<? if ($departemen != "") { ?> 
        	<font size = "2" color ="red"><b>No New Student Admission Process data for Department <?=$departemen?>. 
            <br> Please enter a data in New Student Admission Process menu on New Student Admission section.</font>
		<? } else { ?>
            <font size = "2" color ="red"><b>No Department yet.
            <br />Please make a new one in Department menu on Reference section.
            </b></font>
   		<? } ?> 
        </td>
   	</tr>
	</table>
  	</td>
</tr>
</table> 
<? } ?>  
    </td></tr>
    
 	<tr height="35">
	<td align="center">    
    <input type="button" name="Tutup" id="Tutup" value="Close" class="but" onClick="tutup()" />
    <input type="hidden" name="kelompok" id="kelompok" value="<?=$kelompok?>" />
    </td>
</tr>
<!-- END TABLE CENTER -->    
</table>
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
</body>
</html>
<script language="javascript">
	var spryselect1 = new Spry.Widget.ValidationSelect("departemen");
</script>