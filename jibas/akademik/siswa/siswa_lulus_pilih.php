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
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');

if (isset($_REQUEST['departemen']))
	$departemen=$_REQUEST['departemen'];
if (isset($_REQUEST['pilihan']))
	$pilihan=(int)$_REQUEST['pilihan'];
if (isset($_REQUEST['nisdipindah']))
	$nisdipindah=$_REQUEST['nisdipindah'];
if (isset($_REQUEST['namadicari']))
	$namadicari=$_REQUEST['namadicari'];
if (isset($_REQUEST['nisdicari']))
	$nisdicari=$_REQUEST['nisdicari'];
if (isset($_REQUEST['kelas']))
	$kelas=$_REQUEST['kelas'];
if (isset($_REQUEST['tingkat']))
	$tingkat=$_REQUEST['tingkat'];
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran=$_REQUEST['tahunajaran'];
if (isset($_REQUEST['kelastujuan']))
	$kelastujuan=$_REQUEST['kelastujuan'];
if (isset($_REQUEST['tingkattujuan']))
	$tingkattujuan=$_REQUEST['tingkattujuan'];
if (isset($_REQUEST['tahunajarantujuan']))
	$tahunajarantujuan=$_REQUEST['tahunajarantujuan'];
if (isset($_REQUEST['ket']))
	$ket=$_REQUEST['ket'];
if (isset($_REQUEST['depasal']))
	$depasal=$_REQUEST['depasal'];
if (isset($_REQUEST['depawal']))
	$depawal=$_REQUEST['depawal'];
if (isset($_REQUEST['tahunajaranawal']))
	$tahunajaranawal=$_REQUEST['tahunajaranawal'];
if (isset($_REQUEST['tingkatawal']))
	$tingkatawal=$_REQUEST['tingkatawal'];
if (isset($_REQUEST['angkatan']))
	$angkatan=$_REQUEST['angkatan'];
if (isset($_REQUEST['nisbaru']))
	$nisbaru=$_REQUEST['nisbaru'];
if (isset($_REQUEST['jenis']))
	$jenis=$_REQUEST['jenis'];
if (isset($_REQUEST['op']))
	$op=$_REQUEST['op'];

$varbaris=10;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];
$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];
$urut = "s.nama";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	
$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$tahun1 = date("Y");
$th = date("Y");
if (isset($_REQUEST['th']))
	$th = $_REQUEST['th'];
$tgl = date("j");
if (isset($_REQUEST['tgl']))
	$tgl = $_REQUEST['tgl'];
$bln = date("n");
if (isset($_REQUEST['bln']))
	$bln = $_REQUEST['bln'];

if ($jenis <> ""){
	$string = "";
	if ($jenis == "text") {			
		if ($namadicari == "")			
			$string = "s.nis LIKE '%$nisdicari%' AND";
		if ($nisdicari == "")
			$string = "s.nama LIKE '%$namadicari%' AND";
		if ($nisdicari <> "" && $namadicari <> "")
			$string = "s.nis LIKE '%$nisdicari%' AND s.nama LIKE '%$namadicari%' AND";
	} else if ($jenis == "combo") {			
		$string = "s.idkelas = $kelas AND";
	} 
} 

$n = JmlHari($bln, $th);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Graduates Student [Select]</title>
<script src="../script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/ajax.js"></script>
<script language="javascript">

