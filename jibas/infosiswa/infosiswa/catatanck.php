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
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$nis=$_REQUEST[nis];
OpenDb();
$sql_year="SELECT DISTINCT YEAR(tanggal) as tahun FROM jbsvcr.catatansiswa WHERE nis='$nis'";
$res_year=QueryDb($sql_year);
$tahun="";
$bulan_pjg = array(1=>'January','February','March','April','May','June','July','August','September','October','November','December');
?>
<table width="100%" border="0" cellspacing="5">
  <tr>
    <td width="150" height="30" valign="top"><div id="thn_catatan">Year
      <select name="tahun" id="tahun" onChange="chg_thn_ck('<?=$nis?>')">
        <?
	if (@mysql_num_rows($res_year)>0){
	while ($row_year=@mysql_fetch_array($res_year)){
	if ($tahun=="")
		$tahun=$row_year[tahun];
	?>
        <option value="<?=$row_year[tahun]?>">
          <?=$row_year[tahun]?>
        </option>
        <?
	}
	} else {
	?>
        <option value="">Data Not Found</option>
        <?
	}
	?>
      </select></div>
      <br />
		<div id="tabel_ck">
        <table width="100%" border="1" cellspacing="0" class="tab">
          <tr class="header" height="30">
            <td width="50"><div align="center">Month</div></td>
            <td width="35%"><div align="center">#</div></td>
          </tr>
          <?
          $sql="SELECT MONTH(tanggal) AS bulan FROM jbsvcr.catatansiswa WHERE YEAR(tanggal)='$tahun' AND nis='$nis' GROUP BY MONTH(tanggal)";
		  //echo $sql;
		  $result=QueryDb($sql);
		  if (@mysql_num_rows($result)>0){
          	while ($row=@mysql_fetch_array($result)){
		  	$sql_cnt="SELECT COUNT(*) FROM jbsvcr.catatansiswa WHERE nis='$nis' AND MONTH(tanggal)='$row[bulan]' AND YEAR(tanggal)='$tahun'";
		  	$res_cnt=QueryDb($sql_cnt);
			$row_cnt=@mysql_fetch_row($res_cnt);
		  ?>
		  <tr onClick="show_ck('<?=$row[bulan]?>','<?=$tahun?>')" style="cursor:pointer;" title="Click to show Student Note list">
            <td width="50"><?=$bulan_pjg[$row[bulan]]?></td>
            <td><div align="center">
              <?=$row_cnt[0]?>
            </div></td>
          </tr>
          <?
		  	}
		  } else {
		  ?>
		  <tr>
            <td colspan="2" align="center">Data Not Found.</td>
          </tr>
		  <? } ?>
        </table>
    </div>
    </td>
    <td rowspan="2"><div id="contentcatatan">&nbsp;
    </div></td>
  </tr>
  <tr>
    <td valign="top"></td>
  </tr>
</table>