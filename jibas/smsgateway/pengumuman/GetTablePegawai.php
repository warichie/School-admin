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
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
OpenDb();
$bag = $_REQUEST['Section'];
if ($bag=="")
	$bag='-1';
$Employee ID 	= $_REQUEST['Employee ID'];
$Nama 	= $_REQUEST['Nama'];
$Source = $_REQUEST['Source'];
?>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab">
  <tr class="Header">
    <td>#</td>
    <td>Employee ID/Name</td>
    <td>Mobile</td>
    <td>&nbsp;</td>
  </tr>
  <?
    if ($Source=='Select'){
		if ($bag=='-1')
			$sql = "SELECT * FROM $db_name_sdm.pegawai";
		else
			$sql = "SELECT * FROM $db_name_sdm.pegawai WHERE bagian='$bag'";
	} else {
		$sql = "SELECT * FROM $db_name_sdm.pegawai WHERE replid>0";
		if ($Employee ID!="")
			$sql .= " AND nip LIKE '%$Employee ID%'";
		if ($Nama!="")
			$sql .= " AND nama LIKE '%$Nama%'";	
	}
	$res = QueryDb($sql);
    $num = @mysql_num_rows($res);
    if ($num>0){
        $cnt=1;
        while ($row = @mysql_fetch_array($res)){
  ?>
  <tr>
    <td align="center" class="td"><?=$cnt?></td>
    <td class="td">(<?=$row['nip']?>) <?=$row['nama']?></td>
    <td class="td"><?=$row['handphone']?></td>
    <td class="td" align="center">
    <? if (strlen($row['handphone'])>0){ ?>
    <span style="cursor:pointer" class="Link" onclick="InsertNewReceipt('<?=$row['handphone']?>','<?=$row['nama']?>','<?=$row['nip']?>')" align="center"  />Select</span>
    <? } ?>
    </td>
  </tr>
  <?
        $cnt++;
        }
    } else {
    ?>
  <tr>
    <td colspan="4" class="Ket" align="center">Data Not Found.</td>
  </tr>
  <?
    }
        ?>
</table>