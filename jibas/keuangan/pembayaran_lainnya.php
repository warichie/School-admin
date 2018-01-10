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
require_once('include/errorhandler.php');
require_once('include/sessionchecker.php');
require_once('include/common.php');
require_once('include/config.php');
require_once('include/rupiah.php');
require_once('include/db_functions.php');
require_once('include/sessioninfo.php');
require_once('library/jurnal.php');

$idkategori = $_REQUEST['idkategori'];
$idpenerimaan = (int)$_REQUEST['idpenerimaan'];
$idtahunbuku = (int)$_REQUEST['idtahunbuku'];
$tanggal = date('d-m-Y');
if (isset($_REQUEST['tcicilan']))
	$tanggal = $_REQUEST['tcicilan'];

$errmsg = $_REQUEST['errmsg'];

OpenDb();

if (1 == (int)$_REQUEST['issubmit']) 
{
	$jbayar = $_REQUEST['jbayar'];
	$jbayar = UnformatRupiah($jbayar);
	$tbayar = $_REQUEST['tcicilan'];
	$tbayar = MySqlDateFormat($tbayar);
	$kbayar = CQ($_REQUEST['kbayar']);
	$sumber = CQ($_REQUEST['sumber']);
	
	$petugas = getUserName();
	
	//Ambil nama penerimaan
	$namapenerimaan = "";
	$rekkas = "";
	$rekpendapatan = "";
	$rekpiutang = "";
	$sql = "SELECT nama, rekkas, rekpendapatan, rekpiutang FROM datapenerimaan WHERE replid='$idpenerimaan'";
	$result = QueryDb($sql);
	if (mysql_num_rows($result) == 0) 
	{
		CloseDb();
		trigger_error("No Data Found.", E_USER_ERROR);
	} 
	else 
	{
		$row = mysql_fetch_row($result);
		$namapenerimaan = $row[0];
		$rekkas = $row[1];
		$rekpendapatan = $row[2];
		$rekpiutang = $row[3];
	}
	
	//Ambil awalan and cacah tahunbuku untuk bikin nokas;
	$sql = "SELECT awalan, cacah FROM tahunbuku WHERE replid = '$idtahunbuku'";
	$result = QueryDb($sql);
	if (mysql_num_rows($result) == 0) 
	{
		CloseDb();
		trigger_error("No Data Found.", E_USER_ERROR);
	} 
	else 
	{
		$row = mysql_fetch_row($result);
		$awalan = $row[0];
		$cacah = $row[1];
	}
	$cacah += 1;
	$nokas = $awalan . rpad($cacah, "0", 6);
	
	//Begin Database Transaction
	BeginTrans();

	//Simpan ke jurnal
	$ketjurnal = "Dana $namapenerimaan tanggal $_REQUEST[tcicilan] from $sumber";
	$idjurnal = 0;
	$success = SimpanJurnal($idtahunbuku, $tbayar, $ketjurnal, $nokas, "", $petugas, "penerimaanlain", $idjurnal);
	
	//Simpan ke jurnaldetail
	if ($success) $success = SimpanDetailJurnal($idjurnal, "D", $rekkas, $jbayar);
	if ($success) $success = SimpanDetailJurnal($idjurnal, "K", $rekpendapatan, $jbayar);
	
	//increment cacah di tahunbuku
	$sql = "UPDATE tahunbuku SET cacah=cacah+1 WHERE replid='$idtahunbuku'";
	QueryDbTrans($sql, $success);
	
	$sql = "INSERT INTO penerimaanlain SET idpenerimaan='$idpenerimaan', idjurnal='$idjurnal', sumber='$sumber', jumlah='$jbayar', tanggal='$tbayar', keterangan='$kbayar', petugas='$petugas'";
	QueryDbTrans($sql, $success);
	
	if ($success) 
		CommitTrans();
	else 
		RollbackTrans();

	CloseDb();
	
	$r = rand(10000, 99999);
	header("Location: pembayaran_lainnya.php?r=$r&idkategori=$idkategori&idpenerimaan=$idpenerimaan&idtahunbuku=$idtahunbuku");
	
	exit();
}

