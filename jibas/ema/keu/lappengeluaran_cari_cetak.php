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
require_once('../inc/config.php');
require_once('../inc/sessionchecker.php');
require_once('../inc/getheader.php');
require_once('../inc/db_functions.php');
require_once('../inc/common.php');
require_once('../inc/rupiah.php');
$tanggal1 = $_REQUEST['tanggal1'];
$tanggal2 = $_REQUEST['tanggal2'];
$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$idtahunbuku = "";
if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = $_REQUEST['idtahunbuku'];

$kriteria = "";
if (isset($_REQUEST['kriteria']))
	$kriteria = $_REQUEST['kriteria'];
	
$keyword = "";
if (isset($_REQUEST['keyword']))
	$keyword = $_REQUEST['keyword'];

switch ($kriteria){
	case 1 : $dasar = "Applicant";
		break;
	case 2 : $dasar = "Recipient";
		break;
	case 3 : $dasar = "Officer";
		break;
	case 4 : $dasar = "Necessities";
		break;
	case 5 : $dasar = "Info";
		break;				
}
$ndepartemen = $departemen;
$ntahunbuku = getname2('tahunbuku',$db_name_fina.'.tahunbuku','replid',$idtahunbuku);
$nperiode = LongDateFormat($tanggal1)." to ".LongDateFormat($tanggal2);

$urut = "nama";
$urutan = "ASC";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS EMA [Print Admission Journal]</title>
</head>

<body>

<table border="0" cellpadding="10" cellspacing="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">
<? getHeader($departemen) ?>
	
<center>
  <font size="4"><strong>EXPENDITURE REPORTS</strong></font><br />
 </center><br /><br />
<table width="100%">
<tr>
	<td width="8%" class="news_content1"><strong>Department</strong></td>
    <td width="92%" class="news_content1">: 
      <?=$departemen ?></td>
    </tr>
<tr>
  <td class="news_content1"><strong>Fiscal Year</strong></td>
  <td class="news_content1">: 
      <?=$ntahunbuku ?></td>
  </tr>
<tr>
  <td class="news_content1"><strong>Period</strong></td>
  <td class="news_content1">:
    <?=$nperiode ?></td>
  </tr>
<tr>
  <td class="news_content1"><strong>Sort by</strong></td>
  <td class="news_content1">:
    <?=$dasar ?> '<?=$keyword?>'</td>
  </tr>
