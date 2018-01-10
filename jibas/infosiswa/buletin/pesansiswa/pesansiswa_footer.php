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
require_once('../../include/common.php');
require_once('../../include/sessioninfo.php');
require_once('../../include/config.php');
require_once('../../include/getheader.php');
require_once('../../include/db_functions.php');
function delete($file) {
 if (file_exists($file)) {
   chmod($file,0777);
   if (is_dir($file)) {
     $handle = opendir($file); 
     while($filename = readdir($handle)) {
       if ($filename != "." && $filename != "..") {
         delete($file."/".$filename);
       }
     }
     closedir($handle);
     rmdir($file);
   } else {
     unlink($file);
   }
 }
}
$op="";
if (isset($_REQUEST['op']))
	$op=$_REQUEST['op'];
if ($op=="34983xihxf084bzux834hx8x7x93"){
	$numdel=(int)$_REQUEST["numdel"]-1;
	$msgall=$_REQUEST["listdel"];
	$x=0;
	$msg=explode("|",$msgall);
	while ($x<=$numdel){
		if ($msg[$x]!=""){
		OpenDb();
			$sql="UPDATE jbsvcr.tujuanpesan SET aktif=0, baru=0 WHERE replid='$msg[$x]'";
			//echo $sql;
			$result=QueryDb($sql);
		CloseDb();
		}
	$x++;
	}
}
if ($op=="f3fxxa7svys774l3067den747hhd783uu83"){//Mindahin ke draft
	$numdel=(int)$_REQUEST["numdel"]-1;
	$msgall=$_REQUEST["listdel"];
	$x=0;
	$msg=explode("|",$msgall);
	while ($x<=$numdel){
		if ($msg[$x]!=""){
		OpenDb();
		$sql="SELECT idpesan FROM jbsvcr.tujuanpesan WHERE replid='$msg[$x]'";
		$result=QueryDb($sql);
		$row=@mysql_fetch_array($result);
		//echo $sql."<br>";
		$sql2="SELECT replid,tanggalpesan,judul,pesan,nis FROM jbsvcr.pesan WHERE replid='$row[idpesan]'";
		$result2=QueryDb($sql2);
		$row2=@mysql_fetch_array($result2);
		//echo $sql2."<br>";
		$sql3="INSERT INTO jbsvcr.draft SET tanggalpesan='$row2[tanggalpesan]',judul='$row2[judul]',pesan='$row2[pesan]',idpemilik='".SI_USER_ID()."',idpengirim='$row2[nis]'";
		$result3=QueryDb($sql3);
		//echo $sql3."<br>";
		$sql4="SELECT replid FROM jbsvcr.draft WHERE idpemilik='".SI_USER_ID()."' ORDER BY replid DESC LIMIT 1";
		$result4=QueryDb($sql4);
		$row4=@mysql_fetch_array($result4);
		$lastid=$row4[replid];
		//echo $sql5."<br>";
		$sql5="SELECT direktori,namafile FROM jbsvcr.lampiranpesan WHERE idpesan='$row2[replid]'";
		$result5=QueryDb($sql5);
		//$row5=@mysql_fetch_array($result5);
		//echo $sql5."<br>";
		$updir = $UPLOAD_DIR."pesan\\";
		$dir_bln=date(m);
		$dir_thn=date(Y);
		$dir = $updir . $dir_thn . $dir_bln;
		if (!is_dir($dir)) 
			mkdir($dir, 0777);
		$newdir=$dir."\\";
		$dir_db = str_replace($UPLOAD_DIR,$WEB_UPLOAD_DIR,$newdir);
		$new_dir_db = str_replace("\\","/",$dir_db);
		while ($row5=@mysql_fetch_array($result5)){
		copy($row5['direktori'].$row5['namafile'], $newdir.SI_USER_ID()."-".$row5['namafile']);
		//echo $row5['direktori'].$row5['namafile'];
		$sql6="INSERT INTO jbsvcr.lampirandraft SET idpesan='$lastid',direktori='$new_dir_db',namafile='".SI_USER_ID()."-".$row5['namafile']."'";
		$result6=QueryDb($sql6);
		}
		$sql7="UPDATE jbsvcr.tujuanpesan SET aktif=0, baru=0 WHERE idpesan='$row2[replid]' AND idpenerima='".SI_USER_ID()."'";
		$result7=QueryDb($sql7);
		CloseDb();
		}
	$x++;
	}
}
if ($op=="bzux834hx8x7x934983xihxf084"){
	//Hapus dulu file attachnya
	OpenDb();
	$sql="SELECT direktori, namafile FROM jbsvcr.lampiranpesan WHERE idpesan='$_REQUEST[replid]'";
	$result=QueryDb($sql);
	$file="file";
	$cntdel=0;
	while ($row=@mysql_fetch_array($result)){
		$mydir[$cntdel]=$row['direktori'].$row['namafile'];
		$cntdel++;	
	}
	CloseDb();
	delete($mydir[0]);
	delete($mydir[1]);
	delete($mydir[2]);
	//Hapus tabel lampiranberitasiswa
	OpenDb();
	$sql="DELETE FROM jbsvcr.lampiranpesan WHERE idpesan='$_REQUEST[replid]'";
	$result=QueryDb($sql);
	CloseDb();
	OpenDb();
	$sql="DELETE FROM jbsvcr.tujuanpesan WHERE idpesan='$_REQUEST[replid]'";
	$result=QueryDb($sql);
	CloseDb();
	//Hapus tabel beritasiswa
	OpenDb();
	$sql="DELETE FROM jbsvcr.pesan WHERE replid='$_REQUEST[replid]'";
	$result=QueryDb($sql);
	CloseDb();
}
if ($op=="baca"){
	OpenDb();
	$sql="UPDATE jbsvcr.tujuanpesan SET baru=0 WHERE replid='$_REQUEST[replid]'";
	//echo $sql;
	//exit;
	$result=QueryDb($sql);
	CloseDb();
	?>
	<script language="javascript">
		document.location.href="pesansiswabaca.php?replid=<?=$_REQUEST[replid]?>";
	</script>
	<?
	
}
$bulan="";
if (isset($_REQUEST['bulan']))
	$bulan=$_REQUEST['bulan'];
