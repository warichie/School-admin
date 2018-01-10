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
require_once('../include/sessionchecker.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/getheader.php');
require_once('../include/db_functions.php');
require_once('../include/rupiah.php');

OpenDb();

$nis = $_SESSION["infosiswa.nis"];

$sql  =	"SELECT * FROM siswa c, kelas k, tahunajaran t ".
		"WHERE c.nis='".$nis."' AND k.replid = c.idkelas AND k.idtahunajaran = t.replid ";
$result = QueryDb($sql);
$row = mysql_fetch_array($result);
?>
<form name="paneldp">    
<input type="hidden" name="nis" id="nis" value="<?=$nis?>" />    
<br>    
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left" >
  <tr height="30">
	<td colspan="4" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#87c759">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Student Personal Data</strong></font>
		<hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
	<td align="right"><a href="javascript:CetakProfile()"><img src="../images/ico/print.png" border="0" />&nbsp;Print</a></td>    
  </tr>
  <tr height="20">
    <td width="5%" rowspan="15" bgcolor="#FFFFFF" ></td>
    <td class="tab2">1.</td>
    <td class="tab2">National Student ID</td>
    <td class="tab2">:
	  <?=$row['nisn']?></td>
    <td rowspan="15" bgcolor="#FFFFFF"><div align="center"><img src="../library/gambar_siswa_pegawai.php?nis=<?=$nis?>"  /> </div></td>
  </tr>
  <tr height="20">
	<td width="5%" class="tab2">2.</td>
	<td colspan="2" class="tab2">Student Member Name</td>
	</tr>
  <tr height="20">
	<td bgcolor="#FFFFFF">&nbsp;</td>
	<td width="20%" class="tab2">a. Full Name</td>
	<td class="tab2">:
	  <?=$row['nama']?></td>
  </tr>
  <tr height="20">
	<td bgcolor="#FFFFFF">&nbsp;</td>
	<td class="tab2">b. Nickname</td>
	<td class="tab2">:
	  <?=$row['panggilan']?></td>
  </tr>
  <tr height="20">
	<td class="tab2" >3.</td>
	<td class="tab2">Gender</td>
	<td class="tab2" >:
	  <? 	if ($row['kelamin']=="l")
				echo "Male"; 
			if ($row['kelamin']=="p")
				echo "Female"; 
		?></td>
  </tr>
  <tr height="20">
	<td class="tab2">4.</td>
	<td class="tab2">Birth Place</td>
	<td class="tab2">:
	  <?=$row['tmplahir']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">5.</td>
	<td class="tab2">Date of Birth</td>
	<td class="tab2">:
	  <?=LongDateFormat($row['tgllahir']) ?></td>
  </tr>
  <tr height="20">
	<td class="tab2">6.</td>
	<td class="tab2" >Religion</td>
	<td class="tab2">:
	  <?=$row['agama']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">7.</td>
	<td class="tab2">Citizenship</td>
	<td class="tab2">:
	  <?=$row['warga']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">8.</td>
	<td class="tab2">Child #</td>
	<td class="tab2">:
	<? if ($row['anakke']!=0) { echo $row['anakke']; }?></td>
  </tr>
  <tr height="20">
	<td class="tab2">9.</td>
	<td class="tab2">Siblings</td>
	<td class="tab2">:
	<? if ($row['jsaudara']!=0) { echo $row['jsaudara']; }?></td>
  </tr>
  <tr height="20">
	<td class="tab2">10.</td>
	<td class="tab2">Student Conditions</td>
	<td class="tab2">:
	  <?=$row['kondisi']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">11.</td>
	<td class="tab2">Student Status</td>
	<td class="tab2">:
	  <?=$row['status']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">12.</td>
	<td class="tab2">Language</td>
	<td class="tab2">:
	  <?=$row['bahasa']?></td>
  </tr>
  <tr>
	<td bgcolor="#FFFFFF" colspan="4">&nbsp;</td>
  </tr>
  <tr height="30">
	<td colspan="5" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#87c759">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Residency Info</strong></font>
		<hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
  </tr>
  <tr height="20">
	<td rowspan="5" bgcolor="#FFFFFF"></td>
	<td class="tab2">13.</td>
	<td class="tab2">Address</td>
	<td colspan="2" class="tab2">:
	  <?=$row['alamatsiswa']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">14.</td>
	<td class="tab2">Phone</td>
	<td colspan="2" class="tab2">:
	  <?=$row['telponsiswa']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">15.</td>
	<td class="tab2">Mobile</td>
	<td colspan="2" class="tab2">:
	  <?=$row['hpsiswa']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">16.</td>
	<td class="tab2">Email</td>
	<td colspan="2" class="tab2">:
	  <?=$row['emailsiswa']?></td>
  </tr>
  <tr>
	<td colspan="4" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr height="30">
	<td colspan="5" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#87c759">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Health Information</strong></font>
		<hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
  </tr>
  <tr height="20">
	<td rowspan="5" bgcolor="#FFFFFF"></td>
	<td class="tab2">17.</td>
	<td class="tab2" >Body Weight</td>
	<td colspan="2" class="tab2">:
	<? if ($row['berat']!=0) { echo $row['berat']." kg"; }?></td>
  </tr>
  <tr height="20">
	<td class="tab2">18.</td>
	<td class="tab2">Body Height</td>
	<td colspan="2" class="tab2">:
	<? if ($row['tinggi']!=0) { echo $row['tinggi']." cm"; }?></td>
  </tr>
  <tr height="20">
	<td class="tab2">19.</td>
	<td class="tab2" >Blood Type</td>
	<td colspan="2" class="tab2">:
	  <?=$row['darah']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">20.</td>
	<td class="tab2" >Illness History</td>
	<td colspan="2" class="tab2">:
	  <?=$row['kesehatan']?></td>
  </tr>
  <tr>
	<td colspan="4" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr height="30">
	<td colspan="5" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#87c759">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Past Education Info</strong></font>
		<hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
  </tr>
  <tr height="20">
	<td rowspan="2" bgcolor="#FFFFFF"></td>
	<td class="tab2">21.</td>
	<td class="tab2" >Past School</td>
	<td colspan="2" class="tab2">:
	  <?=$row['asalsekolah']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">22.</td>
	<td class="tab2" >Info</td>
	<td colspan="2" class="tab2">:
	  <?=$row['ketsekolah']?></td>
  </tr>
  <tr>
	<td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr height="30">
	<td colspan="5" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#87c759">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Parent Info</strong></font>
		<hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
  </tr>
  <tr height="20">
	<td rowspan="10" bgcolor="#FFFFFF"></td>
	<td bgcolor="#FFFFFF">&nbsp;</td>
	<td class="news_content1"><strong>Parent</strong></td>
	<td width="30%" bgcolor="#FFFFCC" class="news_content1"><div align="center"><strong>Father</strong></div></td>
	<td bgcolor="#FFCCFF" class="news_content1"><div align="center"><strong>Mother</strong></div></td>
  </tr>
  <tr height="20">
	<td class="tab2">23.</td>
	<td class="tab2" >Name</td>
	<td bgcolor="#FFFFCC" class="tab2" >:
	  <?=$row['namaayah']?>
		<?
		if ($row['almayah']==1)
		echo "&nbsp;(late)";
		?></td>
	<td bgcolor="#FFCCFF" class="tab2"><?=$row['namaibu']?>
		<?
		if ($row['almibu']==1)
		echo "&nbsp;(late)";
		?></td>
  </tr>
  <tr height="20">
	<td class="tab2">24.</td>
	<td class="tab2" >Education</td>
	<td bgcolor="#FFFFCC" class="tab2" >:
	  <?=$row['pendidikanayah']?></td>
	<td bgcolor="#FFCCFF" class="tab2"><?=$row['pendidikanibu']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">25.</td>
	<td class="tab2" >Occupation</td>
	<td bgcolor="#FFFFCC" class="tab2" >:
	  <?=$row['pekerjaanayah']?></td>
	<td bgcolor="#FFCCFF" class="tab2"><?=$row['pekerjaanibu']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">26.</td>
	<td class="tab2" >Income</td>
	<td bgcolor="#FFFFCC" class="tab2" >:
	<? if ($row['penghasilanayah']!=0){ echo FormatRupiah($row['penghasilanayah']) ; } ?></td>
	<td bgcolor="#FFCCFF" class="tab2"><? if ($row['penghasilanibu']!=0){ echo FormatRupiah($row['penghasilanibu']) ; } ?></td>
  </tr>
  <tr height="20">
	<td class="tab2">27.</td>
	<td class="tab2" >Email</td>
	<td bgcolor="#FFFFCC" class="tab2" >: <?=$row['emailayah']?></td>
	<td bgcolor="#FFCCFF" class="tab2"><?=$row['emailibu']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">28. </td>
	<td class="tab2" >Guardian Name</td>
	<td colspan="2" class="tab2">:
	  <?=$row['wali']?></td>
  </tr>
  <tr>
	<td class="tab2">29.</td>
	<td class="tab2" >Address</td>
	<td colspan="2" class="tab2">:
	  <?=$row['alamatortu']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">30.</td>
	<td class="tab2" >Phone</td>
	<td colspan="2" class="tab2">:
	  <?=$row['telponortu']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">31.</td>
	<td class="tab2" >Mobile</td>
	<td colspan="2" class="tab2">:
	  <?=$row['hportu']?></td>
  </tr>
  <tr height="20">
	<td bgcolor="#FFFFFF"></td>
	<td bgcolor="#FFFFFF" >&nbsp;</td>
  </tr>
  <tr height="30">
	<td colspan="6" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#87c759">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Others</strong></font>
	<hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
  </tr>
  <tr height="20">
	<td rowspan="2" bgcolor="#FFFFFF"></td>
	<td class="tab2">32.</td>
	<td class="tab2">Mailing Address</td>
	<td colspan="2" class="tab2">:
	  <?=$row['alamatsurat']?></td>
  </tr>
  <tr height="20">
	<td class="tab2">33.</td>
	<td class="tab2" >Info</td>
	<td colspan="2">:
	  <?=$row['keterangan']?></td>
  </tr>
</table>    
</form>