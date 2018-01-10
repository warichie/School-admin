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
require_once('../include/theme.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Search Student</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../css/mainmenu.css" type="text/css">


<script language="javascript">
function validate(){
var test;
	test = document.main.cr_nis.value;
	test2 = document.main.cr_nama.value;

	if(test.length == 0 && test2.length == 0){
		alert("Student ID or Name is required");
		document.main.cr_nis.focus();
		return false;
		}

		if(test.length < 3 && test2.length < 3){
		alert("Student ID or Name should be minimum 3 characters");
		document.main.cr_nis.focus();
		return false;
		}
}
function changeSel(rno) {
	document.main.selected.value = rno;
}


function tekan() {
	var rno = document.main.selected.value;
	//alert(rno);
	if (rno.length == 0) {
			alert('You have not select any students yet');
			return false;
		}
	eval("nis = document.main.nis" + rno + ".value;");
	eval("nama = document.main.nama" + rno + ".value;");

	//opener.acceptSiswa(<?=$selected; ?>, nis, nama, keterangan);
	//alert(nama);
	opener.acceptSiswa(nis,nama);
	window.close();
}
</script>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="JavaScript" src="../script/tooltips.js"></script>
</head>

<body topmargin="0" leftmargin="10" marginheight="0" marginwidth="10"><br>
<?
openDB();
?>
<form action="carisiswa.php" method="post" name="main" onSubmit="return validate()">
<input type="hidden" name="selected">
<fieldset><legend><b>Search Student</b></legend>
			<!--  BEGIN TABLE FORM -->
			<table width="479" height="83" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5">
			  <tr>
				<td width="17">&nbsp;</td>
				<td height="20" colspan="2">&nbsp;</td>
				<td colspan="7" class="titleMenu">Search Student based on :</td>
			  </tr>
			  <tr bgcolor="#F5F5F5">
				<td>&nbsp;</td>
				<td width="25">&nbsp;</td>
				<td width="10">&nbsp;</td>
				<td colspan="7" class="titlemenu">&nbsp;</td>
			  </tr>
			  <tr bgcolor="#F5F5F5">
				<td valign="middle">&nbsp;</td>
				<td valign="middle">Student ID</td>
				<td>:</td>
				<td width="153"><input type="text" name="cr_nis"></td>
				<td width="8">&nbsp;</td>
				<td width="33">Name</td>
				<td width="10">:</td>
				<td width="154"><input type="text" name="cr_nama"></td>
				<td width="10">&nbsp;</td>
				<td width="57"><input type="submit" name="cari" value="Search" class="but"></td>
			  </tr>
			   <tr bgcolor="#F5F5F5">
				 <td colspan="10" class="titlemenu">&nbsp;</td>
			   </tr>
			</table>
			<!-- END TABLE FORM -->
	</fieldset>
<?
if ((isset($_POST["cari"]))){
 	if((trim($_POST[cr_nis]!="")) && (trim($_POST[cr_nama]==""))) {
		$selectSQL ="SELECT nis,nama,idkelas FROM jbsakad.siswa ".
		            "WHERE nis LIKE '$_POST[cr_nis]%' AND aktif = '1'";
	}elseif((isset($_POST["cari"])) && (trim($_POST[cr_nama]!="")) && (trim($_POST[cr_nis]==""))){
		$selectSQL ="SELECT nis,nama,idkelas FROM jbsakad.siswa ".
		            "WHERE nama LIKE '$_POST[cr_nama]%' AND aktif = '1'";
	}elseif((isset($_POST["cari"])) && (trim($_POST[cr_nis]=="")) && (trim($_POST[cr_nama]==""))) {
		$selectSQL ="SELECT nis,nama,idkelas FROM jbsakad.siswa WHERE nama='x'";
	}

	$result_sis = QueryDb($selectSQL);

	echo "<p><table border='1' cellspacing='0' cellpadding='0' bordercolor='#5A7594' width='100%'>
			<tr>
			  <td>
			 	<table border='1' width='100%'>

					<tr>
						<td class='header' align='center' height='30'>Student ID</td>
						<td class='header' height='30'>Name</td>
						<td class='header' height='30'>Class</td>";

	$jml_data = @mysql_num_rows($result_sis);

	if($jml_data=="0"){
		echo "<tr>
				<td colspan='3' align='center' class='style4' bgcolor='#B3C0D0'>Data Not Found.</td>
			 </tr>";
	}else{

	$cnt = 0;
	while($row = @mysql_fetch_array($result_sis)){
	  
	  $qq = "SELECT kelas, departemen FROM kelas WHERE replid = '$row[idkelas]'";
	  $rr = QueryDb($qq);
	  $rw = mysql_fetch_array($rr);
	?>

	<tr <?="bgcolor=#".($cnt%2?"ffffff":"EAECEE").""; ?>>
		<td class='data'><input type="hidden" name="nis<?=$cnt; ?>" value="<?=$row[nis]; ?>">
		<input type="hidden" name="nama<?=$cnt; ?>" value="<?=$row[nama]; ?>"><input name='siswa' type='radio' value='<?=$row[nis]; ?>' onclick='changeSel(<?=$cnt; ?>)' width='20%'><?=$row[nis]; ?></td>
		<td width='60%'class='data'><?=$row[nama]; ?></td><td><?="$rw[departemen] - $rw[kelas]"; ?> </td> 
	</tr>
	<?
	$cnt++;
	}
	CloseDb();
	?>
	<tr>
		<td colspan='3' align="right">
		<input type='button' class='but' value='Select >>' name='pilih' onclick='tekan()'></td>
		</form>
		</tr>
	</table>
   </td>
  </tr>
</table>
<?
	}
}
?>
</body>
</html>