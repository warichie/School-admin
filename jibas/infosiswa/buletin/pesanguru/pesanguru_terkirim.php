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
$varbaris=10;
$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];

if ($op=="bzux834hx8x7x934983xihxf084"){
	OpenDb();
	//cek di tujuan yang belum dihapus sama penerima (aktif=1)
	$sql_cek_tujuan="SELECT * FROM jbsvcr.tujuanpesan WHERE idpesan=(SELECT idpesan FROM jbsvcr.pesanterkirim WHERE replid='".$_REQUEST[replid]."') AND aktif=1";
	//echo "sql_cek_tujuan = ".$sql_cek_tujuan."<br>";
	$res_cek_tujuan=QueryDb($sql_cek_tujuan);
	$tujuanexist=@mysql_num_rows($res_cek_tujuan);
	if ($tujuanexist==0){ //Kalo gak ada, lsg hapus aja semuanya...
		//Ambil dulu idpesan
		$sql_get_idpesan="SELECT idpesan FROM jbsvcr.pesanterkirim WHERE replid='$_REQUEST[replid]'";
		//echo "sql_get_idpesan = ".$sql_get_idpesan."<br>";
		$res_get_idpesan=QueryDb($sql_get_idpesan);
		$row_get_idpesan=@mysql_fetch_array($res_get_idpesan);
		$idpesan=$row_get_idpesan[idpesan];
		//Hapus di tujuanpesan
		$sql_del_tujuan="DELETE FROM jbsvcr.tujuanpesan WHERE idpesan='$idpesan'";
		//echo "sql_del_tujuan = ".$sql_del_tujuan."<br>";
		QueryDb($sql_del_tujuan);
		//Ambil direktori+namafile buat dihapus filenya..
		$sql_getfname="SELECT direktori, namafile FROM jbsvcr.lampiranpesan WHERE idpesan='$idpesan'";
		$result_getfname=QueryDb($sql_getfname);
		$file="file";
		$cntdel=0;
		while ($row_fname=@mysql_fetch_array($result_getfname)){
			$mydirs[$cntdel]=$UPLOAD_DIR."pesan\\".$row_fname['direktori'].$row_fname['namafile'];
			$mydir[$cntdel]=str_replace("/","\\",$mydirs[$cntdel]);
			$cntdel++;	
		}
		//echo $mydir[0]."<br>";
		//echo $mydir[1]."<br>";
		//echo $mydir[2]."<br>";
		//exit;
		delete($mydir[0]);
		delete($mydir[1]);
		delete($mydir[2]);
		//Kalo filenya uda dihapus, hapus alamatnya di tabel lampiran pesan
		$sql_del_attch="DELETE FROM jbsvcr.lampiranpesan WHERE idpesan='$idpesan'";
		QueryDb($sql_del_attch);
		//Hapus from tabel pesanterkirim
		$sql_del_terkirim="DELETE FROM jbsvcr.pesanterkirim WHERE replid='$_REQUEST[replid]'";
		QueryDb($sql_del_terkirim);
		//Finally, hapus from tabel pesan
		$sql_del_terkirim="DELETE FROM jbsvcr.pesan WHERE replid='$idpesan'";
		QueryDb($sql_del_terkirim);

	} else { //Kalo ada pesan yang belum dibaca
		$sql_del_terkirim="DELETE FROM jbsvcr.pesanterkirim WHERE replid='$_REQUEST[replid]'";
		QueryDb($sql_del_terkirim);
	}
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
		document.location.href="pesangurubaca.php?replid=<?=$_REQUEST[replid]?>";
	</script>
	<?
	
}
$bulan="";
if (isset($_REQUEST['bulan']))
	$bulan=$_REQUEST['bulan'];
$tahun="";
if (isset($_REQUEST['tahun']))
	$tahun=$_REQUEST['tahun'];
