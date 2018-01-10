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
require_once('../inc/sessionchecker.php');
require_once('../inc/common.php');
require_once('../inc/config.php');
require_once('../inc/getheader.php');
require_once('../inc/db_functions.php');
require_once('../inc/rupiah.php');

$nis = $_REQUEST['nis'];

OpenDb();
$sql = "SELECT t.departemen
	      FROM siswa s, kelas k, tingkat t
		 WHERE s.nis='$nis' AND s.idkelas=k.replid AND k.idtingkat=t.replid";
$result = QueryDb($sql);
$row = @mysql_fetch_row($result);
$departemen = $row[0];

$sql = "SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.suku,
			   c.agama, c.status, c.kondisi, c.kelamin, c.tmplahir, DAY(c.tgllahir) AS tanggal,
			   MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga, c.anakke,
			   c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
			   c.telponsiswa, c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah,
			   c.namaayah, c.namaibu, c.almayah, c.almibu, c.pendidikanayah, c.pendidikanibu,
			   c.pekerjaanayah, c.pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
			   c.alamatortu, c.telponortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan,
			   t.departemen, t.tahunajaran, k.kelas, c.nisn
		  FROM siswa c, kelas k, tahunajaran t
		 WHERE c.nis='$nis' AND k.replid = c.idkelas AND k.idtahunajaran = t.replid";
$result = QueryDb($sql);
$row_siswa = @mysql_fetch_array($result); 
CloseDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style/style.css">
<title>JIBAS EMA [Print Student Data]</title>
</head>
<body>
<table border="0" cellpadding="10" cellspacing="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">

<? getHeader($departemen) ?>

