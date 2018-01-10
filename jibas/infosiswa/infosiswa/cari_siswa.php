<?
/**[N]**
 * JIBAS Road To Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 2.5.2 (October 5, 2011)
 * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * Copyright (C) 2009 PT.Galileo Mitra Solusitama (http://www.galileoms.com)
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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../library/departemen.php');

$flag = 0;
if (isset($_REQUEST['flag']))
	$flag = (int)$_REQUEST['flag'];
$nama = $_REQUEST['nama'];
$nis = $_REQUEST['nis'];
$departemen = $_REQUEST['departemen'];
$filter = "";
if ($departemen <> -1) 
	$filter = "AND t.departemen = '$departemen'";

$varbaris1=10;
if (isset($_REQUEST['varbaris1']))
	$varbaris1 = $_REQUEST['varbaris1'];
$page1=0;
if (isset($_REQUEST['page1']))
	$page1 = $_REQUEST['page1'];
$hal1=0;
if (isset($_REQUEST['hal1']))
	$hal1 = $_REQUEST['hal1'];
$urut1 = "s.nama";	
if (isset($_REQUEST['urut1']))
	$urut1 = $_REQUEST['urut1'];	
$urutan1 = "ASC";	
if (isset($_REQUEST['urutan1']))
	$urutan1 = $_REQUEST['urutan1'];

OpenDb();
?>
<link href="../style/style.css" rel="stylesheet" type="text/css" />

<table border="0" width="100%" cellpadding="1" cellspacing="1" align="center">
<tr>
	<td>
    <input type="hidden" name="varbaris" id="varbaris" value="<?=$varbaris ?>" />
	<input type="hidden" name="flag" id="flag" value="<?=$flag ?>" />
    <input type="hidden" name="urut1" id="urut1" value="<?=$urut1 ?>" />
    <input type="hidden" name="urutan1" id="urutan1" value="<?=$urutan1 ?>" />
	<!--<font size="2" color="#000000"><strong>Search Student</strong></font>--> 	</td>
</tr>
<tr>
    <td width="15%"><font color="#000000">Department</font></td>
    <td width="16%"><select name="depart1" id="depart1" onChange="change_departemen(1)" style="width:125px" onkeypress="return focusNext('nis', event)">
    	<option value=-1>(All Department)</option>
	<?	$dep = getDepartemen(SI_USER_ACCESS());    
        foreach($dep as $value) {
            if ($departemen == "")
                $departemen = $value; ?>
        <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> >
        <?=$value ?>
        </option>
        <?	} ?>
  	</select>    </td>
   	<td width="69%" align="center">&nbsp;</td>
</tr>
<tr>
  <td><font color="#000000">Student ID</font></td>
  <td><input type="text" name="nis" id="nis" value="<?=$_REQUEST['nis'] ?>" size="22" onkeypress="return focusNext('submit', event)"/></td>
  <td width="69%" rowspan="2" align="center"><input type="button" class="but" name="submit" id="submit" value="Search" onclick="carilah()"/></td>
</tr>
<tr>
  <td><font color="#000000">Name</font></td>
  <td><input type="text" name="nama" id="nama" value="<?=$_REQUEST['nama'] ?>" size="22" onkeypress="return focusNext('submit', event)"/></td>
  </tr>
<tr>
  <td width="69%" align="center">&nbsp;</td>
</tr>
<tr>
    <td align="center" colspan="3">
    <hr />
	<div id="caritabel">
<? 
if (isset($_REQUEST['submit']) || $_REQUEST['submit'] == 1) { 
	OpenDb();    
   	
	if ((strlen($nama) > 0) && (strlen($nis) > 0)) {
		$sql_tot = "SELECT s.nis, s.nama, k.kelas, t.departemen FROM jbsakad.siswa s,jbsakad.kelas k,jbsakad.tingkat t, jbsakad.departemen d WHERE s.nama LIKE '%$nama%' AND s.nis LIKE '%$nis%' AND k.replid=s.idkelas AND s.alumni=0 AND s.aktif=1 AND k.idtingkat = t.replid $filter GROUP BY s.nis ORDER BY d.departemen, k.kelas, s.nama"; 	
		$sql = "SELECT s.nis, s.nama, k.kelas, t.departemen, t.tingkat FROM jbsakad.siswa s,jbsakad.kelas k,jbsakad.tingkat t, jbsakad.departemen d WHERE s.nama LIKE '%$nama%' AND s.nis LIKE '%$nis%' AND k.replid=s.idkelas AND s.alumni=0 AND s.aktif=1 AND k.idtingkat = t.replid $filter GROUP BY s.nis ORDER BY $urut1 $urutan1 LIMIT ".(int)$page1*(int)$varbaris1.",$varbaris1"; 	
		//$sql = "SELECT s.nis, s.nama, k.kelas, t.departemen FROM jbsakad.siswa s,jbsakad.kelas k,jbsakad.tingkat t, jbsakad.departemen d WHERE s.nama LIKE '%$nama%' AND s.nis LIKE '%$nis%' AND k.replid=s.idkelas AND s.statusmutasi=0 AND s.alumni=0 AND s.aktif=1 AND k.idtingkat = t.replid AND t.departemen = d.departemen ORDER BY d.departemen, k.kelas, s.nama"; 	
		
	} else if (strlen($nama) > 0) {
		$sql_tot = "SELECT s.nis, s.nama, k.kelas, t.departemen FROM jbsakad.siswa s,jbsakad.kelas k,jbsakad.tingkat t, jbsakad.departemen d WHERE s.nama LIKE '%$nama%' AND k.replid=s.idkelas AND s.alumni=0 AND s.aktif=1 AND k.idtingkat = t.replid $filter GROUP BY s.nis ORDER BY d.departemen, k.kelas, s.nama"; 
		$sql = "SELECT s.nis, s.nama, k.kelas, t.departemen, t.tingkat FROM jbsakad.siswa s,jbsakad.kelas k,jbsakad.tingkat t, jbsakad.departemen d WHERE s.nama LIKE '%$nama%' AND k.replid=s.idkelas AND s.alumni=0 AND s.aktif=1 AND k.idtingkat = t.replid $filter GROUP BY s.nis ORDER BY $urut1 $urutan1 LIMIT ".(int)$page1*(int)$varbaris1.",$varbaris1"; 	
	} else if (strlen($nis) > 0) {
		$sql_tot = "SELECT s.nis, s.nama, k.kelas, t.departemen FROM jbsakad.siswa s,jbsakad.kelas k ,jbsakad.tingkat t, jbsakad.departemen d WHERE k.replid=s.idkelas AND s.nis LIKE '%$nis%' AND s.alumni = 0 AND s.aktif=1 AND k.idtingkat = t.replid $filter GROUP BY s.nis ";
		$sql = "SELECT s.nis, s.nama, k.kelas, t.departemen, t.tingkat FROM jbsakad.siswa s,jbsakad.kelas k ,jbsakad.tingkat t, jbsakad.departemen d WHERE k.replid=s.idkelas AND s.nis LIKE '%$nis%' AND s.alumni = 0 AND s.aktif=1 AND k.idtingkat = t.replid $filter GROUP BY s.nis ORDER BY $urut1 $urutan1 LIMIT ".(int)$page1*(int)$varbaris1.",$varbaris1"; 	
	}
	
	$result_tot = QueryDb($sql_tot);
	$total = ceil(mysql_num_rows($result_tot)/(int)$varbaris1);
	$jumlah = mysql_num_rows($result_tot);
	$akhir = ceil($jumlah/5)*5;
	$result = QueryDb($sql); 
	if (@mysql_num_rows($result)>0){
?>   
	
   	<table width="100%" id="table1" class="tab" align="center" cellpadding="2" cellspacing="0" border="1" bordercolor="#000000">
    <tr height="30" class="header" align="center">
        <td width="7%">#</td>
        <td width="15%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('s.nis','<?=$urutan1?>','cari')">Student ID <?=change_urut('s.nis',$urut1,$urutan1)?></td>
        <td width="*" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('s.nama','<?=$urutan1?>','cari')">Name <?=change_urut('s.nama',$urut1,$urutan1)?></td>
        <? if ($departemen == -1)  { ?>
        <td width="15%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('t.departemen','<?=$urutan1?>','cari')">Department <?=change_urut('t.departemen',$urut1,$urutan1)?></td>
        <? } ?>
        <td width="12%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('t.tingkat','<?=$urutan1?>','cari')">Class <?=change_urut('t.tingkat',$urut1,$urutan1)?></td>
        <td width="10%">&nbsp;</td>
    </tr>
<?
	$cnt = 0;
		while($row = mysql_fetch_row($result)) { ?>
   	<tr height="25" onClick="pilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer">
        <td align="center" ><?=++$cnt ?></td>
        <td align="center" ><?=$row[0] ?></td>
        <td align="left"><?=$row[1] ?></td>
        <? if ($departemen == -1)  { ?>
        <td align="center"><?=$row[3] ?></td>
        <? } ?>
        <td align="center"><?=$row[2] ?></td>
        <td align="center"><img src="../images/ico/panahkanan.png" style="cursor:pointer" onclick="pilih('<?=$row[0]?>','<?=$row[1]?>')" /><!--<input type="button" value="&gt;" onclick="pilih('<?=$row[0]?>','<?=$row[1]?>')" class="but">--></td>
	</tr>
<? } CloseDb(); ?>
 	</table>
    <?  if ($page1==0){ 
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:visible;'";
	}
	if ($page1<$total && $page1>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:visible;'";
	}
	if ($page1==$total-1 && $page1>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:hidden;'";
	}
	if ($page1==$total-1 && $page1==0){
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:hidden;'";
	}
	?>
   
    <table border="0"width="100%" align="center"cellpadding="2" cellspacing="2">
    <tr>
       	<td align="left"><font color="#000000">Page
        <select name="hal1" id="hal1" onChange="change_hal('cari')">
        <?	for ($m=0; $m<$total; $m++) {?>
             <option value="<?=$m ?>" <?=IntIsSelected($hal1,$m) ?>><?=$m+1 ?></option>
        <? } ?>
     	</select>
	  	from <?=$total?> pages
		
		<? 
     	// Navigasi halaman berikutnya and sebelumnya
        ?>
        </font>    	</td>
    	</tr>
    </table>
<? } else { ?>    		
	<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0" id="table1">
	<tr height="30" align="center">
		<td>   
   
	<br /><br />	
	<font size = "2" color ="red"><b>Data Not Found. <br /><br />            
		Add student data in the Student Data menu on Student section. </b></font>	
	<br /><br />   		</td>
    </tr>
    </table>
<? 	} 
} else { ?>

<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0" id="table1">
<tr height="30" align="center">
    <td>   

<br /><br />	
<font size="2" color="#757575"><b>Click on the "Search" button above to see student data <br />according to Student ID or Name based on <i>keyword</i> entered.</b></font>	
<br /><br />    </td>
</tr>
</table>
<? }?>	
    </div>	 </td>    
</tr>
</table>