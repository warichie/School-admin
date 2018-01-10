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
require_once('../include/rupiah.php');
require_once('../include/imageresizer.php');
require_once('../cek.php');

$dep_asal="";
$idkelas=$_REQUEST['kelas']; 
$idtingkat=$_REQUEST['tingkat']; 
$idtahunajaran=$_REQUEST['tahunajaran']; 
$departemen=$_REQUEST['departemen'];
$cek = 0;

//end of variabel yang diambil kembali=========
$nis=CQ($_REQUEST['nis']);
$nisn=CQ($_REQUEST['nisn']);
$idangkatan=$_REQUEST['idangkatan'];
$tahunmasuk=$_REQUEST['tahunmasuk'];
$nama=CQ($_REQUEST['nama']);
//$nama=str_replace(""","`",$nama);
$panggilan=CQ($_REQUEST['panggilan']);
$kelamin=$_REQUEST['kelamin'];
$tmplahir=CQ($_REQUEST['tmplahir']);
$tgllahir=$_REQUEST['tgllahir'];
$blnlahir=$_REQUEST['blnlahir'];
$thnlahir=$_REQUEST['thnlahir'];;
$suku=$_REQUEST['suku'];
$agama=$_REQUEST['agama'];
$status=$_REQUEST['status'];
$kondisi=$_REQUEST['kondisi'];

$warga = (isset($_REQUEST['warga']))?$_REQUEST['warga']:"Indonesian Citizen";
$urutananak = (isset($_REQUEST['urutananak']))?$_REQUEST['urutananak']:"1";
$jumlahanak = (isset($_REQUEST['jumlahanak']))?$_REQUEST['jumlahanak']:"1";

$bahasa=CQ($_REQUEST['bahasa']);
$alamatsiswa=CQ($_REQUEST['alamatsiswa']);
$kodepos=CQ($_REQUEST['kodepos']);
$telponsiswa=CQ($_REQUEST['telponsiswa']);
$hpsiswa=trim(CQ($_REQUEST['hpsiswa']));
$hpsiswa=str_replace(' ','',$hpsiswa);
$emailsiswa=CQ($_REQUEST['emailsiswa']);
$dep_asal=$_REQUEST['dep_asal'];

$sekolah=$_REQUEST['sekolah'];
$ketsekolah=CQ($_REQUEST['ketsekolah']);
$gol=$_REQUEST['gol'];

$berat = (isset($_REQUEST['berat']))?$_REQUEST['berat']:"0";
$tinggi = (isset($_REQUEST['tinggi']))?$_REQUEST['tinggi']:"0";
	
$kesehatan=CQ($_REQUEST['kesehatan']);
$namaayah=CQ($_REQUEST['namaayah']);
$namaibu=CQ($_REQUEST['namaibu']);
$pendidikanayah=$_REQUEST['pendidikanayah'];
$pendidikanibu=$_REQUEST['pendidikanibu'];
$pekerjaanayah=$_REQUEST['pekerjaanayah'];
$pekerjaanibu=$_REQUEST['pekerjaanibu'];

$penghasilanayah = (isset($_REQUEST['penghasilanayah']))?$_REQUEST['penghasilanayah']:"0";
$penghasilanibu = (isset($_REQUEST['penghasilanibu']))?$_REQUEST['penghasilanibu']:"0";

$namawali=CQ($_REQUEST['namawali']);
$alamatortu=CQ($_REQUEST['alamatortu']);
$telponortu=CQ($_REQUEST['telponortu']);
$hportu=trim($_REQUEST['hportu']);
$hportu=str_replace(' ','',$hportu);
$emailayah=CQ($_REQUEST['emailayah']);
$emailibu=CQ($_REQUEST['emailibu']);
$alamatsurat=CQ($_REQUEST['alamatsurat']);
$keterangan=CQ($_REQUEST['keterangan']);

$almayah = (isset($_REQUEST['almayah']))?$_REQUEST['almayah']:"0";
$almibu = (isset($_REQUEST['almibu']))?$_REQUEST['almibu']:"0";


$ERROR_MSG = "";
OpenDb();

if (isset($_REQUEST['Simpan'])){
	$sql_cek = "SELECT nis,nama from jbsakad.siswa where nis ='$nis'";
	$hasil_cek=QueryDb($sql_cek);
	$row=@mysql_num_rows($hasil_cek);
	if (mysql_num_rows($hasil_cek) > 0)
	{
		$cek = 1;
		$ERROR_MSG = "National Student ID $nis has been used";
	} 
	else 
	{	
		$lahir=$thnlahir."-".$blnlahir."-".$tgllahir;
		$date=date(j);
		$month=date(m);
		$year=date(Y);
		$kumplit = date(Y)."-".date(m)."-".date(j);
		
		$urutananak = ($urutananak=="")?0:$urutananak;	
		$jumlahanak = ($jumlahanak=="")?0:$jumlahanak;	
		$berat = ($berat=="")?0:$berat;	
		$tinggi = ($tinggi=="")?0:$tinggi;	
		$penghasilanayah = ($penghasilanayah=="")?0:$penghasilanayah;	
		$penghasilanibu = ($penghasilanibu=="")?0:$penghasilanibu;	
		
		$sekolah_sql = ($sekolah == "")?"asalsekolah = NULL":"asalsekolah = '$sekolah'";
		$pendidikanayah_sql = ($pendidikanayah == "")?"pendidikanayah = NULL":"pendidikanayah = '$pendidikanayah'";
		$pendidikanibu_sql = ($pendidikanibu == "")?"pendidikanibu = NULL":"pendidikanibu = '$pendidikanibu'";
		$pekerjaanayah_sql = ($pekerjaanayah == "")?"pekerjaanayah = NULL":"pekerjaanayah = '$pekerjaanayah'";
		$pekerjaanibu_sql = ($pekerjaanibu == "")?"pekerjaanibu = NULL":"pekerjaanibu = '$pekerjaanibu'";
		$kodepos_sql = ($kodepos == "")?"kodepossiswa = NULL":"kodepossiswa = '$kodepos'";
			
		$foto=$_FILES["file_data"];
		$uploadedfile = $foto['tmp_name'];
		$uploadedtypefile = $foto['type'];
		$uploadedsizefile = $foto['size'];
		
		if (strlen($uploadedfile)!=0)
		{
			$tmp_path = realpath(".") . "/../../temp";
			$tmp_exists = file_exists($tmp_path) && is_dir($tmp_path);
			if (!$tmp_exists)
				mkdir($tmp_path, 0755);
			
			$filename = "$tmp_path/ad-sis-tmp.jpg";
			ResizeImage($foto, 159, 120, 100, $filename);

			$fh = fopen($filename,"r");
			$foto_data = addslashes(fread($fh, filesize($filename)));
			fclose($fh);
			
			$gantifoto=", foto='$foto_data'";
		} else {
			$gantifoto="";
		}
		
		$pinsiswa = random(5);
		$pinortu = random(5);
		$pinortuibu = random(5);
		
		BeginTrans();
		
		$success = true;
		$sql_simpan="INSERT INTO jbsakad.siswa SET nis='$nis', nama='$nama', panggilan='$panggilan', tahunmasuk='$tahunmasuk', idangkatan=$idangkatan, idkelas='$idkelas', suku='$suku', agama='$agama', status='$status', kondisi='$kondisi', kelamin='$kelamin', tmplahir='$tmplahir', tgllahir='$lahir', warga='$warga', anakke=$urutananak, jsaudara=$jumlahanak, bahasa='$bahasa', berat=$berat, tinggi=$tinggi, darah='$gol', foto='$foto_data', alamatsiswa='$alamatsiswa', $kodepos_sql, telponsiswa='$telponsiswa', hpsiswa='$hpsiswa', emailsiswa='$emailsiswa', kesehatan='$kesehatan', $sekolah_sql, ketsekolah='$ketsekolah', namaayah='$namaayah', namaibu='$namaibu', almayah=$almayah, almibu=$almibu, $pendidikanayah_sql, $pendidikanibu_sql, $pekerjaanayah_sql, $pekerjaanibu_sql, wali='$namawali', penghasilanayah=$penghasilanayah, penghasilanibu=$penghasilanibu, alamatortu='$alamatortu', telponortu='$telponortu', hportu='$hportu', emailayah='$emailayah', emailibu='$emailibu', alamatsurat='$alamatsurat', keterangan='$keterangan', pinsiswa = '$pinsiswa' , pinortu = '$pinortu', pinortuibu = '$pinortuibu', nisn = '$nisn'";
		QueryDbTrans($sql_simpan,$success);
		
		if ($success)
		{
			$sql_dept = "INSERT INTO jbsakad.riwayatdeptsiswa SET nis='$nis',departemen='$departemen',mulai='$kumplit'";		
			QueryDbTrans($sql_dept, $success);
		}
				
		if ($success)
		{
			$sql_kls="INSERT INTO jbsakad.riwayatkelassiswa SET nis='$nis',idkelas='$idkelas',mulai='$kumplit'";
			QueryDbTrans($sql_kls, $success);
		}	
	
		if ($success)
		{
			CommitTrans();	?>
			<script language="javascript">
				parent.opener.refresh_after_add();
				window.close();
			</script>
		<?		
		} 
		else 
		{
			RollbackTrans(); ?>
			<script language="javascript">
				alert ('Failed to save data');
			</script>
<?		}
	}
}
//=== end of script simpan ==================

