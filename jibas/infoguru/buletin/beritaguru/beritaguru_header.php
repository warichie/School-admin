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
$bulan=date("n");
if (isset($_REQUEST['bulan']))
	$bulan=$_REQUEST['bulan'];
$tahun=date("Y");
if (isset($_REQUEST['tahun']))
	$tahun=$_REQUEST['tahun'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../style/style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function lihat(){
	var bulan=document.getElementById('bulan').value;
	var tahun=document.getElementById('tahun').value;
	parent.beritaguru_footer.location.href="beritaguru_footer.php?bulan="+bulan+"&tahun="+tahun;
}
function chg(){
	var bulan=parseInt(document.getElementById('bulan').value);
	var tahun=parseInt(document.getElementById('tahun').value);
	self.location.href="beritaguru_header.php?tahun="+tahun+"&bulan="+bulan+"&send=true";
	parent.beritaguru_footer.location.href="blank.php";
}
function next(){
	var bulan=parseInt(document.getElementById('bulan').value);
	var tahun=parseInt(document.getElementById('tahun').value);
	if (bulan==12){
		tahun=tahun+1;
    parent.beritaguru_footer.location.href="blank.php";
	self.location.href="beritaguru_header.php?bulan=1&tahun="+tahun;
	} else {
		bulan=bulan+1;
	parent.beritaguru_footer.location.href="blank.php";
	self.location.href="beritaguru_header.php?tahun="+tahun+"&bulan="+bulan+"&send=true";
	}
}
function prev(){
	var bulan=parseInt(document.getElementById('bulan').value);
	var tahun=parseInt(document.getElementById('tahun').value);
	if (bulan==1){
		tahun=tahun-1;
	parent.beritaguru_footer.location.href="blank.php";
	self.location.href="beritaguru_header.php?bulan=12&tahun="+tahun;
	} else {
		bulan=bulan-1;
	parent.beritaguru_footer.location.href="blank.php";
	self.location.href="beritaguru_header.php?tahun="+tahun+"&bulan="+bulan+"&send=true";
	}
}
</script>
</head>
<body onload="lihat();">
<table width="100%" border="0" cellspacing="0">
  <tr>
    <th align="right" scope="row">
    <font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Teacher News</font><br />
    <a href="../../home.php" target="framecenter">
      <font size="1" color="#000000"><b>Home</b></font></a>&nbsp;>&nbsp;
        <font size="1" color="#000000"><b>Teacher News</b></font>    </th>
  </tr>
  <tr>
    <td scope="row"><? if (SI_USER_ID()!="LANDLORD" && SI_USER_ID()!="landlord"){ ?><input type="button" name="beritabaru" id="beritabaru" value="Recent News" class="but" title="Add Recent News" onclick="parent.beritaguru_footer.location.href='beritaguru_add.php';"/><? } ?></th>
    
    Month : 
      <input type="button" name="prevmonth" id="prevmonth" value=" < " class="but" title="Previous Month" onclick="prev()"/>
      &nbsp;
      <select name="bulan" id="bulan" onchange="chg()">
        <?
	for ($i=1;$i<=12;$i++){
	if ($bulan=="")
		$bulan=$i;
	?>
        <option value="<?=(int)$i?>" <?=StringIsSelected($i,$bulan)?>><?=NamaBulan($i)?></option>
        <?
	}
	?>
        </select>
      &nbsp;
      <select name="tahun" id="tahun" onchange="chg()">
        <?
	for ($y=2006;$y<=2020;$y++){
	if ($tahun=="")
		$tahun=$y;
	?>
        <option value="<?=(int)$y?>" <?=StringIsSelected($y,$tahun)?>><?=$y?></option>
        <?
	}
	?>
        </select>
    &nbsp;
    <input type="button" name="nextmonth" id="nextmonth" value=" > " class="but" title="Next Month" onclick="next()"/>
    </th>
    <input type="button" name="berita" id="berita" value="See the News" class="but" title="See the News" onclick="lihat()"/>    </tr>
</table>

</body>
</html>