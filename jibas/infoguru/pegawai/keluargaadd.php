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

$nama = CQ($_REQUEST['txNama']);
$hubungan = CQ($_REQUEST['txHubungan']);
$tgllahir = $_REQUEST['txTglLahir'];
$hp = CQ($_REQUEST['txHp']);
$email = CQ($_REQUEST['txEmail']);
$alm = CQ($_REQUEST['ckAlm']);
$isalm = strtolower($alm) == "on" ? "checked" : ""; 
$keterangan = CQ($_REQUEST['txKeterangan']);

if (isset($_REQUEST['btSubmit']))
{
	OpenDb();
	$alm = strtolower($alm) == "on" ? "1" : "0"; 
	$sql = "INSERT INTO jbssdm.pegkeluarga
               SET nip='$nip', nama='$nama', alm='$alm', hubungan='$hubungan',
                   tgllahir='$tgllahir', hp='$hp', email='$email', keterangan='$keterangan'";
	QueryDb($sql);	
	CloseDb(); ?>
	<script language="javascript">
		opener.Refresh();
		window.close();
	</script>
<?	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Work History</title>
<link rel="stylesheet" href="../style/style<?=GetThemeDir2()?>.css" />
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function validate()
{
	return validateEmptyText('txNama', 'Name Keluarga') &&
		   validateEmptyText('txHubungan', 'Hubungan Keluarga') && 
           validateEmptyText('txTglLahir', 'Date Lahir');
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

<body>
<form name="main" method="post" onSubmit="return validate()">
<input type="hidden" name="nip" id="nip" value="<?=$nip?>" />
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr height="30">
	<td width="100%" class="header" align="center">Add Family Data</td>
</tr>
<tr>
	<td width="100%" align="center">
    
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
    <tr>
    	<td width="25%" align="right"><strong>Name</strong> : </td>
	    <td width="*" align="left" valign="top">
		    <input type="text" name="txNama" id="txNama" value="<?=$nama?>" onKeyPress="return focusNext('txHubungan', event)" size="25" maxlength="255"/>
			<input type="checkbox" name="ckAlm" id="ckAlm" <?=$isalm?>>&nbsp;<i>almarhum</i>
    	</td>
	</tr>
	<tr>
    	<td width="25%" align="right"><strong>Relationship</strong> : </td>
	    <td width="*" align="left" valign="top">
		    <input type="text" name="txHubungan" id="txHubungan" value="<?=$hubungan?>" onKeyPress="return focusNext('txTglLahir', event)" size="25" maxlength="255"/>
    	</td>
	</tr>
	<tr>
    	<td width="25%" align="right"><strong>Date of Birth</strong> : </td>
	    <td width="*" align="left" valign="top">
		    <input type="text" name="txTglLahir" id="txTglLahir" value="<?=$tgllahir?>" onKeyPress="return focusNext('txHp', event)" size="25" maxlength="255"/>
    	</td>
	</tr>
	<tr>
    	<td width="25%" align="right">Mobile : </td>
	    <td width="*" align="left" valign="top">
		    <input type="text" name="txHp" id="txHp" value="<?=$hp?>" onKeyPress="return focusNext('txEmail', event)" size="25" maxlength="255"/>
    	</td>
	</tr>
	<tr>
    	<td width="25%" align="right">Email : </td>
	    <td width="*" align="left" valign="top">
		    <input type="text" name="txEmail" id="txEmail" value="<?=$email?>" onKeyPress="return focusNext('txKeterangan', event)" size="25" maxlength="255"/>
    	</td>
	</tr>
    <tr>
    	<td align="right" valign="top">Info : </td>
	    <td align="left" valign="top">
            <textarea id="txKeterangan" name="txKeterangan" rows="2" cols="37"><?=$keterangan?></textarea>
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