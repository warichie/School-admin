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
//require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/getheader.php');
require_once('../include/numbertotext.class.php');
require_once('../library/dpupdate.php');

$NTT = new NumberToText();

OpenDb();

if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
if (isset($_REQUEST['semester']))
	$semester = $_REQUEST['semester'];
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];
if (isset($_REQUEST['pelajaran'])) 
	$pelajaran = $_REQUEST['pelajaran'];
if (isset($_REQUEST['kelas']))
	$kelas = $_REQUEST['kelas'];
if (isset($_REQUEST['nis']))
	$nis = $_REQUEST['nis'];
if (isset($_REQUEST['prespel']))
	$prespel = $_REQUEST['prespel'];
if (isset($_REQUEST['harian']))
	$harian = $_REQUEST['harian'];	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Report Card</TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<link rel="stylesheet" type="text/css" href="../style/style.css">
<style type="text/css">
<!--
.style6 {
	font-size: 12px;
	font-weight: bold;
}
.style13 {
	font-size: 14px;
	font-weight: bold;
}
.style14 {color: #FFFFFF}
-->
</style>
<script language="javascript" src="../script/tables.js"></script>
</HEAD>
<BODY>
<table width="780" border="0">
  <tr>
    <td><?=getHeader($departemen)?></td>
  </tr>
  <tr>
    <td>
<table width="100%" border="0">
  <tr>
    <td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td height="16" colspan="2" bgcolor="#FFFFFF"><div align="center" class="style13">LAPORAN
        HASIL BELAJAR</div></td>
    </tr>
  <tr>
    <td height="20">Department</td>
    <td height="20">:&nbsp;<?=$departemen?></td>
  </tr>
  <tr>
    <td height="20">Year</td>
    <?
    $sql_get_ta="SELECT tahunajaran FROM jbsakad.tahunajaran WHERE replid='$tahunajaran'";
	$result_get_ta=QueryDb($sql_get_ta);
	$row_get_ta=@mysql_fetch_array($result_get_ta);
	?><td height="20">:&nbsp;<?=$row_get_ta[tahunajaran]?></td>
  </tr>
  <tr>
    <td width="6%" height="20">Student ID 
    </td>
    <td width="93%" height="20">:&nbsp;<?=$nis?>
    </td>
  </tr>
  <tr>
    <td height="20">Name</td>
    <?
	$sql_get_nama="SELECT nama FROM jbsakad.siswa WHERE nis='$nis'";
	$result_get_nama=QueryDb($sql_get_nama);
	$row_get_nama=@mysql_fetch_array($result_get_nama);
	?>
	<td height="20">:&nbsp;<?=$row_get_nama[nama]?></td>
  </tr>
  <tr>
    <td height="20">Class/Semester&nbsp;</td>
    
    <?
    $sql_get_kls="SELECT kelas FROM jbsakad.kelas WHERE replid='$kelas'";
	$result_get_kls=QueryDb($sql_get_kls);
	$row_get_kls=@mysql_fetch_array($result_get_kls);
	
	$sql_get_sem="SELECT semester FROM jbsakad.semester WHERE replid='$semester'";
	$result_get_sem=QueryDb($sql_get_sem);
	$row_get_sem=@mysql_fetch_array($result_get_sem);
	?>
    <td height="20">:&nbsp;<?=$row_get_kls[kelas]."/".$row_get_sem[semester]?>
    </td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><fieldset><legend><strong>Report Card</strong></legend>
	<!-- Content Reports disini -->
    <?	$sql = "SELECT DISTINCT a.dasarpenilaian, d.keterangan
		  	    FROM infonap i, nap n, aturannhb a, dasarpenilaian d
			   WHERE i.replid = n.idinfo AND n.nis = '$nis' 
			     AND i.idsemester = '$semester' 
			     AND i.idkelas = '$kelas'
			     AND n.idaturan = a.replid 	   
			     AND a.dasarpenilaian = d.dasarpenilaian";
	$res = QueryDb($sql);
	$i = 0;
	while($row = mysql_fetch_row($res))
	{
		$aspekarr[$i++] = array($row[0], $row[1]);
	} ?>  
	<table width="100%" border="1" class="tab" bordercolor="#000000">
	<tr>
		<td width="15%" rowspan="2" class="headerlong"><div align="center">Class Subject</div></td>
		<td width="10%" rowspan="2" class="headerlong"><div align="center">Minimum Completeness Criteria</div></td>
<?		for($i = 0; $i < count($aspekarr); $i++)
			echo "<td class='headerlong' colspan='3' align='center' width='18%'>" . $aspekarr[$i][1] . "</td>"; ?>
		<td width="15%" rowspan="2" class="headerlong"><div align="center">Predicate</div></td>
  	</tr>
	<tr>
<?	for($i = 0; $i < count($aspekarr); $i++)
		echo "<td class='header' align='center' width='7%'>Number</td>
			   <td class='header' align='center' width='7%'>Letter</td>
				<td class='header' align='center' width='20%'>Spelled Out</td>"; ?>   
   </tr>
<?	$sql = "SELECT pel.replid, pel.nama
				 FROM ujian uji, nilaiujian niluji, siswa sis, pelajaran pel 
				WHERE uji.replid = niluji.idujian 
				  AND niluji.nis = sis.nis 
				  AND uji.idpelajaran = pel.replid 
				  AND uji.idsemester = '$semester'
				  AND uji.idkelas = '$kelas'
				  AND sis.nis = '$nis' 
			GROUP BY pel.nama";
	$respel = QueryDb($sql);
	while($rowpel = mysql_fetch_row($respel))
	{
		$idpel = $rowpel[0];
		$nmpel = $rowpel[1];
		
		$sql = "SELECT nilaimin 
					 FROM infonap
					WHERE idpelajaran = '$idpel'
					  AND idsemester = '$semester'
				     AND idkelas = '$kelas'";
		$res = QueryDb($sql);
		$row = mysql_fetch_row($res);
		$nilaimin = $row[0];
				
		echo "<tr height='25'>";
		echo "<td align='left'>$nmpel</td>";
		echo "<td align='center'>$nilaimin</td>";
		
		for($i = 0; $i < count($aspekarr); $i++)
		{
			$na = "";
			$nh = "";
		
			$asp = $aspekarr[$i][0];
		
			$sql = "SELECT nilaiangka, nilaihuruf
						 FROM infonap i, nap n, aturannhb a 
						WHERE i.replid = n.idinfo 
						  AND n.nis = '$nis' 
						  AND i.idpelajaran = '$idpel' 
						  AND i.idsemester = '$semester' 
						  AND i.idkelas = '$kelas'
						  AND n.idaturan = a.replid 	   
						  AND a.dasarpenilaian = '$asp'";
			$res = QueryDb($sql);
			if (mysql_num_rows($res) > 0)
			{
				$row = mysql_fetch_row($res);
				$na = $row[0];
				$nh = $row[1];
			}
			$say = $NTT->Convert($na);
			echo "<td align='center'>$na</td><td align='center'>$nh</td><td align='left'>$say</td>"; 
		} 
		
		$pred = "";
		$sql = "SELECT predikat 
				  FROM infonap i, komennap k
				 WHERE i.replid = k.idinfo
				   AND k.nis = '$nis' 
				   AND i.idpelajaran = '$idpel' 
				   AND i.idsemester = '$semester' 
				   AND i.idkelas = '$kelas'";
		$res = QueryDb($sql);
		if (mysql_num_rows($res) > 0)
		{
			$row = mysql_fetch_row($res);
			$tmp = (int)$row[0];
			
			switch ($tmp)
			{
				case 4:	$pred = "Excellent"; break;
				case 3:	$pred = "Good"; break;
				case 2:	$pred = "Average"; break;
				case 1:	$pred = "Not Good"; break;
				case 0:	$pred = "Bad"; break;
				default:
					$pred = "Good";
			}
		}			
		echo "<td align='left'>$pred</td>"; 
		echo "</tr>";
	}
?>   
	</table>
	</td>
  </tr>
  <tr>
    <td><fieldset><legend><strong>Comments</strong></legend>
	<!-- Konten Komentar disini -->
	<table border="1" id="table" class="tab" width="100%">
	<tr>
	<td width="27%" height="30" align="center" class="header">Class Subject</td>
	<td width="73%" height="30" align="center" class="header">Comments</td>
	</tr>
	<!-- Ambil pelajaran per departemen-->
	<?
	$sql_get_pelajaran_komentar="SELECT pel.replid as replid,pel.nama as nama FROM infonap info, komennap komen, siswa sis, pelajaran pel ".
								"WHERE info.replid=komen.idinfo ".
								"AND komen.nis=sis.nis ".
								"AND info.idpelajaran=pel.replid ".
								"AND info.idsemester='$semester' ".
								"AND info.idkelas='$kelas' ".
								"AND sis.nis='$nis' ".
								"GROUP BY pel.nama";
	$result_get_pelajaran_komentar=QueryDb($sql_get_pelajaran_komentar);
	$cntpel_komentar=1;
	while ($row_get_pelajaran_komentar=@mysql_fetch_array($result_get_pelajaran_komentar)){
	$sql_get_komentar="SELECT k.komentar FROM jbsakad.komennap k, jbsakad.infonap i WHERE k.nis='$nis' AND i.idpelajaran='$row_get_pelajaran_komentar[replid]' AND i.replid=k.idinfo";
	$result_get_komentar=QueryDb($sql_get_komentar);
	$row_get_komentar=@mysql_fetch_row($result_get_komentar);
	?>
	<tr>
	<td height="25"><?=$row_get_pelajaran_komentar[nama]?></td>
	<td height="25"><?=$row_get_komentar[0]?></td>
	</tr>
	<?
	$cntpel_komentar++;
	}
	?>
	</table>
	<script language='JavaScript'>
	   	Tables('table', 1, 0);
	</script>
	</fieldset></td>
  </tr>
  <?
  if ($harian!="false"){
  ?>
  <tr>
    <td><fieldset><legend><strong>Daily Presence</strong></legend>
	<?


	 $sql_harian = "SELECT SUM(ph.hadir) as hadir, SUM(ph.ijin) as ijin, SUM(ph.sakit) as sakit, SUM(ph.cuti) as cuti, SUM(ph.alpa) as alpa, SUM(ph.hadir+ph.sakit+ph.ijin+ph.alpa+ph.cuti) as tot ".
			"FROM presensiharian p, phsiswa ph, siswa s ".
			"WHERE ph.idpresensi = p.replid ".
			"AND ph.nis = s.nis ".
			"AND ph.nis = '$nis' ".
			"AND ((p.tanggal1 ".
			"BETWEEN '$tglawal' ".
			"AND '$tglakhir') ".
			"OR (p.tanggal2 BETWEEN '$tglawal' AND '$tglakhir')) ".
			"ORDER BY p.tanggal1"; ;
	 // echo $sql;
	  ?>
	<!-- Content Presensi disini -->
	<table width="100%" border="1" class="tab" id="table">
  <tr>
    <td height="25" colspan="2" background="../style/formbg2agreen.gif"><div align="center" class="style1 style14"><strong>Attend</strong></div></td>
    <td height="25" colspan="2" class="headerlong"><div align="center">Ill</div></td>
    <td height="25" colspan="2" background="../style/formbg2agreen.gif"><div align="center" class="style1 style14"><strong>Consent</strong></div></td>
    <td height="25" colspan="2" class="headerlong"><div align="center">Absent</div></td>
    <td height="25" colspan="2" background="../style/formbg2agreen.gif"><div align="center" class="style14 style1"><strong>Leave</strong></div></td>
    </tr>
  <tr>
    <td width="6" background="../style/formbg2agreen.gif"><div align="center" class="style1 style14">
      <div align="center"><strong>Sum</strong></div>
    </div></td>
    <td width="6" background="../style/formbg2agreen.gif"><div align="center" class="style14 style1">
      <div align="center"><strong>%</strong></div>
    </div></td>
    <td width="6" class="headerlong"><div align="center">Sum</div></td>
    <td width="6" class="headerlong"><div align="center">%</div></td>
    <td width="6" background="../style/formbg2agreen.gif"><div align="center" class="style1 style14">
      <div align="center"><strong>Sum</strong></div>
    </div></td>
    <td width="6" background="../style/formbg2agreen.gif"><div align="center" class="style1 style14">
      <div align="center"><strong>%</strong></div>
    </div></td>
    <td width="6" class="headerlong"><div align="center">Sum</div></td>
    <td width="6" class="headerlong"><div align="center">%</div></td>
    <td width="6" background="../style/formbg2agreen.gif"><div align="center" class="style14 style1">
      <div align="center"><strong>Sum</strong></div>
    </div></td>
    <td width="6" background="../style/formbg2agreen.gif"><div align="center" class="style14 style1">
      <div align="center"><strong>%</strong></div>
    </div></td>
  </tr>
  <!-- Ambil pelajaran per departemen-->
	<?
	$result_harian=QueryDb($sql_harian);
	$row_harian=@mysql_fetch_array($result_harian);
	$hadir=$row_harian['hadir'];
	$sakit=$row_harian['sakit'];
	$ijin=$row_harian['ijin'];
	$alpa=$row_harian['alpa'];
	$cuti=$row_harian['cuti'];
	$all=$row_harian['tot'];
	if ($hadir!=0 && $all !=0)
	$p_hadir=$hadir/$all*100;
	
	if ($sakit!=0 && $all !=0)
	$p_sakit=$sakit/$all*100;
	
	if ($ijin!=0 && $all !=0)
	$p_ijin=$ijin/$all*100;
	
	if ($alpa!=0 && $all !=0)
	$p_alpa=$alpa/$all*100;
	
	if ($cuti!=0 && $all !=0)
	$p_cuti=$cuti/$all*100;
	?>
	<tr>
	  <td height="25" bgcolor="#FFFFFF"><div align="center">
	    <?=$hadir?>
	      </div></td>
    <td height="25" bgcolor="#FFFFFF"><div align="center">
      <?=round($p_hadir,2)?>%</div></td>
    <td height="25" bgcolor="#FFFFCC"><div align="center">
      <?=$sakit?>
    </div></td>
    <td height="25" bgcolor="#FFFFCC"><div align="center">
      <?=round($p_sakit,2)?>%</div></td>
    <td height="25" bgcolor="#FFFFFF"><div align="center">
      <?=$ijin?>
    </div></td>
    <td height="25" bgcolor="#FFFFFF"><div align="center">
      <?=round($p_ijin,2)?>%</div></td>
    <td height="25" bgcolor="#FFFFCC"><div align="center">
      <?=$alpa?>
    </div></td>
    <td height="25" bgcolor="#FFFFCC"><div align="center">
      <?=round($p_alpa,2)?>%</div></td>
      <td height="25" bgcolor="#FFFFFF"><div align="center">
      <?=$cuti?>
    </div></td>
    <td height="25" bgcolor="#FFFFFF"><div align="center">
      <?=round($p_cuti,2)?>%</div></td>
	 </tr>
</table>
<script language='JavaScript'>
	   	Tables('table', 1, 0);
</script>
    </fieldset></td>
  </tr>
  
  
  
  
 <?
 }
 if ($prespel!="false"){
 ?>
 <tr>
    <td><fieldset><legend><strong>Class Presence</strong></legend>
	<!-- Content Presensi disini -->
	<table width="100%" border="1" class="tab" id="table">
  <tr>
    <td width="27%" rowspan="2" class="headerlong"><div align="center">Class Subject</div></td>
    <td height="25" colspan="2" class="headerlong"><div align="center">Attend</div></td>
    <td height="25" colspan="2" class="headerlong"><div align="center">Ill</div></td>
    <td height="25" colspan="2" class="headerlong"><div align="center">Consent</div></td>
    <td height="25" colspan="2" class="headerlong"><div align="center">Absent</div></td>
    </tr>
  <tr>
    <td width="6" class="headerlong"><div align="center">Sum</div></td>
    <td width="6" class="headerlong"><div align="center">%</div></td>
    <td width="6" class="headerlong"><div align="center">Sum</div></td>
    <td width="6" class="headerlong"><div align="center">%</div></td>
    <td width="6" class="headerlong"><div align="center">Sum</div></td>
    <td width="6" class="headerlong"><div align="center">%</div></td>
    <td width="6" class="headerlong"><div align="center">Sum</div></td>
    <td width="6" class="headerlong"><div align="center">%</div></td>
  </tr>
  <!-- Ambil pelajaran per departemen-->
	<?
	$sql_get_pelajaran_presensi="SELECT pel.replid as replid,pel.nama as nama FROM presensipelajaran ppel, ppsiswa pp, siswa sis, pelajaran pel ".
								"WHERE pp.nis=sis.nis ".
								"AND ppel.replid=pp.idpp ".
								"AND ppel.idpelajaran=pel.replid ".
								"AND ppel.idsemester='$semester' ".
								"AND ppel.idkelas='$kelas' ".
								"AND sis.nis='$nis' ".
								"GROUP BY pel.nama";
	$result_get_pelajaran_presensi=QueryDb($sql_get_pelajaran_presensi);
	$cntpel_presensi=1;
	
	while ($row_get_pelajaran_presensi=@mysql_fetch_array($result_get_pelajaran_presensi)){
	//ambil semua jumlah presensi per pelajaran 
	$sql_get_all_presensi="select count(*) as jumlah FROM jbsakad.presensipelajaran pel, jbsakad.ppsiswa pp ".
						  "WHERE pel.idpelajaran='$row_get_pelajaran_presensi[replid]' AND pel.idsemester='$semester' AND pel.idkelas='$kelas' ".
		                  "AND pel.replid=pp.idpp AND pp.nis='$nis'";
	$result_get_all_presensi=QueryDb($sql_get_all_presensi);
	$row_get_all_presensi=@mysql_fetch_array($result_get_all_presensi);
	//dapet nih jumlahnya
	$jumlah_presensi=$row_get_all_presensi[jumlah];


	//ambil yang hadir
	$sql_get_hadir="select count(*) as hadir FROM jbsakad.presensipelajaran pel, jbsakad.ppsiswa pp ".
						  "WHERE pel.idpelajaran='$row_get_pelajaran_presensi[replid]' AND pel.idsemester='$semester' AND pel.idkelas='$kelas' ".
		                  "AND pel.replid=pp.idpp AND pp.nis='$nis' AND pp.statushadir=0";
	$result_get_hadir=QueryDb($sql_get_hadir);
	$row_get_hadir=@mysql_fetch_array($result_get_hadir);
	$hadir=$row_get_hadir[hadir];
	$hh[$cntpel_presensi]=$hadir;
	//ambil yang sakit
	$sql_get_sakit="select count(*) as sakit FROM jbsakad.presensipelajaran pel, jbsakad.ppsiswa pp ".
						  "WHERE pel.idpelajaran='$row_get_pelajaran_presensi[replid]' AND pel.idsemester='$semester' AND pel.idkelas='$kelas' ".
		                  "AND pel.replid=pp.idpp AND pp.nis='$nis' AND pp.statushadir=1";
	$result_get_sakit=QueryDb($sql_get_sakit);
	$row_get_sakit=@mysql_fetch_array($result_get_sakit);
	$sakit=$row_get_sakit[sakit];
	$ss[$cntpel_presensi]=$sakit;
	//ambil yang ijin
	$sql_get_ijin="select count(*) as ijin FROM jbsakad.presensipelajaran pel, jbsakad.ppsiswa pp ".
						  "WHERE pel.idpelajaran='$row_get_pelajaran_presensi[replid]' AND pel.idsemester='$semester' AND pel.idkelas='$kelas' ".
		                  "AND pel.replid=pp.idpp AND pp.nis='$nis' AND pp.statushadir=2";
	$result_get_ijin=QueryDb($sql_get_ijin);
	$row_get_ijin=@mysql_fetch_array($result_get_ijin);
	$ijin=$row_get_ijin[ijin];
	$ii[$cntpel_presensi]=$ijin;
	//ambil yang alpa
	$sql_get_alpa="select count(*) as alpa FROM jbsakad.presensipelajaran pel, jbsakad.ppsiswa pp ".
						  "WHERE pel.idpelajaran='$row_get_pelajaran_presensi[replid]' AND pel.idsemester='$semester' AND pel.idkelas='$kelas' ".
		                  "AND pel.replid=pp.idpp AND pp.nis='$nis' AND pp.statushadir=3";
	$result_get_alpa=QueryDb($sql_get_alpa);
	$row_get_alpa=@mysql_fetch_array($result_get_alpa);
	$alpa=$row_get_alpa[alpa];
	$aa[$cntpel_presensi]=$alpa;
	//hitung prosentase kalo jumlahnya gak 0
	if ($jumlah_presensi<>0){
		$p_hadir=round(($hadir/$jumlah_presensi)*100);
		$p_sakit=round(($sakit/$jumlah_presensi)*100);
		$p_ijin=round(($ijin/$jumlah_presensi)*100);
		$p_alpa=round(($alpa/$jumlah_presensi)*100);
	} else {
		$p_hadir=0;
		$p_sakit=0;
		$p_ijin=0;
		$p_alpa=0;
	}
	?>
	<tr>
    <td height="25"><?=$row_get_pelajaran_presensi[nama]?></td>
    <td height="25"><div align="center">
      <?=$hadir?>
    </div></td>
    <td height="25"><div align="center">
      <?=$p_hadir?>
      &nbsp;%</div></td>
    <td height="25"><div align="center">
      <?=$sakit?>
    </div></td>
    <td height="25"><div align="center">
      <?=$p_sakit?>
      &nbsp;%</div></td>
    <td height="25"><div align="center">
      <?=$ijin?>
    </div></td>
    <td height="25"><div align="center">
      <?=$p_ijin?>
      &nbsp;%</div></td>
    <td height="25"><div align="center">
      <?=$alpa?>
    </div></td>
    <td height="25"><div align="center">
      <?=$p_alpa?>
      &nbsp;%</div></td>
	 </tr>
	<?
	$cntpel_presensi++;
	}
	$hdr = 0;
	for ($i=1;$i<=count($hh);$i++)
		$hdr += $hh[$i];
	$skt = 0;
	for ($i=1;$i<=count($ss);$i++)
		$skt += $ss[$i];
	$ijn = 0;
	for ($i=1;$i<=count($ii);$i++)
		$ijn += $ii[$i];
	$alp = 0;
	for ($i=1;$i<=count($aa);$i++)
		$alp += $aa[$i];
	/*
	//sekarang hitung jumlah hadir semua pelajaran
	$sql_all_hadir="select count(*) as allhadir FROM jbsakad.presensipelajaran pel, jbsakad.ppsiswa pp ".
	               "WHERE pel.idsemester='22' AND pel.idkelas='$kelas' ". 
                   "AND pel.replid=pp.idpp AND pp.nis='$nis' AND pp.statushadir=0";
    $result_all_hadir=QueryDb($sql_all_hadir);
	$row_all_hadir=@mysql_fetch_array($result_all_hadir);
	$all_hadir=$row_all_hadir[allhadir];
	
	//sekarang hitung jumlah sakit semua pelajaran
	$sql_all_sakit="select count(*) as allsakit FROM jbsakad.presensipelajaran pel, jbsakad.ppsiswa pp ".
	               "WHERE pel.idsemester='22' AND pel.idkelas='$kelas' ". 
                   "AND pel.replid=pp.idpp AND pp.nis='$nis' AND pp.statushadir=1";
    $result_all_sakit=QueryDb($sql_all_sakit);
	$row_all_sakit=@mysql_fetch_array($result_all_sakit);
	$all_sakit=$row_all_sakit[allsakit];

	//sekarang hitung jumlah ijin semua pelajaran
	$sql_all_ijin="select count(*) as allijin FROM jbsakad.presensipelajaran pel, jbsakad.ppsiswa pp ".
	               "WHERE pel.idsemester='22' AND pel.idkelas='$kelas' ". 
                   "AND pel.replid=pp.idpp AND pp.nis='$nis' AND pp.statushadir=2";
    $result_all_ijin=QueryDb($sql_all_ijin);
	$row_all_ijin=@mysql_fetch_array($result_all_ijin);
	$all_ijin=$row_all_ijin[allijin];

	//sekarang hitung jumlah alpa semua pelajaran
	$sql_all_alpa="select count(*) as allalpa FROM jbsakad.presensipelajaran pel, jbsakad.ppsiswa pp ".
	               "WHERE pel.idsemester='22' AND pel.idkelas='$kelas' ". 
                   "AND pel.replid=pp.idpp AND pp.nis='$nis' AND pp.statushadir=3";
    $result_all_alpa=QueryDb($sql_all_alpa);
	$row_all_alpa=@mysql_fetch_array($result_all_alpa);
	$all_alpa=$row_all_alpa[allalpa];
	*/
	?>
  <tr>
    <td height="25" bgcolor="#FFFFFF"><div align="center" class="style6">Total</div></td>
    <td height="25" bgcolor="#CCCCCC"><div align="center"><?=$hdr?></div></td>
    <td height="25" bgcolor="#FFFFFF"><div align="center"></div></td>
    <td height="25" bgcolor="#CCCCCC"><div align="center"><?=$skt?></div></td>
    <td height="25" bgcolor="#FFFFFF"><div align="center"></div></td>
    <td height="25" bgcolor="#CCCCCC"><div align="center"><?=$ijn?></div></td>
    <td height="25" bgcolor="#FFFFFF"><div align="center"></div></td>
    <td height="25" bgcolor="#CCCCCC"><div align="center"><?=$alp?></div></td>
    <td height="25" bgcolor="#FFFFFF"><div align="center"></div></td>
  </tr>  
</table>
<script language='JavaScript'>
	   	Tables('table', 1, 0);
</script>
    </fieldset></td>
  </tr>
  <? } ?>  
</table>

</BODY>
<script language="javascript">
window.print();
</script>
</HTML>
<?
//CloseDb();
CloseDb();
?>