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
require_once('../inc/sessionchecker.php');
require_once('../inc/config.php');
require_once('../inc/getheader.php');
require_once('../inc/common.php');
require_once('../inc/db_functions.php');

$krit = array('','Religion','Past School','Blood Type','Gender','Citizenship','Student Post Code','Student Conditions','Father Occupation','Mother Occupation','Father Education','Mother Education','Parent Income','Status Active','Student Status','Ethnicity','Year of Birth','Age');
$departemen = '-1';
if (isset($_REQUEST[departemen]))
	$departemen = $_REQUEST[departemen];
$angkatan = '';
if (isset($_REQUEST[angkatan]))
	$angkatan = $_REQUEST[angkatan];
$kriteria = '1';
if (isset($_REQUEST[kriteria]))
	$kriteria = $_REQUEST[kriteria];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../style/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../script/ajax.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language='javascript'>
function change_dep(){
	var dep = document.getElementById('departemen').value;
	var krit = document.getElementById('kriteria').value;
	document.location.href='stat.php?departemen='+dep+'&kriteria='+krit;
	
}
function chg(){
	var dep = document.getElementById('departemen').value;
	var a = document.getElementById('angkatan').value;
	var krit = document.getElementById('kriteria').value;
	document.location.href='stat.php?departemen='+dep+'&angkatan='+a+'&kriteria='+krit;
}
function viewdetail(kriteria,departemen,angkatan,kondisi){
	show_wait('statdetail');
	sendRequestText('get_stat_detail.php',showDetail,'departemen='+departemen+'&angkatan='+angkatan+'&kriteria='+kriteria+'&kondisi='+kondisi);
}
function show_wait(areaId) {
	var x = document.getElementById("waitBox").innerHTML;
	document.getElementById(areaId).innerHTML = x;
}

function showDetail(x){
	document.getElementById('statdetail').innerHTML = x;
}
function lihat_siswa(replid) {
	//var replid = document.getElementById('replid').value;
	newWindow('../lib/detail_siswa.php?replid='+replid, 'CetakDetailSiswa','800','650','resizable=1,scrollbars=1,status=0,toolbar=0')
	//newWindow('cetak_detail_siswa.php?replid='+replid, 'CetakDetailSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function cetak(){
	var addr = "stat_cetak.php?kriteria=<?=$kriteria?>&departemen=<?=$departemen?>&angkatan=<?=$angkatan?>";
	newWindow(addr, 'CetakStatistik','800','650','resizable=1,scrollbars=1,status=0,toolbar=0');
}
</script>
</head>
<body>
<div id="waitBox" style="position:absolute; visibility:hidden;">
	<img src="../img/loading2.gif" border="0" />&nbsp;<span class="tab2">Please wait...</span>
