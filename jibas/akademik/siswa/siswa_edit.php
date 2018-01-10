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
require_once('../include/rupiah.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../include/theme.php');
require_once('../include/imageresizer.php');
require_once('../cek.php');

$replid = $_REQUEST['replid']; 
$cek = 0;

$nis=CQ($_REQUEST['nis']);
$nisn=CQ($_REQUEST['nisn']);
$nis_lama=trim($_REQUEST['nis_lama']);
$idangkatan=$_REQUEST['idangkatan'];
$kelas = $_REQUEST['kelas'];
$departemen = $_REQUEST['departemen'];
$tahunmasuk=CQ($_REQUEST['tahunmasuk']);
$nama=CQ($_REQUEST['nama']);
//$nama=str_replace("'", "`", $nama);
$panggilan=CQ($_REQUEST['panggilan']);
$kelamin=CQ($_REQUEST['kelamin']);
$tmplahir=CQ($_REQUEST['tmplahir']);
$tgllahir=$_REQUEST['tgllahir'];
$blnlahir=$_REQUEST['blnlahir'];
$thnlahir=$_REQUEST['thnlahir'];;
$suku=$_REQUEST['suku'];
$agama=$_REQUEST['agama'];
$status=$_REQUEST['status'];
$kondisi=$_REQUEST['kondisi'];

$warga="Indonesian Citizen";
if (isset($_REQUEST['warga']))
	$warga = CQ($_REQUEST['warga']);

$urutananak = 1;
if (isset($_REQUEST['urutananak'])) 
	$urutananak=$_REQUEST['urutananak'];
$jumlahanak = 1;
if (isset($_REQUEST['jumlahanak'])) 
	$jumlahanak=$_REQUEST['jumlahanak'];

$bahasa=CQ($_REQUEST['bahasa']);
$alamatsiswa=CQ($_REQUEST['alamatsiswa']);
$kodepos=CQ($_REQUEST['kodepos']);
$telponsiswa=CQ($_REQUEST['telponsiswa']);
$hpsiswa=CQ(trim($_REQUEST['hpsiswa']));
$hpsiswa=str_replace(' ','',$hpsiswa);
$emailsiswa=CQ($_REQUEST['emailsiswa']);
$dep_asal=CQ($_REQUEST['dep_asal']);
$sekolah=CQ(stripslashes($_REQUEST['sekolah']));
$ketsekolah=CQ($_REQUEST['ketsekolah']);
$gol=$_REQUEST['gol'];

$berat = 0;
if (isset($_REQUEST['berat'])) 
	$berat=$_REQUEST['berat'];
$tinggi = 0;
if (isset($_REQUEST['tinggi'])) 
	$tinggi=$_REQUEST['tinggi'];
	
$kesehatan=CQ($_REQUEST['kesehatan']);
$namaayah=CQ($_REQUEST['namaayah']);
$namaibu=CQ($_REQUEST['namaibu']);

$pendidikanayah=$_REQUEST['pendidikanayah'];
$pendidikanibu=$_REQUEST['pendidikanibu'];
$pekerjaanayah=$_REQUEST['pekerjaanayah'];
$pekerjaanibu=$_REQUEST['pekerjaanibu'];

$penghasilanayah = 0;
if (isset($_REQUEST['penghasilanayah'])) 
	$penghasilanayah=$_REQUEST['penghasilanayah'];
$penghasilanibu = 0;
if (isset($_REQUEST['penghasilanibu'])) 
	$penghasilanibu=$_REQUEST['penghasilanibu'];
	
$namawali=CQ($_REQUEST['namawali']);
$alamatortu=CQ($_REQUEST['alamatortu']);
$telponortu=CQ($_REQUEST['telponortu']);
$hportu=CQ($_REQUEST['hportu']);
$hportu=str_replace(' ','',$hportu);
$emailayah=CQ($_REQUEST['emailayah']);
$emailibu=CQ($_REQUEST['emailibu']);
$alamatsurat=CQ($_REQUEST['alamatsurat']);
$keterangan=CQ($_REQUEST['keterangan']);

$almayah = 0;
if (isset($_REQUEST['almayah'])) 
	$almayah=$_REQUEST['almayah'];
$almibu = 0;
if (isset($_REQUEST['almibu'])) 
	$almibu=$_REQUEST['almibu'];

OpenDb();

