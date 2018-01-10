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
$nis="";
$pelajaran="";
$nis=$_REQUEST[nis];
$pelajaran=$_REQUEST[pelajaran];
$bulan_pjg = array(1=>'January','February','March','April','May','June','July','August','September','October','November','December');
OpenDb();
$sql_pp="SELECT pel.nama as namapelajaran, ppsiswa.statushadir as statushadir, pp.tanggal as tanggal, pp.jam as jam, pp.gurupelajaran as guru,ppsiswa.catatan as catatan FROM jbsakad.pelajaran pel, jbsakad.presensipelajaran pp, jbsakad.ppsiswa ppsiswa WHERE ppsiswa.nis='$nis' AND ppsiswa.idpp=pp.replid AND pel.replid=pp.idpelajaran AND ppsiswa.catatan<>'' AND pp.idpelajaran='$pelajaran'";
//echo $sql_pp;
//exit;
$res_pp=QueryDb($sql_pp);
 if (@mysql_num_rows($res_pp)>0){
		?>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td align="right"><a href="#" onclick="cetak_pp('<?=$nis?>','<?=$pelajaran?>')"><img border="0" src="../images/ico/print.png" />&nbsp;Print</a></td>
  </tr>
</table>
<br />
<? } ?>
 <table width="100%" border="1" cellspacing="0" class="tab">
  <tr class="header" height="30">
    <td width="4%" align="center">#</td>
    <td width="5%" align="center">Status</td>
    <td width="25%" align="center">Date-Time</td>
    <td width="38%" align="center">Teacher</td>
  </tr>
  <?
  if (@mysql_num_rows($res_pp)>0){
	  $cnt=1;
	while ($row_pp=@mysql_fetch_array($res_pp)){
	$a="";
	if ($cnt%2==0)
		$a="style='background-color:#FFFFCC'";
  ?>
  <tr height="25" <?=$a?> >
    <td align="center" rowspan="2"><?=$cnt?></td>
    <td align="center">
	<?
	switch ($row_pp[statushadir]){
	case 0:
		echo "Attend";
		break;
	case 1:
		echo "Ill";
		break;
	case 2:
		echo "Consent";
		break;
	case 3:
		echo "Absent";
		break;
	case 4:
		echo "Leave";
		break;
	}
	?>
	</td>
    <td><?=ShortDateFormat($row_pp[tanggal])."-".$row_pp[jam]?></td>
    <td>[<?=$row_pp[guru]?>]&nbsp;
	<?
	$res_gr=QueryDb("SELECT nama FROM jbssdm.pegawai WHERE nip='$row_pp[guru]'");
	$row_gr=@mysql_fetch_array($res_gr);
	echo $row_gr[nama];
	?>
	</td>
    </tr>
    <tr <?=$a?>>
    <td colspan="3"><?=$row_pp[catatan]?></td>
  </tr>
  <?
  $cnt++;
  } } else { ?>
  ?>
  <tr>
    <td align="center" colspan="5">No notes.</td>
  </tr>
  <?
  } ?>
</table>