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
$nis = (string)$_REQUEST['nis'];
$idtahunbuku = (int)$_REQUEST['idtahunbuku'];
$errmsg = $_REQUEST['errmsg'];

OpenDb();

if (1 == (int)$_REQUEST['issubmit']) 
{	
	$jbayar = UnformatRupiah($_REQUEST['besar']);
		
	$tbayar = $_REQUEST['tbayar'];
	$tbayar = MySqlDateFormat($tbayar);
	$kbayar = CQ($_REQUEST['keterangan']);
	$kbayar = urlencode($kbayar);
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
	
	//Ambil nama siswa
	$namasiswa = "";
	$sql = "SELECT nama FROM jbsakad.siswa WHERE nis='$nis'";
	$result = QueryDb($sql);
	if (mysql_num_rows($result) == 0) 
	{
		//CloseDb();
		trigger_error("No Data Found.", E_USER_ERROR);
	} 
	else 
	{
		$row = mysql_fetch_row($result);
		$namasiswa = $row[0];
	}
	
	//Ambil awalan and cacah tahunbuku untuk bikin nokas;
	$sql = "SELECT awalan, cacah FROM tahunbuku WHERE replid = '$idtahunbuku'";
	$result = QueryDb($sql);
	if (mysql_num_rows($result) == 0) 
	{
		//CloseDb();
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
	$ketjurnal = "Payment $namapenerimaan tanggal $_REQUEST[tbayar] siswa $namasiswa ($nis)";
	$idjurnal = 0;
	$success = SimpanJurnal($idtahunbuku, $tbayar, $ketjurnal, $nokas, "", $petugas, "penerimaaniuran", $idjurnal);
	
	//Simpan ke jurnaldetail
	if ($success) $success = SimpanDetailJurnal($idjurnal, "D", $rekkas, $jbayar);
	if ($success) $success = SimpanDetailJurnal($idjurnal, "K", $rekpendapatan, $jbayar);
	
	//increment cacah di tahunbuku
	$sql = "UPDATE tahunbuku SET cacah=cacah+1 WHERE replid=$idtahunbuku";
	QueryDbTrans($sql, $success);
	
	$sql = "INSERT INTO penerimaaniuran SET idpenerimaan='$idpenerimaan', nis='$nis', idjurnal='$idjurnal', jumlah='$jbayar', tanggal='$tbayar', keterangan='$kbayar', petugas='$petugas'";
	QueryDbTrans($sql, $success);
	
	if ($success) 
		CommitTrans();
	else 		
		RollbackTrans();
	CloseDb();
?>	<script language="javascript">
		document.location.href="pembayaran_iuran.php?r=<?=rand(10000, 99999)?>&idkategori=<?=$idkategori?>&idpenerimaan=<?=$idpenerimaan?>&nis=<?=$nis?>&idtahunbuku=<?=$idtahunbuku?>";
	</script>
<?	
}

//Muncul pertama kali
$sql = "SELECT s.replid, nama, telponsiswa as telpon, hpsiswa as hp, kelas, alamatsiswa as alamattinggal, tingkat 
		FROM jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t 
		WHERE s.idkelas = k.replid AND k.idtingkat = t.replid AND nis = '$nis'";
	
$result = QueryDb($sql);
if (mysql_num_rows($result) == 0) 
{
	CloseDb();
	exit();
} 
else 
{
	$row = mysql_fetch_array($result);
	$replid = $row['replid'];
	$nama = $row['nama'];
	$telpon = $row['telpon'];
	$hp = $row['hp'];
	$namakelas = $row['kelas'];
	$namatingkat = $row['tingkat'];
	$alamattinggal = $row['alamattinggal'];
}
	
$sql = "SELECT nama FROM datapenerimaan WHERE replid = '$idpenerimaan'";
$result = QueryDb($sql);
$row = mysql_fetch_row($result);
$namapenerimaan = $row[0];

$tanggal = date('d-m-Y');
if (isset($_REQUEST['tbayar']))
	$tanggal = $_REQUEST['tbayar'];
	
$keterangan = "";
if (isset($_REQUEST['keterangan']))
	$keterangan = CQ($_REQUEST['keterangan']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" type="text/css" href="style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/calendar-green.css">
<title>Payment Contribution</title>
<!--<link rel="stylesheet" type="text/css" href="style/calendar-win2k-1.css">-->
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/lang/calendar-en.js"></script>
<script type="text/javascript" src="script/calendar-setup.js"></script>
<script language="javascript" src="script/rupiah.js" type="application/javascript"></script>
<script language="javascript" src="script/validasi.js"></script>
<script language="javascript" src="script/tables.js" ></script>
<script language="javascript" src="script/tooltips.js"></script>
<script language="javascript" src="script/tools.js"></script>
<script src="script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="script/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="script/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function ValidateSubmit() 
{
	var isok = 	validateEmptyText('besar','Jumlah Payment') &&
		   		validasiAngka() &&
		   		validateEmptyText('tbayar','Date Payment') && 
		   		validateMaxText('keterangan', 255, 'Info Payment');	
				
	document.getElementById('issubmit').value = isok ? 1 : 0;
	
	if (isok)
		document.main.submit();
	else
		document.getElementById('simpan').disabled = false;
}

function salinangka()
{	
	var angka = document.getElementById("besar").value;
	document.getElementById("angkabesar").value = angka;
}

function validasiAngka() {
	var angka = document.getElementById("angkabesar").value;
	if(isNaN(angka)) 
	{
		alert ('Jumlah pembayaran must be numeric');
		document.getElementById('besar').value = "";
		document.getElementById('besar').focus();
		return false;
	}
	else if (angka <= 0)
	{
		alert ('Jumlah pembayaran harus positif');
		document.getElementById('besar').focus();
		return false;
	}
	return true;
}

function cetakkuitansi(id) {
	newWindow('kuitansiiuran.php?id='+id, 'CetakKuitansi','360','650','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function editpembayaran(id) {
	newWindow('pembayaraniuran_edit.php?idpembayaran='+id, 'EditPembayaran','425','392','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function refresh() {
	var idkategori = document.getElementById('idkategori').value;
	var idpenerimaan = document.getElementById('idpenerimaan').value;
	var nis = document.getElementById('nis').value;
	var idtahunbuku = document.getElementById('idtahunbuku').value;
	
	var addr = "pembayaran_iuran.php?idkategori="+idkategori+"&idpenerimaan="+idpenerimaan+"&nis="+nis+"&idtahunbuku="+idtahunbuku;
	document.location.href = addr;
}

function cetak() {
	var addr = "pembayaraniuran_cetak.php?idkategori=<?=$idkategori ?>&idpenerimaan=<?=$idpenerimaan ?>&nis=<?=$nis ?>&idtahunbuku=<?=$idtahunbuku ?>"
	newWindow(addr, 'CetakPembayaranIuran','790','630','resizable=1,scrollbars=1,status=0,toolbar=0');
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
</script>

</head>

<body topmargin="0" leftmargin="0" onLoad="document.getElementById('besar').focus()">
<form name="main" id="main" method="post">
<input type="hidden" name="issubmit" id="issubmit" value="0" />
<input type="hidden" name="idkategori" id="idkategori" value="<?=$idkategori ?>" />
<input type="hidden" name="idpenerimaan" id="idpenerimaan" value="<?=$idpenerimaan ?>" />
<input type="hidden" name="nis" id="nis" value="<?=$nis ?>" />
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
    	<td width="265" valign="top">        	
			<fieldset style="background:url(images/bttable400.png);height:240px">
            <legend></legend>
            <table border="0" cellpadding="2" cellspacing="2" align="center">
                    
            <tr height="25">
                <td colspan="3" class="header" align="center">Contribution <?=$namapenerimaan?></td>
            </tr>
            <tr>
                <td width="25%"><strong>Payment</strong></td>
                <td colspan="2"><input type="text" size="20" value="<?=$namapenerimaan?>" style="background-color:#CCCC99" readonly="readonly"/></td>
            </tr>
            <tr>
                <td><strong>Sum</strong></td>
                <td colspan="2"><input type="text" name="besar" id="besar" size="20" value="<?=FormatRupiah($besar) ?>" onBlur="formatRupiah('besar')" onFocus="unformatRupiah('besar')" onKeyPress="return focusNext('keterangan', event)" <?=$dis?> onKeyUp="salinangka()"/>
                	<input type="hidden" name="angkabesar" id="angkabesar" value="<?=$besar ?>" />
                </td>
            </tr>
            <tr>
                <td><strong>Date</strong></td>
                <td>
                <input type="text" name="tbayar" id="tbayar" readonly size="15" value="<?=$tanggal ?>" onKeyPress="return focusNext('keterangan', event)" style="background-color:#CCCC99"> </td>
                <td width="60%">
                &nbsp;
                </td>        
            </tr>
            <tr>
                <td valign="top">Info</td>
            </tr>
            <tr>
                <td colspan="3"><textarea id="keterangan" name="keterangan" rows="3" cols="35" onKeyPress="return focusNext('simpan', event)" <?=$dis?> style="width:225px; height:50px"><?=$keterangan ?></textarea>
                </td>
            </tr> 
            <tr>
                <td colspan="3" align="center" height="30">
                <input type="button" name="simpan" id="simpan" class="but" value="Save" onClick="this.disabled = true; ValidateSubmit();" style="width:100px"/>
                </td>
            </tr>
            </table>
            </fieldset>            
        </td>
        <td valign="top">
			
            <fieldset style="background:url(images/bttable400.png);height:240px">
            <legend></legend>
            <table border="0" width="100%" cellpadding="2" cellspacing="2">
            <tr height="25">
                <td colspan="4" class="header" align="center">Student Data</td>
            </tr>
            <tr valign="top">                    
                <td width="5%"><strong>Student ID</strong></td>
                <td><strong>:</strong></td>
               	<td><strong><?=$nis ?></strong> </td>
                <td rowspan="5" width="25%">
                <img src='<?="library/gambar.php?replid=".$replid."&table=jbsakad.siswa";?>' width='100' height='100'></td>
            </tr>
            <tr>
                <td valign="top"><strong>Name</strong></td>
                <td valign="top"><strong>:</strong></td> 
				<td><strong><?=$nama ?></strong></td>
            </tr>
            <tr>
                <td><strong>Class</strong></td>
                 <td><strong>:</strong></td>
                <td><strong><?=$namatingkat.' - '.$namakelas ?></strong></td>
            </tr>
            <tr>
                <td><strong>Mobile</strong></td>
                 <td><strong>:</strong></td>
                <td><strong><?=$hp ?></strong></td>
            </tr>
            <tr>
                <td><strong>Phone</strong></td>
                 <td><strong>:</strong></td>
                <td><strong><?=$telpon ?></strong></td>
            </tr>
            
            <tr height="95">
                <td valign="top"><strong>Address</strong></td>
                <td valign="top"><strong>:</strong></td>
                <td colspan="2" valign="top" height="76"><strong>
                  <?=$alamattinggal ?>
                </strong></td>
            </tr>
            <!--<tr>
                <td>&nbsp;</td>
            </tr>           -->
            
            </table>            
            </fieldset>
            
		</td>
  	</tr>
<?  
	$sql = "SELECT p.replid AS id, j.nokas, date_format(p.tanggal, '%d-%b-%Y') as tanggal, p.keterangan, p.jumlah, p.petugas 
	          FROM penerimaaniuran p, jurnal j 
				WHERE j.replid = p.idjurnal AND j.idtahunbuku = '$idtahunbuku' AND p.idpenerimaan = '$idpenerimaan' AND p.nis = '$nis'
			ORDER BY p.tanggal, p.replid";
	
	$result = QueryDb($sql);    
	if (mysql_num_rows($result) > 0) {
?>
    <tr>
        <td align="center" colspan="2">
            <fieldset>
            <legend></legend>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
        	<tr>
                <td align="right">
                <a href="#" onClick="document.location.reload()"><img src="images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;
                <a href="JavaScript:cetak()"><img src="images/ico/print.png" border="0" onMouseOver="showhint('Print', this, event, '50px')"/>&nbsp;Print</a>&nbsp;
                </td>
            </tr>
            </table>
            <br />
            <table class="tab" id="table" border="0" style="border-collapse:collapse" width="100%" align="center">
            <tr height="30" align="center">
                <td class="header" width="5%">#</td>
                <td class="header" width="20%">Journal/Date</td>
                <td class="header" width="21%">Sum</td>
                <td class="header" width="*">Info</td>
                <td class="header" width="12%">Officer</td>
                <td class="header">&nbsp;</td>
            </tr>
            <? 
          
            $cnt = 0;
            $total = 0;
            while ($row = mysql_fetch_array($result)) {
                $total += $row['jumlah'];
            ?>
            <tr height="25">
                <td align="center"><?=++$cnt?></td>
                <td align="center"><?="<strong>" . $row['nokas'] . "</strong><br><i>" . $row['tanggal']?></i></td>
                <td align="right"><?=FormatRupiah($row['jumlah'])?></td>
                <td align="left"><?=$row['keterangan'] ?></td>
                <td align="center"><?=$row['petugas'] ?></td>
                <td align="center">
                <a href="javascript:cetakkuitansi(<?=$row['id'] ?>)" ><img src="images/ico/print.png" border="0" onMouseOver="showhint('Print Kuitansi Payment', this, event, '100px')"/></a>&nbsp;
            <?  if (getLevel() != 2) { ?>    
                <a href="javascript:editpembayaran(<?=$row['id'] ?>)"><img src="images/ico/ubah.png" border="0" onMouseOver="showhint('Edit Payment Cicilan', this, event, '120px')" /></a>
           	<?	} ?>	                 
                </td>
            </tr>
            <?
            }
            ?>
            <tr height="35">
                <td bgcolor="#996600" colspan="2" align="center"><font color="#FFFFFF"><strong>Total</strong></font></td>
                <td bgcolor="#996600" align="right"><font color="#FFFFFF"><strong><?=FormatRupiah($total) ?></strong></font></td>
                <td bgcolor="#996600" colspan="3">&nbsp;</td>
            </tr>
            </table>
            <script language='JavaScript'>
            Tables('table', 1, 0);
            </script>
           	</fieldset>
            
		</td>
    </tr>
<? } ?>
	</table>
<!-- EOF CONTENT -->
</td></tr>
</table>
</form>
</body>
</html>
<script language="javascript">
	var sprytextfield2 = new Spry.Widget.ValidationTextField("besar");
	var sprytextarea1 = new Spry.Widget.ValidationTextarea("keterangan");
</script>