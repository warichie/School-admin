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
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/theme.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once("../include/sessionchecker.php");
?>

<?
OpenDb();
$query3 = "DELETE FROM jbsakad.nau WHERE idjenis = '$_GET[id]'";
$result3 = QueryDb($query3);

$row3 = @mysql_fetch_array($result3);

if(mysql_affected_rows() > 0) {
?>
    <script language="JavaScript">
        //alert("Assessment Type Student berhasil dihapus");
        document.location.href="tampil_nilai_pelajaran.php?jenis_penilaian=<?=$_GET[jenis_penilaian] ?>&departemen=<?=$_GET[departemen] ?>&tahun=<?=$_GET[tahun] ?>&tingkat=<?=$_GET[tingkat] ?>&semester=<?=$_GET[semester] ?>&pelajaran=<?=$_GET[pelajaran] ?>&kelas=<?=$_GET[kelas] ?>";
    </script>
<?
}
else {
?>
    <script language="JavaScript">
        //alert('Exam gagal dihapus');
		document.location.href="tampil_nilai_pelajaran.php?jenis_penilaian=<?=$_GET[jenis_penilaian] ?>&departemen=<?=$_GET[departemen] ?>&tahun=<?=$_GET[tahun] ?>&tingkat=<?=$_GET[tingkat] ?>&semester=<?=$_GET[semester] ?>&pelajaran=<?=$_GET[pelajaran] ?>&kelas=<?=$_GET[kelas] ?>";
    </script>

<?
}
CloseDb();
?>