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
require_once('../include/sessioninfo.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('../include/config.php');
OpenDb();
$sql="SELECT p.idguru as idguru,p.tanggalpesan as tanggalpesan, p.judul as judul, p.pesan as pesan,t.baru as baru from jbsvcr.pesanguru p, jbsvcr.tujuanpesanguru t WHERE t.idpesan=p.replid AND t.idpenerima='".SI_USER_ID()."'";
$result=QueryDb($sql);
//CloseDb();
echo $sql;
?>
<table width="200" border="1">
  <tr class="header">
    <td height="30">#</td>
    <td height="30">&nbsp;</td>
    <td height="30">Sender</td>
    <td height="30">&nbsp;</td>
    <td height="30">Title</td>
    <td height="30">Date</td>
  </tr>
  <?
  if (@mysql_num_rows($result)==0){
  ?>
  <tr>
    <td height="25" colspan="6" align="center">No message in the Inbox</td>    
  </tr>
  <? 
  } else{
  $cnt=1;
  while ($row=@mysql_fetch_array($result)){
  ?>
  <tr>
    <td height="25"><?=$cnt?></td>
    <td height="25"></td>
    <td height="25"><?=$row[idguru]?></td>
    <td height="25">&nbsp;</td>
    <td height="25">&nbsp;</td>
    <td height="25">&nbsp;</td>
  </tr>
  <? $cnt++; } } ?>
</table>