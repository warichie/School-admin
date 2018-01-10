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
require_once('../inc/common.php');
require_once('../inc/config.php');
require_once('../inc/db_functions.php');

$flag = 0;
if (isset($_REQUEST['flag']))
	$flag = (int)$_REQUEST['flag'];

$departemen = $_REQUEST['departemen'];
$tahunajaran = $_REQUEST['tahunajaran'];
$tingkat = $_REQUEST['tingkat'];
$kelas = $_REQUEST['kelas'];

$varbaris=10;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];
$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];
$urut = "s.nama";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	
$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];
OpenDb();
?>
<link href="../sty/style.css" rel="stylesheet" type="text/css" />

<table border="0" width="100%" cellpadding="2" cellspacing="2" align="center">
<tr>
    <td colspan="4">
    <input type="hidden" name="flag" id="flag" value="<?=$flag ?>" />
    <input type="hidden" name="urut" id="urut" value="<?=$urut ?>" />
    <input type="hidden" name="urutan" id="urutan" value="<?=$urutan ?>" />
    <!--<font size="2" color="#000000"><strong>Student List</strong></font><br />-->
    </td>
</tr>
<tr>
    <td width="20%"><font color="#000000"><strong>Department</strong></font></td>
    <td><select name="depart" class="cmbfrm" id="depart" style="width:150px" onChange="change_departemen(0)" onkeypress="return focusNext('tahunajaran', event)">
	<option value=-1>(All Department)</option>
	<?	$sql = "SELECT departemen FROM ".get_db_name('akad').".departemen ORDER BY urutan";
        $result = QueryDb($sql);
		while ($row=@mysql_fetch_array($result)) {
			if ($departemen == "")
                $departemen = $row[departemen]; ?>
        <option value="<?=$row[departemen] ?>" <?=StringIsSelected($row[departemen], $departemen) ?> >
        <?=$row[departemen] ?>
        </option>
        <?	} ?>
  	</select>
    </td>
    <td><font color="#000000"><strong>Grade</strong></font></td>
    <td>
            <select name="tingkat" class="cmbfrm" id="tingkat" style="width:150px;" onChange="change()" onkeypress="return focusNext('kelas', event)">
        <?
            OpenDb();
			$sql="SELECT * FROM ".get_db_name('akad').".tingkat WHERE departemen='$departemen' AND aktif = 1 ORDER BY urutan";
            $result=QueryDb($sql);
            while ($row=@mysql_fetch_array($result)){
                if ($tingkat=="")
                    $tingkat=$row['replid'];
        ?> 
            <option value="<?=$row['replid']?>" <?=IntIsSelected($row['replid'], $tingkat)?>><?=$row['tingkat']?></option>
        <? 	} ?> 
    </select></td>
</tr>
<tr>
    <td><font color="#000000"><strong>Year </strong></font></td>
    <td><select name="tahunajaran" class="cmbfrm" id="tahunajaran" style="width:150px;" onChange="change()" onkeypress="return focusNext('tingkat', event)">
   		 	<?
			OpenDb();
			$sql = "SELECT replid,tahunajaran,aktif FROM ".get_db_name('akad').".tahunajaran where departemen='$departemen' ORDER BY aktif DESC, replid DESC";
			$result = QueryDb($sql);
			CloseDb();
			while ($row = @mysql_fetch_array($result)) {
				if ($tahunajaran == "") 
					$tahunajaran = $row['replid'];
				if ($row['aktif']) 
					$ada = '(Active)';
				else 
					$ada = '';			 
			?>
            
	<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tahunajaran)?> ><?=$row['tahunajaran'].' '.$ada?></option>
    		<?
			}
    		?>
   	</select>        </td>
        
    <td><font color="#000000"><strong>Class</strong></font></td>
    <td><select name="kelas" class="cmbfrm" id="kelas" style="width:150px" onChange="change_kelas()">
<?	if ($tahunajaran <> "") {
		OpenDb();
		$sql="SELECT k.replid,k.kelas FROM ".get_db_name('akad').".kelas k,".get_db_name('akad').".tahunajaran ta,".get_db_name('akad').".tingkat ti WHERE k.idtahunajaran=ta.replid AND k.idtingkat=ti.replid AND ti.departemen='$departemen' AND ta.replid=$tahunajaran AND ti.replid = $tingkat AND k.aktif=1 ORDER BY k.kelas";
    	$result=QueryDb($sql);
		CloseDb();
    	while ($row=@mysql_fetch_array($result)){
            if ($kelas == "")
                $kelas = $row[replid]; 
                ?>
    	<option value="<?=$row[replid] ?>" <?=StringIsSelected($row[replid], $kelas) ?> >
    	<?=$row[kelas] ?>
    	</option>
    <?	} 
	} else {	?>
    	<option></option>
<? } ?> 
  	</select>
   	</td>    
</tr>
<tr>
	<td colspan="4" align="center">
    <br>
<? 
OpenDb();

