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
require_once('include/rupiah.php');
require_once('include/config.php');
require_once('include/db_functions.php');
require_once('include/theme.php');
require_once('include/sessioninfo.php');

$id = $_REQUEST['id'];
$cek = 0;
if (isset($_REQUEST['simpan'])) 
{
	OpenDb();
	$tanggalmulai = MySqlDateFormat($_REQUEST['tcicilan']);
	
	$sql = "SELECT * FROM tahunbuku WHERE tahunbuku = '".CQ($_REQUEST[tahunbuku])."' AND departemen = '$_REQUEST[departemen]' AND replid <> '$id'";
	$result = QueryDb($sql);
	
	$sql1 = "SELECT * FROM tahunbuku WHERE awalan = '".CQ($_REQUEST[awalan])."' AND departemen = '$_REQUEST[departemen]' AND replid <> '$id'";
	$result1 = QueryDb($sql1);
	
	if (mysql_num_rows($result) > 0) 
	{
		CloseDb();
		$MYSQL_ERROR_MSG = "Name $_REQUEST[tahunbuku] has been used";
		$cek = 0;
	} 
	else if (mysql_num_rows($result1) > 0) 
	{
		CloseDb();
		$MYSQL_ERROR_MSG = "Awalan $_REQUEST[awalan] has been used";
		$cek = 1;
	} 
	else 
	{
		BeginTrans();
		$success = true;
		
		$sql = "UPDATE tahunbuku SET tahunbuku='".CQ($_REQUEST['tahunbuku'])."', tanggalmulai='$tanggalmulai', awalan='".CQ($_REQUEST['awalan'])."',	keterangan='".CQ($_REQUEST['keterangan'])."' WHERE replid = '$id'";
		QueryDbTrans($sql, $success);
		
		if ($success)
		{
			$sql = "SELECT info1 FROM tahunbuku WHERE replid='$id'";
			$idjurnal = FetchSingle($sql);
			
			if (strlen($idjurnal) > 0)
			{
				$sql = "UPDATE jurnal SET tanggal = '$tanggalmulai' WHERE replid = '$idjurnal'";
				QueryDbTrans($sql, $success);
			}
		}
		
		if ($success)
			CommitTrans();
		else
			RollbackTrans();
			
		CloseDb();
	
		if ($success) 
		{ ?>
			<script language="javascript">
				opener.refresh();
				window.close();
			</script> 
<?		}
	}
}

switch ($cek) {
	case 0 : $input_awal = "onload=\"document.getElementById('tahunbuku').focus()\"";
		break;
	case 1 : $input_awal = "onload=\"document.getElementById('awalan').focus()\"";
		break;
}

OpenDb();
$sql = "SELECT tahunbuku, departemen, awalan, keterangan, date_format(tanggalmulai, '%d-%m-%Y') AS tanggalmulai FROM tahunbuku WHERE replid = '$id'";
$result = QueryDb($sql);
$row = mysql_fetch_array($result);
CloseDb();
	
$tahunbuku = $row['tahunbuku'];
$departemen = $row['departemen'];
$awalan = $row['awalan'];
$keterangan = $row['keterangan'];
$tanggalmulai = $row['tanggalmulai'];

if (isset($_REQUEST['tahunbuku']))
	$tahunbuku = CQ($_REQUEST['tahunbuku']);
if (isset($_REQUEST['awalan']))
	$awalan = CQ($_REQUEST['awalan']);	
if (isset($_REQUEST['keterangan']))
	$keterangan = CQ($_REQUEST['keterangan']);
