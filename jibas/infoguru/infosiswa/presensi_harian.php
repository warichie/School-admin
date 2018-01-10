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
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('../script/as-diagrams.php');

$nis_awal = $_REQUEST['nis_awal'];

$departemen = 0;
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

OpenDb();
$sql = "SELECT replid, departemen, nislama FROM riwayatdeptsiswa WHERE nis = '$nis_awal'";

$result = QueryDb($sql);
$row = @mysql_fetch_array($result);
$dep[0] = array($row['departemen'], $nis_awal);

if ($row['nislama'] <> "") {
	$sql1 = "SELECT replid, departemen, nislama FROM riwayatdeptsiswa WHERE nis = '$row[nislama]'";
	$result1 = QueryDb($sql1);
	$row1 = @mysql_fetch_array($result1);	
	$dep[1] = array($row1['departemen'], $row['nislama']);
	//$no[2] = $row1['nislama'];	
	if ($row1['nislama'] <> "") {				
		$sql2 = "SELECT replid, departemen, nislama FROM riwayatdeptsiswa WHERE nis = '$row1[nislama]'";
		$result2 = QueryDb($sql2);
		$row2 = @mysql_fetch_array($result2);					
		$dep[2] = array($row2['departemen'],$row1['nislama']) ;
	}	
}		

$nis = $dep[$departemen][1];

$sql_ajaran = "SELECT DISTINCT(t.replid), t.tahunajaran FROM riwayatkelassiswa r, kelas k, tahunajaran t WHERE r.nis = '$nis' AND r.idkelas = k.replid AND k.idtahunajaran = t.replid ORDER BY t.aktif DESC";

$result_ajaran = QueryDb($sql_ajaran);
$k = 0;
while ($row_ajaran = @mysql_fetch_array($result_ajaran)) {
	$ajaran[$k] = array($row_ajaran['replid'],$row_ajaran['tahunajaran']);
	$k++;
}

$sql_kls = "SELECT DISTINCT(r.idkelas), k.kelas, t.tingkat, k.idtahunajaran FROM riwayatkelassiswa r, kelas k, tingkat t WHERE r.nis = '$nis' AND r.idkelas = k.replid AND k.idtingkat = t.replid";
$result_kls = QueryDb($sql_kls);
$j = 0;
while ($row_kls = @mysql_fetch_array($result_kls)) {
	$kls[$j] = array($row_kls['idkelas'],$row_kls['kelas'],$row_kls['tingkat'],$row_kls['idtahunajaran']);
	$j++;
}


$tahunajaran = $ajaran[0][0];
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];
$kelas = $kls[0][0];
if (isset($_REQUEST['kelas']))
	$kelas = $_REQUEST['kelas'];

?>
<body leftmargin="0" topmargin="0">
<form name="panel1" id="panel1" method="post">
<input type="hidden" name="nis" id="nis" value="<?=$nis?>">
<input type="hidden" name="nis_awal" id="nis_awal" value="<?=$nis_awal?>">

<table width="100%" cellspacing="0" cellpadding="0">    
<tr>
	<td width="0">
    <!-- CONTENT GOES HERE //--->	
    <table border="0" cellpadding="2"cellspacing="2" width="100%" style="color:#000000">
    <tr>
    	<!--<td><strong>Department</strong>
    	
    	</td>-->
        <td width="*"><strong>Year</strong>
        <select name="departemen" id="departemen" onChange="change_dep(1)" style="width:80px">
		<? for ($i=0;$i<sizeof($dep);$i++) { ?>        	
            <option value="<?=$i ?>" <?=IntIsSelected($i, $departemen) ?> > <?=$dep[$i][0] ?> </option>
		<? } ?>
		</select>
        <select name="tahunajaran" id="tahunajaran" onChange="change(1)" style="width:125px">
   		<? for($k=0;$k<sizeof($ajaran);$k++) {?>
			<option value="<?=$ajaran[$k][0] ?>" <?=IntIsSelected($ajaran[$k][0], $tahunajaran) ?> > 
			<?=$ajaran[$k][1]?> </option>
		<? } ?>
    	</select>    
		&nbsp;&nbsp;<strong>Class History</strong>
        <select name="kelas" id="kelas" onChange="change(1)" style="width:125px">
   		<? for ($j=0;$j<sizeof($kls);$j++) {
				if ($kls[$j][3] == $tahunajaran) {
		?>
			<option value="<?=$kls[$j][0] ?>" <?=IntIsSelected($kls[$j][0], $kelas) ?> > <?=$kls[$j][2]." - ".$kls[$j][1] ?> </option>
		<? 		}
			} ?>
    	</select>    
		</td>
        <td align="right" width="12%">
  			<a href="#" onClick="cetak(0,1)"><img src="../images/ico/print.png" width="16" height="16" border="0" />&nbsp;Print</a>&nbsp;
    	</td>
  	</tr>
