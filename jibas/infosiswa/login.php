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
require_once('include/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="images/jibas.ico" rel="shortcut icon" />
<script type="text/javascript" language="javascript" src='../script/jquery.min.js'></script>
<script type="text/javascript" language="javascript" src="../script/footer.js"></script>
<script language="JavaScript" src="script/tools.js"></script>
<script language="JavaScript" src="script/resizing_background.js"></script>
<script src="script/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="script/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS InfoSiswa [User Validation]</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../script/bgstretcher.css" />
<script language="javascript" src="../script/bgstretcher.js"></script>
<script language="JavaScript">
function cek_form() 
{
	var user = document.form.username.value;
 	var pass = document.form.password.value;

	if(user.length == 0 && pass.length == 0) 
	{
		alert("Masukkan dulu Username and Password Kamu ");
		document.form.username.value = "";
		document.form.password.value = "";
		document.form.username.focus();
		return false;
	}
	else
	{
		return true;
	}
}

function credit()
{
	//newWindow('credit.html','Credit','190','229','resizable=1,scrollbars=0,statusbar=0,toolbar=0');
}

function focusNext(elemName, evt) 
{
	evt = (evt) ? evt : event;
	var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
	if (charCode == 13) 
	{
		if (elemName=="masuk") 
		{
			document.form.submit();		
		} 
		else 
		{
			document.getElementById(elemName).focus();
			return false;	
		}
	}
	return true;
}

function masuk()
{
	document.form.submit();
}

function alertSize() {
  var WinHeight = 0;
  var WinWidth = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    WinHeight = window.innerHeight;
	WinWidth = window.innerWidth;
  } else if( document.documentElement &&
      ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    WinHeight = document.documentElement.clientHeight;
	WinWidth = document.documentElement.clientWidth;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    WinHeight = document.body.clientHeight;
	WinWidth = document.body.clientWidth;
  }
  document.getElementById('Main').style.left = (parseInt(WinWidth)/2-220)+"px";
  document.getElementById('Main').style.top = (parseInt(WinHeight)/2-80)+"px";
}
function ChgInputPass(s,d,status){
	var Vs = document.getElementById(s);
	var Vd = document.getElementById(d);
	if (status=='1')
	{
		Vs.style.display='none';
		Vd.style.display='block';
		document.getElementById(d).focus();
	} else {
		if (Vd.value.length==0){
			Vs.style.display='block';
			Vd.style.display='none';
		} else {
			Vs.style.display='none';
			Vd.style.display='block';
		}
	}
}
function InputHover(txt,id,state){
	var x = document.getElementById(id).value;
	if (state=='1'){
		if (x==txt){
			document.getElementById(id).value='';
			document.getElementById(id).style.color='#000';
		} else {
			document.getElementById(id).style.color='#000';			
		}
	} else {
		if (x==txt || x==''){
			document.getElementById(id).style.color='#636363';
			document.getElementById(id).value=txt;
		} else {
			document.getElementById(id).style.color='#000';
		}
	}
}

$(document).ready(function () {
    $(document).bgStretcher({
        images: ['../images/background07.jpg'], imageWidth: 1680, imageHeight: 1050
    });
});
</script>
<style type="text/css">
#Main {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	top:50px;
	left: 50px;
}
#Footer {
	position:fixed;
	bottom:20px;
	right:20px;
}
#Partner {
	position:fixed;
	bottom:20px;
	left:20px;
}
</style>
</head>
<body onload="alertSize(); document.getElementById('username').focus()" onresize="alertSize()" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="padding:0px; margin:0px;">
<div style="position:relative; z-index:2;">
	
<form name="form" id="LoginForm" method="post" action="redirect.php" onsubmit="return cek_form()">
<table width="100%" border="0">
  <tr>
    <td width="100%">
    <div id="Main" align="center" style="width:511px; height:234px">
        <table id="Table_01" width="510" height="206" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td rowspan="4"><img src="../images/imfront_infosiswa.png"></td>
                <td height="70" valign="bottom" align="left">
				<font style="font-family:helvetica; font-size:16px; color:#fff; font-weight:bold;">
					INFO <font style="color:#000">SISWA</font>
				</font></td>
            </tr>
            <tr>
                <td width="363" height="24" valign="top" align="left">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="padding-right:4px"><input type="text" name="username" id="username" class="InputTxt" onfocus="InputHover('Username','username','1')" onblur="InputHover('Username','username','0')" style="color:#636363;width:80px; border:1px #666666 solid" value="Username"  /></td>
                    <td style="padding-right:4px"><input name="passwordfake" id="passwordsfake" style="color:#636363; display:block;width:80px; border:1px #666666 solid" value="Password" onfocus="ChgInputPass('passwordsfake','passwords','1')" type="text"    />
                <input name="password" id="passwords" style="color:#000000; display:none;width:80px; border:1px #666666 solid" value="" onblur="ChgInputPass('passwordsfake','passwords','0')"  type="password"    /></td>
                    <td style="padding-right:4px"><input type="submit" style=" background-color:#c9c9c9;font-weight:bold; border:#666666 1px solid;" value="Login" /></td>
                    <td><a title="Back to Main Menu" href="../" style="color:#2fcced; font-weight:bold; font-family:Arial;  font-size:12px; text-decoration:underline">Main Menu</a></td>
                  </tr>
                </table>                
                </td>
            </tr>
            <tr>
                <td width="363" height="18">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
	<div id="Partner">
    <?
		$_REQUEST = array();
		$_REQUEST['relpath'] = "..";
		include('../partner.php');
	?>
    </div>    
    <div id="Footer">
    <? include('../footer.php'); ?>
    </div>    
    </td>
  </tr>
</table>
</form>

</div>        
</body>
</html>