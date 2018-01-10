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

$replid = $_REQUEST['replid'];

OpenDb();
$sql="SELECT c.nopendaftaran, c.nama, c.panggilan, c.tahunmasuk, c.idproses, c.idkelompok, c.suku, c.agama, c.status, c.kondisi as kondisi, c.kelamin, c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.warga, c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa, c.telponsiswa, c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, c.almayah, c.almibu, c.pendidikanayah, c.pendidikanibu, c.pekerjaanayah, c.pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu, c.alamatortu, c.telponortu, c.hportu, c.emailortu, c.alamatsurat, c.keterangan, p.replid AS proses, p.departemen, p.kodeawalan, k.replid AS kelompok FROM calonsiswa c, kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.replid=$replid AND p.replid = c.idproses AND k.replid = c.idkelompok AND p.replid = k.idproses";

$result=QueryDB($sql);
CloseDb();
$row_siswa = mysql_fetch_array($result); 

$departemen = $row_siswa['departemen'];
$proses=$row_siswa['proses'];
$kelompok=$row_siswa['kelompok'];
$no = $row_siswa['nopendaftaran'];

$tahunmasuk = $row_siswa['tahunmasuk'];
$blnlahir = (int)$row_siswa['bulan'];
$thnlahir = (int)$row_siswa['tahun'];

/*OpenDb();
$query = "SELECT urutan FROM jbsakad.departemen WHERE departemen = '$departemen'";	
$hasil = QueryDb($query);	
CloseDb();
$row = mysql_fetch_array($hasil);
$urutan = $row['urutan'];
*/

if ($row_siswa['asalsekolah'] <> NULL) {
	OpenDb();
	$query = "SELECT departemen FROM asalsekolah WHERE sekolah = '$row_siswa[asalsekolah]'";
	$hasil = QueryDb($query);	
	CloseDb();
	$row = mysql_fetch_array($hasil);
	$dep_asal = $row['departemen'];
	$sekolah = $row_siswa['asalsekolah'];
} else {	
	$dep_asal = "";
	$sekolah = "";
}




if ($blnlahir == 4 || $blnlahir == 6|| $blnlahir == 9 || $blnlahir == 11 ) 
	$n = 30;
else if ($blnlahir == 2 && $thnlahir % 4 <> 0) 
	$n = 28;
else if ($blnlahir == 2 && $thnlahir % 4 == 0) 
	$n = 29;
else 
	$n = 31;

OpenDb();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Edit Student Candidate]</title>
<script src="../script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../script/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="../script/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../script/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/ajax.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">