<center>
  <font size="4"><strong>STUDENT DATA</strong></font><br />
 </center><br /><br />
 	<table width="100%">    
	<tr>
		<td width="15%" class="news_content1"><strong>Department </strong></td> 
		<td width="*" class="news_content1">:&nbsp;		  <?=$row_siswa['departemen']?></td>
	</tr>
    <tr>
		<td class="news_content1"><strong>Year </strong></td> 
		<td width="*" class="news_content1">:&nbsp;		  <?=$row_siswa['tahunajaran']?></td>
	</tr>
	<tr>
		<td class="news_content1"><strong>Class</strong></td>
		<td class="news_content1">:&nbsp;		  <?=$row_siswa['kelas']?></td>        		
    </tr>
	</table>
    <br />
    <table width="100%">
    <tr>    	
    	<td align="center" width="150" valign="top">
        <img src="../lib/gambar.php?nis=<?=$nis?>" width="120" height="120" /> 
        <div align="center"><br /><br /><br />Signature<br /><br /><br /><br /><br />
        <strong>(<?=$row_siswa['nama']?>)</strong></div>
        </td>
        <td>
    <table border="1" class="tab" id="table" width="100%" cellpadding="0" style="border-collapse:collapse" cellspacing="0" >
    <tr>
    	<td valign="top">
        <table border="0" cellpadding="0" style="border-collapse:collapse" cellspacing="0" width="100%">
          <tr class="header" height="30">
            <td align="center"><strong>A. </strong></td>
            <td colspan="4"><strong>PERSONAL INFO</strong></td>
          </tr>
          <tr height="20">
            <td rowspan="15"></td>
            <td>1.</td>
            <td>National Student ID</td>
            <td>:
              <?=$row_siswa['nisn']?></td>
            <td rowspan="15">&nbsp;</td>
          </tr>
          <tr height="20">
            <td width="5%">2.</td>
            <td colspan="2">Student Member Name</td>           
            </tr>
          <tr height="20">
            <td>&nbsp;</td>
            <td width="20%">a. Full Name</td>
            <td>:
              <?=$row_siswa['nama']?></td>
          </tr>
          <tr height="20">
            <td>&nbsp;</td>
            <td>b. Nickname</td>
            <td>:
              <?=$row_siswa['panggilan']?></td>
          </tr>
          <tr height="20">
            <td>3.</td>
            <td>Gender</td>
            <td>:
              <? 	if ($row_siswa['kelamin']=="l")
				echo "Male"; 
			if ($row_siswa['kelamin']=="p")
				echo "Female"; 
		?></td>
          </tr>
          <tr height="20">
            <td>4.</td>
            <td>Birth Place</td>
            <td>:
              <?=$row_siswa['tmplahir']?></td>
          </tr>
          <tr height="20">
            <td>5.</td>
            <td>Date of Birth</td>
            <td>:
              <?=LongDateFormat($row_siswa['tgllahir']) ?></td>
          </tr>
          <tr height="20">
            <td>6.</td>
            <td>Religion</td>
            <td>:
              <?=$row_siswa['agama']?></td>
          </tr>
          <tr height="20">
            <td>7.</td>
            <td>Citizenship</td>
            <td>:
              <?=$row_siswa['warga']?></td>
          </tr>
          <tr height="20">
            <td>8.</td>
            <td>Child #</td>
            <td>:
              <?=$row_siswa['anakke']?></td>
          </tr>
          <tr height="20">
            <td>9.</td>
            <td>Siblings</td>
            <td>:
              <?=$row_siswa['jsaudara']?></td>
          </tr>
          <tr height="20">
            <td>10.</td>
            <td>Student Conditions</td>
            <td>:
              <?=$row_siswa['kondisi']?></td>
          </tr>
          <tr height="20">
            <td>11.</td>
            <td>Student Status</td>
            <td>:
              <?=$row_siswa['status']?></td>
          </tr>
          <tr height="20">
            <td>12.</td>
            <td>Language</td>
            <td>:
              <?=$row_siswa['bahasa']?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr class="header" height="30">
            <td width="5%" align="center"><strong>B. </strong></td>
            <td colspan="5"><strong>RESIDENCY INFO</strong></td>
          </tr>
          <tr height="20">
            <td rowspan="5"></td>
            <td>13.</td>
            <td>Address</td>
            <td colspan="2">:
              <?=$row_siswa['alamatsiswa']?></td>
          </tr>
          <tr height="20">
            <td>14.</td>
            <td>Phone</td>
            <td colspan="2">:
              <?=$row_siswa['telponsiswa']?></td>
          </tr>
          <tr height="20">
            <td>15.</td>
            <td>Mobile</td>
            <td colspan="2">:
              <?=$row_siswa['hpsiswa']?></td>
          </tr>
          <tr height="20">
            <td>16.</td>
            <td>Email</td>
            <td colspan="2">:
              <?=$row_siswa['emailsiswa']?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr class="header" height="30">
            <td width="5%" align="center"><strong>C. </strong></td>
            <td colspan="5"><strong>HEALTH INFO</strong></td>
          </tr>
          <tr height="20">
            <td rowspan="5"></td>
            <td>17.</td>
            <td>Body Weight</td>
            <td colspan="2">:
              <?=$row_siswa['berat']?></td>
          </tr>
          <tr height="20">
            <td>18.</td>
            <td>Body Height</td>
            <td colspan="2">:
              <?=$row_siswa['tinggi']?></td>
          </tr>
          <tr height="20">
            <td>19.</td>
            <td>Blood Type</td>
            <td colspan="2">:
              <?=$row_siswa['darah']?></td>
          </tr>
          <tr height="20">
            <td>20.</td>
            <td>Illness History</td>
            <td colspan="2">:
              <?=$row_siswa['kesehatan']?></td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr class="header" height="30">
            <td width="5%" align="center"><strong>D. </strong></td>
            <td colspan="5"><strong>PAST EDUCATION INFO</strong></td>
          </tr>
          <tr height="20">
            <td rowspan="3"></td>
            <td>21.</td>
            <td>Past School</td>
            <td colspan="2">:
              <?=$row_siswa['asalsekolah']?></td>
          </tr>
          <tr height="20">
            <td>22.</td>
            <td>Info</td>
            <td colspan="2">:
              <?=$row_siswa['ketsekolah']?></td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr class="header" height="30">
            <td width="5%" align="center"><strong>E. </strong></td>
            <td colspan="5"><strong>PARENT INFO</strong></td>
          </tr>
          <tr height="20">
            <td rowspan="11"></td>
            <td>&nbsp;</td>
            <td><strong>Parent</strong></td>
            <td width="30%"><strong>Father</strong></td>
            <td><strong>Mother</strong></td>
          </tr>
          <tr height="20">
            <td>23.</td>
            <td>Name</td>
            <td>:
              <?=$row_siswa['namaayah']?>
                <?
		if ($row_siswa['almayah']==1)
		echo "&nbsp;(late)";
		?></td>
            <td colspan="2"><?=$row_siswa['namaibu']?>
                <?
		if ($row_siswa['almibu']==1)
		echo "&nbsp;(late)";
        ?></td>
          </tr>
          <tr height="20">
            <td>24.</td>
            <td>Education</td>
            <td>:
              <?=$row_siswa['pendidikanayah']?></td>
            <td colspan="2"><?=$row_siswa['pendidikanibu']?></td>
          </tr>
          <tr height="20">
            <td>25.</td>
            <td>Occupation</td>
            <td>:
              <?=$row_siswa['pekerjaanayah']?></td>
            <td colspan="2"><?=$row_siswa['pekerjaanibu']?></td>
          </tr>
          <tr height="20">
            <td>26.</td>
            <td>Income</td>
            <td>:
              <?=FormatRupiah($row_siswa['penghasilanayah']); ?></td>
            <td colspan="2"><?=FormatRupiah($row_siswa['penghasilanibu']); ?></td>
          </tr>
          <tr height="20">
            <td>27.</td>
            <td>Email</td>
            <td>: <?=$row_siswa['emailayah']?></td>
            <td colspan="2"><?=$row_siswa['emailibu']?></td>
          </tr>
          <tr height="20">
            <td>28. </td>
            <td>Guardian Name</td>
            <td colspan="2">:
              <?=$row_siswa['wali']?></td>
          </tr>
          <tr>
            <td>29.</td>
            <td>Address</td>
            <td colspan="2">:
              <?=$row_siswa['alamatortu']?></td>
          </tr>
          <tr height="20">
            <td>30.</td>
            <td>Phone</td>
            <td colspan="2">:
              <?=$row_siswa['telponortu']?></td>
          </tr>
          <tr height="20">
            <td>31.</td>
            <td>Mobile</td>
            <td colspan="2">:
              <?=$row_siswa['hportu']?></td>
          </tr>
          <tr height="20">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="30" class="header">
            <td align="center"><strong>F.</strong></td>
            <td colspan="5"><strong>OTHERS</strong></td>
          </tr>
          <tr height="20">
            <td rowspan="2"></td>
            <td>32.</td>
            <td>Mailing Address</td>
            <td colspan="2">:
              <?=$row_siswa['alamatsurat']?></td>
          </tr>
          <tr height="20">
            <td>33.</td>
            <td>Info</td>
            <td colspan="2">: <?=$row_siswa['keterangan']?></td>
          </tr>        
        </table></td>
  	</tr>
	</table>
    </td>
    </tr>
    </table>
  	</td>
</tr>
</table>
<script language="javascript">
	window.print();
</script>
</body>
</html>