</table>
<br />
<table border="0" width="100%" align="center" background="" style="background-repeat:no-repeat; background-attachment:fixed">
<!-- TABLE CENTER -->
<tr>
	<td>
    <? 
    if ($kriteria == 1)
        $sqlwhere = " AND p.namapemohon LIKE '%$keyword%'";
    else if ($kriteria == 2)
        $sqlwhere = " AND p.penerima LIKE '%$keyword%'";
    else if ($kriteria == 3)
        $sqlwhere = " AND p.petugas LIKE '%$keyword%'";
    else if ($kriteria == 4)
        $sqlwhere = " AND p.keperluan LIKE '%$keyword%'";
    else if ($kriteria == 5)
        $sqlwhere = " AND p.keterangan LIKE '%$keyword%'";
		
   	OpenDb();
	$sql_tot = "SELECT p.replid AS id, d.nama AS namapengeluaran, p.keperluan, p.keterangan, p.jenispemohon, 
	                   p.nip, p.nis, p.pemohonlain, p.penerima, date_format(p.tanggal, '%d-%b-%Y') as tanggal, date_format(p.tanggalkeluar, '%d-%b-%Y') as tanggalkeluar, 
					   p.petugas, p.jumlah 
			      FROM jbsfina.pengeluaran p, jbsfina.jurnal j, jbsfina.datapengeluaran d 
				 WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku' 
				   AND p.idpengeluaran = d.replid AND d.departemen = '$departemen' AND p.tanggal BETWEEN '$tanggal1' AND '$tanggal2' $sqlwhere ORDER BY p.tanggal";         
	
    $sql = "SELECT p.replid AS id, d.nama AS namapengeluaran, p.keperluan, p.keterangan, p.jenispemohon, 
	               p.nip, p.nis, p.pemohonlain, p.penerima, date_format(p.tanggal, '%d-%b-%Y') as tanggal, date_format(p.tanggalkeluar, '%d-%b-%Y') as tanggalkeluar, 
				   p.petugas, p.jumlah 
		     FROM jbsfina.pengeluaran p, jbsfina.jurnal j, jbsfina.datapengeluaran d 
			WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku' 
			  AND p.idpengeluaran = d.replid AND d.departemen = '$departemen' AND p.tanggal BETWEEN '$tanggal1' AND '$tanggal2' 
			      $sqlwhere 
		 ORDER BY $urut $urutan"; 
    
    $result = QueryDb($sql);
	
	if (mysql_num_rows($result) > 0) {
	?>
    <input type="hidden" name="total" id="total" value="<?=$total?>"/>
   <table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left" bordercolor="#000000">
    <tr align="center" class="header" height="30">
        <td width="4%">#</td>
        <td width="10%" height="30">Date</td>
        <td width="15%" height="30">Expenditure</td>
        <td width="15%">Applicant</td>
        <td width="10%" height="30">Recipient</td>
        <td width="10%" height="30">Sum</td>
        <td width="*" >Necessities</td>
        <td width="7%" height="30">Officer</td>
        </tr>
    <?
    
  	//if ($page==0)
		$cnt = 0;
	//else 
		//$cnt = (int)$page*(int)$varbaris;
    $totalbiaya = 0;
    while ($row = mysql_fetch_array($result)) {
        
        if ($row['jenispemohon'] == 1) {
            $idpemohon = $row['nip'];
            $sql = "SELECT nama FROM $db_name_sdm.pegawai WHERE nip = '$idpemohon'";
            $jenisinfo = "pegawai";
        } else if ($row['jenispemohon'] == 2) {
            $idpemohon = $row['nis'];
            $sql = "SELECT nama FROM siswa WHERE nis = '$idpemohon'";
            $jenisinfo = "siswa";
        } else {
            $idpemohon = "";
            $sql = "SELECT nama FROM $db_name_fina.pemohonlain WHERE replid = '$row[pemohonlain]'";
            $jenisinfo = "pemohon lain";
        }
        $result2 = QueryDb($sql);
        $row2 = mysql_fetch_row($result2);
        $namapemohon = $row2[0];
        
        $totalbiaya += $row['jumlah'];
    ?>
    <tr height="25">
        <td align="center" valign="top"><?=++$cnt ?></td>
        <td align="center" valign="top"><?=$row['tanggal'] ?></td>
        <td valign="top"><?=$row['namapengeluaran'] ?></td>
        <td valign="top"><?=$idpemohon?> <?=$namapemohon ?><br />
        <em>(<?=$jenisinfo ?>)</em>        </td>
        <td valign="top"><?=$row['penerima'] ?></td>
        <td align="right" valign="top"><?=FormatRupiah($row['jumlah']) ?></td>
        <td valign="top">
        <strong>Necessities: </strong><?=$row['keperluan'] ?><br />
        <strong>Info: </strong><?=$row['keterangan'] ?>        </td>
        <td valign="top" align="center"><?=$row['petugas'] ?></td>
        </tr>
    <?
    }
    CloseDb();
    ?>
    <tr height="30">
        <td colspan="5" align="center" bgcolor="#999900">
        <font color="#FFFFFF"><strong>Total</strong></font>        </td>
        <td align="right" bgcolor="#999900"><font color="#FFFFFF"><strong><?=FormatRupiah($totalbiaya) ?></strong></font></td>
        <td colspan="3" bgcolor="#999900">&nbsp;</td>
    </tr>
    </table>
    <? } ?>
   </td>
</tr>    
</table>
</body>
<script language="javascript">
window.print();
</script>

</html>