</div>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td align="right" class="tab2">Dept.</td>
    <td><select name="departemen" class="cmbfrm" id="departemen" style="width:240px;" onchange="change_dep()" >
       		  <option value="-1" >(All Department)</option>    
			<?
				$sql = "SELECT * FROM departemen WHERE aktif=1 ORDER BY urutan";
				OpenDb();
				$result = QueryDb($sql);
				CloseDb();
			
				//$departemen = "";	
				while($row = mysql_fetch_array($result)) {
					//if ($departemen == "")
						//$departemen = "-1";
						//$departemen = $row['departemen'];
			?>
            	<option value="<?=urlencode($row['departemen'])?>" <?=StringIsSelected($row['departemen'], $departemen) ?>><?=$row['departemen']?></option>
            <?
				} //while
			?>
  		  </select></td>
        <td align="right" class="tab2">Graduates</td>
        <td><select name="angkatan" class="cmbfrm" id="angkatan" style="width:240px;" onchange="chg()" <?=$disable?> >
        	<option value="" >(All Active)</option>
        	<? if ($departemen!='-1'){ ?> 
			<? 	OpenDb();
				$sql = "SELECT replid,angkatan FROM angkatan where aktif = 1 AND departemen = '$departemen' ORDER BY replid DESC";
				$result = QueryDb($sql);
				while ($row = mysql_fetch_array($result)) {
					//if ($angkatan=="")
						//$angkatan = $row[replid];
			?>
        	<option value="<?=urlencode($row[replid])?>" <?=StringIsSelected($row['replid'], $angkatan) ?>><?=$row['angkatan']?></option>
        	<?
  				} //while
				CloseDb();
			}
			?>
   		  </select></td>
        <td align="right" class="tab2">Criteria</td>
        <td><select name="kriteria" class="cmbfrm" id="kriteria" style="width:240px;" onchange="chg()" >
        <? for ($i=1;$i<=17;$i++) { 
			if ($kriteria=="")
				$kriteria = $i;
		?>
        <option value ="<?=$i?>" <?=IntIsSelected($i, $kriteria) ?>><?=$krit[$i] ?></option>
        <?  } ?>
        </select></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2" align="center"><a href="javascript:cetak()"><img src="../img/print.png" width="16" height="16" border="0" />&nbsp;Print</a></td>
    </tr>
  <tr>
    <td><div align="center">
        <img src="<?="statimage.php?type=bar&dep=$departemen&angkatan=$angkatan&krit=$kriteria" ?>" />
        </div></td>
    <td><div align="center">
        <img src="<?="statimage.php?type=pie&dep=$departemen&angkatan=$angkatan&krit=$kriteria" ?>" />
        </div></td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="7" cellpadding="7">
      <tr>
        <td width="30%" align="center" valign="top">
        <?
		$filter = "";
		if ($departemen == "-1")
			$filter="AND a.replid=s.idangkatan ";
		if ($departemen != "-1" && $angkatan == "")
			$filter="AND a.departemen='$departemen' AND a.replid=s.idangkatan ";
		if ($departemen != "-1" && $angkatan != "")
			$filter="AND s.idangkatan=$angkatan AND a.replid=s.idangkatan AND a.departemen='$departemen' ";
		
		if ($kriteria == 1) 
		{
			$xtitle = "Religion";
			$ytitle = "Sum";
		
			$sql = "SELECT s.agama, count(s.replid), s.agama AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.agama";	
		}
		
		elseif ($kriteria == 2) 
		{
			$xtitle = "Past School";
			$ytitle = "Sum";
		
			$sql = "SELECT s.asalsekolah, count(s.replid), s.asalsekolah AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.asalsekolah";	
					//echo $sql;
		}
		
		elseif ($kriteria == 3) 
		{
			$xtitle = "Blood Type";
			$ytitle = "Sum";
		
			$sql = "SELECT s.darah, count(s.replid), s.darah AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.darah";	
		}
		elseif ($kriteria == 4)
		{
			$xtitle = "Gender";
			$ytitle = "Sum";
			$sql	=  "SELECT IF(s.kelamin='l','Male','Female') as X, COUNT(s.nis), s.kelamin AS XX FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X";
		}
		elseif ($kriteria == 5)
		{
			$xtitle = "Citizenship";
			$ytitle = "Sum";
			$sql = "SELECT s.warga, count(s.replid), s.warga AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.warga ORDER BY s.warga DESC";
		}
		elseif ($kriteria == 6)
		{
			$xtitle = "Postal Code";
			$ytitle = "Sum";
			$sql = "SELECT s.kodepossiswa, count(s.replid), s.kodepossiswa AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.kodepossiswa ";
		}
		elseif ($kriteria == 7)
		{
			$xtitle = "Conditions";
			$ytitle = "Sum";
			$sql = "SELECT s.kondisi, count(s.replid), s.kondisi AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.kondisi ";
		}
		elseif ($kriteria == 8)
		{
			$xtitle = "Father Occupation";
			$ytitle = "Sum";
			$sql = "SELECT s.pekerjaanayah, count(s.replid), s.pekerjaanayah AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pekerjaanayah ";
		}
		elseif ($kriteria == 9)
		{
			$xtitle = "Mother Occupation";
			$ytitle = "Sum";
			$sql = "SELECT s.pekerjaanibu, count(s.replid), s.pekerjaanibu AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pekerjaanibu ";
		}
		elseif ($kriteria == 10)
		{
			$xtitle = "Father Education";
			$ytitle = "Sum";
			$sql = "SELECT s.pendidikanayah, count(s.replid), s.pendidikanayah AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pendidikanayah ";
		}
		elseif ($kriteria == 11)
		{
			$xtitle = "Mother Education";
			$ytitle = "Sum";
			$sql = "SELECT s.pendidikanibu, count(s.replid), s.pendidikanibu AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY s.pendidikanibu ";
		}
		elseif ($kriteria == 12)
		{
			$xtitle = "Income";
			$ytitle = "Sum";
			$sql = "SELECT G, COUNT(nis), XX FROM (
					  SELECT nis, IF(peng < 1000000, '< 1 juta',
								  IF(peng >= 1000001 AND peng <= 2500000, '1 juta - 2,5 juta',
								  IF(peng >= 2500001 AND peng <= 5000000, '2,5 juta - 5 juta',
								  IF(peng >= 5000001 , '> 5 juta', 'No data.')))) AS G,
								  IF(peng < 1000000, '1',
								  IF(peng >= 1000001 AND peng <= 2500000, '2',
								  IF(peng >= 2500001 AND peng <= 5000000, '3',
								  IF(peng >= 5000001 , '4', '5')))) AS GG, 
								  IF(peng < 1000000, '(s.penghasilanayah__s.penghasilanibu)<1000000',
								  IF(peng >= 1000001 AND peng <= 2500000, '(s.penghasilanayah__s.penghasilanibu)>=1000001 AND (s.penghasilanayah__s.penghasilanibu)<=2500000',
								  IF(peng >= 2500001 AND peng <= 5000000, '(s.penghasilanayah__s.penghasilanibu)>=2500001 AND (s.penghasilanayah__s.penghasilanibu)<=5000001',
								  IF(peng >= 5000001 , '(s.penghasilanayah__s.penghasilanibu)>=5000001', '(s.penghasilanayah__s.penghasilanibu)=0')))) AS XX FROM
						(SELECT s.nis, FLOOR(s.penghasilanibu + s.penghasilanayah) AS peng FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter ) AS X) AS X GROUP BY G ORDER BY GG";
		}
		elseif ($kriteria == 13)
		{
			$xtitle = "Status Active";
			$ytitle = "Sum";
			$sql	=  "SELECT IF(s.aktif=1,'Active','Inactive') as X, COUNT(s.nis), s.aktif AS XX FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X";
		}
		elseif ($kriteria == 14)
		{
			$xtitle = "Student Status";
			$ytitle = "Sum";
			$sql = "SELECT s.status as X, count(s.replid), s.status AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X ";
		}
		elseif ($kriteria == 15)
		{
			$xtitle = "Ethnicity";
			$ytitle = "Sum";
			$sql = "SELECT s.suku as X, count(s.replid), s.suku AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X ";
		}
		elseif ($kriteria == 16)
		{
			$xtitle = "Year of Birth";
			$ytitle = "Sum";
			$sql = "SELECT YEAR(s.tgllahir) as X, count(s.replid), YEAR(s.tgllahir) AS XX FROM 
					siswa s, angkatan a 
					WHERE a.aktif=1 AND s.aktif=1 $filter GROUP BY X ORDER BY X ";
		}
		elseif ($kriteria == 17)
		{
			$xtitle = "Age";
			$ytitle = "Sum";
			$sql = "SELECT G, COUNT(nis), XX FROM (
					  SELECT nis, IF(usia < 6, '<6',
								  IF(usia >= 6 AND usia <= 12, '6-12',
								  IF(usia >= 13 AND usia <= 15, '13-15',
								  IF(usia >= 16 AND usia <= 18, '16-18','>18')))) AS G,
								  IF(usia < 6, '1',
								  IF(usia >= 6 AND usia <= 12, '2',
								  IF(usia >= 13 AND usia <= 15, '3',
								  IF(usia >= 16 AND usia <= 18, '4','5')))) AS GG, 
								  IF(usia < 6, 'YEAR(now())__YEAR(s.tgllahir)<6',
								  IF(usia >= 6 AND usia <= 12, 'YEAR(now())__YEAR(s.tgllahir)>=6 AND YEAR(now())__YEAR(s.tgllahir)<=12',
								  IF(usia >= 13 AND usia <= 15, 'YEAR(now())__YEAR(s.tgllahir)>=13 AND YEAR(now())__YEAR(s.tgllahir)<=15',
								  IF(usia >= 16 AND usia <= 18, 'YEAR(now())__YEAR(s.tgllahir)>=16 AND YEAR(now())__YEAR(s.tgllahir)<=18','YEAR(now())__YEAR(s.tgllahir)>=18')))) AS XX FROM
						(SELECT nis, YEAR(now())-YEAR(s.tgllahir) AS usia FROM siswa s, angkatan a WHERE a.aktif=1 AND s.aktif=1 $filter ) AS X) AS X GROUP BY G ORDER BY GG";
		}
		
		?>
        <table width="100%" border="1" class="tab" align="center">
          <tr>
            <td height="25" align="center" class="header">#</td>
            <td height="25" align="center" class="header"><?=$xtitle?></td>
            <td height="25" align="center" class="header"><?=$ytitle?></td>
            <td height="25" align="center" class="header">&nbsp;</td>
          </tr>
          <?
		  OpenDb();
		  $result = QueryDb($sql);
		  $cnt=1;
		  while ($row = @mysql_fetch_row($result)){
		  ?>
          <tr>
            <td width="15" height="20" align="center"><?=$cnt?></td>
            <td height="20">&nbsp;&nbsp;<?=$row[0]?></td>
            <td height="20" align="center"><?=$row[1]?> student</td>
            <td height="20" align="center"><a href="javascript:viewdetail('<?=$kriteria?>','<?=$departemen?>','<?=$angkatan?>','<?=$row[2]?>')"><img src="../img/lihat.png" border="0" /></a></td>
          </tr>
          <?
		  $cnt++;
		  }
		  ?>
        </table>
        </td>
        <td align="left" valign="top"><div id="statdetail"></div></td>
      </tr>
    </table>
	</td>
  </tr>
</table>

</body>
</html>