if (isset($_REQUEST['tcicilan']))
	$tanggalmulai = $_REQUEST['tcicilan'];
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" type="text/css" href="style/tooltips.css">
<link rel="stylesheet" type="text/css" href="style/calendar-green.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS FINANCE [Edit Fiscal Year]</title>
<script language="javascript" src="script/tooltips.js"></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/lang/calendar-en.js"></script>
<script type="text/javascript" src="script/calendar-setup.js"></script>
<script language="javascript" src="script/tooltips.js"></script>
<script language="javascript" src="script/validasi.js"></script>
<script language="javascript">
function validasi() {
	return validateEmptyText('tahunbuku', 'Fiscal Year') 
		&& validateEmptyText('awalan', 'Awalan Kuitansi')
		&& validateMaxText('keterangan', 255, 'Info Fiscal Year');
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
	var lain = new Array('tahunbuku','awalan','keterangan');
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

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style='background-color:#dfdec9' background="" <?=$input_awal?>>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Edit Fiscal Year :.
    </div>
	</td>
    <td width="28" background="<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    
    <form name="main" method="post" onSubmit="return validasi();">
    <input type="hidden" name="id" id="id" value="<?=$id ?>" /> 
      
    <table border="0" cellpadding="2" cellspacing="2" align="center" background="">
	<!-- TABLE CONTENT -->
    <tr>
        <td width="40%"><strong>Department</strong></td>
        <td colspan="2"><input type="text" name="departemen" id="departemen" value="<?=$departemen ?>" maxlength="25" size="25" readonly="readonly" style="background-color:#CCCC99"></td>
    </tr>
    <tr>
        <td><strong>Fiscal Year</strong></td>
        <td colspan="2"><input type="text" name="tahunbuku" id="tahunbuku" value="<?=$tahunbuku?>" maxlength="100" size="25" onKeyPress="return focusNext('tcicilan', event)" onFocus="panggil('tahunbuku')"></td>
    </tr>
    <tr>
		<td align="left"><strong>Start Date</strong></td>
	    <td>
	    <input type="text" name="tcicilan" id="tcicilan" readonly size="15" value="<?=$tanggalmulai ?>" onKeyPress="return focusNext('awalan', event)" onClick="Calendar.setup()" onFocus="panggil('tcicilan')" style="background-color:#CCCC99"></td>
		<td width="60%">
        <img src="images/calendar.jpg" name="tabel" border="0" id="btntanggal" onMouseOver="showhint('Open calendar', this, event, '100px')"/>
	    </td>
	</tr>
    <tr>
        <td><strong>Awalan Kuitansi</strong></td>
        <td colspan="2"><input type="text" name="awalan" id="awalan" value="<?=$awalan?>" maxlength="5" size="7" onKeyPress="return focusNext('keterangan', event)" onFocus="panggil('awalan')"></td>
    </tr>
    <tr>
        <td valign="top">Info</td>
        <td colspan="2"><textarea name="keterangan" id="keterangan" rows="3" cols="40" onKeyPress="return focusNext('simpan', event)" onFocus="panggil('keterangan')"><?=$keterangan?></textarea></td>
    </tr>
    <tr>
        <td colspan="3" align="center">
        	<input class="but" type="submit" value="Save" name="simpan" id = "simpan" onFocus="panggil('simpan')">
            <input class="but" type="button" value="Close" onClick="window.close();">
        </td>
    </tr>
    </table>
    </form>
	<!-- END OF CONTENT //--->
    </td>
    <td width="28" background="<?=GetThemeDir() ?>bgpop_06a.jpg">&nbsp;</td>
</tr>
<tr height="28">
	<td width="28" background="<?=GetThemeDir() ?>bgpop_07.jpg">&nbsp;</td>
    <td width="*" background="<?=GetThemeDir() ?>bgpop_08a.jpg">&nbsp;</td>
    <td width="28" background="<?=GetThemeDir() ?>bgpop_09.jpg">&nbsp;</td>
</tr>
</table>
<? if (strlen($MYSQL_ERROR_MSG) > 0) { ?>
<script language="javascript">
	alert('<?=$MYSQL_ERROR_MSG?>');		
</script>
<? } ?>

</body>
</html>
<script language="javascript">
  Calendar.setup(
    {
      //inputField  : "tanggalshow","tanggal"
	  inputField  : "tcicilan",         // ID of the input field
      ifFormat    : "%d-%m-%Y",    // the date format
      button      : "btntanggal"       // ID of the button
    }
   );
  Calendar.setup(
    {
      inputField  : "tcicilan",        // ID of the input field
      ifFormat    : "%d-%m-%Y",    // the date format	  
	  button      : "tcicilan"       // ID of the button
    }
  );

</script>