$tahun="";
if (isset($_REQUEST['tahun']))
	$tahun=$_REQUEST['tahun'];
$idsiswa=SI_USER_ID();
$varbaris=10;
$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../style/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../script/tables.js"></script>
<script language="javascript" src="../../script/tools.js"></script>
<script language="javascript">
function fill_month_and_year(){
	var bulan=parent.pesansiswa_header.document.getElementById("bulan").value;
	var tahun=parent.pesansiswa_header.document.getElementById("tahun").value;
	document.location.href="pesansiswa_footer.php?bulan="+bulan+"&tahun="+tahun;
}
function chg_page(){
	var page=document.getElementById("page").value;
	var bulan=parent.pesansiswa_header.document.getElementById("bulan").value;
	var tahun=parent.pesansiswa_header.document.getElementById("tahun").value;
	document.location.href="pesansiswa_footer.php?bulan="+bulan+"&tahun="+tahun+"&page="+page;
}
function change_page(page) {
	
	//var tahun=parent.beritaguru_header.document.getElementById("tahun").value;
	//alert ('Resend');
	document.location.href="pesansiswa_footer.php?page="+page;
}
function ubah(replid){
	document.location.href="pesansiswa_ubah_main.php?replid="+replid;
}
function bacapesan(replid){
	var page=document.getElementById("page").value;
	//var bulan=parent.pesansiswa_header.document.getElementById("bulan").value;
	//var tahun=parent.pesansiswa_header.document.getElementById("tahun").value;
	//document.location.href="pesansiswa_footer.php?op=baca&replid="+replid+"&bulan="+bulan+"&tahun="+tahun+"&page="+page;
	document.location.href="pesansiswa_footer.php?op=baca&replid="+replid+"&page="+page;
}
function hapus(replid){
	var page=document.getElementById("page").value;
	var bulan=parent.pesansiswa_header.document.getElementById("bulan").value;
	var tahun=parent.pesansiswa_header.document.getElementById("tahun").value;
	if (confirm('Are you sure want to delete this message and the attachments?')){ 
		document.location.href="pesansiswa_footer.php?op=bzux834hx8x7x934983xihxf084&replid="+replid+"&bulan="+bulan+"&tahun="+tahun+"&page="+page;
	}
}
function cek_all() {
	var x;
	var jum = document.inbox.numpesan.value;
	var ceked = document.inbox.cek.checked;
	for (x=1;x<=jum;x++){
		if (ceked==true){
			document.getElementById("cekpesan"+x).checked=true;
		} else {
			document.getElementById("cekpesan"+x).checked=false;
		}
	}
}
function chg(i) {
	document.getElementById("listdel").value="";
	document.inbox.cek.checked=false;
}
function delpesan(){
	var x;
	var y=0;
	var jum = document.inbox.numpesan.value;
	for (x=1;x<=jum;x++){
		var ceked = document.getElementById("cekpesan"+x).checked;
		var rep = document.getElementById("rep"+x).value;
		var listdel=document.getElementById('listdel').value;
		if (ceked==true){
			if (y==0)
				y=y+1;
			document.getElementById('listdel').value=listdel+rep+"|";
			document.getElementById('numdel').value=y++;
		}
	}
	var num = document.inbox.numdel.value;
	var list = document.inbox.listdel.value;
	if (list.length==0){
		alert ('You should have at least one message to deleted');
		return false;
	} else {
		if (confirm('Are you sure want to delete this message?')){
			document.location.href="pesansiswa_footer.php?op=34983xihxf084bzux834hx8x7x93&listdel="+list+"&numdel="+num;
		} else {
			document.getElementById("listdel").value="";
		}
	}
}
function savepesan(){
	var x;
	var y=0;
	var jum = document.inbox.numpesan.value;
	for (x=1;x<=jum;x++){
		var ceked = document.getElementById("cekpesan"+x).checked;
		var rep = document.getElementById("rep"+x).value;
		var listdel=document.getElementById('listdel').value;
		if (ceked==true){
			if (y==0)
				y=y+1;
			document.getElementById('listdel').value=listdel+rep+"|";
			document.getElementById('numdel').value=y++;
		}
	}
	var num = document.inbox.numdel.value;
	var list = document.inbox.listdel.value;
	if (list.length==0){
		alert ('You should have at least one message to be moved to Draft');
		return false;
	} else {
		if (confirm('Are you sure want to move this message to draft?')){
			document.location.href="pesansiswa_footer.php?op=f3fxxa7svys774l3067den747hhd783uu83&listdel="+list+"&numdel="+num;
		} else {
			document.getElementById("listdel").value="";
		}
	}
}
</script>
</head>
<body >
<form name="inbox" id="inbox"  action="pesansiswa_footer.php">
<div align="right">
<font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Inbox</font><br />
    <a href="pesansiswa.php" target="framecenter">
      <font size="1" color="#000000"><b>Student Message</b></font></a>&nbsp;>&nbsp;
        <font size="1" color="#000000"><b>Inbox</b></font>