$n = JmlHari($blnlahir, $thnlahir);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Add Student Data]</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/rupiah.js"></script>
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
	var emailayah = document.main.emailayah.value;
	var emailibu = document.main.emailibu.value;
	var tgllahir = document.main.tgllahir.value;
	var blnlahir = document.main.blnlahir.value;
	var thnlahir = document.main.thnlahir.value;
	var nama = document.main.nama.value;
	var tmplahir = document.main.tmplahir.value;
	var nis = document.main.nis.value;
	var tahunmasuk = document.main.tahunmasuk.value;
	var suku = document.main.suku.value;
	var agama = document.main.agama.value;
	var status = document.main.status.value;
	var kondisi = document.main.kondisi.value;
	var file=document.getElementById("file_data").value;
		
	if(tahunmasuk.length == 0) {
       	alert("You must enter a data for Year Joining");
		document.main.tahunmasuk.focus();
        return false;
   	}	
	
	if (tahunmasuk.length > 0){	
		if(isNaN(tahunmasuk)) {
    		alert ('Year Joining data must be numeric');; 
			document.main.tahunmasuk.focus();
        	return false;
		}
		if (tahunmasuk.length > 4 || tahunmasuk.length < 4) {
        	alert("Year Joining should not more or less than 4 characters"); 
			document.main.tahunmasuk.focus();
        return false;
    	}
    }	
	if (nis.length == 0) {
		alert("You must enter a data for Student ID");
		document.getElementById('nis').focus();
		return false;
	}
	if (nama.length == 0) {
		alert("You must enter a data for Student Name");
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
	
	
	if(thnlahir.length == 0) {
       	alert("You must enter a data for Year of Birth");
		document.main.thnlahir.focus();
        return false;
   	}	
	
	if (thnlahir.length > 0){	
		if(isNaN(thnlahir)) {
    		alert ('Year of Birth data must be numeric');; 
			document.main.thnlahir.focus();
        	return false;
		}
		if (thnlahir.length > 4 || thnlahir.length < 4) {
        	alert("Year of Birth should not more or less than 4 characters"); 
			document.main.thnlahir.focus();
        return false;
    	}
    }
	
	if (agama.length == 0) {
		alert("You must enter a data for Religion");
		document.main.agama.focus();
		return false;
	}
	
	if (suku.length == 0) {
		alert("You must enter a data for Ethnicity");
		document.main.suku.focus();
		return false;
	}
	
	if (status.length == 0) {
		alert("You must enter a data for Status");
		document.main.status.focus();
		return false;
	}
	if (kondisi.length == 0) {
		alert("You must enter a data for Conditions");
		document.main.kondisi.focus();
		return false;
	}	
	
	if (urutananak.length > 0){
		if(isNaN(urutananak)) {
			alert ('Child # must be numeric');
			document.getElementById('urutananak').focus();
			return false;
		}
		if (urutananak == 0) {
			alert("Child # should more than 0");
			document.getElementById('urutananak').focus();
			return false;
		}		
		if (jumlahanak.length == 0) {
			alert("Siblings should not leave empty");
			document.getElementById('jumlahanak').focus();
			return false;
		}
	} else {
		alert("You must enter a data for Child #");
		document.getElementById('urutananak').focus();
		return false;
	}
	
	if (jumlahanak.length > 0){
		if(isNaN(jumlahanak)) {
			alert ('Children data must be numeric');
			document.getElementById('jumlahanak').focus();
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
			document.getElementById('kodepos').focus();
			return false;
		}
	}
	
	if (telponsiswa.length > 0){
		if(isNaN(telponsiswa)) {
			alert ('Phone data must be numeric');
			document.getElementById('telponsiswa').focus();
			return false;
		}
	}
	
	if (hpsiswa.length > 0){
		if(isNaN(hpsiswa)) {
			alert ('Mobile phone data must be numeric\nDo not use space');
			//document.getElementById('hpsiswa').value="";
			document.getElementById('hpsiswa').focus();
			return false;
		}
	}

	if (berat.length > 0){
		if(isNaN(berat)) {
			alert ('Body Weight data must be numeric');
			//document.getElementById('berat').value=0;
			document.getElementById('berat').focus();
			return false;
		}
	}
	if (tinggi.length > 0){
		if(isNaN(tinggi)) {
			alert ('Body Height data must be numeric');
			//document.getElementById('tinggi').value="";
			document.getElementById('tinggi').focus();
			return false;
		}
	}
	
	if (penghasilanayah.length > 0){
		if(isNaN(penghasilanayah)) {
			alert ('Father income data must be numeric');
			//document.getElementById('penghasilanayah').value="";
			document.getElementById('penghasilanayah').focus();
			return false;
		}
	}	
	
	if (penghasilanibu.length > 0){
		if(isNaN(penghasilanibu)) {
			alert ('Mother income data must be numeric');
			//document.getElementById('penghasilanibu').value="";
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
			alert ('Parent mobile phone data must be numeric\nDo not use space');
			//document.getElementById('hportu').value="";
			document.getElementById('hportu').focus();
			return false;
		}
	}
	
	if (emailsiswa.length > 0) {
		if (!validateEmail("emailsiswa") ) { 
			alert( "Email you entered is not an email address");
			document.main.emailsiswa.focus();
			return false;	
		}	
	}
	
	if (emailayah.length > 0) {
		if (!validateEmail("emailayah") ) { 
			alert( "Email you entered is not an email address");
			document.main.emailayah.focus();
			return false;	
		}	
	}
	
	if (emailibu.length > 0) {
		if (!validateEmail("emailibu") ) { 
			alert( "Email you entered is not an email address");
			document.main.emailibu.focus();
			return false;	
		}	
	}
	
	var namatgl = "tgllahir";
	var namabln = "blnlahir";
	
	if (thnlahir.length != 0 && blnlahir.length != 0 && tgllahir.length != 0){
		if (thnlahir % 4 == 0){
			 if (blnlahir == 2){
				  if (tgllahir>29){
					   alert ('Sorry, please re-enter the Date of Birth data');
					   sendRequestText("../library/gettanggal.php", show1, "tahun="+thnlahir+"&bulan="+blnlahir+"&tgl="+tgllahir+"&namatgl="+namatgl+"&namabln="+namabln);	
					   document.getElementById("tgllahir").focus();
					   return false;
				  }
			 }
			 if (blnlahir== 4 || blnlahir == 6 || blnlahir == 9 || blnlahir == 11){
				  if (tgllahir>30){
					   alert ('Sorry, please re-enter the Date of Birth data');
					   sendRequestText("../library/gettanggal.php", show1, "tahun="+thnlahir+"&bulan="+blnlahir+"&tgl="+tgllahir+"&namatgl="+namatgl+"&namabln="+namabln);	
					   document.getElementById("tgllahir").focus();
					   return false;
				  }
			 }
		}
		if (thnlahir % 4 != 0){
			 if (blnlahir == 2){
				 if (tgllahir>28){
					   alert ('Sorry, please re-enter the Date of Birth data');
					   sendRequestText("../library/gettanggal.php", show1, "tahun="+thnlahir+"&bulan="+blnlahir+"&tgl="+tgllahir+"&namatgl="+namatgl+"&namabln="+namabln);	
					   document.getElementById("tgllahir").focus();
					   return false;
					   
				  }
			 }
			 if (blnlahir == 4 || blnlahir == 6 || blnlahir == 9 || blnlahir == 11){
				  if (tgllahir>30){
					   alert ('Sorry, please re-enter the Date of Birth data');
					   sendRequestText("../library/gettanggal.php", show1, "tahun="+thnlahir+"&bulan="+blnlahir+"&tgl="+tgllahir+"&namatgl="+namatgl+"&namabln="+namabln);	
					   document.getElementById("tgllahir").focus();
					   return false;
					   
				  }
			 }
		}
	}
	if (file.length>0){
		var ext = "";
	
		/*
		if (file.length > 0) {
			while (i < file.length){
				if (file.charAt(i) == '.'){
					titik = i;
				}
				
				if (titik != 0){
					ext = ext + file.charAt(i);
				}
				i++;
			}	
		} 
		*/
		var x = file.split('.');
		ext = x[(x.length-1)];
		if (ext!='JPG' && ext!='jpg' && ext!='Jpg' && ext!='JPg' && ext!='JPEG' && ext!='jpeg'){
			alert ('Image should be jpg or JPG formatted');
			document.getElementById("file_data").value='';
			document.main.file_data.focus();
    		document.main.file_data.select();
			return false;
		} 
	} 
	return true;
}