function pindah_siswa(nis, idkelas, i) {
	var ket = document.getElementById("ket_"+i).value;
	var nisbaru = document.getElementById("nis_"+i).value;
	
	var tingkattujuan = parent.siswa_lulus_tujuan.document.kanan.tingkat.value;
	var tahunajarantujuan = parent.siswa_lulus_tujuan.document.kanan.tahunajaran.value;
	var kelastujuan = parent.siswa_lulus_tujuan.document.kanan.kelas.value;
	var deptujuan = parent.siswa_lulus_tujuan.document.kanan.departemen.value;
	var angkatantujuan = parent.siswa_lulus_tujuan.document.kanan.angkatan.value;
	
	/*var tingkatawal = parent.siswa_lulus_tujuan.document.kanan.tingkatawal.value;
	var tahunajaranawal = parent.siswa_lulus_tujuan.document.kanan.tahunajaranawal.value;
	var depawal = parent.siswa_lulus_tujuan.document.kanan.depawal.value;
	var depasal = parent.siswa_lulus_tujuan.document.kanan.depasal.value;
	var angkatan = parent.siswa_lulus_tujuan.document.kanan.angkatan.value;
	
	var tingkat = parent.siswa_lulus_menu.document.menu.tingkat.value;
	var tahunajaran = parent.siswa_lulus_menu.document.menu.tahunajaran.value;
	var kelas = parent.siswa_lulus_menu.document.menu.kelas.value;
	var kelasbaru = parent.siswa_lulus_tujuan.document.kanan.kelas.value;
	*/
	var tingkat = document.getElementById('tingkat').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var kelas = document.getElementById('kelas').value;
	var departemen = document.getElementById('departemen').value;
	var tgl = document.getElementById('tgl').value;
	var bln = document.getElementById('bln').value;
	var th = document.getElementById('th').value;
	var pilihan = document.getElementById("pilihan").value;
	var nisdicari = document.getElementById("nisdicari").value;
	var namadicari = document.getElementById("namadicari").value;
	var jenis = document.getElementById("jenis").value;
	
	if (tgl.length == 0) {	
		alert ('Date should not leave empty');	
		document.getElementById('tgl').focus();
		return false;	
	}
	
	if (nisbaru.length == 0) {	
		alert ('Student ID should not leave empty');	
		document.getElementById('nis_'+i).focus();
		return false;	
	}
	
	if (deptujuan.length==0){
		alert ('No higher destination department');
		return false;
	}	
	if (departemen == deptujuan){
		alert ('You should not transfer the student to the same department');
		return false;
	}	
	
	if (tingkattujuan.length==0){
		alert ('No higher destination grade');
		return false;
	}	
	if (tahunajarantujuan.length==0){
		alert ('No Year of Teaching destination');
		return false;
	}
	
	if (kelastujuan.length==0){
		alert ('No active grade or destination class');
		return false;
	}
	
	if (angkatantujuan.length==0){
		alert ('No higher destination graduates nor its active status');
		return false;
	}
	
	if (confirm("Are you sure want to meluluskan this student?")){
		parent.siswa_lulus_tujuan.location.href = "siswa_lulus_tujuan.php?op=x2378e23dkofh73n25ki9234&departemen="+deptujuan+"&departemenawal="+departemen+"&tingkat="+tingkattujuan+"&tahunajaran="+tahunajarantujuan+"&tahunajaranawal="+tahunajaran+"&tingkatawal="+tingkat+"&kelas="+kelastujuan+"&nis="+nis+"&ket="+ket+"&nisbaru="+nisbaru+"&kelasawal="+kelas+"&tgl="+tgl+"&bln="+bln+"&th="+th+"&angkatan="+angkatantujuan;
		refresh_pilih(i);
	}
}