function validate() {
	var urutananak=document.main.urutananak.value;
	var jumlahanak=document.main.jumlahanak.value;
	var kodepos=document.main.kodepos.value;
	var telponsiswa=document.main.telponsiswa.value;
	var hpsiswa=document.main.hpsiswa.value;	
	var berat=document.getElementById('berat').value;
	var tinggi=document.main.tinggi.value;
	var penghasilanayah=document.main.penghasilanayah.value;
	var penghasilanibu=document.main.penghasilanibu.value;
	var telponortu=document.main.telponortu.value;
	var hportu=document.main.hportu.value;
	var emailsiswa = document.main.emailsiswa.value;
	var emailortu = document.main.emailortu.value;
	var tgllahir = document.getElementById("tgllahir").value;
	var blnlahir = document.getElementById("blnlahir").value;
	var thnlahir = document.getElementById("thnlahir").value;
	var nama = document.main.nama.value;
	var tmplahir = document.main.tmplahir.value;
	//var kapasitas = document.main.kapasitas.value;
	//var isi = document.main.isi.value;
	var kelompok = document.main.kelompok.value;
	var kel_lama = document.main.kel_lama.value;
	var agama = document.main.agama.value;
	var suku = document.main.suku.value;
	var status = document.main.status.value;
	var kondisi = document.main.kondisi.value;
	
	if (nama.length == 0) {
		alert("You must enter a data for Name");
		document.getElementById('nama').focus();
		return false;
	}
	
	if (tmplahir.length == 0) {
		alert("You must enter a data for Birth Place");
		document.getElementById('tmplahir').focus();
		return false;
	}
	
	if (tgllahir == "") {
       	alert("You must enter a data for Date of Birth");
		document.main.tgllahir.focus();
        return false;
   	}
	
	if (blnlahir == "") {
       	alert("You must enter a data for Month of Birth");
		document.main.blnlahir.focus();
        return false;
   	}
	
	if (thnlahir == "") {
       	alert("You must enter a data for Year of Birth");
		document.main.thnlahir.focus();
        return false;
   	}
	
	if (thnlahir.length > 0){	
		if(isNaN(thnlahir)) {
    		alert ('Year of Birth data must be numeric');
			document.main.thnlahir.value="";
			document.main.thnlahir.focus();
        	return false;
		}
		if (thnlahir.length > 4 || thnlahir.length < 4) {
        	alert("Year of Birth should not more or less than 4 characters"); 
			document.main.thnlahir.focus();
        return false;
    	}
    }
	
	
	if(agama.length == 0) {
       	alert("You must enter a data for student candidate Religion");
		document.main.agama.focus();
        return false;
   	}
	
	if(suku.length == 0) {
       	alert("You must enter a data for student candidate Ethnicity");
		document.main.suku.focus();
        return false;
   	}
	
	if(status.length == 0) {
       	alert("You must enter a data for student candidate Status");
		document.main.status.focus();
        return false;
   	}
	
	if(kondisi.length == 0) {
       	alert("You must enter a data for student candidate Conditions");
		document.main.kondisi.focus();
        return false;
   	}
		
	if (urutananak.length > 0){
		if(isNaN(urutananak)) {
			alert ('Child # must be numeric');
			document.main.urutananak.value="";
			document.main.urutananak.focus();
			return false;
		}
		if (jumlahanak.length == 0) {
			alert("Siblings should not leave empty");
			document.getElementById('jumlahanak').focus();
			return false;
		}
	}

	if (jumlahanak.length > 0){
		if(isNaN(jumlahanak)) {
			alert ('Siblings must be numeric');
			document.getElementById('jumlahanak').value="";
			document.getElementById('jumlahanak').focus();
			return false;
		} 
		
		if (urutananak.length == 0) {
			alert("Child # should not leave empty");
			document.getElementById('urutananak').focus();
			return false;
		}
	}

	if (parseInt(urutananak) > parseInt(jumlahanak)) {
		alert ('Child # should not exceed the existing siblings data');
		document.getElementById ('urutananak').focus();
		return false;
	}
		
	if (kodepos.length > 0){
		if(isNaN(kodepos)) {
			alert ('Post Code data must be numeric');
			document.getElementById('kodepos').value="";
			document.getElementById('kodepos').focus();
			return false;
		}
	}	

	if (telponsiswa.length > 0){
		if(isNaN(telponsiswa)) {
			alert ('Phone data must be numeric');
			document.getElementById('telponsiswa').value="";
			document.getElementById('telponsiswa').focus();
			return false;
		}
	}
		
	if (hpsiswa.length > 0){
		if(isNaN(hpsiswa)) {
			alert ('Mobile phone data must be numeric');
			document.getElementById('hpsiswa').value="";
			document.getElementById('hpsiswa').focus();
			return false;
		}
	}	
	
	if (berat.length > 0){
		if(isNaN(berat)) {
			alert ('Body Weight data must be numeric');
			document.getElementById('berat').value=0;
			document.getElementById('berat').focus();
			return false;
		}
	}		

	if (tinggi.length > 0){
		if(isNaN(tinggi)) {
			alert ('Body Height data must be numeric');
			document.getElementById('tinggi').value="";
			document.getElementById('tinggi').focus();
			return false;
		}
	}	
	
	if (penghasilanayah.length > 0){
		if(isNaN(penghasilanayah)) {
			alert ('Father income data must be numeric');
			document.getElementById('penghasilanayah').value="";
			document.getElementById('penghasilanayah').focus();
			return false;
		}
	}	
		
	if (penghasilanibu.length > 0){
		if(isNaN(penghasilanibu)) {
			alert ('Mother income data must be numeric');
			document.getElementById('penghasilanibu').value="";
			document.getElementById('penghasilanibu').focus();
			return false;
		}
	}

	if (telponortu.length > 0){
		if(isNaN(telponortu)) {
			alert ('Parent phone data must be numeric');
			//document.getElementById('telponortu').value="";
			document.getElementById('telponortu').focus();
			return false;
		}
	}
	
	if (hportu.length > 0){
		if(isNaN(hportu)) {
			alert ('Parent mobile phone data must be numeric');
			//document.getElementById('hportu').value="";
			document.getElementById('hportu').focus();
			return false;
		}
	}
	
	if (emailsiswa.length > 0) {
		//return validateEmail('emailsiswa');		
	}
	
	if (emailortu.length > 0) {
		//return validateEmail('emailortu');		
	}
	/*	
	if (kapasitas == isi && kelompok != kel_lama) {
		alert("Group Capacity is not enought to add new candidate data");
		document.getElementById('kelompok').focus();
		return false;	
	}*/
		
	if (thnlahir.length != 0 && blnlahir.length != 0 && tgllahir.length != 0){
	if (thnlahir % 4 == 0){
		 if (blnlahir == 2){
			  if (tgllahir>29){
				   alert ('Sorry, please re-enter the Date of Birth data');
				   sendRequestText("../library/gettanggal.php", show1, "tahun="+thnlahir+"&bulan="+blnlahir+"&tgl="+tgllahir);	
				   document.getElementById("tgllahir").focus();
				   return false;
			  }
		 }
		 if (blnlahir != 2 || blnlahir != 4 || blnlahir != 6 || blnlahir != 9 || blnlahir != 11){
			  if (tgllahir>30){
				   alert ('Sorry, please re-enter the Date of Birth data');
				   sendRequestText("../library/gettanggal.php", show1, "tahun="+thnlahir+"&bulan="+blnlahir+"&tgl="+tgllahir);	
				   document.getElementById("tgllahir").focus();
				   return false;
			  }
		 }
	}
	if (thnlahir % 4 != 0){
		 if (blnlahir == 2){
			 if (tgllahir>28){
				   alert ('Sorry, please re-enter the Date of Birth data');
				   sendRequestText("../library/gettanggal.php", show1, "tahun="+thnlahir+"&bulan="+blnlahir+"&tgl="+tgllahir);	
				   document.getElementById("tgllahir").focus();
				   return false;
				   
			  }
		 }
		 if (blnlahir != 2 || blnlahir != 4 || blnlahir != 6 || blnlahir != 9 || blnlahir != 11){
			  if (tgllahir>30){
				   alert ('Sorry, please re-enter the Date of Birth data');
				   sendRequestText("../library/gettanggal.php", show1, "tahun="+thnlahir+"&bulan="+blnlahir+"&tgl="+tgllahir);	
				   document.getElementById("tgllahir").focus();
				   return false;
				   
			  }
		 }
	}
	
}

function sekolah_kiriman(sekolah, dep) {	
	var dep_asal = document.getElementById("dep_asal").value;
	if (dep_asal == dep) {
		change_departemen(sekolah);
	} else {
		setTimeout("change_departemen(0)",1);
	}
}

function change_departemen(kode) {		
	var dep_asal = document.getElementById("dep_asal").value;
	wait_sekolah();
	if (kode==0){
		sendRequestText("../siswa/siswa_add_getsekolah.php", showSekolah, "dep_asal="+dep_asal);		
	} else {		
		sendRequestText("../siswa/siswa_add_getsekolah.php", showSekolah, "dep_asal="+dep_asal+"&sekolah="+kode);
	}
}

function wait_sekolah() {
	show_wait("sekolahInfo");
}
function show_wait(areaId) {
	var x = document.getElementById("waitBox").innerHTML;
	document.getElementById(areaId).innerHTML = x;
}
function showSekolah(x) {
	document.getElementById("sekolahInfo").innerHTML = x;
}
function refresh_delete_sekolah(){
	setTimeout("change_departemen(0)",1);
}

function tambah_suku(){
	newWindow('../library/suku.php', 'tambahSuku','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_agama(){
	newWindow('../library/agama.php', 'tambahAgama','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_status(){
	newWindow('../siswa/siswa_add_status.php', 'tambahStatus','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_kondisi(){
	newWindow('../siswa/siswa_add_kondisi.php', 'tambahKondisi','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_asal_sekolah(){
	var departemen = document.getElementById("dep_asal").value;
	newWindow('../siswa/siswa_add_asalsekolah.php?departemen='+departemen, 'tambahAsalSekolah','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_pendidikan(){
	newWindow('../siswa/siswa_add_pendidikan.php', 'tambahPendidikan','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_pekerjaan(){
	newWindow('../siswa/siswa_add_pekerjaan.php', 'tambahPekerjaan','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function tutup(){
	var departemen = document.getElementById('departemen').value;
	var proses = document.getElementById('proses').value;	
	var kelompok = document.getElementById('kelompok').value;
	parent.opener.location.href = "calon_content.php?departemen="+departemen+"&proses="+proses+"&kelompok="+kelompok;
	window.close();
}

function ambil_alamat_ortu(){
	var alamatsiswa = document.getElementById("alamatsiswa").value;
	document.getElementById("alamatortu").value=alamatsiswa;
}

function ambil_alamat_surat(){
	var alamatsiswa = document.getElementById("alamatsiswa").value;
	document.getElementById("alamatsurat").value=alamatsiswa;
}

//Ajax suku ==========================================================
function suku_kiriman(suku_kiriman) {	
	suku = suku_kiriman
	//suku_kiriman2=suku_kiriman;
	setTimeout("refresh_suku(suku)",1);
}
function refresh_suku(kode){
	wait_suku();
	if (kode==0){
		sendRequestText("../library/getsuku.php", showSuku, "suku=");
	} else {
		sendRequestText("../library/getsuku.php", showSuku, "suku="+kode);
	}
}
function wait_suku() {
	show_wait("InfoSuku");
}
function showSuku(x) {
	document.getElementById("InfoSuku").innerHTML = x;
}
function refresh_delete(){
	setTimeout("refresh_suku(0)",1);
}
// end of Ajax Suku ====================================================

//ajax Agama============================================================
function kirim_agama(agama_kiriman){
	agama=agama_kiriman;
	setTimeout("refresh_agama(agama)",1);
}
function refresh_agama(kode){
	wait_agama();
	if (kode==0){
		sendRequestText("../library/getagama.php", showAgama, "agama=");
	} else {
		sendRequestText("../library/getagama.php", showAgama, "agama="+kode);
	}
}
function wait_agama() {
	show_wait("InfoAgama");
}
function showAgama(x) {
	document.getElementById("InfoAgama").innerHTML = x;
}
function ref_del_agama(){
	setTimeout("refresh_agama(0)",1);
}
// end of Ajax agama=====================================================

//------- Ajax Status====================================================
function status_kiriman(st){
	refresh_status(st);
	//setTimeout("refresh_status(st)",1);
}
function refresh_status(kode) {
	wait_status();
	if (kode==0) {
		sendRequestText("../siswa/siswa_add_getstatus.php", show_status,"status=");
	} else {
		sendRequestText("../siswa/siswa_add_getstatus.php", show_status,"status="+kode);
	}
}
function wait_status() {
	show_wait("InfoStatus"); //lihat div id 
}
function show_status(x) {
	document.getElementById("InfoStatus").innerHTML = x;
}
function ref_del_status(){
	setTimeout("refresh_status(0)",1);
}
// End of Ajax Status===================================================

//====== Ajax Conditions ==================================================
function kondisi_kiriman(kondisi){	
	refresh_kondisi(kondisi);
	//setTimeout("refresh_kondisi(kon)",1);
}
function refresh_kondisi(kode) {	
	wait_kondisi();	
	if (kode==0){
		sendRequestText("../siswa/siswa_add_getkondisi.php", show_kondisi,"kondisi=");
	} else {
		sendRequestText("../siswa/siswa_add_getkondisi.php", show_kondisi,"kondisi="+kode);
	}
}
function wait_kondisi() {
	show_wait("InfoKondisi"); //lihat div id 
}
function show_kondisi(x) {
	document.getElementById("InfoKondisi").innerHTML = x;
}
function ref_del_kondisi(){
	setTimeout("refresh_kondisi(0)",1);
}
//======End of Ajax Conditions==============================================

//====Ajax pendidikan====================================================
function pendidikan_kiriman(pendidikan){
	refresh_pendidikan(pendidikan);
	//pendidikan=pendidikan_kiriman;
	//setTimeout("refresh_pendidikan(pendidikan)",1);
}

function refresh_pendidikan(kode_pendidikan) {	
	if (kode_pendidikan==0) {
		sendRequestText("../siswa/siswa_add_getpendidikan.php", show_pendidikan,"pendidikan=");
	} else {
		sendRequestText("../siswa/siswa_add_getpendidikan.php", show_pendidikan,"pendidikan="+kode_pendidikan);
	}
}

function show_pendidikan(x) {
	document.getElementById("Infopendidikanibu").innerHTML = x;
	document.getElementById("Infopendidikanayah").innerHTML = x;	
}

function ref_del_pendidikan() {
	setTimeout("refresh_pendidikan(0)",1);
}
//=======End Of ajax pendidikan==========================================

//========Ajax Occupation ================================================
function pekerjaan_kiriman(kerja){
	refresh_pekerjaan(kerja);
	//setTimeout("refresh_pekerjaan(pekerjaan)",1);
}

function refresh_pekerjaan(kode_pekerjaan) {
	if(kode_pekerjaan==0){
		sendRequestText("../siswa/siswa_add_getpekerjaan.php", show_pekerjaan,"pekerjaan=");
	} else {
		sendRequestText("../siswa/siswa_add_getpekerjaan.php", show_pekerjaan,"pekerjaan="+kode_pekerjaan);
	}
}

function show_pekerjaan(x) {
	document.getElementById("Infopekerjaanibu").innerHTML = x;
	document.getElementById("Infopekerjaanayah").innerHTML = x;
}

function ref_del_pekerjaan(){
	setTimeout("refresh_pekerjaan(0)",1);
}
//======== End Of Ajax Occupation ========================================

function change_alamat(){	
	var alamatsiswa = document.getElementById("alamatsiswa").value;
	document.getElementById("alamatortu").value=alamatsiswa;
	document.getElementById("alamatsurat").value=alamatsiswa;
}


function change_bln() {	
	alert ('Masuk');
	var thn = document.getElementById('thnlahir').value;
	var bln = parseInt(document.getElementById('blnlahir').value);	
	var tgl = parseInt(document.getElementById('tgllahir').value);
	
	if(thn.length != 0) {
    	if(isNaN(thn)) {
    		alert("Year of Birth should be numeric"); 
			document.getElementById('thnlahir').focus();
        	return false;
		} else {	
			if (thn.length > 4 || thn.length < 4) {
            	alert("Year of Birth should not more or less than 4 characters"); 
				document.getElementById('thnlahir').focus();
            	return false;
			}
		}
    
	sendRequestText("../library/gettanggal.php", show1, "tahun="+thn+"&bulan="+bln+"&tgl="+tgl);
	//alert ('Sorry, please re-enter Date of Birth');
	//document.getElementById("tgllahir").focus();
	}/**/
}
function show1(x) {
	document.getElementById("tgllahir").innerHTML = x;
}

function tampil_kelompok() {
	var departemen = document.getElementById("departemen").value;
	var proses = document.getElementById("proses").value;
	
	newWindow('kelompok_tampil.php?departemen='+departemen+'&proses='+proses,'tampilKelompok','750','425','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function kelompok_kiriman(a,b,c) {	
	var departemen = document.getElementById("departemen").value;	
	change_kelompok(a,b,c);
}

function change_kelompok(kel,pro,dep) {
	var departemen = document.getElementById("departemen").value;
	var proses = document.getElementById("proses").value;
	var kelompok = document.getElementById("kelompok").value;	
	
	if (kel == 0) {
		change_kel()
		//parent.header.location.href = "calon_header.php?kelompok="+kelompok+"&proses="+proses+"&departemen="+departemen;
	} else {
		sendRequestText("getdepartemen.php", show_dep,"departemen="+dep);
		sendRequestText("getproses.php", show_proses,"departemen="+dep);
		sendRequestText("getkelompok.php", show_kelompok,"departemen="+dep+"&kelompok="+kel);	
		//wait_asal();
		sendRequestText("getasalsekolah.php", show_asalsekolah,"departemen="+dep);
				
		//parent.header.location.href = "calon_header.php?kelompok="+kel+"&proses="+proses+"&departemen="+departemen;
	}
	
}

function change_dep() {
	//wait_dep();
	var departemen = document.getElementById("departemen").value;
	sendRequestText("getproses.php", show_proses,"departemen="+departemen);
	sendRequestText("getkelompok.php", show_kelompok,"departemen="+departemen);	
	//wait_asal();
	//sendRequestText("getsekolah1.php", showSekolah1, "departemen="+departemen);	
	sendRequestText("getasalsekolah1.php", show_asalsekolah,"departemen="+departemen);	
		
}

function showSekolah1(x) {
	document.getElementById("sekolahInfo").innerHTML = x;
}

function change_kel() {
	//wait_ket();
	var kelompok = document.getElementById("kelompok").value;	
	//alert ('kelompok '+kelompok);
	sendRequestText("getketerangan.php", show_keterangan,"kelompok="+kelompok);
}

function show_dep(x) {
	document.getElementById("InfoDepartemen").innerHTML = x;
}
	
function show_proses(x) {
	document.getElementById("InfoProses").innerHTML = x;
}

function show_kelompok(x) {

	document.getElementById("InfoKelompok").innerHTML = x;
	change_kel();
}

function show_keterangan(x) {
	document.getElementById("InfoKeterangan").innerHTML = x;
}

function wait_asal() {
	show_wait("InfoSekolah"); //lihat div id 
}

function show_asalsekolah(x) {	
	document.getElementById("InfoSekolah").innerHTML = x;
	change_departemen(0);
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
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" onLoad="document.getElementById('nama').focus()">
<div id="waitBox" style="position:absolute; visibility:hidden;">
<img src="../images/movewait.gif" border="0" />Please wait...
</div>

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
	<form name="main" method="post" action="calon_simpan.php" onsubmit="return validate()" enctype="multipart/form-data">
	<input type="hidden" name="replid" id="replid" value="<?=$replid?>">
	<input type="hidden" name="action" id="action" value="edit">
    <input type="hidden" name="kel_lama" id="kel_lama" value="<?=$kelompok?>">

<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr height="25">
	<td class="header" colspan="2" align="center">Edit Student Candidate Data</td>
</tr>
<tr>
	<td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr>
    	<td>
       	<table width="96%" border="1" >
 		<tr>
    		<td width="27%"><strong>Department</strong></td>
    		<td width="*"><div id="InfoDepartemen">
            <select name="departemen" id="departemen" onchange="change_dep()" style="width:250px">
              <?	$dep = getDepartemen(SI_USER_ACCESS());    
				foreach($dep as $value) {
					if ($departemen == "")
						$departemen = $value; ?>
              <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> >
              <?=$value ?>
              </option>
              <?	} ?>
            </select>
            </div>
            </td>          
  		</tr>
  		
        <tr>
        	<td><strong>Admission Process</strong></td>
    		<td><div id="InfoProses">
            <?	$sql = "SELECT replid,proses FROM prosespenerimaansiswa WHERE aktif=1 AND departemen='$departemen'";				
				$result = QueryDb($sql);				
				$row = mysql_fetch_array($result);
				$proses = $row['replid'];
			?>
            <input type="text" name="nama_proses" id="nama_proses" style="width:240px;" class="disabled" value="<?=$row['proses']?>" readonly />
            <input type="hidden" name="proses" id="proses"  value="<?=$proses?>" />
            	</div>            </td>
  		</tr>
  		<tr>
    		<td><strong>Student Candidate Group</strong></td>
    		<td>
            	<div id = "InfoKelompok">
            	<select name="kelompok" id="kelompok" onchange="change_kel()" style="width:250px">
   		 	<?	
				$sql = "SELECT replid,kelompok,kapasitas FROM kelompokcalonsiswa WHERE idproses = $proses ORDER BY kelompok";
				$result = QueryDb($sql);
				
				while ($row = @mysql_fetch_array($result)) {
					if ($kelompok == "")
						$kelompok = $row['replid'];
										
					$sql1 = "SELECT COUNT(replid) FROM calonsiswa WHERE idkelompok = $row[replid]";
					$result1 = QueryDb($sql1);				
					$row1 = mysql_fetch_row($result1);
					
			?>
    			<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $kelompok)?> ><?=$row['kelompok'].', kapasitas: '.$row['kapasitas'] .', terisi: '.$row1[0]?>
                </option>
    		<?
				//$cnt++; 
				}	
    		?>
    			</select>&nbsp;<img src="../images/ico/tambah.png" onclick="tampil_kelompok();" onMouseOver="showhint('Add Group', this, event, '60px')" />            	
                	
                </div>  
           	</td>
  		</tr>
  		<tr>
    		<td valign="top"><strong>Info</strong></td>
    		<td>
            	<div id = "InfoKeterangan">
			<?	OpenDb();
				$sql = "SELECT keterangan FROM kelompokcalonsiswa WHERE replid = $kelompok";
				$result = QueryDb($sql);
				CloseDb();
				$row = @mysql_fetch_array($result);			
			?>
              <textarea name="keterangan" id="keterangan" rows="2" cols="60" readonly style="background-color:#E5F7FF" ><?=$row['keterangan'] ?>
              </textarea>
            	</div>        	</td>
  		</tr>
		</table>  
		
      	</td>
        <td align="right"><img src="../library/gambar.php?replid=<?=$replid?>&table=calonsiswa" width="120" height="120" />
        </td>
  	</tr>
	</table>
	<br />
  	<table width="100%" border="0" cellspacing="0">
 	<tr>
    	<td width="46%" valign="top"><!--Kolom Kiri-->      
		<table width="100%" border="0" cellspacing="0" id="table" class="tab">
  		<tr>
    		<td height="30" colspan="4" class="header">STUDENT PERSONAL DATA</td>
    	</tr>
  		<tr>
    		<td width="20%"><strong>Registration</strong></td>
    		<td colspan="3">
            	<input type="text" name="kode" id="kode" size="20" class="disabled" value="<?=$no ?>" readonly />
                <input type="hidden" name="no" id="no" value="<?=$no?>" />
           	</td>
  		</tr>
  		<tr>
    		<td><strong>Year Joining</strong></td>
    		<td colspan="3">
            	<input type="text" name="masuk" id="masuk" size="5" maxlength="4" value="<?=$tahunmasuk?>" readonly="readonly" class="disabled"/> 
            	<input type="hidden" name="tahunmasuk" id="tahunmasuk" value="<?=$tahunmasuk?>" /></td>
  		</tr>
  		<tr>
    		<td><strong>Name</strong></td>
    		<td colspan="3"><input type="text" name="nama" id="nama" size="30" maxlength="100" onFocus="showhint('Student Full Name should not leave empty', this, event, '120px')" value="<?=$row_siswa['nama']?>" class="ukuranemail"  onKeyPress="return focusNext('panggilan', event)" /></td>
  		</tr>
  		<tr>
    		<td>Nickname</td>
    		<td colspan="3"><input type="text" name="panggilan" id="panggilan" size="30" maxlength="30" onFocus="showhint('Nickname should not exceed 30 characters', this, event, '120px')" value="<?=$row_siswa['panggilan']?>" class="ukuran"  onKeyPress="return focusNext('kelamin', event)" /></td>
  		</tr>
  		<tr>
    		<td><strong>Gender</strong></td>
    		<td colspan="3">
    		<input type="radio" id="kelamin" name="kelamin" value="l"
			<? if ($row_siswa['kelamin']=="l") 
				echo "checked='checked'";
			?>
			 onKeyPress="return focusNext('tmplahir', event)" />&nbsp;Male&nbsp;&nbsp;
        	<input type="radio" id="kelamin" name="kelamin" value="p" 
        	<? if ($row_siswa['kelamin']=="p") 
				echo "checked ='checked'";
			?>
			 onKeyPress="return focusNext('tmplahir', event)" />&nbsp;Female			</td>
		</tr>
  		<tr>
  		  <td><strong>Birth Place</strong></td>
		  <td colspan="3"><input type="text" name="tmplahir" id="tmplahir" size="30" maxlength="50" onFocus="showhint('Birth Place should not leave empty', this, event, '120px')" value="<?=$row_siswa['tmplahir']?>"  onKeyPress="return focusNext('tgllahir', event)" /></td>
  		</tr>
  		<tr>
    		<td><strong>Date of Birth</strong></td>
    		<td colspan="3">
    			<select name="tgllahir" id="tgllahir" onKeyPress="return focusNext('blnlahir', event)" >                              
                <option value="">[Date]</option>
				<? 	for ($tgl=1;$tgl<=$n;$tgl++){ ?>
                   	<option value="<?=$tgl?>" <?=IntIsSelected($tgl, $row_siswa['tanggal'])?>><?=$tgl?></option>
                <?	}	?>
                </select>
                <select name="blnlahir" id="blnlahir" onKeyPress="return focusNext('thnlahir', event)" onChange="change_bln()" />
               	 <option value="">[Bln]</option>
                <? 	for ($i=1;$i<=12;$i++) { ?>
                   	<option value="<?=$i?>" <?=IntIsSelected($i, $row_siswa['bulan'] )?>><?=NamaBulan($i)?></option>	
				<?	} ?>
                </select>
                <input type="text" name="thnlahir" id="thnlahir" size="5" maxlength="4" onFocus="showhint('Year of Birth should not leave empty', this, event, '120px')" value="<?=$row_siswa['tahun']?>" onKeyPress="return focusNext('agama', event)"/></strong>
            </td>
  		</tr>
        <tr>
    		<td><strong>Religion</strong></td>
    		<td colspan="3">
    		<div id="InfoAgama">
    		<select name="agama" id="agama" class="ukuran"  onKeyPress="return focusNext('suku', event)" >
    		<option value="">[Select Religion]</option>
			<? // Olah untuk combo agama
			OpenDb();
			$sql_agama="SELECT replid,agama,urutan FROM jbsumum.agama ORDER BY urutan";
			$result_agama=QueryDB($sql_agama);
			while ($row_agama = mysql_fetch_array($result_agama)) {
			?>
			<option value="<?=$row_agama['agama']?>" <?=StringIsSelected($row_agama['agama'], $row_siswa['agama'])?>><?=$row_agama['agama']?></option>
			<?
    		} 
			CloseDb();
			// Akhir Olah Data agama
			?>
    		</select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onclick="tambah_agama();"  onMouseOver="showhint('Add Religion', this, event, '50px')"/>
            <? } ?>
            </div>
            </td>
  		</tr>
  		<tr>
    		<td><strong>Ethnicity</strong></td>
    		<td colspan="3">
    		<div id="InfoSuku">
    		<select name="suku" id="suku" class="ukuran" onKeyPress="return focusNext('status', event)" >            
    		<option value="">[Select Ethnicity]</option>
			<? // Olah untuk combo suku
			OpenDb();
			$sql_suku="SELECT suku,urutan,replid FROM jbsumum.suku ORDER BY urutan";
			$result_suku=QueryDB($sql_suku);
			while ($row_suku = mysql_fetch_array($result_suku)) {				
			?>
			<option value="<?=$row_suku['suku']?>" <?=StringIsSelected($row_suku['suku'], $row_siswa['suku'])?>><?=$row_suku['suku']?></option>
			<?
    		} 
			CloseDb();
			// Akhir Olah Data suku
			?>
    		</select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onclick="tambah_suku();"  onMouseOver="showhint('Add Ethnicity', this, event, '50px')"/>
            <? } ?></div></td>
  		</tr>
  		
  		<tr>
    		<td><strong>Status</strong></td>
    		<td colspan="3">
    		<div id="InfoStatus">
    		<select name="status" id="status" class="ukuran"  onKeyPress="return focusNext('kondisi', event)" >
    		<option value="">[Select Status]</option>
			<? // Olah untuk combo status
			OpenDb();
			$sql_status="SELECT replid,status,urutan FROM jbsakad.statussiswa ORDER BY urutan";
			$result_status=QueryDB($sql_status);
			while ($row_status = mysql_fetch_array($result_status)) {
			?>
			<option value="<?=$row_status['status']?>" <?=StringIsSelected($row_status['status'], $row_siswa['status'])?>><?=$row_status['status']?></option>
			<?
    		} 
			CloseDb();
			// Akhir Olah Data status
			?>
    		</select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onclick="tambah_status();"  onMouseOver="showhint('Add Status', this, event, '50px')"/>
            <? } ?>
            </div>  </td>
 		</tr>
  		<tr>
    		<td><strong>Conditions</strong></td>
    		<td colspan="3">
    		<div id="InfoKondisi">
    		<select name="kondisi" id="kondisi" class="ukuran"  onKeyPress="return focusNext('warga', event)" >
            <option value="">[Select Conditions]</option>
                <? // Olah untuk combo kondisi
			OpenDb();
			$sql_kondisi="SELECT kondisi,urutan FROM jbsakad.kondisisiswa ORDER BY urutan";
			$result_kondisi=QueryDB($sql_kondisi);
			while ($row_kondisi = mysql_fetch_array($result_kondisi)) {
			?>
                <option value="<?=$row_kondisi['kondisi']?>" <?=StringIsSelected($row_kondisi['kondisi'], $row_siswa['kondisi'])?>>
                  <?=$row_kondisi['kondisi']?>
                  </option>
                <?
    		} 
			CloseDb();
			// Akhir Olah Data kondisi
			?>
            </select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
    		<img src="../images/ico/tambah.png" onclick="tambah_kondisi();" onMouseOver="showhint('Add Conditions', this, event, '50px')"/>
            <? } ?>
            </div></td>
  		</tr>
  		<tr>
    		<td>Citizenship</td>
    		<td colspan="3">
    		<input type="radio" name="warga" id="warga" value="Indonesian Citizen"
			<? if ($row_siswa['warga']=="Indonesian Citizen") 
				echo "checked='checked'";
			?>
			 onKeyPress="return focusNext('urutananak', event)" />&nbsp;Indonesian Citizen&nbsp;&nbsp;
    		<input type="radio" name="warga" id="warga" value="Other Citizen" 
			<? if ($row_siswa['warga']=="Other Citizen") 
				echo "checked='checked'";
			?>
			 onKeyPress="return focusNext('urutananak', event)" />&nbsp;Other Citizen</td>
  		</tr>
  		<tr>
    		<td>Child #</td>
    		<td colspan="3"><input type="text" name="urutananak" id="urutananak" size="3" maxlength="3" onFocus="showhint('Child # should not exceed 3 digits', this, event, '120px')" <? if($row_siswa['anakke']!=0){ ?>value="<?=$row_siswa['anakke'];?>" <? } else { ?>value=""<? } ?> onKeyPress="return focusNext('jumlahanak', event)" />
			&nbsp;&nbsp;from&nbsp;&nbsp;<input type="text" name="jumlahanak" id="jumlahanak" size="3" maxlength="3" onFocus="showhint('Siblings should not exceed 3 digits', this, event, '120px')" value="<?=$row_siswa['jsaudara'];?>"  onKeyPress="return focusNext('bahasa', event)" />&nbsp;&nbsp;siblings</td>
  		</tr>
  		<tr>
    		<td>Language</td>
    		<td colspan="3"><input type="text" name="bahasa" id="bahasa" size="30" maxlength="60" onFocus="showhint('Language should not exceed 60 characters', this, event, '120px')" value="<?=$row_siswa['bahasa']?>" class="ukuran"  onKeyPress="return focusNext('alamatsiswa', event)" /></td>
  		</tr>
  		<tr>
    		<td>Photo</td>
    		<td colspan="3"><input type="file" name="nama_foto" id="file" size="25" /></td>
  		</tr>
  		<tr>
    		<td>Address</td>
    		<td colspan="3"><textarea name="alamatsiswa" id="alamatsiswa" rows="2" cols="30" onFocus="showhint('Student Address should not exceed 255 characters', this, event, '120px')" class="Ukuranketerangan" onKeyUp="change_alamat()"  onKeyPress="return focusNext('kodepos', event)" ><?=$row_siswa['alamatsiswa']?></textarea></td>
  		</tr>
  		<tr>
    		<td>Post Code</td>
    		<td colspan="3"><input type="text" name="kodepos" id="kodepos" size="5" maxlength="8" onFocus="showhint('Post Code should not exceed 8 digits', this, event, '120px')" value="<?=$row_siswa['kodepossiswa'];?>"  onKeyPress="return focusNext('telponsiswa', event)" /></td>
  		</tr>
  		<tr>
    		<td>Phone</td>
    		<td colspan="3"><input type="text" name="telponsiswa" id="telponsiswa" size="20" maxlength="25" onFocus="showhint('Phone should not exceed 20 digits', this, event, '120px')" value="<?=$row_siswa['telponsiswa'];?>" class="ukuran"  onKeyPress="return focusNext('hpsiswa', event)" /></td>
  		</tr>
  		<tr>
    		<td>Mobile</td>
    		<td colspan="3"><input type="text" name="hpsiswa" id="hpsiswa" size="20" maxlength="25" onFocus="showhint('Mobile should not exceed 20 digits', this, event, '120px')" value="<?=$row_siswa['hpsiswa'];?>" class="ukuran"  onKeyPress="return focusNext('emailsiswa', event)" />      	</td>
  		</tr>
  		<tr>
    		<td>Email</td>
    		<td colspan="3"><input type="text" name="emailsiswa" id="emailsiswa" size="30" maxlength="100" onFocus="showhint('Email should not exceed 100 characters', this, event, '120px')" value="<?=$row_siswa['emailsiswa']?>"  onKeyPress="return focusNext('dep_asal', event)" /></td>
  		</tr>
  		<tr>
    		<td valign="top">Past School</td>
    		<td width="11%"><!--<div id = "InfoSekolah">-->
    		<select name="dep_asal" id="dep_asal" onchange="change_departemen(0)" onKeyPress="return focusNext('sekolah', event)">
    		<option value="">[Select]</option>	
			<? // Olah untuk combo departemen
			OpenDb();
			$sql_departemen="SELECT departemen,urutan FROM jbsakad.departemen WHERE departemen <> '$departemen' ORDER BY urutan";			
			$result_departemen=QueryDB($sql_departemen);
			//$row_departemen = @mysql_fetch_array($result_departemen);
			//$dep_asal = $row_departemen['departemen'];
			//if ($dep_asal == "") 
			//	$dep_asal = $row_departemen['departemen'];
			while ($row_departemen = mysql_fetch_array($result_departemen)) {			
							
			?>
			<option value="<?=$row_departemen['departemen']?>" <?=StringIsSelected($row_departemen['departemen'], $dep_asal)?>><?=$row_departemen['departemen']?></option>
			<? 	} 
			CloseDb();
			// Akhir Olah Data kondisi
			?>
    		</select><!--</div>--></td>
            <!--<input type="hidden" name="dep_asal" id="dep_asal" value="<?=$dep_asal?>" />-->
            <td width="16%"><div id="sekolahInfo">
           	<select name="sekolah" id="sekolah"  onKeyPress="return focusNext('ketsekolah', event)" >
            <option value="">[Select Past School]</option>	
    		<? // Olah untuk combo sekolah
			OpenDb();
			$sql_sekolah="SELECT sekolah FROM jbsakad.asalsekolah WHERE departemen='$dep_asal' ORDER BY sekolah";
			$result_sekolah=QueryDB($sql_sekolah);
			while ($row_sekolah = mysql_fetch_array($result_sekolah)) {
				 //if ($sekolah=="")
            		//$sekolah=$row_sekolah['sekolah'];
			?>
      		<option value="<?=$row_sekolah['sekolah']?>" <?=StringIsSelected($row_sekolah['sekolah'], $sekolah)?>>
        	<?=$row_sekolah['sekolah']?>
        	</option>
      		<? } 
			CloseDb();
			// Akhir Olah Data sekolah
			?>
    		</select></div></td>
    		<td width="48%">
            <img src="../images/ico/tambah.png" onclick="tambah_asal_sekolah();" onMouseOver="showhint('Add Past School', this, event, '80px')"/></td>
  		</tr>
 		<tr>
    		<td valign="top">Past School <br />Info      </td>
    		<td colspan="3"><textarea name="ketsekolah" id="ketsekolah" onFocus="showhint('Past School info should not exceed 255 characters', this, event, '120px')" class="Ukuranketerangan"  onKeyPress="return focusNext('gol', event)" ><?=$row_siswa['ketsekolah']?></textarea></td>
  		</tr>
		</table>    
		<script language='JavaScript'>
	    	Tables('table', 1, 0);
		</script>
		</td><!-- Akhir Kolom Kiri-->
    	<td width="1%" align="center" valign="middle"><img src="../images/batas.png" width="2" height="500" /></td>
    	<td width="60%" align="center" valign="top"><!-- Kolom Kanan-->
    	<table width="100%" border="0" cellspacing="0" id="table" class="tab">
  		<tr>
    		<td height="30" colspan="3" class="header" valign="top">HEALTH HISTORY</td>
    	</tr>
  		<tr>
    		<td width="20%" valign="top">Blood Type</td>
    		<td colspan="2">
                <input type="radio" name="gol" id="gol" value"A" <? 
                if ($row_siswa['darah']=="A")
                echo "checked='checked'";
                ?> onKeyPress="return focusNext('berat', event)" />&nbsp;A&nbsp;&nbsp;
                <input type="radio" name="gol" id="gol" value="AB" <? 
                if ($row_siswa['darah']=="AB")
                echo "checked='checked'";
                ?> onKeyPress="return focusNext('berat', event)" />&nbsp;AB&nbsp;&nbsp;
                <input type="radio" name="gol" id="gol" value="B" <? 
                if ($row_siswa['darah']=="B")
                echo "checked='checked'";
                ?> onKeyPress="return focusNext('berat', event)" />&nbsp;B&nbsp;&nbsp;
                <input type="radio" name="gol" id="gol" value="O" <? 
                if ($row_siswa['darah']=="O")
                echo "checked='checked'";
                ?> onKeyPress="return focusNext('berat', event)" />&nbsp;O&nbsp;&nbsp;	
                <input type="radio" name="gol" id="gol" value="" <? 
                if ($row_siswa['darah']=="")
                echo "checked='checked'";
                ?> onKeyPress="return focusNext('berat', event)" />&nbsp;<em>(don't have any data)</em>&nbsp;         	
           	</td>
 		</tr>
  		<tr>
    		<td>Body Weight</td>
    		<td colspan="2">
            <input name="berat" type="text" size="6" maxlength="6" id="berat" onFocus="showhint('Body Weight should not exceed 6 digits', this, event, '120px')" value="<?=$row_siswa['berat'];?>"  onKeyPress="return focusNext('tinggi', event)" />&nbsp;kg</td>
  		</tr>
  		<tr>
    		<td>Body Height</td>
    		<td colspan="2"><input name="tinggi" type="text" size="6" maxlength="6" id="tinggi" onFocus="showhint('Body Height should not exceed 6 digits', this, event, '120px')" value="<?=$row_siswa['tinggi'];?>"  onKeyPress="return focusNext('kesehatan', event)" />&nbsp;cm</td>
  		</tr>
  		<tr>
    		<td valign="top">Illness History</td>
    		<td colspan="2"><textarea name="kesehatan" size="35" maxlength="255" id="kesehatan" onFocus="showhint('Illness History should not exceed 255 characters', this, event, '120px')" class="Ukuranketerangan"  onKeyPress="return focusNext('namaayah', event)" ><?=$row_siswa['kesehatan']?></textarea></td>
  		</tr>
  		<tr>
    		<td height="30" colspan="3" class="header">PARENT DATA</td>
    	</tr>
  		<tr>
    		<td>&nbsp;</td>
    		<td width="28%" valign="middle" align="center"><strong>Father</strong></td>
    		<td align="center" valign="middle"><strong>Mother</strong></td>
  		</tr>
  		<tr>
            <td valign="top">Name</td>
            <td><input name="namaayah" type="text" size="15" maxlength="100" id="namaayah" onFocus="showhint('Father name should not exceed 100 characters', this, event, '120px')"  value="<?=$row_siswa['namaayah']?>" class="ukuran"  onKeyPress="return focusNext('namaibu', event)" />
            	<br />
                <input type="checkbox" name="almayah" id="almayah" value="1" title="Click here if Father has been passed away"  
        		<? if ($row_siswa['almayah']=="1") echo "checked";?> />
                &nbsp;&nbsp;<font color="#990000" size="1">(Late)</font> </td>
          	<td colspan="2"><input name="namaibu" type="text" size="15" maxlength="100" id="namaibu" onFocus="showhint('Mother name should not exceed 100 characters', this, event, '120px')" value="<?=$row_siswa['namaibu']?>" class="ukuran"  onKeyPress="return focusNext('Infopendidikanayah', event)" />
            	<br />
                <input type="checkbox" name="almibu" id="almibu" value="1" title="Click here if Mother has been passed away"
        		<? if ($row_siswa['almibu']=="1") echo "checked";?>/>
                &nbsp;&nbsp;<font color="#990000" size="1">(Late)</font> </td>
        </tr>
  		<tr>
    		<td>Education</td>
    		<td>			
			<select name="pendidikanayah" id="Infopendidikanayah" class="ukuran"  onKeyPress="return focusNext('Infopendidikanibu', event)" >
      		<option value="">[Select Education]</option>
			<? // Olah untuk combo pendidikan ayah
			OpenDb();
			$sql_pend_ayah="SELECT pendidikan FROM jbsumum.tingkatpendidikan ORDER BY pendidikan";
			$result_pend_ayah=QueryDB($sql_pend_ayah);
			while ($row_pend_ayah = mysql_fetch_array($result_pend_ayah)) {
			?>
      		<option value="<?=$row_pend_ayah['pendidikan']?>" <?=StringIsSelected($row_pend_ayah['pendidikan'], $row_siswa['pendidikanayah'])?>><?=$row_pend_ayah['pendidikan']?></option>
      		<?
    		} 
			CloseDb();
			// Akhir Olah Data sekolah
			?>
    		</select></td>
    		<td width="49%">			
			<select name="pendidikanibu" id="Infopendidikanibu" class="ukuran"  onKeyPress="return focusNext('Infopekerjaanayah', event)" >
      		<option value="">[Select Education]</option>
			<? // Olah untuk combo sekolah
			OpenDb();
			$sql_pend_ibu="SELECT pendidikan FROM jbsumum.tingkatpendidikan ORDER BY pendidikan";
			$result_pend_ibu=QueryDB($sql_pend_ibu);
			while ($row_pend_ibu = mysql_fetch_array($result_pend_ibu)) {
			?>
      		<option value="<?=$row_pend_ibu['pendidikan']?>" <?=StringIsSelected($row_pend_ibu['pendidikan'], $row_siswa['pendidikanibu'])?>><?=$row_pend_ibu['pendidikan']?></option>
      		<?
    		} 
			CloseDb();
			// Akhir Olah Data sekolah
			?>
    		</select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onclick="tambah_pendidikan();" onMouseOver="showhint('Add Education Level', this, event, '80px')" />
            <? } ?>
            </td>
  		</tr>
  		<tr>
    		<td>Occupation</td>
    		<td>
			
			<select name="pekerjaanayah" id="Infopekerjaanayah" class="ukuran"  onKeyPress="return focusNext('Infopekerjaanibu', event)" >
      		<option value="">[Select Occupation]</option>
			<? // Olah untuk combo sekolah
			OpenDb();
			$sql_kerja_ayah="SELECT pekerjaan FROM jbsumum.jenispekerjaan ORDER BY pekerjaan";
			$result_kerja_ayah=QueryDB($sql_kerja_ayah);
			while ($row_kerja_ayah = mysql_fetch_array($result_kerja_ayah)) {
			?>
      		<option value="<?=$row_kerja_ayah['pekerjaan']?>" <?=StringIsSelected($row_kerja_ayah['pekerjaan'], $row_siswa['pekerjaanayah'])?>><?=$row_kerja_ayah['pekerjaan']?></option>
      		<?
    		} 
			CloseDb();
			// Akhir Olah Data sekolah
			?>
   		 	</select></td>
    		<td>			
			<select name="pekerjaanibu" id="Infopekerjaanibu" class="ukuran"  onKeyPress="return focusNext('penghasilanayah', event)" >
      		<option value="">[Select Occupation]</option>
			<? // Olah untuk combo sekolah
			OpenDb();
			$sql_kerja_ibu="SELECT pekerjaan FROM jbsumum.jenispekerjaan ORDER BY pekerjaan";
			$result_kerja_ibu=QueryDB($sql_kerja_ibu);
			while ($row_kerja_ibu = mysql_fetch_array($result_kerja_ibu)) {
			?>
      		<option value="<?=$row_kerja_ibu['pekerjaan']?>" <?=StringIsSelected($row_kerja_ibu['pekerjaan'], $row_siswa['pekerjaanibu'])?>><?=$row_kerja_ibu['pekerjaan']?></option>
      		<?
    		} 
			CloseDb();
			// Akhir Olah Data sekolah
			?>
    		</select>
             <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onclick="tambah_pekerjaan();" onMouseOver="showhint('Add Occupation Type', this, event, '80px')" />
            <? } ?>
            </td>
  		</tr>
  		<tr>
    		<td>Income</td>
    		<td><input type="text" name="penghasilanayah" id="penghasilanayah" size="15" maxlength="20" value="<?=$row_siswa['penghasilanayah'];?>" class="ukuran"  onKeyPress="return focusNext('penghasilanibu', event)" ></td>
    		<td><input type="text" name="penghasilanibu" id="penghasilanibu" size="15" maxlength="20" value="<?=$row_siswa['penghasilanibu'];?>" class="ukuran"  onKeyPress="return focusNext('namawali', event)" /></td>
  		</tr>
  		<tr>
    		<td>Guardian Name</td>
    		<td colspan="2">
            <input type="text" name="namawali" id="namawali" size="30" maxlength="100" value="<?=$row_siswa['wali']?>"  onKeyPress="return focusNext('alamatortu', event)"  ></td>
  		</tr>
  		<tr>
    		<td valign="top">Parent Address</td>
    		<td colspan="2">
            <textarea name="alamatortu" id="alamatortu" size="25" maxlength="100" class="Ukuranketerangan"  onKeyPress="return focusNext('telponortu', event)" ><?=$row_siswa['alamatortu']?></textarea><br /></td>
  		</tr>
  		<tr>
    		<td>Parent Phone</td>
    		<td colspan="2">
            <input type="text" name="telponortu" id="telponortu" class="ukuran" maxlength="20" value="<?=$row_siswa['telponortu']?>"  onKeyPress="return focusNext('hportu', event)" /></td>
  		</tr>
  		<tr>
    		<td>Parent Mobile</td>
    		<td colspan="2"><input type="text" name="hportu" id="hportu" class="ukuran" maxlength="20" value="<?=$row_siswa['hportu']?>"  onKeyPress="return focusNext('emailortu', event)" /></td>
  		</tr>
  		<tr>
    		<td>Parent Email</td>
    		<td colspan="2"><input type="text" name="emailortu" id="emailortu" size="30" maxlength="100" value="<?=$row_siswa['emailortu']?>"  onKeyPress="return focusNext('alamatsurat', event)" /></td>
  		</tr>
  		<tr>
    		<td height="30" colspan="3" class="header">OTHERS</td>
    	</tr>
  		<tr>
    		<td valign="top">Mailing Address</td>
    		<td colspan="2"><textarea name="alamatsurat" id="alamatsurat" size="35" maxlength="100" class="Ukuranketerangan"  onKeyPress="return focusNext('keterangan', event)" ><?=$row_siswa['alamatsurat']?></textarea></td>
  		<tr>
    		<td valign="top">Info</td>
    		<td colspan="2"><textarea name="keterangan" id="keterangan" class="Ukuranketerangan"><?=$row_siswa['keterangan']?></textarea></td>
  		</tr>
		</table>    
		<script language='JavaScript'>
	    	Tables('table', 1, 0);
		</script>
		</td><!-- Akhir Kolom Kanan-->	
    </tr>
	<tr height="50">	
		<td valign="middle" align="right">     
        <input type="Submit" value="Save" name="Simpan" class="but" /></td>
  		<td align="center" valign="middle"></td>
  		<td valign="middle"><input class="but" type="button" value="Close" name="Tutup"  onClick="tutup()" />
  		</td>           
	</tr>
	</table>
	
   	</td>
</tr>
</table>
</form>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("nama");
var sprytextfield2 = new Spry.Widget.ValidationTextField("panggilan");
var sprytextfield3 = new Spry.Widget.ValidationTextField("tmplahir");
var sprytextfield4 = new Spry.Widget.ValidationTextField("thnlahir");
var sprytextfield5 = new Spry.Widget.ValidationTextField("urutananak");
var sprytextfield6 = new Spry.Widget.ValidationTextField("jumlahanak");
var sprytextfield7 = new Spry.Widget.ValidationTextField("bahasa");
var sprytextfield8 = new Spry.Widget.ValidationTextField("kodepos");
var sprytextfield9 = new Spry.Widget.ValidationTextField("telponsiswa");
var sprytextfield10 = new Spry.Widget.ValidationTextField("hpsiswa");
var sprytextfield11 = new Spry.Widget.ValidationTextField("emailsiswa");
var sprytextfield12 = new Spry.Widget.ValidationTextField("berat");
var sprytextfield13 = new Spry.Widget.ValidationTextField("tinggi");
var sprytextfield14 = new Spry.Widget.ValidationTextField("namaayah");
var sprytextfield15 = new Spry.Widget.ValidationTextField("namaibu");
var sprytextfield16 = new Spry.Widget.ValidationTextField("penghasilanayah");
var sprytextfield17 = new Spry.Widget.ValidationTextField("penghasilanibu");
var sprytextfield18 = new Spry.Widget.ValidationTextField("namawali");
var sprytextfield19 = new Spry.Widget.ValidationTextField("telponortu");
var sprytextfield20 = new Spry.Widget.ValidationTextField("hportu");
var sprytextfield21 = new Spry.Widget.ValidationTextField("emailortu");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("alamatsiswa");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("ketsekolah");
var sprytextarea3 = new Spry.Widget.ValidationTextarea("kesehatan");
var sprytextarea4 = new Spry.Widget.ValidationTextarea("alamatortu");
var sprytextarea5 = new Spry.Widget.ValidationTextarea("alamatsurat");
var sprytextarea6 = new Spry.Widget.ValidationTextarea("keterangan");
var spryselect1 = new Spry.Widget.ValidationSelect("tgllahir");
var spryselect2 = new Spry.Widget.ValidationSelect("blnlahir");
var spryselect3 = new Spry.Widget.ValidationSelect("suku");
var spryselect4 = new Spry.Widget.ValidationSelect("agama");
var spryselect5 = new Spry.Widget.ValidationSelect("status");
var spryselect6 = new Spry.Widget.ValidationSelect("kondisi");
var spryselect7 = new Spry.Widget.ValidationSelect("sekolah");
var spryselect8 = new Spry.Widget.ValidationSelect("Infopendidikanayah");
var spryselect9 = new Spry.Widget.ValidationSelect("Infopendidikanibu");
var spryselect10 = new Spry.Widget.ValidationSelect("Infopekerjaanayah");
var spryselect11 = new Spry.Widget.ValidationSelect("Infopekerjaanibu");
var spryselect12 = new Spry.Widget.ValidationSelect("departemen");
var spryselect13 = new Spry.Widget.ValidationSelect("kelompok");
</script>