function sekolah_kiriman(sekolah, dep) {	
	var dep_asal = document.getElementById("dep_asal").value;
	if (dep_asal == dep) {
		change_departemen(sekolah);
	} else {
		setTimeout("change_departemen(0)",1);
	}
}

function sekolah_kiriman2(dep) {
	show_wait("depInfo");
	sendRequestText("siswa_add_getdepasal.php", showDep, "dep="+dep);
	//setTimeout("change_departemen(0)",1);
	
}
function showDep(x) {
	document.getElementById("depInfo").innerHTML = x;
	change_departemen(0);
}
function change_departemen(kode) {	
	var dep_asal = document.getElementById("dep_asal").value;
	wait_sekolah();
	if (kode==0){
		sendRequestText("siswa_add_getsekolah.php", showSekolah, "dep_asal="+dep_asal);
	} else {
		sendRequestText("siswa_add_getsekolah.php", showSekolah, "dep_asal="+dep_asal+"&sekolah="+kode);
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
	newWindow('siswa_add_status.php', 'tambahStatus','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_kondisi(){
	newWindow('siswa_add_kondisi.php', 'tambahKondisi','500','425','resizable=1,scrollbars=1,status=0,toolbar=0');
}
function tambah_asal_sekolah(){
	var departemen = document.getElementById("dep_asal").value;
	newWindow('siswa_add_asalsekolah.php?departemen='+departemen, 'tambahAsalSekolah','500','425','resizable=1,scrollbars=1,status=0,toolbar=0');
}
function tambah_pendidikan(){
	newWindow('siswa_add_pendidikan.php', 'tambahPendidikan','500','425','resizable=1,scrollbars=1,status=0,toolbar=0');
}
function tambah_pekerjaan(){
	newWindow('siswa_add_pekerjaan.php', 'tambahPekerjaan','500','425','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function tutup(){	 
	parent.opener.refresh();
	window.close();
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
		sendRequestText("siswa_add_getstatus.php", show_status,"status=");
	} else {
		sendRequestText("siswa_add_getstatus.php", show_status,"status="+kode);
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
		sendRequestText("siswa_add_getkondisi.php", show_kondisi,"kondisi=");
	} else {
		sendRequestText("siswa_add_getkondisi.php", show_kondisi,"kondisi="+kode);
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
	setTimeout("refresh_pendidikan(pendidikan)",1);
}

function refresh_pendidikan(kode_pendidikan) {	
	wait_pendidikan();
	if (kode_pendidikan==0) {
		sendRequestText("siswa_add_getpendidikan.php", show_pendidikan,"pendidikan=");
		sendRequestText("siswa_add_getpendidikanibu.php", show_pendidikan1,"pendidikan=");
	} else {
		sendRequestText("siswa_add_getpendidikan.php", show_pendidikan,"pendidikan="+kode_pendidikan);
		sendRequestText("siswa_add_getpendidikanibu.php", show_pendidikan1,"pendidikan="+kode_pendidikan);
	}
}

function show_pendidikan(x) {
	document.getElementById("pendidikanayahInfo").innerHTML = x;
}

function show_pendidikan1(x) {
	document.getElementById("pendidikanibuInfo").innerHTML = x;
}

function wait_pendidikan() {
	show_wait("pendidikanayahInfo");
	show_wait("pendidikanibuInfo");
}

function ref_del_pendidikan() {
	setTimeout("refresh_pendidikan(0)",1);
}
//=======End Of ajax pendidikan==========================================

//========Ajax Occupation ================================================
function pekerjaan_kiriman(kerja){
	//refresh_pekerjaan(kerja);
	setTimeout("refresh_pekerjaan(pekerjaan)",1);
}

function refresh_pekerjaan(kode_pekerjaan) {
	wait_pekerjaan();
	if(kode_pekerjaan==0){
		sendRequestText("siswa_add_getpekerjaan.php", show_pekerjaan,"pekerjaan=");
		sendRequestText("siswa_add_getpekerjaanibu.php", show_pekerjaan1,"pekerjaan=");
	} else {
		sendRequestText("siswa_add_getpekerjaan.php", show_pekerjaan,"pekerjaan="+kode_pekerjaan);
		sendRequestText("siswa_add_getpekerjaanibu.php", show_pekerjaan1,"pekerjaan="+kode_pekerjaan);
	}
}

function wait_pekerjaan() {
	show_wait("pekerjaanayahInfo");
	show_wait("pekerjaanibuInfo");
}

function show_pekerjaan(x) {
	document.getElementById("pekerjaanayahInfo").innerHTML = x;
}

function show_pekerjaan1(x) {
	document.getElementById("pekerjaanibuInfo").innerHTML = x;
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

function change_tgl() {	
	var thn = document.getElementById('thnlahir').value;
	var bln = parseInt(document.getElementById('blnlahir').value);	
	var tgl = parseInt(document.main.tgllahir.value);
	
	if(thn.length == 0) {
       	alert("Year of Birth should not leave empty"); 
		document.main.blnlahir.value = "";
		document.main.thnlahir.focus();
        return false;
	} else {	
		if(isNaN(thn)) {
    		alert("Year of Birth should be numeric"); 
			document.main.thnlahir.focus();
        	return false;
		} else {	
			if (thn.length > 4 || thn.length < 4) {
            	alert("Year of Birth should not more or less than 4 characters"); 
				document.main.thnlahir.focus();
            	return false;
			}
		}
    }
	
	var namatgl = "tgllahir";
	var namabln = "blnlahir";

	sendRequestText("../library/gettanggal.php", show1, "tahun="+thn+"&bulan="+bln+"&tgl="+tgl+"&namatgl="+namatgl+"&namabln="+namabln);	
}

function show1(x) {
	document.getElementById("tgl_info").innerHTML = x;
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
/*
	var lain = new Array('nama','panggilan','tmplahir','thnlahir','urutananak','jumlahanak','bahasa','kodepos','telponsiswa','hpsiswa','emailsiswa','berat','tinggi','namaayah','namaibu','penghasilanayah1','penghasilanibu1','emailayah','emailibu','namawali','telponortu','hportu','alamatsiswa','ketsekolah','kesehatan','alamatortu','alamatsurat','keterangan','tgllahir','blnlahir','suku','agama','status','kondisi','sekolah','dep_asal','Infopendidikanayah','Infopendidikanibu','Infopekerjaanayah','Infopekerjaanibu','nis','tahunmasuk','idangkatan');
	
	for (i=0;i<lain.length;i++) {
		if (lain[i] == elem) {
			document.getElementById(elem).style.background='#4cff15';
		} else {
			document.getElementById(lain[i]).style.background='#FFFFFF';
		}
	}
	*/
	document.getElementById(elem).style.background='#c9feb9';
}
function unfokus(elem){
	document.getElementById(elem).style.background='#FFFFFF';
}

function penghasilan_ayah(){	
	var ayah = document.getElementById("penghasilanayah1").value;
	document.getElementById("penghasilanayah").value=ayah;
}
function penghasilan_ibu(){	
	var ibu = document.getElementById("penghasilanibu1").value;
	document.getElementById("penghasilanibu").value=ibu;
}
function change_bln() {	
	//alert ('Masuk');
	var thn = document.getElementById('thnlahir').value;
	var bln = parseInt(document.getElementById('blnlahir').value);	
	var tgl = parseInt(document.getElementById('tgllahir').value);
	
	var namatgl = "tgllahir";
	var namabln = "blnlahir";
	
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
    
	sendRequestText("../library/gettanggal.php", show1, "tahun="+thn+"&bulan="+bln+"&tgl="+tgl+"&namatgl="+namatgl+"&namabln="+namabln);
	//alert ('Sorry, please re-enter Date of Birth');
	//document.getElementById("tgllahir").focus();
	}/**/
}
</script>
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" <? if($cek==0){ ?>onLoad="document.getElementById('tahunmasuk').focus()" <? } else { ?>onLoad="document.getElementById('nis').focus()" <? } ?> >
<!--<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#FFFFFF">-->
<div id="waitBox" style="position:absolute; visibility:hidden;">
<img src="../images/movewait.gif" border="0" />Please wait...
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Add Student Data :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
	<form name="main" method="post" enctype="multipart/form-data" onSubmit="return validate();">
	<input type="hidden" name="idkelas" value="<?=$idkelas?>">
	<input type="hidden" name="idtahunajaran" value="<?=$idtahunajaran?>">
	<input type="hidden" name="idtingkat" value="<?=$idtingkat?>">
    <input type="hidden" name="departemen" value="<?=$departemen?>">

  	<table width="100%" border="0" cellspacing="0">
  	<tr>
    	<td width="45%" valign="top"><!-- Kolom Kiri-->      
      	<table width="100%" border="0" cellspacing="0">
  	<tr>
    	<td height="30" colspan="3">
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Student Personal Data</strong></font>
        <!--hr width="300" style="line-height:1px; border-style:dashed" align="left" color="#000000"/-->
        <div style="border-bottom:1px dashed #666666; border-width:thinl; margin-bottom:5px; margin-top:3px;"></div>
        </td>
    </tr>
  	<tr>
    	<td width="22%"><strong>Graduates</strong></td>
    	<td colspan="2">  
        	<select name="idangkatan" id="idangkatan" style="width:195px;" onKeyPress="return focusNext('tahunmasuk', event)" onFocus="panggil('idangkatan')" onBlur="unfokus('idangkatan')" >    		
			<? // Olah untuk combo angkatan
				$sql_angkatan="SELECT * FROM jbsakad.angkatan WHERE aktif=1 AND departemen='$departemen' ORDER BY replid DESC";
				$result_angkatan=QueryDB($sql_angkatan);
				while ($row_angkatan = mysql_fetch_array($result_angkatan)) {
					if ($idangkatan = "") 
						$idangkatan = $row_angkatan['angkatan'];
			?>
			<option value="<?=$row_angkatan['replid']?>"<?=StringIsSelected($row_angkatan['replid'], $idangkatan)?>><?=$row_angkatan['angkatan']?></option>
	<?
    		} 
	// Akhir Olah Data angkatan
			?>
		</select>        </td>
  	</tr>
  	<tr>
    	<td><strong>Year Joining</strong></td>
    	<td colspan="2">
        <input type="text" name="tahunmasuk" id="tahunmasuk" size="5" maxlength="4" onFocus="showhint('Year Joining should not leave empty', this, event, '120px');panggil('tahunmasuk')" value="<?=$tahunmasuk?>"  onKeyPress="return focusNext('nis', event)" onBlur="unfokus('tahunmasuk')"/></td>
  	</tr>
  	<tr>
    	<td><strong>Student ID</strong></td>
    	<td colspan="2">
        <input type="text" name="nis" id="nis" size="20" maxlength="20" class="ukuran" value="<?=$nis?>"  onKeyPress="return focusNext('nisn', event)" onFocus="showhint('Student ID should not leave empty', this, event, '120px');panggil('nis')" onBlur="unfokus('nis')"/>        </td>
  	</tr>
  	<tr>
  	  <td>National Student ID</td>
  	  <td colspan="2">
      	<input type="text" name="nisn" id="nisn" size="50" maxlength="50" class="ukuran" value="<?=$nisn?>"  onKeyPress="return focusNext('nama', event)" />
      </td>
	  </tr>
 	<tr>
    	<td><strong>Name</strong></td>
    	<td colspan="2">
        <input type="text" name="nama" id="nama" size="30" maxlength="100" onFocus="showhint('Student Full Name should not leave empty', this, event, '120px');panggil('nama')"  value="<?=$nama?>"  onKeyPress="return focusNext('panggilan', event)" onBlur="unfokus('nama')"/></td>
  	</tr>
  	<tr>
    	<td>Nickname</td>
    	<td colspan="2">
        <input type="text" name="panggilan" id="panggilan" size="30" maxlength="30" onFocus="showhint('Nickname should not exceed 30 characters', this, event, '120px');panggil('panggilan')"  value="<?=$panggilan?>"  onKeyPress="return focusNext('kelamin', event)" onBlur="unfokus('panggilan')"/></td>
 	</tr>
  	<tr>
    	<td><strong>Gender</strong></td>
    	<td colspan="2">&nbsp;
    	  <input type="radio" id="kelamin2" name="kelamin" value="l"  
    	<? if ($kelamin=="1")
		  	echo "checked";
		  else
		  	echo "checked";
		?>
		   onkeypress="return focusNext('tmplahir', event)" />
    	  Male&nbsp;&nbsp;<input type="radio" id="kelamin" name="kelamin" value="p"
        <? if ($kelamin=="p")
		  echo "checked"; ?>  onKeyPress="return focusNext('tmplahir', event)"/>&nbsp;Female</td>
  	</tr>
  	<tr>
    	<td><strong>Birth Place</strong></td>
    	<td colspan="2"><input type="text" name="tmplahir" id="tmplahir" size="30" maxlength="50" onFocus="showhint('Birth Place should not leave empty', this, event, '120px');panggil('tmplahir')"  value="<?=$tmplahir?>"  onKeyPress="return focusNext('tgllahir', event)" onBlur="unfokus('tmplahir')"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  	</tr>
  	<tr>
        <td><strong>Date of Birth</strong></td>
    	<td colspan="2">
            <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td>
                <div id="tgl_info">
                <select name="tgllahir" id="tgllahir" onKeyPress="return focusNext('blnlahir', event)" onFocus="panggil('tgllahir')" onBlur="unfokus('tgllahir')">
                <option value="">[Date]</option>  
                <? 	for ($tgl=1;$tgl<=$n;$tgl++){ ?>
                <option value="<?=$tgl?>" <?=IntIsSelected($tgllahir, $tgl)?>><?=$tgl?></option>        
                <?	}	?>
                </select>
                </div>                </td>
                <td>
                <select name="blnlahir" id="blnlahir"  onKeyPress="return focusNext('thnlahir', event)" onChange="change_bln()" onFocus="panggil('blnlahir')" onBlur="unfokus('blnlahir')">
                <option value="">[Month]</option>  
                <? 	for ($i=1;$i<=12;$i++) { ?>
                <option value="<?=$i?>" <?=IntIsSelected($blnlahir, $i)?>><?=NamaBulan($i)?></option>	
                <?	} ?>
                </select>
                <input type="text" name="thnlahir" id="thnlahir" size="5" maxlength="4" onFocus="showhint('Year of Birth should not leave empty', this, event, '120px');panggil('thnlahir')"  value="<?=$thnlahir?>"  onKeyPress="return focusNext('agama', event)" onBlur="unfokus('thnlahir')"/>                </td>
           	</tr>
            </table>    	</td>
  	</tr>
  	<tr>
    	<td><strong>Religion</strong></td>
    	<td colspan="2">
        	<div id="InfoAgama">
            <select name="agama" id="agama" class="ukuran"  onKeyPress="return focusNext('suku', event)" onFocus="panggil('agama')" onBlur="unfokus('agama')">
            <option value="">[Select Religion]</option>
            <? // Olah untuk combo agama
            $sql_agama="SELECT replid,agama,urutan FROM jbsumum.agama ORDER BY urutan";
            $result_agama=QueryDB($sql_agama);
            while ($row_agama = mysql_fetch_array($result_agama)) {
            ?>
            <option value="<?=$row_agama['agama']?>"<?=StringIsSelected($row_agama['agama'],$agama)?>><?=$row_agama['agama']?></option>
            <?
            } 
            // Akhir Olah Data agama
            ?>
            </select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onClick="tambah_agama();" onMouseOver="showhint('Add Religion', this, event, '50px')" />    
            <? } ?>
            </div>    	</td>
  	</tr>
    <tr>
    	<td><strong>Ethnicity</strong></td>
    	<td colspan="2">
            <div id="InfoSuku">
            <select name="suku" id="suku" class="ukuran"  onkeypress="return focusNext('status', event)" onFocus="panggil('suku')" onBlur="unfokus('suku')">
                <option value="">[Select Ethnicity]</option>
<?              $sql_suku="SELECT suku,urutan,replid FROM jbsumum.suku ORDER BY urutan";
                $result_suku=QueryDB($sql_suku);
                while ($row_suku = mysql_fetch_array($result_suku))
                {
                    ?>
                    <option value="<?=$row_suku['suku']?>"<?=StringIsSelected($row_suku['suku'], $suku)?> >
                    <?=$row_suku['suku']?>
                    </option>
<?              }   ?>
            </select>
<?          if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                <img src="../images/ico/tambah.png" onClick="tambah_suku();" onMouseOver="showhint('Add Ethnicity', this, event, '50px')" />
<?          } ?>
            </div>
        </td>
  	</tr>
  	
  	<tr>
    	<td><strong>Status</strong></td>
    	<td colspan="2">
            <div id="InfoStatus">
            <select name="status" id="status" class="ukuran"  onKeyPress="return focusNext('kondisi', event)" onFocus="panggil('status')" onBlur="unfokus('status')">
            <option value="">[Select Status]</option>
            <? // Olah untuk combo status
            $sql_status="SELECT replid,status,urutan FROM jbsakad.statussiswa ORDER BY urutan";
            $result_status=QueryDB($sql_status);
            while ($row_status = mysql_fetch_array($result_status)) {
            //	if ($status=="")
            //		$status=$row_status['status'];
            ?>
            <option value="<?=$row_status['status']?>"<?=StringIsSelected($row_status['status'],$status)?> ><?=$row_status['status']?></option>
            <?
            } 
            // Akhir Olah Data status
            ?>
            </select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onClick="tambah_status();" onMouseOver="showhint('Add Status', this, event, '50px')"/>    
            <? } ?>
            </div> </td>
  	</tr>
  	<tr>
    	<td><strong>Conditions</strong></td>
    	<td colspan="2">
            <div id="InfoKondisi">
            <select name="kondisi" id="kondisi" class="ukuran"  onKeyPress="return focusNext('warga', event)" onFocus="panggil('kondisi')" onBlur="unfokus('kondisi')">
            <option value="">[Select Conditions]</option>
            <? // Olah untuk combo kondisi
            $sql_kondisi="SELECT kondisi,urutan FROM jbsakad.kondisisiswa ORDER BY urutan";
            $result_kondisi=QueryDB($sql_kondisi);
            while ($row_kondisi = mysql_fetch_array($result_kondisi)) {
            //	if ($kondisi=="")
            //		$kondisi=$row_kondisi['kondisi'];
            ?>
            <option value="<?=$row_kondisi['kondisi']?>" <?=StringIsSelected($row_kondisi['kondisi'],$kondisi)?> ><?=$row_kondisi['kondisi']?>
            </option>
            <?
            } 
            // Akhir Olah Data kondisi
            ?>
            </select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onClick="tambah_kondisi();" onMouseOver="showhint('Add Conditions', this, event, '50px')"/>
            <? } ?>
            </div></td>
    </tr>
  	<tr>
    	<td>Citizenship</td>
    	<td colspan="2">
            <input type="radio" id="warga" name="warga" value="Indonesian Citizen" 
            <? 	if ($warga=="Indonesian Citizen" || $warga=="")
                    echo "checked";
                else
                    echo "checked";
            ?> onKeyPress="return focusNext('urutananak', event)"
            />&nbsp;Indonesian Citizen&nbsp;&nbsp;
            <input type="radio" id="warga" name="warga" value="Other Citizen"
            <? 	if ($warga=="Other Citizen")
                    echo "checked"
            ?> onKeyPress="return focusNext('urutananak', event)"
            />&nbsp;Other Citizen</td>
  	</tr>
 	<tr>
    	<td>Child #</td>
    	<td colspan="2">
            <input type="text" name="urutananak" id="urutananak" size="3" maxlength="3" onFocus="showhint('Child # should not exceed 3 digits', this, event, '120px');panggil('urutananak')" value="<?=$urutananak ?>"  onKeyPress="return focusNext('jumlahanak', event)" onBlur="unfokus('urutananak')"/>&nbsp;from&nbsp;
            <input type="text" name="jumlahanak" id="jumlahanak" size="3" maxlength="3" onFocus="showhint('Siblings should not exceed 3 digits', this, event, '120px');panggil('jumlahanak')"  value="<?=$jumlahanak?>"  onKeyPress="return focusNext('bahasa', event)" onBlur="unfokus('jumlahanak')"/>&nbsp;siblings</td>
  	</tr>
  	<tr>
    	<td>Language</td>
    	<td colspan="2">
        	<input type="text" name="bahasa" id="bahasa" size="30" maxlength="60" onFocus="showhint('Language should not exceed 60 characters', this, event, '120px');panggil('bahasa')"  value="<?=$bahasa?>"  onKeyPress="return focusNext('alamatsiswa', event)" onBlur="unfokus('bahasa')"/></td>
 	 </tr>
  	<tr>
        <td>Photo</td>
    	<td colspan="2"><input type="file" name="file_data" id="file_data" size="25" style="width:215px" value="<?=$file_data?>"/></td>
  	</tr>
  	<tr>
    	<td valign="top">Address</td>
    	<td colspan="2">
        	<textarea name="alamatsiswa" class="Ukuranketerangan" id="alamatsiswa" onFocus="showhint('Student Address should not exceed 255 characters', this, event, '120px');panggil('alamatsiswa')" onKeyUp="change_alamat()"  onKeyPress="return focusNext('kodepos', event)"  onblur="unfokus('alamatsiswa')"><?=$alamatsiswa?></textarea></td>
  	</tr>
  	<tr>
    	<td>Post Code</td>
    	<td colspan="2">
        	<input type="text" name="kodepos" id="kodepos" size="5" maxlength="8" onFocus="showhint('Post Code should not exceed 8 digits', this, event, '120px');panggil('kodepos')" value="<?=$kodepos?>"  onKeyPress="return focusNext('telponsiswa', event)" onBlur="unfokus('kodepos')"/></td>
  	</tr>
  	<tr>
    	<td>Phone</td>
    	<td colspan="2">
        	<input type="text" name="telponsiswa" id="telponsiswa" class="ukuran" maxlength="20" onFocus="showhint('Phone should not exceed 20 digits', this, event, '120px');panggil('telponsiswa')" value="<?=$telponsiswa?>"  onKeyPress="return focusNext('hpsiswa', event)" onBlur="unfokus('telponsiswa')"/></td>
    </tr>
  	<tr>
    	<td>Mobile</td>
    	<td colspan="2">
        	<input type="text" name="hpsiswa" id="hpsiswa" class="ukuran" maxlength="20" onFocus="showhint('Mobile should not exceed 20 digits', this, event, '120px');panggil('hpsiswa')" value="<?=$hpsiswa?>" onKeyPress="return focusNext('emailsiswa', event)" onBlur="unfokus('hpsiswa')"/>      </td>
  	</tr>
  	<tr>
    	<td>Email</td>
    	<td colspan="2">
        	<input type="text" name="emailsiswa" id="emailsiswa" size="30" maxlength="100" onFocus="showhint('Email should not exceed 100 characters', this, event, '120px');panggil('emailsiswa')"  value="<?=$emailsiswa?>"  onKeyPress="return focusNext('dep_asal', event)" onBlur="unfokus('emailsiswa')"/></td>
  	</tr>
  	<tr>
    	<td rowspan="2" valign="top">Past School</td>
        <td>
			<div id="depInfo">
        	<select name="dep_asal" id="dep_asal"  onKeyPress="return focusNext('sekolah', event)" onChange="change_departemen(0)" style="width:150px;" onFocus="panggil('dep_asal')" onBlur="unfokus('dep_asal')"> 
                <option value="">[Select Department]</option>
            <? // Olah untuk combo departemen
            $sql_departemen="SELECT DISTINCT departemen FROM jbsakad.asalsekolah ORDER BY departemen";   
            $result_departemen=QueryDB($sql_departemen);
            while ($row_dep = mysql_fetch_array($result_departemen)) {
            
            ?>
            <option value="<?=$row_dep['departemen']?>" <?=StringIsSelected($row_dep['departemen'], $dep_asal)?>><?=$row_dep['departemen']?></option>
            <?
                }
            ?>
    		</select>
			</div>        </td>
        <td></td>
   	</tr>
	<tr>
    	<td colspan="2">
        <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td>
            <div id="sekolahInfo">
            <select name="sekolah" id="sekolah" onKeyPress="return focusNext('ketsekolah', event)" style="width:150px;" onFocus="panggil('sekolah')"  onblur="unfokus('sekolah')">
            <option value="">[Select Past School]</option>
            <? // Olah untuk combo sekolah
            $sql_sekolah="SELECT sekolah FROM jbsakad.asalsekolah WHERE departemen='$dep_asal' ORDER BY urutan";
            $result_sekolah=QueryDB($sql_sekolah);
            while ($row_sekolah = mysql_fetch_array($result_sekolah)) {
                
            ?>
           <option value="<?=$row_sekolah['sekolah']?>" <?=StringIsSelected($row_sekolah['sekolah'],$sekolah)?>>
            <?=$row_sekolah['sekolah']?>
            </option>
          <?
            } 
            // Akhir Olah Data sekolah
            ?>
            </select></div>            </td>
            <td valign="middle">
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onClick="tambah_asal_sekolah();" onMouseOver="showhint('Add Past School', this, event, '80px')"/>
            <? } ?>            </td>
     	</tr>
        </table>        </td>
	</tr>
  	<tr>
    	<td valign="top">Past School <br />Info      </td>
    	<td colspan="2">
        	<textarea name="ketsekolah" cols="30" rows="2" id="ketsekolah" onFocus="showhint('Past School info should not exceed 255 characters', this, event, '120px');panggil('ketsekolah')" class="Ukuranketerangan" onKeyPress="return focusNext('gol', event)" onBlur="unfokus('ketsekolah')"><?=$ketsekolah?></textarea>     	</td>
  	</tr>
	</table>    
	<script language='JavaScript'>
	    //Tables('table', 1, 0);
	</script>
	</td><!-- Akhir Kolom Kiri-->
    <td width="1%" align="center" valign="middle" style="border-left:1px dashed #333333; border-width:thin"></td>
    <td width="*" valign="top"><!-- Kolom Kanan-->
    <table width="100%" border="0" cellspacing="0" id="table" >
  	<tr>
    	<td height="30" colspan="3" valign="top">
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Health History</strong></font>
        <!--hr width="375" style="line-height:1px; border-style:dashed" align="left" color="#000000"/-->
        <div style="border-bottom:1px dashed #666666; border-width:thinl; margin-bottom:5px; margin-top:3px;"></div>
        </td>
    </tr>
    <tr>
    	<td width="20%" valign="top">Blood Type</td>
    	<td colspan="2">
            <input type="radio" name="gol" id="gol" value="A" 
            <? if ($gol=="A")
                   echo "checked"; 
                   ?> onKeyPress="return focusNext('berat', event)"/>&nbsp;A&nbsp;&nbsp;
            <input type="radio" name="gol" id="gol2" value="AB"
            <? if ($gol=="B")
                    echo "checked"; 
                    ?> onKeyPress="return focusNext('berat', event)"/>&nbsp;AB&nbsp;&nbsp;
            <input type="radio" name="gol" id="gol" value="B" 
            <? if ($gol=="AB")
                    echo "checked";
                    ?> onKeyPress="return focusNext('berat', event)"/>&nbsp;B&nbsp;&nbsp;
            <input type="radio" name="gol" id="gol" value="O" 
            <? if ($gol=="O")
                    echo "checked"
                    ?> onKeyPress="return focusNext('berat', event)"/>&nbsp;O&nbsp;&nbsp;
            <input type="radio" name="gol" id="gol" value="" 
            <? if ($gol=="")
                echo "checked" ?> onKeyPress="return focusNext('berat', event)"/><em>(don't have any data)</em></td>
  	</tr>
  	<tr>
    	<td>Body Weight</td>
    	<td colspan="2"><input name="berat" type="text" size="6" maxlength="6" id="berat" onFocus="showhint('Body Weight should not exceed 6 digits', this, event, '120px');panggil('berat')" value="<?=$berat?>" onKeyPress="return focusNext('tinggi', event)" onBlur="unfokus('berat')"/>&nbsp;kg</td>
  	</tr>
  	<tr>
   	 	<td>Body Height</td>
    	<td colspan="2"><input name="tinggi" type="text" size="6" maxlength="6" id="tinggi" onFocus="showhint('Body Height should not exceed 6 digits', this, event, '120px');panggil('tinggi')" value="<?=$tinggi?>" onKeyPress="return focusNext('kesehatan', event)" onBlur="unfokus('tinggi')" />&nbsp;cm</td>
  	</tr>
  	<tr>
    	<td valign="top">Illness History</td>
    	<td colspan="2"><textarea name="kesehatan" cols="30" id="kesehatan" onFocus="showhint('Illness History should not exceed 255 characters', this, event, '120px');panggil('kesehatan')" class="Ukuranketerangan" onKeyPress="return focusNext('namaayah', event)" onBlur="unfokus('kesehatan')"><?=$kesehatan?></textarea></td>
  	</tr>
  	<tr>
    	<td height="30" colspan="3">
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Student Parent Data</strong></font>
		<!--hr width="375" style="line-height:1px; border-style:dashed" align="left" color="#000000"/-->
        <div style="border-bottom:1px dashed #666666; border-width:thinl; margin-bottom:5px; margin-top:3px;"></div>
        </td>
    </tr>
  	<tr>
    	<td>&nbsp;</td>
    	<td align="center" valign="middle" bgcolor="#DBD8F3"><strong>Father</strong></td>
    	<td align="center" valign="middle" bgcolor="#E9AFCF"><strong>Mother</strong></td>
  	</tr>
 	<tr>
    	<td valign="top">Name</td>
    	<td bgcolor="#DBD8F3">
        	<input name="namaayah" type="text" size="15" maxlength="100" id="namaayah" onFocus="showhint('Father name should not exceed 100 characters', this, event, '120px');panggil('namaayah')" value="<?=$namaayah?>" class="ukuran" onKeyPress="return focusNext('namaibu', event)" onBlur="unfokus('namaayah')" />    
        	<br />
        	<input type="checkbox" name="almayah" value="1"  title="Click here if Father has been passed away"
    		<? if ($almayah=="1") echo "checked";?>/>&nbsp;&nbsp;<font color="#990000" size="1">(Late)</font>        </td>
    	<td bgcolor="#E9AFCF">
        	<input name="namaibu" type="text" size="15" maxlength="100" id="namaibu" onFocus="showhint('Mother name should not exceed 100 characters', this, event, '120px');panggil('namaibu')"  value="<?=$namaibu?>" class="ukuran" onKeyPress="return focusNext('Infopendidikanayah', event)" onBlur="unfokus('namaibu')"/>    
            <br />
            <input type="checkbox" name="almibu" value="1"  title="Click here if Mother has been passed away"
            <? if ($almibu=="1") echo "checked"; ?>/>&nbsp;&nbsp;
            <font color="#990000" size="1">(Late)</font>        </td>
  	</tr>  	
  	<tr>
    	<td>Education</td>
    	<td bgcolor="#DBD8F3">
        	<div id = "pendidikanayahInfo">
            <select name="pendidikanayah" id="Infopendidikanayah" class="ukuran" onKeyPress="return focusNext('Infopendidikanibu', event)" onFocus="panggil('Infopendidikanayah')" style="width:140px" onBlur="unfokus('Infopendidikanayah')">
            <option value="">[Select Education]</option> 
            <? // Olah untuk combo pendidikan ayah
            $sql_pend_ayah="SELECT pendidikan FROM jbsumum.tingkatpendidikan ORDER BY pendidikan";
            $result_pend_ayah=QueryDB($sql_pend_ayah);
            while ($row_pend_ayah = mysql_fetch_array($result_pend_ayah)) {
            ?>
            <option value="<?=$row_pend_ayah['pendidikan']?>"<?=StringIsSelected($row_pend_ayah['pendidikan'],$pendidikanayah)?>>
            <?=$row_pend_ayah['pendidikan']?>
            </option>
            <?
            } 
            // Akhir Olah Data sekolah
            ?>
            </select>
            </div>	  	</td>
    	<td bgcolor="#E9AFCF">
        	<table cellpadding="0" cellspacing="0">
            <tr>
               	<td>
                <div id = "pendidikanibuInfo">	
                <select name="pendidikanibu" id="Infopendidikanibu" class="ukuran" onKeyPress="return focusNext('Infopekerjaanayah', event)" onFocus="panggil('Infopendidikanibu')"  style="width:140px" onBlur="unfokus('Infopendidikanibu')">
                <option value="">[Select Education]</option>   
                <? // Olah untuk combo sekolah
                $sql_pend_ibu="SELECT pendidikan FROM jbsumum.tingkatpendidikan ORDER BY pendidikan";
                $result_pend_ibu=QueryDB($sql_pend_ibu);
                while ($row_pend_ibu = mysql_fetch_array($result_pend_ibu)) {
                    //if ($pendidikanibu=="")
                    //	$pendidikanibu=$row_pend_ibu['pendidikan'];
                ?>
                <option value="<?=$row_pend_ibu['pendidikan']?>"<?=StringIsSelected($row_pend_ibu['pendidikan'],$pendidikanibu) ?> >
                <?=$row_pend_ibu['pendidikan']?></option>
                <?
                } 
                // Akhir Olah Data sekolah
                ?>
                </select>
                </div>                </td>
                <td>
                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                <img src="../images/ico/tambah.png" onClick="tambah_pendidikan();" onMouseOver="showhint('Add Education Type', this, event, '80px')"/>
                <? } ?>                </td>
        	</tr>
            </table>      	</td>
 	</tr>
  	<tr>
    	<td>Occupation</td>
    	<td bgcolor="#DBD8F3">
        	<div id="pekerjaanayahInfo">
        	<select name="pekerjaanayah" id="Infopekerjaanayah" class="ukuran" onKeyPress="return focusNext('Infopekerjaanibu', event)" onFocus="panggil('Infopekerjaanayah')" style="width:140px" onBlur="unfokus('Infopekerjaanayah')">
            <option value="">[Select Occupation]</option>
            <? // Olah untuk combo sekolah
            $sql_kerja_ayah="SELECT pekerjaan FROM jbsumum.jenispekerjaan ORDER BY pekerjaan ASC";
            $result_kerja_ayah=QueryDB($sql_kerja_ayah);
            while ($row_kerja_ayah = mysql_fetch_array($result_kerja_ayah)) {
                //if ($pekerjaanayah=="")
                //	$pekerjaanayah=$row_kerja_ayah['pekerjaan'];
            ?>
            <option value="<?=$row_kerja_ayah['pekerjaan']?>"<?=StringIsSelected($row_kerja_ayah['pekerjaan'],$pekerjaanayah)?>>
            <?=$row_kerja_ayah['pekerjaan']?>
            </option>
            <?
            } 

            // Akhir Olah Data sekolah
            ?>
            </select>
            </div>	  	</td>
    	<td bgcolor="#E9AFCF">
        	<table cellpadding="0" cellspacing="0">
            <tr>
            	<td>
                <div id = "pekerjaanibuInfo">
                <select name="pekerjaanibu" id="Infopekerjaanibu"  class="ukuran" onKeyPress="return focusNext('penghasilanayah1', event)" onFocus="panggil('Infopekerjaanibu')" style="width:140px" onBlur="unfokus('Infopekerjaanibu')">
                <option value="">[Select Occupation]</option>
                <? // Olah untuk combo sekolah
                $sql_kerja_ibu="SELECT pekerjaan FROM jbsumum.jenispekerjaan ORDER BY pekerjaan ";
                $result_kerja_ibu=QueryDB($sql_kerja_ibu);
                while ($row_kerja_ibu = mysql_fetch_array($result_kerja_ibu)) {
                    //if ($pekerjaan=="")
                    //	$pekerjaanibu=$row_kerja_ibu['pekerjaan'];
                ?>
                <option value="<?=$row_kerja_ibu['pekerjaan']?>"<?=StringIsSelected($row_kerja_ibu['pekerjaan'],$pekerjaanibu)?>>
                <?=$row_kerja_ibu['pekerjaan']?></option>
                <?
                } 
                // Akhir Olah Data sekolah
                ?>
                </select>
                </div>                </td>
                <td>
				<? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                <img src="../images/ico/tambah.png" onClick="tambah_pekerjaan();" onMouseOver="showhint('Add Occupation Type', this, event, '80px')" />
                <? } ?>                </td>
           	</tr>
            </table>      	</td>
  	</tr>
  	<tr>
    	<td>Income</td>
    	<td bgcolor="#DBD8F3">
        <input type="text" name="penghasilanayah1" id="penghasilanayah1" class="ukuran" maxlength="20" size="15" value="<?=FormatRupiah($penghasilanayah) ?>" onKeyPress="return focusNext('penghasilanibu1', event)" onBlur="formatRupiah('penghasilanayah1');unfokus('penghasilanayah1')" onFocus="unformatRupiah('penghasilanayah1');panggil('penghasilanayah1')" onKeyUp="penghasilan_ayah()" />
        <input type="hidden" name="penghasilanayah" id="penghasilanayah" value="<?=$penghasilanayah?>">        </td>
    	<td colspan="2" bgcolor="#E9AFCF">
        <input type="text" name="penghasilanibu1" id="penghasilanibu1" class="ukuran" maxlength="20"  value="<?=FormatRupiah($penghasilanibu) ?>" onKeyPress="return focusNext('emailayah', event)" onBlur="formatRupiah('penghasilanibu1');unfokus('penghasilanibu1')" onFocus="unformatRupiah('penghasilanibu1');panggil('penghasilanibu1')" onKeyUp="penghasilan_ibu()" />
        <input type="hidden" name="penghasilanibu" id="penghasilanibu" value="<?=$penghasilanibu?>">        </td>
  	</tr>
  	<tr>
  	  <td>Parent Email</td>
  	  <td bgcolor="#DBD8F3"><input name="emailayah" type="text" size="15" maxlength="100" id="emailayah" onFocus="showhint('Father Email should not exceed 100 characters', this, event, '120px');panggil('emailayah')" value="<?=$emailayah?>" class="ukuran" onKeyPress="return focusNext('emailibu', event)" onBlur="unfokus('emailayah')" /></td>
  	  <td colspan="2" bgcolor="#E9AFCF"><input name="emailibu" type="text" size="15" maxlength="100" id="emailibu" onFocus="showhint('Mother Email should not exceed 100 characters', this, event, '120px');panggil('emailibu')" value="<?=$emailibu?>" class="ukuran" onKeyPress="return focusNext('namawali', event)" onBlur="unfokus('emailibu')" /></td>
	  </tr>
 	<tr>
    	<td>Guardian Name</td>
    	<td colspan="2">
        <input type="text" name="namawali" id="namawali" size="30" maxlength="100" value="<?=$namawali?>" onKeyPress="return focusNext('alamatortu', event)" onFocus="panggil('namawali')" onBlur="unfokus('namawali')"/></td>
  	</tr>
  	<tr>
    	<td valign="top">Parent Address<br /></td>
    	<td colspan="2"><textarea name="alamatortu" cols="30" id="alamatortu" class="Ukuranketerangan" onKeyPress="return focusNext('telponortu', event)" onFocus="panggil('alamatortu')" onBlur="unfokus('alamatortu')"><?=$alamatortu?></textarea>       </td>
    </tr>
  	<tr>
    	<td>Parent Phone</td>
    	<td colspan="2">
        <input type="text" name="telponortu" id="telponortu" class="ukuran" maxlength="20" value="<?=$telponortu?>" onKeyPress="return focusNext('hportu', event)" onFocus="panggil('telponortu')" onBlur="unfokus('telponortu')" /></td>
  	</tr>
  	<tr>
    	<td>Parent Mobile</td>
    	<td colspan="2"><input type="text" name="hportu" id="hportu" class="ukuran" maxlength="20"  value="<?=$hportu?>" onKeyPress="return focusNext('alamatsurat', event)" onFocus="panggil('hportu')" onBlur="unfokus('hportu')"/></td>
  	</tr>
    <!--
  	<tr>
    	<td>Parent Email</td>
    	<td colspan="2">
        <input type="text" name="emailortu" id="emailortu" maxlength="100" value="<?=$emailortu?>" class="ukuranemail" onKeyPress="return focusNext('alamatsurat', event)" onFocus="panggil('emailortu')"/>        </td>
  	</tr>
    -->
  	<tr>
    	<td height="30" colspan="3">
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Others</strong></font>
	    <!--hr width="375" style="line-height:1px; border-style:dashed" align="left" color="#000000"/-->
        <div style="border-bottom:1px dashed #666666; border-width:thinl; margin-bottom:5px; margin-top:3px;"></div>
        </td>
    </tr>
  	<tr>
    	<td valign="top">Mailing Address</td>
    	<td colspan="2">
        <textarea name="alamatsurat" cols="30" id="alamatsurat" class="Ukuranketerangan" onKeyPress="return focusNext('keterangan', event)" onFocus="panggil('alamatsurat')" onBlur="unfokus('alamatsurat')"><?=$alamatsurat?></textarea>        </td>
  	</tr>
  	<tr>
    	<td valign="top">Info</td>
    	<td colspan="2"><textarea id="keterangan" name="keterangan" class="Ukuranketerangan" onKeyPress="return focusNext('Simpan', event)" onFocus="panggil('keterangan')" onBlur="unfokus('keterangan')"><?=$keterangan?></textarea></td>
  	</tr>
	</table>    
	<script language='JavaScript'>
	    //Tables('table', 1, 0);
	</script>

	</td><!-- Akhir Kolom Kanan-->
</tr>
<tr height="50">
  	<td valign="middle" align="right">
  	<input type="Submit" value="Save" name="Simpan" id="Simpan" class="but" onFocus="panggil('Simpan')" onBlur="unfokus('Simpan')"/></td>
  	<td align="center" valign="middle">&nbsp;</td>
  	<td valign="middle"><input class="but" type="button" value="Close" name="Tutup"  onClick="tutup()" />
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
<?
CloseDb();
?>
</body>
</html>