$ERROR_MSG = "";
if (isset($_REQUEST['Simpan']))
{
    $sql = "SELECT COUNT(replid)
              FROM jbsakad.siswa
             WHERE Student ID = '$nis' AND replid <> $replid";
    $res = QueryDb($sql);
    $row = mysql_fetch_row($res);
    $countnis = (int)$row[0];
    
	$sql_cek = "SELECT k.kapasitas, COUNT(s.replid) 
				FROM kelas k, siswa s 
				WHERE k.replid = $kelas AND s.idkelas = k.replid AND k.replid <> '$_REQUEST[kelas_lama]' AND s.aktif = 1 GROUP BY kelas"; 
	
	$sql_kapasitas = "SELECT kapasitas FROM kelas WHERE replid = '$kelas'";
	$result_kapasitas = QueryDb($sql_kapasitas);
	$row_kapasitas = mysql_fetch_row($result_kapasitas);
	$kapasitas = $row_kapasitas[0];
	
	$sql_siswa = "SELECT COUNT(*) FROM siswa WHERE idkelas = '$kelas' AND aktif = 1";
	$result_siswa = QueryDb($sql_siswa);
	$row_siswa = mysql_fetch_row($result_siswa);
	$isi = $row_siswa[0];
	
	if ($kapasitas == $isi && $_REQUEST['kelas_lama'] != $kelas) 
	{
		$ERROR_MSG = "Do not have enough classroom to add more new students";
	}
    else if ($countnis > 0)
    {
        $ERROR_MSG = "National Student ID $nis has been used by another student";
    }
	else 
	{ 
		$lahir=$thnlahir."-".$blnlahir."-".$tgllahir;
		$date=date(j);
		$month=date(m);
		$year=date(Y);
		$kumplit = date(Y)."-".date(m)."-".date(j);
		
		if ($urutananak=="")
			$urutananak = 0;
		if ($jumlahanak=="")
			$jumlahanak = 0;
		if ($berat=="")
			$berat = 0;
		if ($tinggi=="")
			$tinggi = 0;
		if ($penghasilanayah =="")
			$penghasilanayah = 0;
		if ($penghasilanibu=="")
			$penghasilanibu = 0;
		
		$sekolah_sql = "asalsekolah = '$sekolah'";
		if ($sekolah == "")
			$sekolah_sql = "asalsekolah = NULL";
		$pendidikanayah_sql = "pendidikanayah = '$pendidikanayah'";
		if ($pendidikanayah == "")
			$pendidikanayah_sql = "pendidikanayah = NULL";
		$pendidikanibu_sql = "pendidikanibu = '$pendidikanibu'";
		if ($pendidikanibu == "")
			$pendidikanibu_sql = "pendidikanibu = NULL";
		$pekerjaanayah_sql = "pekerjaanayah = '$pekerjaanayah'";
		if ($pekerjaanayah == "")
			$pekerjaanayah_sql = "pekerjaanayah = NULL";
		$pekerjaanibu_sql = "pekerjaanibu = '$pekerjaanibu'";
		if ($pekerjaanibu == "")
			$pekerjaanibu_sql = "pekerjaanibu = NULL";
		$kodepos_sql = "kodepossiswa = '$kodepos'";
		if ($kodepos == "")
			$kodepos_sql = "kodepossiswa = NULL";
					
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
			
			$filename = "$tmp_path/ed-sis-tmp.jpg";
			ResizeImage($foto, 159, 120, 100, $filename);
			
			$fh = fopen($filename, "r");
			$foto_data = addslashes(fread($fh, filesize($filename)));
			fopen($fh);
			
			$gantifoto = ", foto='$foto_data'";
		} else {
			$gantifoto = "";
		}
		
		$sql_cek_nis = "SELECT * FROM siswa WHERE nis='$nis_lama' AND replid<>'$replid'";
		$res_cek_nis = QueryDb($sql_cek_nis);
		$num_cek_nis = @mysql_num_rows($res_cek_nis);
		
		if ($num_cek_nis==0)
		{
			$success = true;
			BeginTrans();

			$sql_simpan="UPDATE jbsakad.siswa SET nis='$nis', nama='$nama', panggilan='$panggilan', tahunmasuk='$tahunmasuk', idangkatan='$idangkatan', idkelas='$kelas', suku='$suku', agama='$agama', status='$status', kondisi='$kondisi', kelamin='$kelamin', tmplahir='$tmplahir', tgllahir='$lahir', warga='$warga', anakke='$urutananak', jsaudara='$jumlahanak', bahasa='$bahasa', berat='$berat', tinggi='$tinggi', darah='$gol', alamatsiswa='$alamatsiswa', kodepossiswa='$kodepos', telponsiswa='$telponsiswa', hpsiswa='$hpsiswa', emailsiswa='$emailsiswa', kesehatan='$kesehatan', $sekolah_sql, ketsekolah='$ketsekolah', namaayah='$namaayah', namaibu='$namaibu', almayah='$almayah', almibu='$almibu', $pendidikanayah_sql, $pendidikanibu_sql, $pekerjaanayah_sql, $pekerjaanibu_sql, wali='$namawali', penghasilanayah='$penghasilanayah', penghasilanibu='$penghasilanibu', alamatortu='$alamatortu', telponortu='$telponortu', hportu='$hportu', emailayah='$emailayah', emailibu='$emailibu', alamatsurat='$alamatsurat', keterangan='$keterangan' $gantifoto, nisn = '$nisn' WHERE replid = '$replid'";			
			QueryDbTrans($sql_simpan,$success);
			
			if ($success)
			{
				$sql_dept = "UPDATE jbsakad.riwayatdeptsiswa 
							 SET nis='$nis',departemen='$departemen',mulai='$kumplit' WHERE nis='$nis'";
				QueryDbTrans($sql_dept, $success);
			}
				
			if ($success)
			{
				$sql_kls = "UPDATE jbsakad.riwayatkelassiswa 
							SET nis='$nis',idkelas='$kelas',mulai='$kumplit' WHERE nis='$nis' AND idkelas='$kelas_lama'";
				QueryDbTrans($sql_kls, $success);
			}
			
			if ($success)
			{
				CommitTrans();	?>
				<script language="javascript">
					parent.opener.refresh_after_add();
					window.close();
				</script>
<?			} 
			else 
			{
				RollbackTrans(); ?>
				<script language="javascript">
					alert ('Failed to save data');
				</script>
<?			}
		} 
		else 
		{	?>
			<script language="javascript">
				alert ('Student ID <?=$nis_lama?> has been used');
			</script>
<?		}
	}
}

$sql_siswa="SELECT c.tahunmasuk, c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idangkatan, c.idkelas, c.suku, c.agama, c.status, c.kondisi, c.kelamin, c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.warga, c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa, c.telponsiswa, c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, c.almayah, c.almibu, c.pendidikanayah, c.pendidikanibu, c.pekerjaanayah, c.pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu, c.alamatortu, c.telponortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.replid AS tahunajaran, t.departemen, k.replid AS kelas, k.idtingkat AS tingkat,c.nisn AS nisn FROM siswa c, kelas k, tahunajaran t WHERE c.replid='$replid' AND k.replid = c.idkelas AND k.idtahunajaran = t.replid";

$result=QueryDb($sql_siswa);
$row_siswa=mysql_fetch_array($result);
$departemen = $row_siswa['departemen'];
$tahunajaran = $row_siswa['tahunajaran'];
$tingkat = $row_siswa['tingkat'];
$kelas = $row_siswa['kelas'];
$kelas_lama = $row_siswa['kelas'];
$blnlahir = (int)$row_siswa['bulan'];
$thnlahir = (int)$row_siswa['tahun'];

if ($row_siswa['asalsekolah'] <> NULL) 
{
	$aslSek = addslashes($row_siswa['asalsekolah']);
	$query = "SELECT departemen FROM asalsekolah WHERE sekolah = '$aslSek'";
	$hasil = QueryDb($query);	
	$row = mysql_fetch_array($hasil);
	$dep_asal = $row['departemen'];
	$sekolah = $row_siswa['asalsekolah'];
} 
else 
{	
	$dep_asal = "";
	$sekolah = "";
}

