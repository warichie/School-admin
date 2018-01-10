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
require_once("../include/sessioninfo.php");
require_once("daftarpribadi.class.php");

OpenDb();
$DP = new DaftarPribadi();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Employee Affair</title>
<link rel="stylesheet" href="../style/style.css" />
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/ajax.js"></script>
<script language="javascript" src="daftarpribadi.js"></script>
<style type="text/css">
.style1 { color: #999999; font-style: italic; font-size: 11px; }
.style3 {color: #666666; font-style: italic; }
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#ffffff">
<div id="waitBox" style="position:absolute; visibility:hidden;">
<img src="../images/movewait.gif" border="0" />Please wait...
</div>
<table width="100%" border="0" cellspacing="0">
<tr>
	<td width="74%" align="center" valign="bottom">
		<font class="subtitle"><?=$DP->pegawai?> - <?=$DP->nip?></font>
	</td>
    <td width="26%" rowspan="2" align="center">
		<div id="fotoInfo">
		<img src="../include/gambar.php?nip=<?=$DP->nip?>&table=pegawai&field=foto" height="120">
		</div>
	</td>
</tr>
<tr>
    <td align="center" valign="top">
		<a href="JavaScript:Refresh()"><img src="../images/ico/refresh.png" border="0" />&nbsp;Refresh</a>&nbsp;
		<a href="JavaScript:Cetak()"><img src="../images/ico/print.png" border="0" />&nbsp;Print</a>&nbsp;
	</td>
</tr>
</table>

<form name="main" method="post" onSubmit="return validate()" enctype="multipart/form-data">
<input type="hidden" name="nip" id="nip" value="<?=$DP->nip?>">
<input type="hidden" name="replid" id="replid" value="<?=$DP->replid?>">
<table border="0" cellpadding="5" cellspacing="0" width="100%" id="table56">
<tr>
	<td width="100%" align="left" style="border-bottom:thin dashed #CCCCCC; border-top:none; border-left:none; border-right:none;">
        <font style="background-color:#FFCC33; font-size:14px">&nbsp;&nbsp;</font>
        <font class="subtitle">Personal Data</font><br />
    </td>
</tr>
<tr><td>

<table border="0" cellpadding="5" cellspacing="0" width="100%">
<? if (strlen($DP->ERRMSG) > 0) { ?>
<tr>
	<td colspan="2" align="center">
        <table border="1" style="border-style:dashed; border-color:#CC0000; background-color:#FFFFCC" width="300">
        <tr><td align="center"><?=$DP->ERRMSG?></td></tr>
        </table>
	</td>
</tr>
<? } ?>
<tr>
	<td align="right" valign="top"><strong>Status </strong>:</td>
    <td width="*" align="left" valign="top">
    <input type="radio" name="rbPNS" id="rbPNS" value="PNS" <? if($DP->pns == "PNS") echo "checked"; ?> />&nbsp;Government Employees&nbsp;&nbsp;
    <input type="radio" name="rbPNS" id="rbPNS" value="CPNS" <? if($DP->pns == "CPNS") echo "checked"; ?> />&nbsp;Government Employees Candidate&nbsp;&nbsp;
    <input type="radio" name="rbPNS" id="rbPNS" value="HONORER" <? if($DP->pns == "HONORER") echo "checked"; ?> />&nbsp;Honorer
	<input type="radio" name="rbPNS" id="rbPNS" value="SWASTA" <? if($DP->pns == "SWASTA") echo "checked"; ?> />&nbsp;Private
    </td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Section</strong>:</td>
    <td width="*" align="left" valign="top">
<?	 $sql = "SELECT bagian FROM jbssdm.bagianpegawai ORDER BY urutan";
	 $res = QueryDb($sql);
	 $checked = "checked='checked'";
	 while ($row = @mysql_fetch_row($res))
	 {
		 echo "<input type='radio' $checked name='rbBagian' id='rbBagian' value='$row[0]' " .  StringIsChecked($row[0], $DP->bagian) . " />&nbsp;$row[0]&nbsp;";
		 $checked = "";
	 } ?>
    </td>
</tr>
<tr>
	<td width="140" align="right" valign="top"><strong>Name </strong>:</td>
    <td width="*" align="left" valign="top">
    
    <table border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td width="80"><input type="text" name="txGelarAwal" id="txGelarAwal" size="10" maxlength="45" value="<?=$DP->gelarawal?>" onKeyPress="return focusNext('txNama', event)"/></td>
        <td width="260"><input type="text" name="txNama" id="txNama" size="40" maxlength="255" value="<?=$DP->nama?>" onKeyPress="return focusNext('txGelarAkhir', event)"/></td>
        <td width="120"><input type="text" name="txGelarAkhir" id="txGelarAkhir" size="10" maxlength="45" value="<?=$DP->gelarakhir?>" onKeyPress="return focusNext('txPanggilan', event)"/></td>
    </tr>
    <tr>
    	<td><font color="#999999"><em>title</em></font>&nbsp;</td>
        <td>&nbsp;</td>
        <td><font color="#999999"><em>academic title</em></font></td>
    </tr>
    </table>    </td>
</tr>
<tr>
	<td align="right" valign="top">Abbreviation:</td>
    <td width="*" align="left" valign="top">
		<input type="text" name="txPanggilan" id="txPanggilan" size="20" maxlength="30" value="<?=$DP->panggilan?>" onKeyPress="return focusNext('txNIP', event)"/>
	</td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Employee ID </strong>:</td>
    <td width="*" align="left" valign="top">
		<input type="text" name="txNIP" id="txNIP" size="20" maxlength="30" value="<?=$DP->nip?>" onKeyPress="return focusNext('txNUPTK', event)"/>
	</td>
</tr>
<tr>
	<td align="right" valign="top">NUPTK :</td>
    <td width="*" align="left" valign="top">
		<input type="text" name="txNUPTK" id="txNUPTK" size="20" maxlength="30" value="<?=$DP->nuptk?>" onKeyPress="return focusNext('txNRG', event)"/>
	</td>
</tr>
<tr>
	<td align="right" valign="top">NRG :</td>
    <td width="*" align="left" valign="top">
		<input type="text" name="txNRP" id="txNRP" size="20" maxlength="30" value="<?=$DP->nrp?>" onKeyPress="return focusNext('txTmpLahir', event)"/>
	</td>
</tr>

<tr>
	<td align="right" valign="top"><strong>Date of Birth </strong>:</td>
    <td width="*" align="left" valign="top">
    <input type="text" name="txTmpLahir" id="txTmpLahir" size="20" maxlength="25" value="<?=$DP->tmplahir?>" onKeyPress="return focusNext('cbTglLahir', event)"/>, 
    <select id="cbTglLahir" name="cbTglLahir" onKeyPress="return focusNext('cbBlnLahir', event)">
<?	for ($i = 1; $i <= 31; $i++) { ?>    
    	<option value="<?=$i?>" <?=IntIsSelected($i, $DP->tgllahir)?>><?=$i?></option>	
<?	} ?>    
	</select>
    <select id="cbBlnLahir" name="cbBlnLahir" onKeyPress="return focusNext('txThnLahir', event)">
<?	for ($i = 1; $i <= 12; $i++) { ?>    
    	<option value="<?=$i?>" <?=IntIsSelected($i, $DP->blnlahir)?>><?=NamaBulan($i)?></option>	
<?	} ?>    
	</select>
    <input type="text" name="txThnLahir" id="txThnLahir" size="4" maxlength="4" value="<?=$DP->thnlahir?>" onKeyPress="return focusNext('txAlamat', event)"/>    </td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Religion:</strong>    </td>
    <td width="*" align="left" valign="top">
	<span id="agama_info">
    <select name="cbAgama" id="cbAgama" onKeyPress="return focusNext('cbSuku', event)">
<?	$sql = "SELECT agama FROM jbsumum.agama ORDER BY urutan";
	$result = QueryDb($sql);
	while ($row = mysql_fetch_row($result)) { ?>    
    	<option value="<?=$row[0]?>" <?=StringIsSelected($row[0], $DP->agama)?> ><?=$row[0]?></option>
<?	} ?>    
    </select>&nbsp;
<? 	if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
    <img src="../images/ico/tambah.png" border="0" onClick="tambah_agama();"">
<? 	} ?>
	</span>
	</td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Ethnicity:</strong>    </td>
    <td width="*" align="left" valign="top">
	<span id="suku_info">
    <select name="cbSuku" id="cbSuku" onKeyPress="return focusNext('cbNikah', event)">
<?		$sql = "SELECT suku FROM jbsumum.suku";
		$res = QueryDb($sql);
	    while ($row = @mysql_fetch_row($res))
		  echo "<option value='$row[0]' " . StringIsSelected($row[0], $DP->suku) . " >$row[0]</option>";
?>
    </select>&nbsp;
<? 	if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
		<img src="../images/ico/tambah.png" onClick="tambah_suku();" />
<? 	} ?>
    </span>
	</td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Marital Status :</strong>    </td>
    <td width="*" align="left" valign="top">
    <select name="cbNikah" id="cbNikah" onKeyPress="return focusNext('cbKelamin', event)">
		 <option value="Married" <?=StringIsSelected("menikah", $DP->nikah)?> >Married</option>
		 <option value="Not Married" <?=StringIsSelected("belum", $DP->nikah)?> >#</option>
		 <option value="None" <?=StringIsSelected("tak_ada", $DP->nikah)?> >Data Not Found</option>
    </select>&nbsp;    </td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Gender :</strong>    </td>
		<td width="*" align="left" valign="top">
		<select name="cbKelamin" id="cbKelamin" onKeyPress="return focusNext('txAlamat', event)">
			<option value="l" <?=StringIsSelected("l", $DP->kelamin)?>>Male</option>
			<option value="p" <?=StringIsSelected("p", $DP->kelamin)?>>Female</option>
	   </select>&nbsp;
	</td>
