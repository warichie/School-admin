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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
    <link rel="Stylesheet" href="../style/style.css")
    <title></title>
    <script language="javascript">
        function upload() {
            parent.content.location.href = "Uploader2.php";
        }
        
        function browse() {
            parent.content.location.href = "UploaderBrowser2.php";
        }
    </script>
</head>
<body style="background-color: #F5F5F5">
<table border="0" width="100%">
<tr>
    <td width="50%" align="left">
    <input type="button" value="Image Upload" onclick="upload()" class="but" />&nbsp;&nbsp;
    <input type="button" value="Browse Gambar" onclick="browse()" class="but" />&nbsp;&nbsp;
    <input type="button" value="Close" onclick="parent.close();" class="but" />&nbsp;&nbsp;
    </td>
    <td width="50%" align="right">
    <font size="5" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="5" color="Gray">Upload Image</font><br /><br /><br />
    </td>
</tr>
</table>    
</body>
</html>