function change_urutan(urut,urutan){
	var nisdicari = document.getElementById("nisdicari").value;
	var namadicari = document.getElementById("namadicari").value;
	var departemen = document.getElementById("departemen").value;
	var tingkat = document.getElementById("tingkat").value;
	var tahunajaran = document.getElementById("tahunajaran").value;
	var kelas = document.getElementById("kelas").value;
	var jenis=document.getElementById("jenis").value;
	
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	
	document.location.href="siswa_lulus_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&urut="+urut+"&urutan="+urutan+"&jenis="+jenis+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function change_page(page) {
	var departemen=document.getElementById("departemen").value;
	var tingkat=document.getElementById("tingkat").value;
	var tahunajaran=document.getElementById("tahunajaran").value;
	var kelas=document.getElementById("kelas").value;
	var nisdicari=document.getElementById("nisdicari").value;
	var namadicari=document.getElementById("namadicari").value;
	var jenis=document.getElementById("jenis").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href = "siswa_lulus_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&jenis="+jenis+"&page="+page+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris+"&hal="+page;
}

function change_hal() {
	var departemen=document.getElementById("departemen").value;
	var tingkat=document.getElementById("tingkat").value;
	var tahunajaran=document.getElementById("tahunajaran").value;
	var kelas=document.getElementById("kelas").value;
	var nisdicari=document.getElementById("nisdicari").value;
	var namadicari=document.getElementById("namadicari").value;
	var jenis=document.getElementById("jenis").value;
	var hal = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="siswa_lulus_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&jenis="+jenis+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

function change_baris() {
	var departemen=document.getElementById("departemen").value;
	var tingkat=document.getElementById("tingkat").value;
	var tahunajaran=document.getElementById("tahunajaran").value;
	var kelas=document.getElementById("kelas").value;
	var nisdicari=document.getElementById("nisdicari").value;
	var namadicari=document.getElementById("namadicari").value;
	var jenis=document.getElementById("jenis").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href= "siswa_lulus_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&jenis="+jenis+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
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

function panggil(elem){
	var lain = new Array('tgl','bln','th');
	for (i=0;i<lain.length;i++) {
		if (lain[i] == elem) {
			document.getElementById(elem).style.background='#4cff15';
		} else {
			document.getElementById(lain[i]).style.background='#FFFFFF';
		}
	}
}

function change_tgl() {
	var th = parseInt(document.getElementById('th').value);
	var bln = parseInt(document.getElementById('bln').value);
	var tgl = parseInt(document.pilih.tgl.value);
	var namatgl = "tgl";
	var namabln = "bln";
	
	sendRequestText("../library/gettanggal.php", show, "tahun="+th+"&bulan="+bln+"&tgl="+tgl+"&namatgl="+namatgl+"&namabln="+namabln);	
}

function show(x) {
	document.getElementById("InfoTgl").innerHTML = x;
}

function refresh_pilih(i) {
	var pilihan=document.getElementById("pilihan").value;
	var departemen=document.getElementById("departemen").value;
	var tingkat=document.getElementById("tingkat").value;
	var tahunajaran=document.getElementById("tahunajaran").value;
	var kelas=document.getElementById("kelas").value;
	var nisdicari=document.getElementById("nisdicari").value;
	var namadicari=document.getElementById("namadicari").value;
	var jenis=document.getElementById("jenis").value;
	var ket = document.getElementById("ket_"+i).value;
	var nisbaru = document.getElementById("nis_"+i).value;

	document.location.href="siswa_lulus_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&urut=<?=$urut?>&urutan=<?=$urutan?>&jenis="+jenis+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>&count="+i+"&ket="+ket+"&nisbaru="+nisbaru;
}
</script>
</head>
<body topmargin="0" leftmargin="0">
<form name="pilih" id="pilih">
<input type="hidden" name="pilihan" id="pilihan" value="<?=$pilihan?>">
<input type="hidden" name="departemen" id="departemen" value="<?=$departemen?>" />
<input type="hidden" name="nisdicari" id="nisdicari" value="<?=$nisdicari?>" />
<input type="hidden" name="namadicari" id="namadicari" value="<?=$namadicari?>" />
<input type="hidden" name="kelas" id="kelas" value="<?=$kelas?>" />
<input type="hidden" name="tingkat" id="tingkat" value="<?=$tingkat?>" />
<input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$tahunajaran?>" />
<input type="hidden" name="jenis" id="jenis" value="<?=$jenis?>" />

<? 	if ($jenis <> ""){ 
		OpenDb();
		$sql_tot = "SELECT s.nis,s.nama,s.idkelas,k.kelas,s.replid,t.tingkat FROM jbsakad.siswa s, kelas k, tingkat t WHERE $string s.idkelas = k.replid AND k.idtahunajaran = '$tahunajaran' AND s.aktif=1 AND k.idtingkat = t.replid AND t.replid = '$tingkat'"; 
		
		$result_tot = QueryDb($sql_tot);
		$total=ceil(mysql_num_rows($result_tot)/(int)$varbaris);
		$jumlah = mysql_num_rows($result_tot);
		$akhir = ceil($jumlah/5)*5;	
		
		$sql_siswa = "SELECT s.nis,s.nama,s.idkelas,k.kelas,s.replid,t.tingkat FROM jbsakad.siswa s, kelas k, tingkat t WHERE $string s.idkelas = k.replid AND k.idtahunajaran = '$tahunajaran' AND s.aktif=1 AND k.idtingkat = t.replid AND t.replid = '$tingkat' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
		
		$result_siswa = QueryDb($sql_siswa);
		if (@mysql_num_rows($result_siswa)>0) {
?>	
<input type="hidden" name="total" id="total" value="<?=$jumlah?>">
<table width="100%" border="0" align="center">
<!-- TABLE CENTER -->
<tr>
	<td>
    	<table border="0" cellspacing="0" cellpadding="0">
        <tr>
        	<td><strong>Date Graduated</strong>&nbsp;</td>
           	<td>
            <div id = "InfoTgl" >
            <select name="tgl" id = "tgl" onChange="change_tgl()" onfocus = "panggil('tgl')" onKeyPress="focusNext('bln',event)">
            <option value="">[Date]</option>
        <? 	for($i=1;$i<=$n;$i++){   ?>      
            <option value="<?=$i?>" <?=IntIsSelected($tgl, $i)?>><?=$i?></option>
        <?	} ?>
            </select>
            </div>
            </td>
            <td>
            <select name="bln" id ="bln" onChange="change_tgl()" onfocus = "panggil('bln')" onKeyPress="focusNext('th',event)">
        <? 	for ($i=1;$i<=12;$i++) { ?>
            <option value="<?=$i?>" <?=IntIsSelected($bln, $i)?>><?=$bulan[$i]?></option>	
        <?	}	?>	
            </select>
            <!--select name="th1" id = "th1" onchange="change_tgl1()" onkeypress="return focusNext('tgl2',event)" onfocus="panggil('th1')" style="width:60px">
              <?  //for($i=$th1-10;$i<=$th1;$i++){ ?>
              <?  for ($i = $tahun1; $i <= $tahun2; $i++) { ?>
              <option value="<?=$i?>" <?=IntIsSelected($th1, $i)?>>
                <?=$i?>
                </option>
              <?	} ?>
            </select-->
            <select name="th" id = "th" onChange="change_tgl()" onfocus = "panggil('th')" onKeyPress="focusNext('nis1',event)" style="width:60px">
        <?  for ($i = $tahun1-5; $i <= $tahun1; $i++) { ?>
            <option value="<?=$i?>" <?=IntIsSelected($th, $i)?>><?=$i?></option>	   
        <?	} ?>	
            </select> 
            </td>
       	</tr>
        </table>
    </td>
</tr>
<tr>
	<td align="left" valign="top">
    <table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left" bordercolor="#000000">
	<tr align="center">
		<td width="6%" height="30" class="header">#</td>
		<td width="15%" height="30" class="header" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('s.nis','<?=$urutan?>')">Student ID <?=change_urut('s.nis',$urut,$urutan)?></td>
		<td width="*" height="30" class="header" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('s.nama','<?=$urutan?>')" >Name <?=change_urut('s.nama',$urut,$urutan)?></td>
		<td height="30" width="14%" class="header" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('k.kelas','<?=$urutan?>')">Class <?=change_urut('k.kelas',$urut,$urutan)?></td>
		<td height="15" width="37%" colspan="2" class="header">Graduation</td>
	</tr>
    <!--<tr>
      	<td width="26%" class="header" align="center">Student ID Baru</td>
        <td width="26%" class="header" align="center">Info</td>
      	<td width="8%" class="header">&nbsp;</td>
    </tr>-->
<?		if ($page==0)
			$cnt = 1;
		else 
			$cnt = (int)$page*(int)$varbaris+1;
		while ($row_siswa=@mysql_fetch_row($result_siswa)){
            $sql_kelas="SELECT replid,kelas FROM jbsakad.kelas WHERE replid='$row_siswa[2]'";
            $result_kelas=QueryDb($sql_kelas);
            $row_kelas=@mysql_fetch_row($result_kelas);
?>
	<tr height="25">
        <td align="center"><?=$cnt?></td>
        <td align="center"><?=$row_siswa[0]?></td>
        <td><a href="#" onClick="newWindow('../library/detail_siswa.php?replid=<?=$row_siswa[4]?>', 'DetailSiswa','800','650','resizable=1,scrollbars=1,status=0,toolbar=0')"><?=$row_siswa[1]?></a></td>
        <td align="center"><?=$row_siswa[5]." - ".$row_siswa[3]?></td>
        <td>
        	<table cellpadding="0" cellspacing="0" border="0">
            <tr>
            	<td width="20%">Student ID </td>
                <td><input type="text" size="15" maxlength="20" id="nis_<?=$cnt?>" name="nis_<?=$row_siswa[0]?>" value="<? if ($_REQUEST['count'] == $cnt) echo $nisbaru?>" onKeyPress="return focusNext('ket_<?=$cnt?>', event)"/>
        		</td>
            </tr>
            <tr>
            	<td width="20%">Info </td>
                <td><input type="text" size="15" maxlength="255" id="ket_<?=$cnt?>" name="ket_<?=$row_siswa[0]?>" onKeyPress="return focusNext('nis_<?=$cnt+1?>', event)" value="<? if ($_REQUEST['count'] == $cnt) echo $ket ?>" />
        		</td>
            </tr>
            </table>    
      	</td>
        <td align="center"><input type="button" class="but" value=" > " onClick="pindah_siswa('<?=$row_siswa[0]?>', <?=$row_siswa[2]?>, <?=$cnt?>)" onMouseOver="showhint('Click for Grade promote', this, event, '80px')" style="height:30px"/></td>
   </tr>
<?			$cnt++;
		}
		
?>
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
    <table border="0"width="100%" align="center" cellpadding="0" cellspacing="0">	
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
    	<<input <?=$disback?> type="button" class="but" name="back" value=" << " onClick="change_page('<?=(int)$page-1?>')" onMouseOver="showhint('Previous', this, event, '75px')">-->
		<?
		/*for($a=0;$a<$total;$a++){
			if ($page==$a){
				echo "<font face='verdana' color='red'><strong>".($a+1)."</strong></font> "; 
			} else { 
				echo "<a href='#' onClick=\"change_page('".$a."')\">".($a+1)."</a> "; 
			}
				 
	    }*/
		?>
	    <!--<input <?=$disnext?> type="button" class="but" name="next" value=" >> " onClick="change_page('<?=(int)$page+1?>')" onMouseOver="showhint('Next', this, event, '75px')">
 		</td-->
        <td width="30%" align="right">Row per page
      	<select name="varbaris" id="varbaris" onChange="change_baris()">
        <? 	for ($m=5; $m <= $akhir; $m=$m+5) { ?>
        	<option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
        <? 	} ?>
       
      	</select></td>
    </tr>
    </table>		
<?			
		} else {
?>
	<table width="100%" border="0" align="center">          
	<tr>
		<td align="center" valign="middle" height="200">

    	<font size = "2" color ="red"><b>Data Not Found. 
        <br />Add Student data on Department <?=$departemen?> in the Student menu on Student Data Collection section.
       	</b></font>
        
		</td>
	</tr>
	</table>
<?		}
	} else {
?>
	<table width="100%" border="0" align="center">          
	<tr>
		<td align="center" valign="middle" height="200">    	  	
    	<font size="2" color="#757575"><b>Click on Show or Search to
      show student graduates candidate list</b></font>
 	</td>
	</tr>
	</table>
<? 	} ?>
	</td>
</tr>
</table>
</form>
<!-- Tamplikan error jika ada -->
<? if (strlen($ERROR_MSG) > 0) { ?>
<script language="javascript">
	alert('<?=$ERROR_MSG?>');
</script>
<? } ?>
</body>
</html>
<script language="javascript">
	var page = document.getElementById('hal').value;
	var varbaris = document.getElementById('varbaris').value;
	var total = document.getElementById('total').value;
	var i, x;
	if (page == 0)
		x = 1;
	else 
		x = parseInt(page)*parseInt(varbaris)+1;
		
	for (i=x;i<=total;i++)	{
		var sprytextfield1 = new Spry.Widget.ValidationTextField("nis_"+i);
		var sprytextfield1 = new Spry.Widget.ValidationTextField("ket_"+i);
	}
</script>