$n = JmlHari($blnlahir, $thnlahir);	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Edit Student Data]</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/rupiah.js"></script>
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
	var kondisi = document.main.status.value;
	var kelas = document.main.kelas.value;
	var kelas_lama = document.main.kelas_lama.value;
	var tahunajaran = document.main.tahunajaran.value;
	var file = document.main.file_data.value;
	
	if (tahunajaran.length == 0) {
		alert("Year of Teaching should not leave empty");
		document.getElementById('departemen').focus();
		return false;
	} 
	
	if (kelas.length == 0) {
		alert("Student Class should not leave empty");
		document.getElementById('departemen').focus();
		return false;
	} 
		
	if (kelas != kelas_lama) {
		var kapasitas = parseInt(document.main.kapasitas.value);
		var isi = parseInt(document.main.isi.value);
		if (kapasitas <= isi) {
			alert("Do not have enough classroom to add more new students");
			document.getElementById('kelas').focus();
			return false;	
		}
	}
		
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
		document.main.agama.focus();
		return false;
	}
	if (kondisi.length == 0) {
		alert("You must enter a data for Conditions");
		document.main.agama.focus();
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
			//document.getElementById('kodepos').value="";
			document.getElementById('kodepos').focus();
			return false;
		}
	}
	if (telponsiswa.length > 0){
		if(isNaN(telponsiswa)) {
			alert ('Phone data must be numeric');
			//document.getElementById('telponsiswa').value="";
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
			 if (blnlahir == 4 || blnlahir == 6 || blnlahir == 9 || blnlahir == 11){
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
	newWindow('siswa_add_kondisi.php', 'tambahKondisi','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_asal_sekolah(){
	var departemen = document.getElementById("dep_asal").value;
	newWindow('siswa_add_asalsekolah.php?departemen='+departemen, 'tambahAsalSekolah','500','400','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_pendidikan(){
	newWindow('siswa_add_pendidikan.php', 'tambahPendidikan','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah_pekerjaan(){
	newWindow('siswa_add_pekerjaan.php', 'tambahPekerjaan','500','425','resizable=1,scrollbars=1,status=0,toolbar=0')
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
	//refresh_pendidikan(pendidikan);
	//pendidikan=pendidikan_kiriman;
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
	var lain = new Array('nama','panggilan','tmplahir','thnlahir','urutananak','jumlahanak','bahasa','kodepos','telponsiswa','hpsiswa','emailsiswa','berat','tinggi','namaayah','namaibu','penghasilanayah1','penghasilanibu1','namawali','telponortu','hportu','emailortu','alamatsiswa','ketsekolah','kesehatan','alamatortu','alamatsurat','keterangan','tgllahir','blnlahir','suku','agama','status','kondisi','sekolah','dep_asal','Infopendidikanayah','Infopendidikanibu','Infopekerjaanayah','Infopekerjaanibu','nis','tahunmasuk','idangkatan','departemen','kelasInfo','tingkatInfo');
	
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


function change_dep() {
	var departemen = document.getElementById("departemen").value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkatInfo').value;	
	
	sendRequestText("siswa_edit_gettahunajaran.php", show_tahunajaran,"departemen="+departemen);
	//sendRequestText("siswa_edit_gettingkat.php", show_tingkat,"departemen="+departemen);
	//sendRequestText("siswa_edit_getkelas.php", show_kelas,"tahunajaran="+tahunajaran+"&tingkat="+tingkat);	
	//sendRequestText("siswa_edit_getkelas.php", show_kelas,"departemen="+departemen);
	
	sendRequestText("siswa_edit_getangkatan.php", show_angkatan,"departemen="+departemen);
	sendRequestText("../siswa_baru/getasalsekolah1.php", show_asalsekolah,"departemen="+departemen);
	//change_tingkat();
}

function show_tahunajaran(x) {
	var departemen = document.getElementById("departemen").value;
	document.getElementById("tahunajaranInfo").innerHTML = x;
	sendRequestText("siswa_edit_gettingkat.php", show_tingkat,"departemen="+departemen);
	
}

function show_tingkat(x) {
	document.getElementById("InfoTingkat").innerHTML = x;		
	change_tingkat();
}

function show_angkatan(x) {
	document.getElementById("InfoAngkatan").innerHTML = x;
}

function change_tingkat() {
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkatInfo').value;	
	
	sendRequestText("siswa_edit_getkelas.php", show_kelas,"tahunajaran="+tahunajaran+"&tingkat="+tingkat);
}

function show_kelas(x) {
	document.getElementById("InfoKelas").innerHTML = x;
	change_kelas();	
}

function change_kelas() {
	var kelas = document.getElementById('kelasInfo').value;	
	sendRequestText("siswa_edit_getkapasitas.php", show_kapasitas,"kelas="+kelas);	
}

function show_kapasitas(x) {
	document.getElementById("InfoKapasitas").innerHTML = x;	
}

function show_asalsekolah(x) {	
	document.getElementById("InfoSekolah").innerHTML = x;
	change_departemen(0);
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
	}
}
</script>
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" onLoad="document.getElementById('nama').focus();">
<div id="waitBox" style="position:absolute; visibility:hidden;">
<img src="../images/movewait.gif" border="0" />Please wait...
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Edit Student Data :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
	<form name="main" method="post" enctype="multipart/form-data" action="siswa_edit.php" onSubmit="return validate()">
	<input type="hidden" name="replid" id="replid" value="<?=$replid?>">
	<input type="hidden" name="kelas_lama" id="kelas_lama" value="<?=$kelas_lama?>">
    
<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr>
	<td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">	
	<tr>
		<td valign="top">
       	<table width = "98%" border = "0">
  		<tr valign="top">
    		<td width="18%"><strong>Department</strong></td>
    		<td width="*" colspan="2">
            <select name="departemen" id="departemen" onChange="change_dep()" style="width:260px;" onKeyPress="return focusNext('tingkat',event)" onFocus="panggil('departemen')">
            <?	$dep = getDepartemen(SI_USER_ACCESS());    
				foreach($dep as $value) {
					if ($departemen == "")
						$departemen = $value; ?>
              	<option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> >
             	<?=$value ?>
              	</option>
            <?	} ?>
            </select></td>
  		</tr>
  		<tr>
    		<td><strong>Year </strong></td>
    		<td colspan="2"><div id="tahunajaranInfo">
            <?  
			$sql = "SELECT replid,tahunajaran FROM tahunajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY replid DESC";
			$result = QueryDb($sql);
			$row = @mysql_fetch_array($result);	
			$tahunajaran = $row['replid'];				
		?>
        	<input type="text" name="tahun" id="tahun" size="20" readonly class="disabled" value="<?=$row['tahunajaran']?>" style="width:250px;"/>
        	<input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$row['replid']?>">   </div></td>
            
					
  		</tr>
  		<tr>
    		<td><strong>Class </strong></td>
    		<td width="7%">
            <div id="InfoTingkat">
        	<select name="tingkat" id="tingkatInfo" onChange="change_tingkat()" style="width:55px;" onKeyPress="return focusNext('kelas',event)" onFocus="panggil('tingkatInfo')">
   		 	<?	$sql = "SELECT replid,tingkat FROM tingkat where departemen='$departemen' AND aktif = 1 ORDER BY urutan";
				$result = QueryDb($sql);
				while ($row = @mysql_fetch_array($result)) {
			?>
    			<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tingkat)?> ><?=$row['tingkat']?></option>
    		<?	}	?>
  			</select>
            </div>
            </td>
            <td>
    		<div id="InfoKelas">
            <select name="kelas" id="kelasInfo" style="width:200px;" onKeyPress="return focusNext('idangkatan',event)" onFocus="panggil('kelasInfo')" onChange="change_kelas()">
            <?	$sql = "SELECT replid, kelas, kapasitas FROM kelas where idtingkat=$tingkat AND idtahunajaran=$tahunajaran AND aktif = 1 ORDER BY kelas";
				$result = QueryDb($sql);
				while ($row = @mysql_fetch_array($result)) {					
					$sql1 = "SELECT COUNT(*) FROM siswa WHERE idkelas = $row[0] AND aktif = 1";
					$result1 = QueryDb($sql1);
					$row1 = @mysql_fetch_row($result1); 				
			?>
            	<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row[replid], $kelas)?> >
               	<?=$row['kelas'].', kapasitas: '.$row['kapasitas'].', terisi: '.$row1[0]?>
                </option>
           	<?  } ?>
           	</select>
           	<input type="hidden" name="kelas_lama" id="kelas_lama"   value="<?php echo $kelas ?>">
            </div>
           
            </td>
  		</tr> 
        <tr>
        	<td colspan="2">
        	<div id="InfoKapasitas">
            <? 	$sql1 = "SELECT kapasitas FROM kelas WHERE replid = $kelas";
				$result1 = QueryDb($sql1);
				$row_cek1 = mysql_fetch_array($result1);
				$sql2 = "SELECT COUNT(*) AS jum FROM siswa WHERE idkelas = $kelas AND aktif = 1";
				$result2 = QueryDb($sql2);
				$row_cek2 = mysql_fetch_array($result2);
			?>
            <input type="hidden" name="kapasitas" id="kapasitas" value="<?=$row_cek1['kapasitas']?>" />
			<input type="hidden" name="isi" id="isi" value="<?=$row_cek2['jum']?>" />
            </div>
            </td>
       	</tr>
		</table>
        </td>
    	<td align="right"><img src="../library/gambar.php?replid=<?=$replid?>&table=siswa"   border="0"/>
     
        </td>
	</tr>
	</table>
    <br />
  	<table width="100%" border="0" cellspacing="0"><!-- -->
  	<tr>
    	<td width="45%" valign="top"><!-- Kolom Kiri-->
        <table width="100%" border="0" cellspacing="0">
  		<tr>
    		<td colspan="3" height="30"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Student Personal Data</font>
            <!--hr width="300" style="line-height:1px; border-style:dashed; border-width:thin" align="left" color="#000000" /-->
            <div style="border-bottom:1px dashed #666666; border-width:thinl; margin-bottom:5px; margin-top:3px;"></div>
            </td>
        </tr>
        <tr>
            <td width="22%"><strong>Graduates</strong></td>
            <td colspan="2"><div id="InfoAngkatan">    
            <select name="idangkatan" id="idangkatan" class="ukuran" style="width:195px;" onKeyPress="return focusNext('tahunmasuk', event)" onFocus="panggil('idangkatan')" onBlur="unfokus('idangkatan')">
                
                <? // Olah untuk combo angkatan
                    $sql_angkatan="SELECT * FROM jbsakad.angkatan WHERE aktif=1 AND departemen='$departemen' ORDER BY replid DESC";
                    $result_angkatan=QueryDB($sql_angkatan);
                    while ($row_angkatan = mysql_fetch_array($result_angkatan)) {
                ?>
                <option value="<?=$row_angkatan['replid']?>"<?=IntIsSelected($row_angkatan['replid'], $row_siswa['idangkatan'])?>>
                <?=$row_angkatan['angkatan']?></option>
                <?  } 	
                // Akhir Olah Data angkatan
                ?>
            </select></div></td>
        </tr>
        <tr>
            <td><strong>Year Joining</strong></td>
            <td colspan="2">
                <input type="text" name="tahunmasuk" id="tahunmasuk" size="5" maxlength="4" onFocus="showhint('Year Joining should not leave empty', this, event, '120px');panggil('tahunmasuk')" value="<?=$row_siswa['tahunmasuk']?>" onKeyPress="return focusNext('nis', event)" onBlur="unfokus('tahunmasuk')"/> </td>
        </tr>
        <tr>
            <td><strong>Student ID</strong></td>
            <td colspan="2">
                <input type="text" name="nis" id="nis" size="20" maxlength="20" value="<?=$row_siswa['nis']?>"  onKeyPress="return focusNext('nisn', event)" onFocus="showhint('Student ID should not leave empty', this, event, '120px');panggil('nis')"  onblur="unfokus('nis')"/><input type="hidden" name="nis_lama" value="<?=$row_siswa['nis']?>"></td>
        </tr>
        <tr>
          <td>National Student ID</td>
          <td colspan="2">
          	<input type="text" name="nisn" id="nisn"  class="ukuran" size="50" maxlength="50" value="<?=$row_siswa['nisn']?>"  onKeyPress="return focusNext('nama', event)" />
          </td>
        </tr>
        <tr>
            <td><strong>Name</strong></td>
            <td colspan="2">
                <input type="text" name="nama" id="nama" size="30" maxlength="100" onFocus="showhint('Student Full Name should not leave empty', this, event, '120px');panggil('nama')" value="<?=$row_siswa['nama']?>" onKeyPress="return focusNext('panggilan', event)" onBlur="unfokus('nama')"/></td>
        </tr>
        <tr>
            <td>Nickname</td>
            <td colspan="2">
                <input type="text" name="panggilan" id="panggilan" size="30" maxlength="30" onFocus="showhint('Nickname should not exceed 30 characters', this, event, '120px');panggil('panggilan')" value="<?=$row_siswa['panggilan']?>" onKeyPress="return focusNext('kelamin', event)" onBlur="unfokus('panggilan')" /></td>
        </tr>
        <tr>
            <td><strong>Gender</strong></td>
            <td colspan="3"><input type="radio" id="kelamin" name="kelamin" value="l" 
            <? 	if ($row_siswa['kelamin']=="l")
                    echo "checked='checked'";	?> onKeyPress="return focusNext('tmplahir', event)"
            />&nbsp;Male&nbsp;&nbsp;<input type="radio" id="kelamin" name="kelamin" value="p" 
            <? 	if ($row_siswa[kelamin]=="p")
                    echo "checked='checked'";
            ?> onKeyPress="return focusNext('tmplahir', event)"
            />&nbsp;Female</td>
        </tr>
        <tr>
            <td>Birth Place</td>
            <td colspan="2"><input type="text" name="tmplahir" id="tmplahir" size="30" maxlength="50" onFocus="showhint('Birth Place should not leave empty', this, event, '120px');panggil('tmplahir')" value="<?=$row_siswa[tmplahir]?>" onKeyPress="return focusNext('tgllahir', event)" onBlur="unfokus('tmplahir')"/></td>
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
                    <?	for ($tgl=1;$tgl<=$n;$tgl++){	?>
                    <option value="<?=$tgl?>" <?=StringIsSelected($tgl, $row_siswa['tanggal'])?>><?=$tgl?></option>
                    <? } ?>
                    </select>
                    </div>                    </td>
                    <td>
                    <select name="blnlahir" id="blnlahir" onChange="change_bln()" onKeyPress="return focusNext('thnlahir', event)" onFocus="panggil('blnlahir')" onBlur="unfokus('blnlahir')">
                    <option value="">[Month]</option>  
                    <? 	for ($i=1;$i<=12;$i++) { ?>
                    <option value="<?=$i?>" <?=IntIsSelected($row_siswa['bulan'], $i)?>><?=NamaBulan($i)?></option>	
                    <?	} ?>
                    </select>
                    <input type="text" name="thnlahir" id="thnlahir" size="5" maxlength="4" onFocus="showhint('Year of Birth should not leave empty', this, event, '120px');panggil('thnlahir')" value="<?=$row_siswa['tahun']?>" onKeyPress="return focusNext('agama', event)" onBlur="unfokus('thnlahir')"/>                    </td>
                </tr>
                </table>            </td>
        </tr>
        
        <tr>
            <td><strong>Religion</strong></td>
            <td colspan="2"><div id="InfoAgama">
            <select name="agama" id="agama" class="ukuran" onKeyPress="return focusNext('suku', event)" onFocus="panggil('agama')" onBlur="unfokus('agama')">
            <option value="">[Select Religion]</option>
			<? // Olah untuk combo agama
                $sql_agama="SELECT replid,agama,urutan FROM jbsumum.agama ORDER BY urutan";
                $result_agama=QueryDB($sql_agama);
                while ($row_agama = mysql_fetch_array($result_agama)) {
            ?>
                <option value="<?=$row_agama['agama']?>" <?=StringIsSelected($row_agama['agama'], $row_siswa['agama'])?>>
                <?=$row_agama['agama']?>
                </option>
            <?  } 
            // Akhir Olah Data agama
            ?>
            </select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onClick="tambah_agama();" onMouseOver="showhint('Add Religion', this, event, '50px')"/>    
            <? } ?>
            </div></td>
        </tr>
        
        <tr>
            <td><strong>Ethnicity</strong></td>
            <td colspan="2"><div id="InfoSuku">
            <select name="suku" id="suku" class="ukuran" onKeyPress="return focusNext('status', event)" onFocus="panggil('suku')" onBlur="unfokus('suku')">
            <option value="">[Select Ethnicity]</option>
			<? // Olah untuk combo suku
                $sql_suku="SELECT suku,urutan,replid FROM jbsumum.suku ORDER BY urutan";
                $result_suku=QueryDB($sql_suku);
                while ($row_suku = mysql_fetch_array($result_suku)) {
            ?>
                <option value="<?=$row_suku['suku']?>" <?=StringIsSelected($row_suku['suku'], $row_siswa['suku'])?>>
                <?=$row_suku['suku']?>
                </option>
            <?   }
        // Akhir Olah Data suku
            ?>
            </select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onClick="tambah_suku();" onMouseOver="showhint('Add Ethnicity', this, event, '50px')" />
            <? } ?>
            </div></td>
        </tr>
        
        <tr>
            <td><strong>Status</strong></td>
            <td colspan="2"><div id="InfoStatus">
            <select name="status" id="status" class="ukuran" onKeyPress="return focusNext('kondisi', event)" onFocus="panggil('status')" onBlur="unfokus('status')">
            <option value="">[Select Status]</option>
			<? // Olah untuk combo status
                $sql_status="SELECT replid,status,urutan FROM jbsakad.statussiswa ORDER BY urutan";
                $result_status=QueryDB($sql_status);
                while ($row_status = mysql_fetch_array($result_status)) {
            ?>
                <option value="<?=$row_status['status']?>" <?=StringIsSelected($row_status['status'], $row_siswa['status'])?>>
                <?=$row_status['status']?>
                </option>
            <?  } 
            // Akhir Olah Data status
            ?>
            </select>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <img src="../images/ico/tambah.png" onClick="tambah_status();" onMouseOver="showhint('Add Status', this, event, '50px')"/>  
            <? } ?>
            </div></td>
        </tr>
        <tr>
            <td><strong>Conditions</strong></td>
            <td colspan="2"><div id="InfoKondisi">
            <select name="kondisi" id="kondisi" class="ukuran" onKeyPress="return focusNext('warga', event)" onFocus="panggil('kondisi')" onBlur="unfokus('kondisi')">
            <option value="">[Select Conditions]</option>
			<? // Olah untuk combo kondisi
                $sql_kondisi="SELECT kondisi,urutan FROM jbsakad.kondisisiswa ORDER BY urutan";
                $result_kondisi=QueryDB($sql_kondisi);
                while ($row_kondisi = mysql_fetch_array($result_kondisi)) {
            ?>
                <option value="<?=$row_kondisi['kondisi']?>" <?=StringIsSelected($row_kondisi['kondisi'], $row_siswa['kondisi'])?>>
                <?=$row_kondisi['kondisi']?>
                </option>
            <?  } 
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
            <? 	if ($row_siswa[warga]=="Indonesian Citizen")
                    echo "checked='checked'"; ?> onKeyPress="return focusNext('urutananak', event)"
            />&nbsp;Indonesian Citizen&nbsp;&nbsp; <input type="radio" id="warga" name="warga" value="Other Citizen" 
            <? 	if ($row_siswa[warga]=="Other Citizen")
                    echo "checked='checked'"; ?> onKeyPress="return focusNext('urutananak', event)"
            />&nbsp;Other Citizen</td>
        </tr>
        <tr>
            <td>Child #</td>
            <td colspan="2"><input type="text" name="urutananak" id="urutananak" size="3" maxlength="3" onFocus="showhint('Child # should not exceed 3 digits', this, event, '120px');panggil('urutananak')" value="<?=$row_siswa['anakke']?>" onKeyPress="return focusNext('jumlahanak', event)" onBlur="unfokus('urutananak')" />
            &nbsp;from&nbsp;<input type="text" name="jumlahanak" id="jumlahanak" size="3" maxlength="3" onFocus="showhint('Siblings should not exceed 3 digits', this, event, '120px');panggil('jumlahanak')" value="<?=$row_siswa['jsaudara']?>" onKeyPress="return focusNext('bahasa', event)" onBlur="unfokus('jumlahanak')" />&nbsp;siblings</td>
        </tr>
        <tr>
            <td>Language</td>
            <td colspan="2"><input type="text" name="bahasa" id="bahasa" size="30" maxlength="60" onFocus="showhint('Language should not exceed 60 characters', this, event, '120px');panggil('bahasa')" value="<?=$row_siswa[bahasa]?>" onKeyPress="return focusNext('alamatsiswa', event)" onBlur="unfokus('bahasa')" /></td>
        </tr>
        <tr>
            <td>Photo</td>
            <td colspan="2"><input type="file" name="file_data" id="file_data" size="25" style="width:215px"/></td>
        </tr>
        <tr>
            <td valign="top">Address</td>
            <td colspan="2"><textarea name="alamatsiswa" id="alamatsiswa" maxlength="255" onFocus="showhint('Student Address should not exceed 255 characters', this, event, '120px');panggil('alamatsiswa')" class="Ukuranketerangan" onKeyUp="change_alamat()"  onKeyPress="return focusNext('kodepos', event)" onBlur="unfokus('alamatsiswa')"><?=$row_siswa[alamatsiswa]?></textarea></td>
        </tr>
        <tr>
            <td>Post Code</td>
            <td colspan="2"><input type="text" name="kodepos" id="kodepos" size="5" maxlength="8" onFocus="showhint('Post Code should not exceed 8 digits', this, event, '120px');panggil('kodepos')" value="<?=$row_siswa[kodepossiswa]?>" onKeyPress="return focusNext('telponsiswa', event)" onBlur="unfokus('kodepos')"/></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td colspan="2"><input type="text" name="telponsiswa" id="telponsiswa" size="20" maxlength="20" onFocus="showhint('Phone should not exceed 20 digits', this, event, '120px');panggil('telponsiswa')" value="<?=$row_siswa[telponsiswa]?>" class="ukuran" onKeyPress="return focusNext('hpsiswa', event)" onBlur="unfokus('telponsiswa')"/></td>
        </tr>
        <tr>
            <td>Mobile</td>
            <td colspan="2"><input type="text" name="hpsiswa" id="hpsiswa" size="20" maxlength="20" onFocus="showhint('Mobile should not exceed 20 digits', this, event, '120px');panggil('hpsiswa')" value="<?=$row_siswa[hpsiswa]?>" class="ukuran" onKeyPress="return focusNext('emailsiswa', event)" onBlur="unfokus('hpsiswa')"/>      </td>
        </tr>
        <tr>
            <td>Email</td>
            <td colspan="2"><input type="text" name="emailsiswa" id="emailsiswa" size="30" maxlength="100" onFocus="showhint('Email should not exceed 100 characters', this, event, '120px');panggil('emailsiswa')" value="<?=$row_siswa[emailsiswa]?>" class="ukuran" onKeyPress="return focusNext('dep_asal', event)" onBlur="unfokus('emailsiswa')"/></td>
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
				</div>          	</td>
             <td></td>
       	</tr>
        <tr>
            <td colspan="2">
            <table cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td>
            
            	<div id="sekolahInfo">
                <select name="sekolah" id="sekolah" onKeyPress="return focusNext('ketsekolah', event)" style="width:150px;" onFocus="panggil('sekolah')" onBlur="unfokus('sekolah')">
                <option value="">[Select Past School]</option>	
				<? // Olah untuk combo sekolah
                $sql_sekolah="SELECT sekolah FROM jbsakad.asalsekolah WHERE departemen='$dep_asal'  ORDER BY sekolah";
                $result_sekolah=QueryDB($sql_sekolah);
                while ($row_sekolah = mysql_fetch_array($result_sekolah)) {
                ?>
                <option value="<?=$row_sekolah[sekolah]?>" <?=StringIsSelected($row_sekolah['sekolah'], $sekolah)?>>
                <?=$row_sekolah['sekolah']?>
                </option>
                <?  } 
                // Akhir Olah Data sekolah
                ?>
                </select>
                </div></td>
                <td valign="middle">
                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                <img src="../images/ico/tambah.png" onClick="tambah_asal_sekolah();" onMouseOver="showhint('Add Past School', this, event, '80px')"/>
                <? } ?>            	</td>
          	</tr>
            </table>            </td>
        </tr>
        <tr>
            <td valign="top">Past School <br />Info      </td>
            <td colspan="2"><textarea name="ketsekolah" cols="30" rows="2" id="ketsekolah" onFocus="showhint('Past School info should not exceed 255 characters', this, event, '120px');panggil('ketsekolah')" class="Ukuranketerangan" onKeyPress="return focusNext('gol', event)" onBlur="unfokus('ketsekolah')"><?=$row_siswa['ketsekolah']?></textarea>            </td>
        </tr>
        </table>    
        <script language='JavaScript'>
            //Tables('table', 1, 0);
        </script>
        </td><!-- Akhir Kolom Kiri-->
        <td width="1%" align="center" valign="middle" style="border-left:1px dashed #333333; border-width:thin">&nbsp;</td>
        <td width="*" valign="top"><!-- Kolom Kanan-->
        <table width="100%" border="0" cellspacing="0" id="table">
        <tr>
            <td colspan="3" height="30" valign="top">
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Health History</font>
            <!--hr width="375" style="line-height:1px; border-style:dashed" align="left" color="#000000"/-->
            <div style="border-bottom:1px dashed #666666; border-width:thinl; margin-bottom:5px; margin-top:3px;"></div>
            </td>
        </tr>
        <tr>
            <td width="20%" valign="top">Blood Type</td>
            <td colspan="3">
            <input type="radio" id="gol" name="gol" value="A" 
            <? 	if ($row_siswa[darah]=="A")
                    echo "checked='checked'";	?> onKeyPress="return focusNext('berat', event)"	
            />&nbsp;A&nbsp;&nbsp;<input type="radio" id="gol" name="gol" value="AB" 
            <? 	if ($row_siswa[darah]=="AB")
                    echo "checked='checked'";	?> onKeyPress="return focusNext('berat', event)"
            />&nbsp;AB&nbsp;&nbsp;<input type="radio" id="gol" name="gol" value="B" 
            <?  if ($row_siswa[darah]=="B")
                    echo "checked='checked'";		?> onKeyPress="return focusNext('berat', event)"
            />&nbsp;B&nbsp;&nbsp;<input type="radio" id="gol" name="gol" value="O" 
            <? 	if ($row_siswa[darah]=="O")
                    echo "checked='checked'";		?> onKeyPress="return focusNext('berat', event)"
            />&nbsp;O&nbsp;&nbsp;<input type="radio" id="gol" name="gol" value="" 
            <? 	if ($row_siswa[darah]=="")
                    echo "checked='checked'";	?> onKeyPress="return focusNext('berat', event)"
            />&nbsp;<em>(don't have any data)</em></td>
        </tr>
        <tr>
            <td>Body Weight</td>
            <td colspan="2">
            <input name="berat" type="text" size="6" maxlength="6" id="berat" onFocus="showhint('Body Weight should not exceed 6 digits', this, event, '120px');panggil('berat')" value="<?=$row_siswa['berat']?>" onKeyPress="return focusNext('tinggi', event)" onBlur="unfokus('berat')"/>&nbsp;kg</td>
        </tr>
        <tr>
            <td>Body Height</td>
            <td colspan="2"><input name="tinggi" type="text" size="6" maxlength="6" id="tinggi" onFocus="showhint('Body Height should not exceed 6 digits', this, event, '120px');panggil('tinggi')" value="<?=$row_siswa['tinggi']?>" onKeyPress="return focusNext('kesehatan', event)" onBlur="unfokus('tinggi')"/>&nbsp;cm</td>
        </tr>
        <tr>
            <td valign="top">Illness History</td>
            <td colspan="2"><textarea name="kesehatan" type="text" size="35" maxlength="255" id="kesehatan" onFocus="showhint('Illness History should not exceed 255 characters', this, event, '120px');panggil('kesehatan')" class="Ukuranketerangan" onKeyPress="return focusNext('namaayah', event)" onBlur="unfokus('kesehatan')"><?=$row_siswa['kesehatan']?></textarea></td>
        </tr>
        <tr>
            <td colspan="3" height="30">
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Parent Data</font>
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
            <td bgcolor="#DBD8F3"><input name="namaayah" type="text" size="25" maxlength="100" id="namaayah" onFocus="showhint('Father name should not exceed 100 characters', this, event, '120px');panggil('namaayah')" value="<?=$row_siswa[namaayah]?>" class="ukuran" onKeyPress="return focusNext('namaibu', event)" onBlur="unfokus('namaayah')"/>
                <br />
                <input type="checkbox" name="almayah" value="1" 
                <?  if ($row_siswa[almayah]==1)	echo "checked='checked'"; ?> 
                title="Click here if Father has been passed away"/>&nbsp;&nbsp;<font color="#990000" size="1">(Late)</font>            </td>
            <td bgcolor="#E9AFCF"><input name="namaibu" type="text" size="25" maxlength="100" id="namaibu" onFocus="showhint('Mother name should not exceed 100 characters', this, event, '120px');panggil('namaibu')" value="<?=$row_siswa[namaibu]?>" class="ukuran" onKeyPress="return focusNext('Infopendidikanayah', event)" onBlur="unfokus('namaibu')"/>
                <br />
                <input type="checkbox" name="almibu" value="1"
                <? 	if ($row_siswa[almibu]==1)	echo "checked='checked'"; ?> 
                title="Click here if Mother has been passed away" />&nbsp;&nbsp;<font color="#990000" size="1">(Late)</font>            </td>
        </tr>
        <tr>
            <td>Education</td>
            <td bgcolor="#DBD8F3">
            	<div id = "pendidikanayahInfo">
                <select name="pendidikanayah" id="Infopendidikanayah" class="ukuran" onKeyPress="return focusNext('Infopendidikanibu', event)" onFocus="panggil('Infopendidikanayah')"  style="width:140px" onBlur="unfokus('Infopendidikanayah')">
                <option value="">[Select Education]</option>
				<? // Olah untuk combo pendidikan ayah
                $sql_pend_ayah="SELECT pendidikan FROM jbsumum.tingkatpendidikan ORDER BY pendidikan";
                $result_pend_ayah=QueryDB($sql_pend_ayah);
                while ($row_pend_ayah = mysql_fetch_array($result_pend_ayah)) {
                ?>
                <option value="<?=$row_pend_ayah['pendidikan']?>" <?=StringIsSelected($row_pend_ayah['pendidikan'], $row_siswa['pendidikanayah'])?>><?=$row_pend_ayah['pendidikan']?></option>
                <?  } 
                // Akhir Olah Data sekolah
                ?>
                </select>
                </div>            </td>
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
                    ?>
                    <option value="<?=$row_pend_ibu['pendidikan']?>" <?=StringIsSelected($row_pend_ibu['pendidikan'], $row_siswa['pendidikanibu'])?>><?=$row_pend_ibu['pendidikan']?>
                    </option>
                    <?  } 
                    // Akhir Olah Data sekolah
                    ?>
                    </select>
                    </div>                    </td>
                    <td>
                    <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                    <img src="../images/ico/tambah.png" onClick="tambah_pendidikan();" onMouseOver="showhint('Add Education Level', this, event, '80px')"/>
                    <? } ?>                	</td>
            	</tr>
            	</table>      		</td>
        </tr>
        <tr>
            <td>Occupation</td>
            <td bgcolor="#DBD8F3">
            	<div id="pekerjaanayahInfo">
                <select name="pekerjaanayah" id="Infopekerjaanayah" class="ukuran"  onKeyPress="return focusNext('Infopekerjaanibu', event)" onFocus="panggil('Infopekerjaanayah')"  style="width:140px" onBlur="unfokus('Infopekerjaanayah')">
                <option value="">[Select Occupation]</option>
				<? // Olah untuk combo sekolah
                $sql_kerja_ayah = "SELECT pekerjaan FROM jbsumum.jenispekerjaan ORDER BY pekerjaan";
                $result_kerja_ayah = QueryDb($sql_kerja_ayah);
                while ($row_kerja_ayah = mysql_fetch_array($result_kerja_ayah)) {
                ?>
                <option value="<?=$row_kerja_ayah['pekerjaan']?>" <?=StringIsSelected($row_kerja_ayah['pekerjaan'], $row_siswa['pekerjaanayah'])?>><?=$row_kerja_ayah['pekerjaan']?>
                </option>
                <?  } 
                // Akhir Olah Data sekolah
                ?>
                </select>
                </div>            </td>
            <td bgcolor="#E9AFCF">
            	<table cellpadding="0" cellspacing="0">
            	<tr>
            		<td>
                    <div id = "pekerjaanibuInfo">
                    <select name="pekerjaanibu" id="Infopekerjaanibu" class="ukuran"  onKeyPress="return focusNext('penghasilanayah1', event)" onFocus="panggil('Infopekerjaanibu')"  style="width:140px" onBlur="unfokus('Infopekerjaanibu')">
                    <option value="">[Select Occupation]</option>
                    <? // Olah untuk combo sekolah
                    $sql_kerja_ibu="SELECT pekerjaan FROM jbsumum.jenispekerjaan ORDER BY pekerjaan";
                    $result_kerja_ibu=QueryDb($sql_kerja_ibu);
                    while ($row_kerja_ibu = mysql_fetch_array($result_kerja_ibu)) {
                    ?>
                    <option value="<?=$row_kerja_ibu['pekerjaan']?>" <?=StringIsSelected($row_kerja_ibu['pekerjaan'], $row_siswa['pekerjaanibu'])?>><?=$row_kerja_ibu['pekerjaan']?></option>
                    <?  } 	
                    // Akhir Olah Data sekolah
                    ?>
                    </select>
                    
                    </div>                     </td>
           		    <td><? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                    <img src="../images/ico/tambah.png" onClick="tambah_pekerjaan();" onMouseOver="showhint('Add Occupation Type', this, event, '80px')"/>	
                    <? } ?></td>
            	</tr>
            	</table>            </td>
        </tr>
        <tr>
            <td>Income</td>
            <td bgcolor="#DBD8F3">
			<input type="text" name="penghasilanayah1" id="penghasilanayah1" class="ukuran" maxlength="20" value="<?=FormatRupiah($row_siswa['penghasilanayah']); ?>" onKeyPress="return focusNext('penghasilanibu1', event)" onBlur="formatRupiah('penghasilanayah1');unfokus('penghasilanayah1')" onFocus="unformatRupiah('penghasilanayah1');panggil('penghasilanayah1')" onKeyUp="penghasilan_ayah()"/>
			<input type="hidden" name="penghasilanayah" id="penghasilanayah" value="<?=$row_siswa['penghasilanayah']; ?>">	 		</td>
            <td bgcolor="#E9AFCF">
			<input type="text" name="penghasilanibu1" id="penghasilanibu1" class="ukuran" maxlength="20"  value="<?=FormatRupiah($row_siswa['penghasilanibu']) ?>" onKeyPress="return focusNext('emailayah', event)" onBlur="formatRupiah('penghasilanibu1');unfokus('penghasilanibu1')" onFocus="unformatRupiah('penghasilanibu1');panggil('penghasilanibu1')" onKeyUp="penghasilan_ibu()" />
	 		<input type="hidden" name="penghasilanibu" id="penghasilanibu" value="<?=$row_siswa['penghasilanibu']; ?>">			</td>
        </tr>
        <tr>
  	  <td>Parent Email</td>
  	  <td bgcolor="#DBD8F3"><input name="emailayah" type="text" size="15" maxlength="100" id="emailayah" onFocus="showhint('Father Email should not exceed 100 characters', this, event, '120px');panggil('emailayah')" value="<?=$row_siswa['emailayah']?>" class="ukuran" onKeyPress="return focusNext('emailibu', event)" onBlur="unfokus('emailayah')" /></td>
  	  <td colspan="2" bgcolor="#E9AFCF"><input name="emailibu" type="text" size="15" maxlength="100" id="emailibu" onFocus="showhint('Mother Email should not exceed 100 characters', this, event, '120px');panggil('emailibu')" value="<?=$row_siswa['emailibu']?>" class="ukuran" onKeyPress="return focusNext('namawali', event)" onBlur="unfokus('emailibu')" /></td>
	  </tr>
        <tr>
            <td>Guardian Name</td>
            <td colspan="2">
            <input type="text" name="namawali" id="namawali" size="30" maxlength="100" value="<?=$row_siswa[wali]?>" onKeyPress="return focusNext('alamatortu', event)" onFocus="panggil('namawali')" onBlur="unfokus('namawali')" /></td>
        </tr>
        <tr>
            <td valign="top">Parent Address</td>
            <td colspan="2"><textarea name="alamatortu" id="alamatortu" size="25" maxlength="100" class="Ukuranketerangan"  onKeyPress="return focusNext('telponortu', event)" onFocus="panggil('alamatortu')" onBlur="unfokus('alamatortu')"><?=$row_siswa[alamatortu]?></textarea></td>
        </tr>
        <tr>
            <td>Parent Phone</td>
            <td colspan="2"><input type="text" name="telponortu" id="telponortu" size="15" maxlength="20" value="<?=$row_siswa[telponortu]?>" class="ukuran" onKeyPress="return focusNext('hportu', event)" onFocus="panggil('telponortu')" onBlur="unfokus('telponortu')"/></td>
        </tr>
        <tr>
            <td>Parent Mobile</td>
            <td colspan="2"><input type="text" name="hportu" id="hportu" size="15" maxlength="20" value="<?=$row_siswa[hportu]?>" class="ukuran" onKeyPress="return focusNext('alamatsurat', event)" onFocus="panggil('hportu')" onBlur="unfokus('hportu')"/></td>
        </tr>
        
        <tr>
            <td colspan="3" height="30" >
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Others</font>
            <!--hr width="375" style="line-height:1px; border-style:dashed" align="left" color="#000000" /-->
            <div style="border-bottom:1px dashed #666666; border-width:thinl; margin-bottom:5px; margin-top:3px;"></div>
            </td>
        </tr>
        <tr>
            <td valign="top">Mailing Address</td>
            <td colspan="2"><textarea name="alamatsurat" id="alamatsurat" size="35" maxlength="100" class="Ukuranketerangan" onKeyPress="return focusNext('keterangan', event)" onFocus="panggil('alamatsurat')" onBlur="unfokus('alamatsurat')"><?=$row_siswa[alamatsurat]?></textarea></td>
        </tr>
        <tr>
            <td valign="top">Info</td>
            <td colspan="2"><textarea id="keterangan" name="keterangan" class="Ukuranketerangan" onFocus="panggil('keterangan')" onKeyPress="return focusNext('Simpan', event)" onBlur="unfokus('keterangan')"><?=$row_siswa[keterangan]?></textarea></td>
        </tr>
        </table>    
        <script language='JavaScript'>
            //Tables('table', 1, 0);
        </script>
        </td><!-- Akhir Kolom Kanan-->
    </tr>
    <tr height="50">
        <td align="right" valign="middle">
        <input type="Submit" value="Save" name="Simpan" id="Simpan" class="but" onClick="return validate();" onFocus="panggil('Simpan')" onBlur="unfokus('Simpan')"/></div></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="left" valign="middle"><input class="but" type="button" value="Close" name="Tutup" onClick="tutup();" /></td>
    </tr>
    </table>
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
<?
CloseDb();
?>
</html>