//Muncul pertama kali
$sql = "SELECT nama FROM datapenerimaan WHERE replid = '$idpenerimaan'";
$result = QueryDb($sql);
$row = mysql_fetch_row($result);
$namapenerimaan = $row[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" type="text/css" href="style/tooltips.css">
<link rel="stylesheet" type="text/css" href="style/calendar-green.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Lainnya</title>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/lang/calendar-en.js"></script>
<script type="text/javascript" src="script/calendar-setup.js"></script>
<script language="javascript" src="script/rupiah.js"></script>
<script language="javascript" src="script/validasi.js"></script>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tooltips.js"></script>
<script language="javascript" src="script/tools.js"></script>
<script src="script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="script/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="script/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<script language="javascript">

var win = null;
function newWindow(mypage,myname,w,h,features) {
      var winl = (screen.width-w)/2;
      var wint = (screen.height-h)/2;
      if (winl < 0) winl = 0;
      if (wint < 0) wint = 0;
      var settings = 'height=' + h + ',';
      settings += 'width=' + w + ',';
      settings += 'top=' + wint + ',';
      settings += 'left=' + winl + ',';
      settings += features;
      win = window.open(mypage,myname,settings);
      win.window.focus();
}

function salinangka(){	
	var angka = document.getElementById("jbayar").value;
	document.getElementById("angkabesar").value=angka;
}

function ValidateSubmit() 
{
	var isok = validateEmptyText('sumber','Source Penerimaan') &&
		   	   validateEmptyText('jbayar','Jumlah Penerimaan') &&
		   	   validasiAngka() &&
		   	   validateMaxText('kbayar', 255, 'Info Penerimaan') &&
		   	   confirm('The data is correct?');	
			   
	document.getElementById('issubmit').value = isok ? 1 : 0;
	
	if (isok)
		document.main.submit();
	else
		document.getElementById('Simpan').disabled = false;
}

function validasiAngka() {
	var angka = document.getElementById("angkabesar").value;
	if(isNaN(angka)) {
		alert ('Jumlah Penerimaan must be numeric');
		document.getElementById('jbayar').value = "";
		document.getElementById('jbayar').focus();
		return false;
	}
	else if (angka <= 0)
	{
		alert ('Jumlah Penerimaan harus positif');
		document.getElementById('jbayar').focus();
		return false;
	}
	return true;
}

function cetakkuitansi(id) {
	newWindow('kuitansilain.php?id='+id,'CetakKuitansiLain','360','650','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function editpembayaran(id) {
	newWindow('pembayaranlain_edit.php?idpembayaran='+id,'EditPembayaran','425','390','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function refresh() {
	var idkategori = document.getElementById('idkategori').value;
	var idpenerimaan = document.getElementById('idpenerimaan').value;
	var idtahunbuku = document.getElementById('idtahunbuku').value;
	
	var addr = "pembayaran_lainnya.php?idkategori="+idkategori+"&idpenerimaan="+idpenerimaan+"&idtahunbuku="+idtahunbuku;
	document.location.href = addr;
}

function focusNext(elemName, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		document.getElementById(elemName).focus();
        return false;
    }
    return true;
}

function panggil(elem){
	
	var lain = new Array('sumber','jbayar','kbayar');
	for (i=0;i<lain.length;i++) {
		if (lain[i] == elem) {
			document.getElementById(elem).style.background='#FFFF99';
		} else {
			document.getElementById(lain[i]).style.background='#FFFFFF';
		}
	}
}
</script>

</head>

<body topmargin="0" leftmargin="0" onload="document.getElementById('sumber').focus();">
<form name="main" id="main" method="post">
<input type="hidden" name="issubmit" id="issubmit" value="0" />
<input type="hidden" name="idkategori" id="idkategori" value="<?=$idkategori ?>" />
<input type="hidden" name="idpenerimaan" id="idpenerimaan" value="<?=$idpenerimaan ?>" />
<input type="hidden" name="idtahunbuku" id="idtahunbuku" value="<?=$idtahunbuku ?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td valign="top" background="" style="background-repeat:no-repeat; background-attachment:fixed">
    <table width="100%" border="0" height="100%" cellspacing="2" cellpadding="2">
   	<tr>
    	<td colspan="2">
        <font size="5" color="#990000"><strong><?=$namapenerimaan ?></strong></font><p></td>
   	</tr>
    <tr>
    	<td valign="top" width="35%">
            <fieldset style="background:url(images/bttablelong.png)">
            <legend></legend>
            <table border="0"  cellpadding="2" cellspacing="2" width="100%" align="center">
            <tr height="25">
                <td colspan="3" class="header" align="center">Penerimaan <?=$namapenerimaan?></td>
            </tr>
            <tr>
                <td width="30%"><strong>Admission</strong></td>
                <td colspan="2"><input type="text" readonly="readonly" size="30" value="<?=$namapenerimaan?>" style="background-color:#CCCC99" /></td>
            </tr>
            <tr>
                <td width="25%"><strong>Source</strong></td>
                <td colspan="2"><input type="text" name="sumber" id="sumber" size="30" maxlength="30" onKeyPress="return focusNext('jbayar', event)" onfocus="panggil('sumber')"/></td>
            </tr>
            <tr>
                <td width="25%"><strong>Sum</strong></td>
                <td colspan="2"><input type="text" name="jbayar" id="jbayar" onblur="formatRupiah('jbayar')" onfocus="unformatRupiah('jbayar');panggil('jbayar')" onKeyPress="return focusNext('tcicilan', event)" onkeyup="salinangka()"/>
                	<input type="hidden" name="angkabesar" id="angkabesar" value="<?=$jbayar ?>" />
            </tr>
            <tr>
                <td><strong>Date</strong></td>
                <td>
                <input type="text" name="tcicilan" id="tcicilan" readonly value="<?=$tanggal ?>" onKeyPress="return focusNext('kbayar', event)" style="background-color:#CCCC99"> </td>
                <td width="60%">
                &nbsp;
                </td>        
            </tr>
            <tr>
                <td width="25%" align="left" valign="top">Info</td>
                <td colspan="2"><textarea id="kbayar" name="kbayar" rows="3" cols="27" onKeyPress="return focusNext('Simpan', event)" style="width:225px; height:50px" onfocus="panggil('kbayar')"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                <input type="button" name="Simpan" id="Simpan" class="but" value="Save" onclick="this.disabled = true; ValidateSubmit(); " />
                <br /><br />
                </td>
            </tr>
            </table>
        	</fieldset>
 		</td>
     	<td valign="top">
<?      $sql = "SELECT p.replid AS id, j.nokas, p.sumber,  date_format(p.tanggal, '%d-%b-%Y') as tanggal, 
					   p.keterangan, p.jumlah, p.petugas 
				  FROM penerimaanlain p, jurnal j 
				 WHERE j.replid = p.idjurnal AND p.idpenerimaan = '$idpenerimaan' ORDER BY p.tanggal, p.replid";
        $result = QueryDb($sql);
        if (mysql_num_rows($result) > 0) 
		{ ?>            
            <table class="tab" id="table" width="100%" cellpadding="5" cellspacing="0">
            <tr height="30" align="center">
                <td class="header" width="5%">#</td>
                <td class="header" width="20%">Journal/Date</td>
                <td class="header" width="15%">Source</td>
                <td class="header" width="18%">Sum</td>
                <td class="header" width="*">Info</td>
                <td class="header" width="8%">Officer</td>
                <td class="header">&nbsp;</td>
            </tr>
<?          $cnt = 0;
            $total = 0;
            while ($row = mysql_fetch_array($result)) 
			{
                $total += $row['jumlah']; ?>
            <tr>
                <td align="center"><?=++$cnt?></td>
                <td align="center"><?="<strong>" . $row['nokas'] . "</strong><br><i>" . $row['tanggal']?></i></td>
                <td align="left"><?=$row['sumber'] ?></td>
                <td align="right"><?=FormatRupiah($row['jumlah'])?></td>
                <td><?=$row['keterangan'] ?></td>
                <td><?=$row['petugas'] ?></td>
                <td align="center">
                <a href="javascript:cetakkuitansi(<?=$row['id'] ?>)" ><img src="images/ico/print.png" border="0" onMouseOver="showhint('Print Kuitansi Payment', this, event, '100px')" /></a>&nbsp;
            <?  if (getLevel() != 2) { ?>       
                <a href="javascript:editpembayaran(<?=$row['id'] ?>)"><img src="images/ico/ubah.png" border="0" onMouseOver="showhint('Edit Payment Cicilan', this, event, '120px')"/></a>
            <?	} ?>  
                </td>
            </tr>
            <?
            }
            ?>
            <tr height="35">
                <td bgcolor="#996600" colspan="2" align="center"><font color="#FFFFFF"><strong>Total</strong></font></td>
                <td bgcolor="#996600" align="right" colspan="2"><font color="#FFFFFF"><strong><?=FormatRupiah($total) ?></strong></font></td>
                <td bgcolor="#996600" colspan="3">&nbsp;</td>
            </tr>
            </table>
            <script language='JavaScript'>
            Tables('table', 1, 0);
            </script>
     	<? } ?>
		</td>
	</tr>
	</table>
<!-- EOF CONTENT -->
</td></tr>
</table>
</form>
</body>

</html>