$idguru=SI_USER_ID();
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
	var bulan=parent.pesanguru_header.document.getElementById("bulan").value;
	var tahun=parent.pesanguru_header.document.getElementById("tahun").value;
	document.location.href="pesanguru_footer.php?bulan="+bulan+"&tahun="+tahun;
}
function chg_page(){
	var page=document.getElementById("page").value;
	document.location.href="pesanguru_terkirim.php?page="+page;
}
function change_page(page) {
	
	//var tahun=parent.beritaguru_header.document.getElementById("tahun").value;
	//alert ('Resend');
	document.location.href="pesanguru_terkirim.php?page="+page;
}
function ubah(replid){
	document.location.href="pesanguru_ubah_main.php?replid="+replid;
}
function bacapesan(replid){
	var page=document.getElementById("page").value;
	document.location.href="pesangurubaca_terkirim.php?op=baca&replid="+replid+"&page="+page;
}
function hapus(replid){
	var page=document.getElementById("page").value;
	if (confirm('Are you sure want to delete this message and the attachments?')){ 
		document.location.href="pesanguru_terkirim.php?op=bzux834hx8x7x934983xihxf084&replid="+replid+"&page="+page;
	}
}
function cek_all() {
	//alert ('Masuk');
	var x;
	var jum = document.inbox.numpesan.value;
	var ceked = document.inbox.cek.checked;
	//alert (''+ceked);
	for (x=1;x<=jum;x++){
		if (ceked==true){
			document.getElementById("cekpesan"+x).checked=true;
		} else {
			document.getElementById("cekpesan"+x).checked=false;
		}
	}
}
function delpesan(){
	//alert ('Masuk Hapus');
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
	if (listdel.length==0){
		alert ('You should have at least one message to deleted');
		return false;
	} else {
		if (confirm('Are you sure want to delete this message?')){
			document.location.href="pesanguru_terkirim.php?op=34983xihxf084bzux834hx8x7x93&listdel="+list+"&numdel="+num;
		}
	}
}
</script>
</head>
<body >
<input type="hidden" name="bulan" id="bulan" value="<?=$bulan?>" />
<input type="hidden" name="tahun" id="tahun" value="<?=$tahun?>" />
<div align="right">
<font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Sent Message</font><br />
    <a href="pesanguru.php" target="framecenter">
      <font size="1" color="#000000"><b>Teacher Message</b></font></a>&nbsp;>&nbsp;
        <font size="1" color="#000000"><b>Sent</b></font>