</tr>
<tr>
	<td align="right" valign="top">Address :</td>
    <td width="*" align="left" valign="top"><input type="text" name="txAlamat" id="txAlamat" size="70" onKeyPress="return focusNext('txHP', event)" maxlength="255" value="<?=$DP->alamat?>"/></td>
</tr>
<tr>
	<td align="right" valign="top">Mobile :</td>
    <td width="*" align="left" valign="top"><input type="text" name="txHP" id="txHP" size="15" maxlength="15" value="<?=$DP->hp?>" onKeyPress="return focusNext('txTelpon', event)"/>
    Phone: <input type="text" name="txTelpon" id="txTelpon" size="15" maxlength="15" value="<?=$DP->telpon?>" onKeyPress="return focusNext('txEmail', event)"/>    </td>
</tr>
<tr>
	<td align="right" valign="top">Email :</td>
    <td width="*" align="left" valign="top">
		<input type="text" name="txEmail" id="txEmail" size="45" maxlength="255" value="<?=$DP->email?>" onKeyPress="return focusNext('txFacebook', event)"/>
	</td>
</tr>
<tr>
	<td align="right" valign="top">Facebook :</td>
    <td width="*" align="left" valign="top">
		<input type="text" name="txFacebook" id="txFacebook" size="45" maxlength="255" value="<?=$DP->facebook?>" onKeyPress="return focusNext('txTwitter', event)"/>
	</td>
