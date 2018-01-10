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
require_once('../../include/common.php');
require_once('../../include/sessioninfo.php');
require_once('../../include/config.php');
require_once('../../include/getheader.php');
require_once('../../include/db_functions.php');
$bulan = "";
if (isset($_REQUEST['bulan']))
	$bulan = $_REQUEST['bulan'];

$tahun = "";
if (isset($_REQUEST['tahun']))
	$tahun = $_REQUEST['tahun'];

if (isset($_REQUEST['op']))
	$op=$_REQUEST['op'];

if ($op=="gj83cs065mnsg4y9fnby37d"){
	OpenDb();
	$sql="DELETE FROM jbsvcr.agenda WHERE replid='$_REQUEST[replid]'";
	QueryDb($sql);
	CloseDb();
	?>
	<script language="javascript">
		parent.kiriatas.refresh();	
	//get_fresh(<?=$bulan?>,<?=$tahun?>);
	</script>
	<?
}
if ($bulan == 4 || $bulan == 6|| $bulan == 9 || $bulan == 11) 
	$n = 30;
else if ($bulan == 2 && $tahun % 4 <> 0) 
	$n = 28;
else if ($bulan == 2 && $tahun % 4 == 0) 
	$n = 29;
else 
	$n = 31;
$namabulan = array("January","February","March","April","May","June","July","August","September","October","November","December");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../style/style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="JavaScript" src="../../script/tools.js"></script>
<script language="javascript">
function tambah(tanggal){
	newWindow('tambahagenda.php?tanggal='+tanggal,'TambahAgenda',519,480,'resizable=0,scrollbars=0,status=0,toolbar=0');
}
function cetak(){
	newWindow('cetakagenda.php?bulan=<?=$bulan?>&tahun=<?=$tahun?>','CetakAgenda','798','529','resizable=1,scrollbars=0,status=0,toolbar=0');
}
function get_fresh(bulan,tahun){
	parent.kiriatas.location.href="jadwal.php?bulan="+bulan+"&tahun="+tahun;
}
function hapus(replid){
	if (confirm('Are you sure want to delete agenda ini ?')){
		document.location.href="daftaragenda.php?bulan=<?=$bulan?>&tahun=<?=$tahun?>&op=gj83cs065mnsg4y9fnby37d&replid="+replid;
	}
}
function ubah(replid){
	newWindow('ubahagenda.php?replid='+replid,'UbahAgenda',514,478,'resizable=0,scrollbars=0,status=0,toolbar=0');
}
</script>
</head>

<body style="background-color:#F0F0F0" >
<table width="100%" border="0" cellspacing="0" bordercolor="#00000">
  <tr>
    <th scope="row" align="right">
	
	<a href="JavaScript:get_fresh('<?=$bulan?>','<?=$tahun?>')"><img src="../../images/ico/refresh.png" border="0" /> Refresh</a>&nbsp;&nbsp;
<a href="JavaScript:cetak()"><img src="../../images/ico/print.png" border="0" /> Print</a>&nbsp;&nbsp;</th>
  </tr>
  <tr>
    <th scope="row">
    <table width="100%" border="1" cellspacing="0" class="tab">
  <tr>
    <th height="30" class="header" scope="row">Date</th>
    <td height="30" class="header">Agenda</td>
    <td height="30" class="header">&nbsp;</td>
  </tr>
  <?
	  for ($y=1;$y<=$n;$y++){
  ?>
  <tr>
    <th height="25" width="5" scope="row" valign="top"><a id="tgl<?=$y?>" name="tgl<?=$y?>"><?=$y?></a></th>
    <?
	OpenDb();
	$sql1="SELECT * FROM jbsvcr.agenda WHERE nis='".SI_USER_ID()."' AND tanggal='$tahun-$bulan-$y'";
  	$result1=QueryDb($sql1);
	$i=0;
	$ada=@mysql_num_rows($result1);
	while ($row1=@mysql_fetch_array($result1)){
		$idguru[$i]=$row1['idguru'];
		$judul[$i]=$row1['judul'];
		$replid[$i]=$row1['replid'];	
	$i++;
	}
	CloseDb();
	?>
    <td height="25" align="left">
	<? 
	for ($x=0;$x<=$i-1;$x++){
		?>
		<img src="../../images/ico/titik.png" border="0" height="5" width="5"/>&nbsp;<a href="detailagenda.php?replid=<?=$replid[$x]?>" target="kanan" onClick="tampil('<?=$judul[$x]?>')" title="See Details !"><?=$judul[$x]?></a><br>
		<?
	}
	?>
    </td>
    <td height="25" <? if ($ada>0){ ?> align="right" <? } else { ?> align="left" <? } ?> width="70">
    
	<? if (SI_USER_ID()!="LANDLORD" && SI_USER_ID()!="landlord"){ ?>
	<img style="cursor:pointer;visibility:visible;" title="Add agenda date <?=$y."-".$namabulan[$bulan-1]."-".$tahun?> !" src="../../images/ico/tambah.png" border="0" onClick="tambah('<?=$y."-".$bulan."-".$tahun?>')"/>&nbsp;
	<?
	for ($x=0;$x<=$i-1;$x++){
		?>
        <img style="cursor:pointer;visibility:visible;" title="Edit" src="../../images/ico/ubah.png" border="0" onClick="ubah('<?=$replid[$x]?>')"/>&nbsp;
        <img style="cursor:pointer;visibility:visible;" title="Delete" src="../../images/ico/hapus.png" border="0" onClick="hapus('<?=$replid[$x]?>')"/>
        <br />
		<?
	}
		?>

	<? } ?>
    </td>
  </tr>
  <?
	  } ?>
  
</table>
    </th>
  </tr>
</table>




</body>
</html>