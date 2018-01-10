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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$ERRMSG = "";

$nis = trim($_REQUEST['nis']);
$pin = trim($_REQUEST['pin']);

if (strlen($nis) == 0 || strlen($pin) == 0)
{
    include("infosiswa.login.php");
    exit();
}

OpenDb();
$sql = "SELECT COUNT(replid)
          FROM jbsakad.siswa
         WHERE nis = '$nis' AND pinsiswa = '$pin'";
$ndata = (int)FetchSingle($sql);

if ($ndata == 0)
{
    $ERRMSG = "Wrong Student ID or PIN";
    include("infosiswa.login.php");
    exit();
}

require_once("infosiswa.session.php");

$_SESSION['islogin'] = true;
?>
<script>
    $.ajax({
        url : 'infosiswa/infosiswa.content.php?nis=<?=$nis?>&reporttype=PROFILE',
        type: 'get',
        success : function(html) {
            $('#is_main').html(html);
        }
    })    
</script>
