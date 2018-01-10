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
<? 
require_once('../inc/config.php');
require_once('../inc/getheader.php');
require_once('../inc/db_functions.php');
require_once('../inc/common.php');

$semester = $_REQUEST['semester']; 
$namasemester = $_REQUEST['namasemester']; 
$pelajaran = $_REQUEST['pelajaran']; 
$nis = $_REQUEST['nis'];
$kelas = $_REQUEST['kelas'];

?>
<link href="../style/style.css" rel="stylesheet" type="text/css">

<table width="100%" border="0" height="100%" >
    <tr>
        <td width="72%" valign="top">
        <? 	OpenDb();
            $sql = "SELECT * FROM pelajaran WHERE replid = '$pelajaran' ";
            $result = QueryDb($sql);
            CloseDb();
            $row = mysql_fetch_array($result);
            
        ?>	
        <font color="#000000" size="3" class="news_content1">Subject <?=$row[nama]?><br />Semester <?=$namasemester?> </font></td> 
        <td width="28%" align="right" valign="top"> 
        <a href="JavaScript:cetak('X_<?=$semester?>')"><img src="../img/print.png" border="0" />&nbsp;Print</a>              </td>
    </tr>
    <?	OpenDb();
        $sql = "SELECT j.replid, j.jenisujian FROM jenisujian j, ujian u WHERE j.idpelajaran = '$pelajaran' AND u.idjenis = j.replid ".
        "GROUP BY j.jenisujian";
        
        $result = QueryDb($sql);
        if (mysql_num_rows($result) > 0) { //2
        while($row = @mysql_fetch_array($result)){	//1		
    ?>
    <tr>
        <td colspan="2"> 
        <br>
        <fieldset><legend><span class="news_title2"><?=$row['jenisujian']?></span></legend>
        <br />
        <? 	OpenDb();		
            $sql1 = "SELECT u.tanggal, n.nilaiujian, n.keterangan FROM ujian u, pelajaran p, nilaiujian n WHERE u.idpelajaran = p.replid AND u.idkelas = '$kelas' AND u.idpelajaran = '$pelajaran' AND u.idsemester = '".$semester."' AND u.idjenis = '$row[replid]' AND u.replid = n.idujian AND n.nis = '$nis' ".
            "ORDER BY u.tanggal";
            $result1 = QueryDb($sql1);
            
            if (@mysql_num_rows($result1) > 0){
        ?>
            <table border="1" width="100%" id="table19" class="tab" >
                <tr class="header" align="center" height="30">		
                    <td width="5%">#</td>
                    <td width="20%">Date</td>
                    <td width="10%">Point</td>
                    <td width="*">Info</td>
                </tr>
                <?	
                    $sql2 = "SELECT AVG(n.nilaiujian) as rata FROM ujian u, pelajaran p, nilaiujian n WHERE u.idpelajaran = p.replid AND u.idkelas = '$kelas' AND u.idpelajaran = '$pelajaran' AND u.idsemester = '".$semester."' AND u.idjenis = '$row[replid]' AND u.replid = n.idujian AND n.nis = '$nis' ";
                    $result2 = QueryDb($sql2);	
                    $row2 = @mysql_fetch_array($result2);
                    $rata = $row2[rata];
                    $cnt = 1;
                    while($row1 = @mysql_fetch_array($result1)){			
                ?>
                <tr>        			
                    <td width="5" height="25" align="center"><?=$cnt?></td>
                    <td width="250" height="25" align="center"><?=LongDateFormat($row1[0])?></td>
                    <td width="10" height="25" align="center"><?=$row1[1]?></td>
                    <td height="25"><?=$row1[2]?></td>            
                </tr>	
            <?		$cnt++;
                    }	?>
                <tr>        			
                    <td colspan="2" height="25" align="center"><strong>Index Point/Cumulative</strong></td>
                    <td width="10" height="25" align="center"><?=round($rata,2)?></td>
                    <td height="25">&nbsp;</td>            
                </tr>
            </table>
            <? } else { ?>
            <table width="100%" border="0" align="center" id="table1">          
                <tr>
                    <td align="center" valign="middle" height="50">
                    <font color ="red" size = "2" class="err"><b>Data Not Found</b></font>                    </td>
                </tr>
            </table>
            <? } ?>
        </fieldset>
        </td>	
    </tr>
		<?	} //1 ?>
        <? } else { //2?>
    <tr>
        <td align="center" valign="middle" height="50">
        <table border="0" width="100%" id="table1" cellpadding="0" cellspacing="0">
        <tr align="center" valign="middle" >
            <td><span class="err"><font size = "2" color ="red"><b>Data Not Found</font></span><font size = "2" color ="red"><br />
          </font></td>
        </tr>
        </table>
        </td>
    </tr>
    <? } //2?>
</table>