</div><br />
<table width="100%" border="0" cellspacing="0">
  <tr>
  <? OpenDb();
  /*$sql_tot="SELECT pg.replid as replid, pg.judul as judul, DATE_FORMAT(pg.tanggalpesan, '%e %b %Y') as tanggal, TIME_FORMAT(pg.tanggalpesan, '%H:%i') as waktu, ".
  		"pg.pesan as pesan, p.nama as nama, p.nip as nip FROM jbsvcr.pesanguru pg, jbssdm.pegawai p, jbsvcr.tujuanpesanguru t ".
		"WHERE pg.replid=t.idpesan AND p.nip=pg.idguru ORDER BY pg.tanggalpesan DESC ";
  */
  $sql_tot="SELECT * FROM jbsvcr.pesanterkirim pt, jbsvcr.pesan p WHERE p.nis='".SI_USER_ID()."' AND p.keguru=1 AND pt.idpesan=p.replid";
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
    <table width="100%" border="1" cellspacing="0" class="tab" id="table">
  <tr>
    <th width="22" height="30" class="header" scope="row"><div align="center">#</div></th>
    <td width="69" height="30" class="header"><div align="center">Date</div></td>
    <td width="184" height="30" class="header"><div align="center">Recipient</div></td>
    <td width="428" height="30" class="header"><div align="center">Title</div></td>
    <td width="150" height="30" class="header"><div align="center">Attachment</div></td>
    <td width="70" height="30" class="header">&nbsp;</td>
  </tr>
  <?
  OpenDb();
  
  $sql1="SELECT pt.replid as replid_tkrm, pg.replid as replid, pg.judul as judul, DATE_FORMAT(pg.tanggalpesan, '%e %b %Y') as tanggal, TIME_FORMAT(pg.tanggalpesan, '%H:%i') as waktu FROM jbsvcr.pesan pg, jbsvcr.pesanterkirim pt WHERE pg.nis='".SI_USER_ID()."' AND keguru=1 AND pt.idpesan=pg.replid ORDER BY pg.tanggalpesan DESC, pg.replid DESC LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
  /*$sql1="SELECT pg.replid as replid, pg.judul as judul, DATE_FORMAT(pg.tanggalpesan, '%e %b %Y') as tanggal, TIME_FORMAT(pg.tanggalpesan, '%H:%i') as waktu, t.baru as baru, t.replid as replid2, ".
  		"pg.pesan as pesan, p.nama as nama, p.nip as nip FROM jbsvcr.pesanguru pg, jbssdm.pegawai p, jbsvcr.tujuanpesanguru t ".
		"WHERE pg.replid=t.idpesan AND p.nip=pg.idguru ORDER BY replid LIMIT ".(int)$page*(int)$varbaris.",$varbaris";*/
  $result1=QueryDb($sql1);
  $numpesan=@mysql_num_rows($result1);
  if (@mysql_num_rows($result1)>0){
  if ($page==0){
  $cnt=1;
  } else {
  $cnt=(int)$page*(int)$varbaris+1;
  }
  while ($row1=@mysql_fetch_array($result1)){
  $trstyle="style='background-color:#FFFFFF'";
  if ($cnt%2==0)
	  $trstyle="style='background-color:#FFFFCC'";
  ?>
  <tr <?=$trstyle?>>
    <td scope="row"><div align="center"><?=$cnt;?></div></th>
    <td><div align="center"><?=$row1['tanggal']?></div></td>
    <td>
	<?
	  $sql3="SELECT t.baru as baru, t.idpenerima as nip, p.nama as nama FROM jbsvcr.tujuanpesan t, jbssdm.pegawai p WHERE idpesan='$row1[replid]' AND t.idpenerima=p.nip ORDER BY p.nama";
	  $result3=QueryDb($sql3);
	  while ($row3=@mysql_fetch_array($result3)){
	  $img="<img src='../../images/ico/ok.png' />";
	  if ($row3[baru]==1)
		  $img="<img src='../../images/ico/ok.png' title='Not Read'/>";
	  if ($row3[baru]==0)
		  $img="<img src='../../images/ico/not_ok.png' title='Read' />";
	  echo $img.$row3[nip]."-".$row3[nama]."<br>";
	  }
	 
	?>
	</td>
    <td><? if ($row1['baru']==1) { ?><img src="../../images/ico/unread.gif" /><? } ?><a href="#" onClick="bacapesan('<?=$row1['replid']?>')">
	<? 
	$judul=substr($row1['judul'],0,20);
	if (strlen($row1['judul'])>20){
	echo $judul." ...";
	} else {
	echo $judul;
	}
	?></a>
    </td>
    <td>
    <?
	$sql2="SELECT direktori,namafile FROM jbsvcr.lampiranpesan WHERE idpesan='$row1[replid]'";
	$result2=QueryDb($sql2);
	while ($row2=@mysql_fetch_array($result2)){
		echo "<a title='Open this attachment' href=\"#\" onclick=newWindow('".$WEB_UPLOAD_DIR."pesan/".$row2[direktori].$row2[namafile]."','View',640,480,'resizable=1'); ><img border='0' src='../../images/ico/titik.png' width='5' heiht='5'/> ".$row2['namafile']."</a><br>";
	}
	?>
    </td>
    <td><div align="center">
    <!--<img src="../../images/ico/ubah.png" border="0" onClick="ubah('<?=$row1[replid]?>')" style="cursor:pointer;" title="Edit this News" />&nbsp;--><img src="../../images/ico/hapus.png" border="0" onClick="hapus('<?=$row1[replid_tkrm]?>')" style="cursor:pointer;" title="Delete this Message" />
   </div></td>
  </tr>
  <? 
  $cnt++;
  } 
  } else {?>
   <tr>
    <td scope="row" colspan="6"><div align="center">No message.</div></th>
   </tr>
  <? } ?>
</table>
<input type="hidden" name="numpesan" id="numpesan" value="<?=$numpesan?>">

		<script language='JavaScript'>
			//Tables('table', 1, 0);
		</script>

	</td>
  </tr>
</table>

</body>
</html>