</tr>
<tr>
	<td align="right" valign="top">Twitter :</td>
    <td width="*" align="left" valign="top">
		<input type="text" name="txTwitter" id="txTwitter" size="45" maxlength="255" value="<?=$DP->twitter?>" onKeyPress="return focusNext('txWebsite', event)"/>
	</td>
</tr>
<tr>
	<td align="right" valign="top">Website :</td>
    <td width="*" align="left" valign="top">
		<input type="text" name="txWebsite" id="txWebsite" size="45" maxlength="255" value="<?=$DP->website?>" onKeyPress="return focusNext('foto', event)"/>
	</td>
</tr>
<tr>
  <td valign="top" align="right">Photo :</td>
  <td align="left" valign="top">
	<input type="file" name="foto" id="foto" size="30"/>
    <span class="style3">&nbsp;Diisi jika akan mengganti photo</span>
    <input type="hidden" id="ext" name="ext"/>
  </td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Status :</strong></td>
    <td width="*" align="left" valign="top">
<?	$aktifchecked = "";
	if ($DP->aktif == 1) 
		$aktifchecked = "checked"; 
		
	$nonchecked = "";
	if ($DP->aktif == 0) 
		$nonchecked = "checked"; ?>
    <input type="radio" name="rbAktif" value="1" id="rbAktif" <?=$aktifchecked?> />&nbsp;Active
    <input type="radio" name="rbAktif" value="0" id="rbAktif" <?=$nonchecked?>  >&nbsp;Inactive&nbsp;
    <input type="text" name="txKetNonAktif" id="txKetNonAktif" value="<?=$DP->ketnonaktif?>" size="25" maxlength="255"  onKeyPress="return focusNext('cbTglMulai', event)"/>
</td>
</tr>
<tr>
	<td align="right" valign="top"><strong>Start Working :</strong></td>
    <td width="*" align="left" valign="top">
    <select id="cbTglMulai" name="cbTglMulai" onKeyPress="return focusNext('cbBlnMulai', event)">
<?	for ($i = 1; $i <= 31; $i++) { ?>    
    	<option value="<?=$i?>" <?=IntIsSelected($i, $DP->tglmulai)?>><?=$i?></option>	
<?	} ?>    
	</select>
    <select id="cbBlnMulai" name="cbBlnMulai" onKeyPress="return focusNext('txThnMulai', event)">
<?	$M = date("m");
	for ($i = 1; $i <= 12; $i++) { ?>    
    	<option value="<?=$i?>" <?=IntIsSelected($i, $DP->blnmulai)?>><?=NamaBulan($i)?></option>	
<?	} ?>    
	</select>
    <input type="text" name="txThnMulai" id="txThnMulai" onKeyPress="return focusNext('cbTglPensiun', event)" size="4" maxlength="4" value="<?=$DP->thnmulai?>"/>    </td>
</tr>
<tr>
	<td align="right" valign="top">Info :</td>
    <td width="*" align="left" valign="top">
    <textarea id="txKeterangan" name="txKeterangan" rows="3" cols="60" onKeyPress="return focusNext('txAlasan', event)"><?=$DP->keterangan?></textarea>    </td>
</tr>
<tr>
	<td align="center" valign="top" colspan="2" bgcolor="#CCCCCC">
    <input type="submit" value="Save" name="btSubmit" id="btSubmit" class="but" />
    &nbsp;
<? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
    <input type="button" value="Hapus Pegawai Ini" name="btHapus" style="color:#FF0000; font-weight:bold" class="but" onClick="JavaScript:Hapus('<?=$DP->nip?>')" />
<? } ?>	
</td>
</tr>
</table>
<?
CloseDb();
?>    
</td></tr>

</table>
</form>

</body>
</html>