</div>
<input type="hidden" name="bulan" id="bulan" value="<?=$bulan?>" />
<input type="hidden" name="tahun" id="tahun" value="<?=$tahun?>" />
<table width="100%" border="0" cellspacing="0">
  <tr>
  <? OpenDb();
  /*$sql_tot="SELECT pg.replid as replid, pg.judul as judul, DATE_FORMAT(pg.tanggalpesan, '%e %b %Y') as tanggal, TIME_FORMAT(pg.tanggalpesan, '%H:%i') as waktu, ".
  		"pg.pesan as pesan, p.nama as nama, p.nip as nip FROM jbsvcr.pesansiswa pg, jbssdm.pegawai p, jbsvcr.tujuanpesansiswa t ".
		"WHERE pg.replid=t.idpesan AND p.nip=pg.idsiswa ORDER BY pg.tanggalpesan DESC ";
  */
  $sql_tot="SELECT * FROM jbsvcr.tujuanpesan t, jbsvcr.pesan p WHERE t.idpenerima='".SI_USER_ID()."' AND t.idpesan=p.replid AND p.nis<>'' AND t.aktif=1 ORDER BY p.tanggalpesan DESC ";
  //echo $sql_tot;
  $result_tot=QueryDb($sql_tot);
  $total = ceil(mysql_num_rows($result_tot)/(int)$varbaris);
  CloseDb();
	?>
	<td scope="row" align="left">
	<?
	if ($total!=0){
		if ($page==0){ 
		$disback="style='visibility:hidden;position:absolute;'";
		$disnext="style='visibility:visible;position:inherit;'";
		}
		if ($page<$total && $page>0){
		$disback="style='visibility:visible;position:inherit;'";
		$disnext="style='visibility:visible;position:inherit;'";
		}
		if ($page==$total-1 && $page>0){
		$disback="style='visibility:visible;position:inherit;'";
		$disnext="style='visibility:hidden;position:absolute;'";
		}
		if ($page==$total-1 && $page==0){
		$disback="style='visibility:hidden;position:absolute;'";
		$disnext="style='visibility:hidden;position:absolute;'";
		}
	
	?>
    Page : 
	<input <?=$disback?> type="button" class="but" title="Previous" name="back" value="<" onClick="change_page('<?=(int)$page-1?>')" onMouseOver="showhint('Previous', this, event, '75px')">
	<select name="page" id="page" onChange="chg_page()">
	<? for ($p=1;$p<=$total;$p++){ ?>
		<option value="<?=$p-1?>" <?=StringIsSelected($page,$p-1)?>><?=$p;?></option>
	<? } ?>
	</select>   
    <input <?=$disnext?> type="button" class="but" name="next" title="Next" value=">" onClick="change_page('<?=(int)$page+1?>')" onMouseOver="showhint('Next', this, event, '75px')">&nbsp;from&nbsp;<?=$total?> 
	<? } ?><br><br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab" id="table">
  <tr>
    <th width="31" height="30" class="header" scope="row"><div align="center">#</div></th>
    <td width="28" height="30" class="header"><div align="center"><input type="checkbox" name="cek" id="cek" onClick="cek_all()" title="Select all" onMouseOver="showhint('Select all', this, event, '120px')"/></div></td>
    <td width="492" height="30" class="header"><div align="center">Sender</div></td>
    <td width="22" height="30" class="header" title="Attachment"><div align="center"></div></td>
    <td width="240" class="header"><div align="center">Title</div></td>
    <!--<td width="191" height="30" class="header"><div align="center">Attachment</div></td>-->
   	<td width="117" class="header"><div align="center">Date</div></td>
   </tr>
  <?
  OpenDb();
  
	$sql1="SELECT s.nama as nama,s.nis as nis,t.replid as replid, pg.replid as replid2, pg.judul as judul, DATE_FORMAT(pg.tanggalpesan, '%e %b %Y') as tanggal, TIME_FORMAT(pg.tanggalpesan, '%H:%i') as waktu, t.baru as baru FROM jbsvcr.pesan pg, jbsvcr.tujuanpesan t, jbsakad.siswa s WHERE t.idpesan=pg.replid AND t.idpenerima='".SI_USER_ID()."' AND pg.nis=s.nis AND t.aktif=1 ORDER BY pg.tanggalpesan DESC LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
  //echo $sql1;
  /*$sql1="SELECT pg.replid as replid, pg.judul as judul, DATE_FORMAT(pg.tanggalpesan, '%e %b %Y') as tanggal, TIME_FORMAT(pg.tanggalpesan, '%H:%i') as waktu, t.baru as baru, t.replid as replid2, ".
  		"pg.pesan as pesan, p.nama as nama, p.nip as nip FROM jbsvcr.pesansiswa pg, jbssdm.pegawai p, jbsvcr.tujuanpesansiswa t ".
		"WHERE pg.replid=t.idpesan AND p.nip=pg.idsiswa ORDER BY replid LIMIT ".(int)$page*(int)$varbaris.",$varbaris";*/
  $result1=QueryDb($sql1);
  if (@mysql_num_rows($result1)>0){
   if ($page==0){
  $cnt=1;
  } else {
  $cnt=(int)$page*(int)$varbaris+1;
  }
  $numpesan=@mysql_num_rows($result1);
  $count=1;
  while ($row1=@mysql_fetch_array($result1)){
  $depan="";
  $belakang="";
  $tr="";
  if ($row1[baru]==1){
  	 	$depan="<strong>";
  		$belakang="</strong>";
		$tr="style=\"background-color:#fcf7c1;\"";
  } else {
	  $tr="style=\"background-color:#FFFFFF;\"";
  }
  ?>
  <tr <?=$tr?> >
    <td height="25" scope="row"><div align="center">
      <?=$cnt;?>
    </div></th>
    <td height="25" align="center">
	<input type="checkbox" onClick="chg('<?=$count?>')" name="cekpesan<?=$count?>" id="cekpesan<?=$count?>"/>
	<input type="hidden" name="delete<?=$count?>" id="delete<?=$count?>"/>
	<input type="hidden" name="rep<?=$count?>" id="rep<?=$count?>" value="<?=$row1[replid]?>"/>	</td>
    <td height="25"><?=$depan?><?=$row1['nis']?>-<?=$row1['nama']?><?=$belakang?></td>
    <? 
	$sql2="SELECT direktori,namafile FROM jbsvcr.lampiranpesan WHERE idpesan='$row1[replid2]'";
	$result2=QueryDb($sql2); 
	?>
    <td width="22" height="25"><?=$depan?><? if (@mysql_num_rows($result2)>0){ ?><img title="With Attachment" src="../../images/ico/attachment.png"/><? } ?><?=$belakang?></td>
    <td height="25"><?=$depan?><? if ($row1['baru']==1) { ?><img src="../../images/ico/unread.png" /><? } else { ?><img src="../../images/ico/readen.png" /><? } ?><a href="#" onClick="bacapesan('<?=$row1['replid']?>')">
	<? 
	$judul=substr($row1['judul'],0,20);
	if (strlen($row1['judul'])>20){
	echo $judul." ...";
	} else {
	echo $judul;
	}
	?></a><?=$belakang?></td>
    <!--<td><?=$depan?>
    <?
	//while ($row2=@mysql_fetch_array($result2)){
		//echo "<a title='Open this attachment' href=\"#\" onclick=newWindow('".$row2[direktori].$row2[namafile]."','View',640,480,'resizable=1'); ><img border='0' src='../../images/ico/titik.png' width='5' heiht='5'/> ".$row2['namafile']."</a><br>";
	//}
	?><?=$belakang?></td>-->
    <td height="25"><?=$depan?><div align="center"><?=$row1['tanggal']?><br><?=$row1['waktu']?></div><?=$belakang?></td>
  </tr>
  <? 
  $cnt++;
	$count++;
  } 
  } else {?>
   <tr>
    <td scope="row" colspan="8"><div align="center">No student message in your Inbox.</div></th>   </tr>
  <? } ?>
</table>
	</td>
  </tr>
</table>
<input type="hidden" name="numpesan" id="numpesan" value="<?=$numpesan?>">
<input type="hidden" name="listdel" id="listdel">
<input type="hidden" name="numdel" id="numdel">
<? if ($numpesan>0){ ?>
<input type="button" class="but" name="del_pesan" id="del_pesan" value="Delete" onClick="delpesan()">
<input type="button" class="but" name="movepesan" id="movepesan" value="Move to Draft" onClick="savepesan()">
<? } ?>
</form>
</body>
</html>