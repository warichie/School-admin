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
require_once('../include/rupiah.php');

$replid=$_REQUEST['replid'];

OpenDb();

$sql="SELECT c.nopendaftaran, c.nama, c.panggilan, c.tahunmasuk, c.idproses, c.idkelompok, c.suku, c.agama, c.status, c.kondisi, c.kelamin, c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga, c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa, c.telponsiswa, c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, c.almayah, c.almibu, c.pendidikanayah, c.pendidikanibu, c.pekerjaanayah, c.pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu, c.alamatortu, c.telponortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, p.proses, p.departemen, p.kodeawalan, k.kelompok, k.keterangan AS ket FROM calonsiswa c, kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.replid=$replid AND p.replid = c.idproses AND k.replid = c.idkelompok AND p.replid = k.idproses";

$result=QueryDB($sql);
$row_siswa = mysql_fetch_array($result); 
CloseDb();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style/style.css">

<title>JIBAS SIMAKA [Student Candidate Data]</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function cetak() {
	var replid = document.getElementById('replid').value;
	newWindow('cetak_detail_calon.php?replid='+replid, 'CetakCalonSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
</script>
</head>

<body>
<div align="right">
  <input type="hidden" name="replid" id="replid" value="<?=$replid?>" />
</div>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="center">
<tr>
	<td align="center" valign="top" colspan="2">

<? include("../library/headercetak.php") ?>
<br />
 
      <table border="0" class="tab" id="table" cellpadding="0" style="border-collapse:collapse" cellspacing="0" width="100%">
        <tr align="left"height="30">
          <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Student Candidate Personal Data</strong></font>
              <hr width="300" style="line-height:1px; border-style:solid" align="left" />          </td>
        </tr>
        <tr height="20">
          <td width="5%" rowspan="14" bgcolor="#FFFFFF"></td>
          <td width="5%">1.</td>
          <td colspan="2">Student Member Name</td>
          <td colspan="2" rowspan="14" bgcolor="#FFFFFF"><div align="center"><img src="../library/gambar.php?replid=<?=$replid?>&table=calonsiswa" width="120" height="140" /></div></td>
        </tr>
        <tr height="20">
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td width="20%">a. Full Name</td>
          <td>:
            <?=$row_siswa['nama']?></td>
        </tr>
        <tr height="20">
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td>b. Nickname</td>
          <td>:
            <?=$row_siswa['panggilan']?></td>
        </tr>
        <tr height="20">
          <td>2.</td>
          <td>Gender</td>
          <td>:
            <? 	if ($row_siswa['kelamin']=="l")
				echo "Male"; 
			if ($row_siswa['kelamin']=="p")
				echo "Female"; 
		?></td>
        </tr>
        <tr height="20">
          <td>3.</td>
          <td>Birth Place</td>
          <td>:
            <?=$row_siswa['tmplahir']?></td>
        </tr>
        <tr height="20">
          <td>4.</td>
          <td>Date of Birth</td>
          <td>:
            <?=format_tgl($row_siswa['tgllahir']) ?></td>
        </tr>
        <tr height="20">
          <td>5.</td>
          <td>Religion</td>
          <td>:
            <?=$row_siswa['agama']?></td>
        </tr>
        <tr height="20">
          <td>6.</td>
          <td>Citizenship</td>
          <td>:
            <?=$row_siswa['warga']?></td>
        </tr>
        <tr height="20">
          <td>7.</td>
          <td>Child #</td>
          <td>:
            <? if ($row_siswa['anakke']!=0) { echo $row_siswa['anakke']; } ?></td>
        </tr>
        <tr height="20">
          <td>8.</td>
          <td>Siblings</td>
          <td>:
            <? if ($row_siswa['jsaudara']!=0) { echo $row_siswa['jsaudara']; } ?></td>
        </tr>
        <tr height="20">
          <td>9.</td>
          <td>Student Conditions</td>
          <td>:
            <?=$row_siswa['kondisi']?></td>
        </tr>
        <tr height="20">
          <td>10.</td>
          <td>Student Status</td>
          <td>:
            <?=$row_siswa['status']?></td>
        </tr>
        <tr height="20">
          <td>11.</td>
          <td>Language</td>
          <td>:
            <?=$row_siswa['bahasa']?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr align="left" height="30">
          <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Residency Info</strong></font>
              <hr width="300" style="line-height:1px; border-style:solid" align="left" /></td>
        </tr>
        <tr height="20">
          <td rowspan="5" bgcolor="#FFFFFF"></td>
          <td>12.</td>
          <td>Address</td>
          <td colspan="2">:
            <?=$row_siswa['alamatsiswa']?></td>
        </tr>
        <tr height="20">
          <td>13.</td>
          <td>Phone</td>
          <td colspan="2">:
            <?=$row_siswa['telponsiswa']?></td>
          </tr>
        <tr height="20">
          <td>14.</td>
          <td>Mobile</td>
          <td colspan="2">:
            <?=$row_siswa['hpsiswa']?></td>
        </tr>
        <tr height="20">
          <td>15.</td>
          <td>Email</td>
          <td colspan="2">:
            <?=$row_siswa['emailsiswa']?></td>
        </tr>
        <tr>
          <td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr align="left" height="30">
          <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Health Information</strong></font>
              <hr width="300" style="line-height:1px; border-style:solid" align="left" /></td>
        </tr>
        <tr height="20">
          <td rowspan="5" bgcolor="#FFFFFF"></td>
          <td>16.</td>
          <td>Body Weight</td>
          <td colspan="2">:
            <? if ($row_siswa['berat']!=0) { echo $row_siswa['berat']." kg"; } ?></td>
          </tr>
        <tr height="20">
          <td>17.</td>
          <td>Body Height</td>
          <td colspan="2">:
            <? if ($row_siswa['tinggi']!=0) { echo $row_siswa['tinggi']." cm"; } ?></td>
        </tr>
        <tr height="20">
          <td>18.</td>
          <td>Blood Type</td>
          <td colspan="2">:
            <?=$row_siswa['darah']?></td>
        </tr>
        <tr height="20">
          <td>19.</td>
          <td>Illness History</td>
          <td colspan="2">:
            <?=$row_siswa['kesehatan']?></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr align="left" height="30">
          <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Past Education Info</strong></font>
              <hr width="300" style="line-height:1px; border-style:solid" align="left" /></td>
        </tr>
        <tr height="20">
          <td rowspan="2" bgcolor="#FFFFFF"></td>
          <td>20.</td>
          <td>Past School</td>
          <td colspan="2">:
            <?=$row_siswa['asalsekolah']?></td>
          </tr>
        <tr height="20">
          <td>21.</td>
          <td>Info</td>
          <td colspan="2">:
            <?=$row_siswa['ketsekolah']?></td>
        </tr>
        <tr>
          <td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr align="left" height="30">
          <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Parent Info</strong></font>
              <hr width="300" style="line-height:1px; border-style:solid" align="left" /></td>
        </tr>
        <tr height="20">
          <td rowspan="11" bgcolor="#FFFFFF"></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td><strong>Parent</strong></td>
          <td width="30%"><div align="center"><strong>Father</strong></div></td>
          <td><div align="center"><strong>Mother</strong></div></td>
        </tr>
        <tr height="20">
          <td>22.</td>
          <td>Name</td>
          <td>:
            <?=$row_siswa['namaayah']?>
              <?
		if ($row_siswa['almayah']==1)
		echo "&nbsp;(late)";
		?></td>
          <td><?=$row_siswa['namaibu']?>
              <?
		if ($row_siswa['almibu']==1)
		echo "&nbsp;(late)";
        ?></td>
          </tr>
        <tr height="20">
          <td>23.</td>
          <td>Education</td>
          <td>:
            <?=$row_siswa['pendidikanayah']?></td>
          <td><?=$row_siswa['pendidikanibu']?></td>
        </tr>
        <tr height="20">
          <td>24.</td>
          <td>Occupation</td>
          <td>:
            <?=$row_siswa['pendidikanayah']?></td>
          <td><?=$row_siswa['pendidikanibu']?></td>
        </tr>
        <tr height="20">
          <td>25.</td>
          <td>Income</td>
          <td>:
            <? if ($row_siswa['penghasilanayah']!=0) { echo FormatRupiah($row_siswa['penghasilanayah']); } ?></td>
          <td><? if ($row_siswa['penghasilanibu']!=0) { echo FormatRupiah($row_siswa['penghasilanibu']); } ?></td>
        </tr>
        <tr height="20">
          <td>26. </td>
          <td>Guardian Name</td>
          <td colspan="2">:
            <?=$row_siswa['wali']?></td>
        </tr>
        <tr>
          <td>27.</td>
          <td>Address</td>
          <td colspan="2">:
            <?=$row_siswa['alamatortu']?></td>
        </tr>
        <tr height="20">
          <td>28.</td>
          <td>Phone</td>
          <td colspan="2">:
            <?=$row_siswa['telponortu']?></td>
        </tr>
        <tr height="20">
          <td>29.</td>
          <td>Mobile</td>
          <td colspan="2">:
            <?=$row_siswa['hportu']?></td>
        </tr>
        <tr height="20">
          <td>30.</td>
          <td>Parent Email</td>
          <td>:
            <?=$row_siswa['emailayah']?></td>
          <td><?=$row_siswa['emailibu']?></td>
        </tr>
        <tr height="20">
          <td bgcolor="#FFFFFF" >&nbsp;</td>
        </tr>
        <tr height="30" align="left">
          <td colspan="6" align="center" bgcolor="#FFFFFF"><div align="left"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Others</strong></font> </div>
              <hr width="300" style="line-height:1px; border-style:solid" align="left" /></td>
        </tr>
        <tr height="20">
          <td rowspan="2" bgcolor="#FFFFFF"></td>
          <td>31.</td>
          <td>Mailing Address</td>
          <td colspan="2">:
            <?=$row_siswa['alamatsurat']?></td>
        </tr>
        <tr height="20">
          <td>32.</td>
          <td>Info</td>
          <td colspan="2">:
            <?=$row_siswa['keterangan']?></td>
        </tr>
      </table>
    </td>
    </tr>
    </table>
	
</body>
</html>
<script language="javascript">
	window.print();
</script>