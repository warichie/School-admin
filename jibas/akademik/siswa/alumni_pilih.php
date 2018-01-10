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
$jenis="xxxx";
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

$string = "";
if ($pilihan == 1) {			
	if ($namadicari == "")			
		$string = " s.nis LIKE '%$nisdicari%' AND ";
	if ($nisdicari == "")
		$string = " s.nama LIKE '%$namadicari%' AND ";
	if ($nisdicari <> "" && $namadicari <> "")
		$string = " s.nis LIKE '%$nisdicari%' OR s.nama LIKE '%$namadicari%' AND ";
} else if ($pilihan == 2) {			
	$string = " s.idkelas = $kelas AND ";
} 
//echo $pilihan."_".$nisdicari."_".$namadicari."_".$kelas."_".$string; 

$n = JmlHari($bln, $th);	
	
OpenDb();	
$sql="SELECT YEAR(tgllulus) AS tahun FROM alumni WHERE departemen='$departemen' GROUP BY tahun ORDER BY tahun DESC";
$result=QueryDb($sql);
 

if (isset($_REQUEST['alumnikan'])){
	$thn=$_REQUEST['th'];
	$bln=$_REQUEST['bln'];
	$tgl=$_REQUEST['tgl'];
	$tgllulus=$thn."-".$bln."-".$tgl;

	$jumalumni=(int)$_REQUEST['total'];
	for ($ialumni=1;$ialumni<=$jumalumni;$ialumni++){
		$nis=$_REQUEST["nis".$ialumni];
		$cek=$_REQUEST["ceknis".$ialumni];
		
		if ($nis && $cek) {
			OpenDb();
			$sql1="SELECT k.replid, k.idtingkat FROM jbsakad.siswa s, jbsakad.kelas k WHERE s.nis='$nis' AND s.idkelas = k.replid";
			
			$result1=QueryDb($sql1);
			$row1=@mysql_fetch_array($result1);
			$idtingkat = $row1['idtingkat'];
			$idkelas = $row1['replid'];
			
			BeginTrans();
			$success=0;
			//nonaktifkan siswa sekaligus alumnikan siswa
			$sql_siswa="UPDATE jbsakad.siswa SET aktif=0, alumni=1 WHERE nis='$nis'";
			QueryDbTrans($sql_siswa, $success);
			//$result_siswa=QueryDb($sql_siswa);
			
			//nonaktifkan nis di riwayatkelas
			if ($success) {	
				$sql_kelas="UPDATE jbsakad.riwayatkelassiswa SET aktif=0 WHERE nis='$nis' AND aktif=1";
				QueryDbTrans($sql_kelas,$success);
			}
			//nonaktifkan nis di riwayatdept
			if ($success) {
				$sql_dept="UPDATE jbsakad.riwayatdeptsiswa SET aktif=0 WHERE nis='$nis' AND aktif=1";
				QueryDbTrans($sql_dept,$success);
			}
			
			if ($success){
			//isi tabel alumni
				$sql_alumni="INSERT INTO jbsakad.alumni SET nis='$nis', tgllulus='$tgllulus', tktakhir='$idtingkat', klsakhir='$idkelas', departemen = '$departemen'";
				QueryDbTrans($sql_alumni,$success);
				
			}
			
			if ($success) {
				CommitTrans(); 
			?>
				<script language="javascript">
					parent.alumni_content.location.href="alumni_content.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>&tahun=<?=$th?>";
				</script>	
			<? 
			} else  {
				RollbackTrans();
			}
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Graduates Student [Select]</title>
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/ajax.js"></script>
<script language="javascript">

function change_urutan(urut,urutan){
	var jenis=document.getElementById("jenis").value;
	var nisdicari = document.getElementById("nisdicari").value;
	var namadicari = document.getElementById("namadicari").value;
	var departemen = document.getElementById("departemen").value;
	var tingkat = document.getElementById("tingkat").value;
	var tahunajaran = document.getElementById("tahunajaran").value;
	var kelas = document.getElementById("kelas").value;
	
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	
	document.location.href="alumni_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&urut="+urut+"&urutan="+urutan+"&jenis="+jenis+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
	
}

function cek_all() {
	var x;
	var jum = document.pilih.total.value;
	var ceked = document.pilih.cek.checked;
	for (x=1;x<=jum;x++){
		if (ceked==true){
			document.getElementById("ceknis"+x).checked=true;
		} else {
			document.getElementById("ceknis"+x).checked=false;
		}
	}
}

function alumnikeun() {
	var jumalumni=0;
	var jum = document.pilih.total.value;
	var tgl = document.getElementById('tgl').value;
	for (x=1;x<=jum;x++){
		var nis=document.getElementById("ceknis"+x).checked;
		if (nis == 1){
			jumalumni++;	
		}
	}
	
	if (tgl.length == 0) {	
		alert ('Date should not leave empty');	
		document.getElementById('tgl').focus();
		return false;	
	}
		
	if (jumalumni==0) {
		alert ("You have to select at least one student to be alumni");
		return false;
	} else if (jumalumni > 0) {
		if (confirm("Are you sure want to make the student selected to be an alumni?"))
			return true;
		else
			return false;	
	}
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
	
	document.location.href = "alumni_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&jenis="+jenis+"&page="+page+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris+"&hal="+page;
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
	
	document.location.href="alumni_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&jenis="+jenis+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
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
	
	document.location.href= "alumni_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&jenis="+jenis+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
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

function refresh_pilih() {
	var pilihan=document.getElementById("pilihan").value;
	var departemen=document.getElementById("departemen").value;
	var tingkat=document.getElementById("tingkat").value;
	var tahunajaran=document.getElementById("tahunajaran").value;
	var kelas=document.getElementById("kelas").value;
	var nisdicari=document.getElementById("nisdicari").value;
	var namadicari=document.getElementById("namadicari").value;
	var jenis=document.getElementById("jenis").value;
		
	document.location.href="siswa_kenaikan_pilih.php?tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&nisdicari="+nisdicari+"&namadicari="+namadicari+"&departemen="+departemen+"&kelas="+kelas+"&urut=<?=$urut?>&urutan=<?=$urutan?>&jenis="+jenis+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

</script>
</head>
<body topmargin="0" leftmargin="0">
<form name="pilih" id="pilih" onSubmit="return alumnikeun()">
<input type="hidden" name="pilihan" id="pilihan" value="<?=$pilihan?>">
<input type="hidden" name="departemen" id="departemen" value="<?=$departemen?>" />
<input type="hidden" name="nisdicari" id="nisdicari" value="<?=$nisdicari?>" />
<input type="hidden" name="namadicari" id="namadicari" value="<?=$namadicari?>" />
<input type="hidden" name="kelas" id="kelas" value="<?=$kelas?>" />
<input type="hidden" name="tingkat" id="tingkat" value="<?=$tingkat?>" />
<input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$tahunajaran?>" />
<input type="hidden" name="jenis" id="jenis" value="<?=$jenis?>" />

<?
if ($jenis <> ""){ 
	OpenDb();
	$sql_tot = "SELECT s.nis,s.nama,s.idkelas,k.kelas,s.replid,t.tingkat FROM jbsakad.siswa s, kelas k, tingkat t WHERE $string s.idkelas = k.replid AND k.idtahunajaran = '$tahunajaran' AND s.aktif=1 AND k.idtingkat = t.replid AND t.replid = '$tingkat'"; 
	//echo $sql_tot;
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
            <select name="th" id = "th" onChange="change_tgl()" onfocus = "panggil('th')" style="width:60px">
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
		<td width="6%" height="30" rowspan="2" class="header">#</td>
		<td width="15%" height="30" rowspan="2" class="header" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('s.nis','<?=$urutan?>')">Student ID <?=change_urut('s.nis',$urut,$urutan)?></td>
		<td width="*" height="30" rowspan="2" class="header" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('s.nama','<?=$urutan?>')" >Name <?=change_urut('s.nama',$urut,$urutan)?></td>
		<td height="30" width="20%"rowspan="2" class="header" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('k.kelas','<?=$urutan?>')">Class <?=change_urut('k.kelas',$urut,$urutan)?></td>
		<td height="15" colspan="2" class="header">Alumni</td>
	</tr>
	<tr>
  		<td width="11%" class="header" colspan="2">
  		<input type="checkbox" name="cek" id="cek" onClick="cek_all()" onMouseOver="showhint('Select All', this, event, '80px')"/>
		</td>
	</tr>
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
        <td align="center">
            <input type="checkbox" name="ceknis<?=$cnt?>" id="ceknis<?=$cnt?>" value="1"/>
            <input type="hidden" name="nis<?=$cnt?>" id="nis<?=$cnt?>" value="<?=$row_siswa[0]?>" />
            <!--<input type="hidden" name="alumni<?=$cnt?>" id="alumni<?=$cnt?>"/>-->
        </td>
        <? if ($cnt==1){ ?>
        <td rowspan="<?=$jumlah?>" align="center">
            <input name="alumnikan" id="alumnikan" type="submit" class="but" value=" > " onMouseOver="showhint('Make this student an alumni', this, event, '120px')"/>
        </td>
        <? } ?>
<? //if ($cnt<=1){ ?>
<!--<td style="background-color:#C0C0C0" align="center" rowspan="<?=$ada?>" bgcolor="white"><input name="alumnikan" id="alumnikan" type="submit" class="but" value=" >> " onMouseOver="showhint('Make this student an alumni', this, event, '120px')"/></td>-->
<? //} ?>
	</tr>
<?		$cnt++;
	}
?>
<!--<input type="hidden" name="numsiswa" id="numsiswa" value="<?=$cnt-1?>" />-->
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
       	<td width="45%" align="left">Page
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
    	<td align="center">
    	<!--<input <?=$disback?> type="button" class="but" name="back" value=" << " onClick="change_page('<?=(int)$page-1?>')" onMouseOver="showhint('Previous', this, event, '75px')">-->
		<?
		/*for($a=0;$a<$total;$a++){
			if ($page==$a){
				echo "<font face='verdana' color='red'><strong>".($a+1)."</strong></font> "; 
			} else { 
				echo "<a href='#' onClick=\"change_page('".$a."')\">".($a+1)."</a> "; 
			}
				 
	    }*/
		?>
	    <!--<input <?=$disnext?> type="button" class="but" name="next" value=" >> " onClick="change_page('<?=(int)$page+1?>')" onMouseOver="showhint('Next', this, event, '75px')">-->
 		</td>
        <td width="45%" align="right">Row per page
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
      to show alumni student list</b></font>
 	</td>
	</tr>
	</table>
<? 	} ?>
	</td>
</tr>
</table>
</form>
</body>
</html>