if ($kelas <> "" && $tingkat <> "" && $tahunajaran <> "") { 
	$sql_tot = "SELECT s.nis, s.nama, k.kelas FROM ".get_db_name('akad').".siswa s,".get_db_name('akad').".kelas k WHERE s.aktif=1 AND k.replid=s.idkelas AND s.alumni=0 AND k.replid='$kelas' ORDER BY s.nama"; 	
	$result_tot = QueryDb($sql_tot);
	$total = ceil(mysql_num_rows($result_tot)/(int)$varbaris);
	$jumlah = mysql_num_rows($result_tot);
	$akhir = ceil($jumlah/5)*5;
	
	$sql = "SELECT s.nis, s.nama, k.kelas FROM ".get_db_name('akad').".siswa s,".get_db_name('akad').".kelas k WHERE s.aktif=1 AND k.replid=s.idkelas AND s.alumni=0 AND k.replid='$kelas' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
	$result = QueryDb($sql);
	
	if (mysql_num_rows($result) > 0) {
?>
	<table width="100%" id="table" class="tab" align="center" cellpadding="2" cellspacing="0" border="1" bordercolor="#000000">
	<tr height="30" class="header" align="center">
        <td width="7%" >#</td>
        <td width="15%">Student ID</td>
        <td>Name </td>
        <td width="10%">&nbsp;</td>
	</tr>
<?
	if ($page==0)
		$cnt = 1;
	else 
		$cnt = (int)$page*(int)$varbaris+1;
	while($row = mysql_fetch_row($result)) { 
?>
	<tr height="25" onClick="pilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer">
		<td align="center" ><?=$cnt ?></td>
		<td align="center"><?=$row[0] ?></td>
		<td align="left"><?=$row[1] ?></td>
		<!--<td align="center"><?=$row[2] ?></td>-->
		<td align="center"><input type="button" value="Select" onClick="pilih('<?=$row[0]?>','<?=$row[1]?>')"  class="cmbfrm2"></td>
	</tr>
	<?
	$cnt++;
	}
	CloseDb();	?>
    </table>
    <?  if ($page==0){ 
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:visible;'";
	}
	if ($page<$total && $page>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:visible;'";
	}
	if ($page==$total-1 && $page>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:hidden;'";
	}
	if ($page==$total-1 && $page==0){
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:hidden;'";
	}
	?>
    </td>
</tr> 
<tr>
    <td colspan="4">
    <table border="0"width="100%" align="center"cellpadding="0" cellspacing="0">	
    <tr>
       	<td width="30%" align="left"><font color="#000000">Page
        <select name="hal" class="cmbfrm" id="hal" onChange="change_hal('daftar')">
        <?	for ($m=0; $m<$total; $m++) {?>
             <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
        <? } ?>
     	</select>
	  	from <?=$total?> pages
		
		<? 
     	// Navigasi halaman berikutnya and sebelumnya
        ?>
        </font></td>
    	<!--td align="center">
    	<input <?=$disback?> type="button" class="cmbfrm2" name="back" value=" << " onClick="change_page('<?=(int)$page-1?>','daftar')" >
		<?
		for($a=0;$a<$total;$a++){
			if ($page==$a){
				echo "<font face='verdana' color='red'><strong>".($a+1)."</strong></font> "; 
			} else { 
				echo "<a href='#' onClick=\"change_page('".$a."','daftar')\">".($a+1)."</a> "; 
			}
				 
	    }
		?>
	     <input <?=$disnext?> type="button" class="cmbfrm2" name="next" value=" >> " onClick="change_page('<?=(int)$page+1?>','daftar')" >
 		</td-->
        <td width="30%" align="right"><font color="#000000">Row per page
      	<select name="varbaris" class="cmbfrm" id="varbaris" onChange="change_baris('daftar')">
        <? 	for ($m=5; $m <= $akhir; $m=$m+5) { ?>
        	<option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
        <? 	} ?>
      	</select>
        </font></td>
    </tr>
    </table>
<? } else { ?>
	<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0" id="table">
	<tr height="30" align="center">
		<td>   
   
	<br /><br />	
	<font size = "2" color ="red"><b>No data available. <br />           
		Add student data in Student Data on Student. </b></font>	
	<br /><br />
   		</td>
    </tr>
    </table>
<? }
} else {?>
    <table width="100%" align="center" cellpadding="2" cellspacing="0" border="0" id="table">
	<tr height="30" align="center">
		<td>   
   
	<br /><br />	
	<font size = "2" color ="red"><b>No data available. <br />          
		Add Year, Grade or Class in Reference section. </b></font>	
	<br /><br />
   		</td>
    </tr>
    </table>
<? } ?>
</td>    
</tr>
<tr>
	<td align="center" colspan="4">
	<input type="button" class="cmbfrm2" name="tutup" id="tutup" value="Close" onclick="window.close()" style="width:80px;"/>
	</td>
</tr>
</table>