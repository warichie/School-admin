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
require_once("../include/sessionchecker.php");
require_once("../include/config.php");
require_once("../include/db_functions.php");
require_once("../include/common.php");
require_once('../include/theme.php');
require_once("../include/sessioninfo.php");

$nip = $_REQUEST['nip'];

$tgl = $_REQUEST['cbTgl'];
$bln = $_REQUEST['cbBln'];
$thn = $_REQUEST['txThn'];
$tmt = "$thn-$bln-$tgl";
$keterangan = $_REQUEST['txKeterangan'];

if (isset($_REQUEST['btSubmit']))
{
	OpenDb();
	$sql = "INSERT INTO jadwal SET nip='$nip', jenis='golongan', tanggal='$tmt', keterangan='$keterangan', aktif=1";
	QueryDb($sql);
	CloseDb(); ?>
    <script language="javascript">
		opener.Refresh();
		window.close();
    </script>
<?
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Promotion Schedule</title>
<link rel="stylesheet" href="../style/style<?=GetThemeDir2()?>.css" />
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function validate()
{
	return validateEmptyText('txThn', 'Date Jadwal Kenaikan Golongan Pegawai') && 
  		   validateInteger('txThn', 'Month Jadwal Kenaikan Golongan Pegawai') && 
		   validateLength('txThn', 'Year Jadwal Kenaikan Golongan Pegawai', 4) &&
		   validateEmptyText('txKeterangan', 'Schedule Info Kenaikan Golongan Pegawai');
}

function focusNext(elemName, evt)
{
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13)
	{
		document.getElementById(elemName).focus();
        return false;
    }
    return true;
}
</script>
</head>

<body onLoad="document.getElementById('cbTglPensiun').focus()">
<form name="main" method="post" onSubmit="return validate()">
<input type="hidden" name="nip" id="nip" value="<?=$nip?>" />
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr height="30">
	<td width="100%" class="header" align="center">Promotion Schedule</td>
</tr>
<tr>
	<td width="100%" align="center">
    
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
        <td align="right" valign="top" width="25%"><strong>Promotion Schedule :</strong></td>
        <td width="*" align="left" valign="top">

        <select id="cbTgl" name="cbTgl" onKeyPress="return focusNext('cbBln', event)">
    <?	for ($i = 1; $i <= 31; $i++) { ?>    
            <option value="<?=$i?>" <?=IntIsSelected($i, $tgl)?>><?=$i?></option>	
    <?	} ?>    
        </select>
        <select id="cbBln" name="cbBln" onKeyPress="return focusNext('txThn', event)">
    <?	for ($i = 1; $i <= 12; $i++) { ?>    
            <option value="<?=$i?>" <?=IntIsSelected($i, $bln)?>><?=NamaBulan($i)?></option>	
    <?	} ?>    
        </select>
        <input type="text" name="txThn" onKeyPress="return focusNext('txKeterangan', event)" id="txThn" size="4" maxlength="4" value="<?=$thn?>"/>
        </td>
	</tr>
    <tr>
    	<td align="right" valign="top"><strong>Info :</strong></td>
	    <td align="left" valign="top">
        <textarea id="txKeterangan" name="txKeterangan" rows="2" cols="40"><?=$keterangan?></textarea>
        </td>
    </tr>
    <tr>
    	<td align="right" valign="top">&nbsp;</td>
	    <td align="left" valign="top">
        <input type="submit" value="Save" name="btSubmit" class="but" />
        <input type="button" value="Close" onClick="window.close()" class="but" />
        </td> 
    </tr>
    </table>
    </td>
</tr>
</table>
</form>

</body>
</html>