<? if ($kelas <> "" ) { 
		$sql = "SELECT tglmulai, tglakhir FROM tahunajaran WHERE replid = '$tahunajaran'";
		$result = QueryDb($sql);
		$row = mysql_fetch_array($result);
		$tglawal = $row['tglmulai'];
		$tglakhir = $row['tglakhir'];
		
		//$sql1 = "SELECT CONCAT(DATE_FORMAT(tanggal1,'%b'),' ',YEAR(tanggal1)) AS blnthn, SUM(hadir), SUM(ijin), SUM(sakit),  SUM(alpa),SUM(cuti) FROM presensiharian p, phsiswa ph WHERE ph.nis = '$nis' AND ph.idpresensi = p.replid AND p.idkelas = $kelas AND (((p.tanggal1 BETWEEN '$tglawal' AND '$tglakhir') OR (p.tanggal2 BETWEEN '$tglawal' AND '$tglakhir')) OR (('$tglawal' BETWEEN p.tanggal1 AND p.tanggal2) OR ('$tglakhir' BETWEEN p.tanggal1 AND p.tanggal2))) GROUP BY blnthn ORDER BY YEAR(tanggal1), MONTH(tanggal1)";
		$sql1 = "SELECT CONCAT(DATE_FORMAT(tanggal1,'%b'),' ',YEAR(tanggal1)) AS blnthn, SUM(hadir), SUM(ijin), SUM(sakit),  SUM(alpa),SUM(cuti), MONTH(tanggal1) FROM presensiharian p, phsiswa ph WHERE ph.nis = '$nis' AND ph.idpresensi = p.replid AND p.idkelas = '$kelas' AND (((p.tanggal1 BETWEEN '$tglawal' AND '$tglakhir') OR (p.tanggal2 BETWEEN '$tglawal' AND '$tglakhir')) OR (('$tglawal' BETWEEN p.tanggal1 AND p.tanggal2) OR ('$tglakhir' BETWEEN p.tanggal1 AND p.tanggal2))) GROUP BY blnthn ORDER BY YEAR(tanggal1), MONTH(tanggal1)";
		$result1 = QueryDb($sql1);
		
      	$num = mysql_num_rows($result1);
		echo "<input type='hidden' name='num' id='num' value=$num>";
		if ($num > 0) {
?>
    <tr>
    	<td colspan="3">
        <table border="0" cellpadding="2" cellspacing="2" width="100%" align="center" bgcolor="#FFFFFF">
        <tr>
        	<td align="center">
       	<?		
        
		$data_title = "<font size='4'>DAILY PRESENCE STATISTIC</font>"; // title for the diagram

        // sample data array
        $data = array();

        while($row1 = mysql_fetch_row($result1)) {
            $data[] = array($row1[1],$row1[2],$row1[3],$row1[4],$row1[5]);
            $legend_x[] = $row1[0];			
        }
				
        //$legend_x = array('Jan','Feb','March','April','May');
        $legend_y = array('Attend','Consent','Ill','Absent', 'Leave');

        $graph = new CAsBarDiagram;
        $graph->bwidth = 10; // set one bar width, pixels
        $graph->bt_total = 'Total'; // 'totals' column title, if other than 'Totals'
       // $graph->showtotals = 0;  // uncomment it if You don't need 'totals' column
        $graph->precision = 1;  // decimal precision
        // call drawing function
        $graph->DiagramBar($legend_x, $legend_y, $data, $data_title);
		?>
            </td>
        </tr>
        <tr>
        	<td>
            <table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="center" bordercolor="#000000">		
            <tr height="30" align="center">		
                <td width="*" class="header">Month</td>
                <td width="15%" class="header">Attend</td>
                <td width="15%" class="header">Consent</td>
                <td width="15%" class="header">Ill</td>
                <td width="15%" class="header">Absent</td>
                <td width="15%" class="header">Leave</td>
            </tr>
			<? 
            
            $result2 = QueryDb($sql1);
            while ($row2 = @mysql_fetch_row($result2)) {		
                $waktu = explode(" ",$row2[0]);
            ?>	
            <tr height="25">        			
                <td align="center"><?=NamaBulan($row2[6]).' '.$waktu[1]?></td>
                <td align="center"><?=$row2[1]?></td>
                <td align="center"><?=$row2[2]?></td>
                <td align="center"><?=$row2[3]?></td>
                <td align="center"><?=$row2[4]?></td>
                <td align="center"><?=$row2[5]?></td>
            </tr>
			<? } ?>
            </table>
           	</td>
       	</tr>
        </table>
        </td>
  	</tr>
<?	} else { ?>                 
	<tr>
		<td align="center" valign="middle" height="120" colspan="3">
		
    	<font size = "2" color ="red"><b>Data Not Found<br /></font>
		<table id="table"></table>
		</td>
	</tr>
  	<? } ?>
<? } else { ?>                 
	<tr>
		<td align="center" valign="middle" height="120" colspan="3">
    	<font size = "2" color ="red"><b>Data Not Found<br /></font>
		<table id="table"></table>
		</td>
	</tr>
<? } ?>

    </table>
     <!-- END OF CONTENT //--->
	</td>
</tr>
</table> 
</form>