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
require_once("../include/config.php");
require_once("../include/common.php");
require_once("../include/db_functions_2.php");
require_once("../include/chartfactory.php");
require_once("../include/as-diagrams.php");
require_once('../include/theme.php');

$stat = $_REQUEST['stat'];
switch ($stat)
{
	case 1:
		$judul="Work Unit";
		break;
	case 2:
		$judul="Educational Background";
		break;
	case 3:
		$judul="Level";
		break;
	case 4:
		$judul="Age";
		break;
	case 5:
		$judul="Education and Training";
		break;
	case 6:
		$judul="Gender";
		break;
	case 7:
		$judul="Marital Status";
		break;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style<?=GetThemeDir2()?>.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Employee Affair</title>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top"><? include("../include/headercetak.php") ?>
<center>
    <font size="4"><strong>Statistic based on <?=$judul?></strong></font><br />
   </center><br /><br />
   
<table width="95%" border="0" cellspacing="5">
  <tr>
    <td><div id="grafikbar" align="center">
<?	if ($stat == 5)
	{
		$sql = "SELECT sk.satker, SUM(IF(NOT pl.idpegdiklat IS NULL, 1, 0)) AS Sudah, SUM(IF(pl.idpegdiklat IS NULL, 1, 0)) AS Belum
				FROM pegawai p, peglastdata pl, pegjab pj, jabatan j, satker sk
				WHERE p.aktif = 1 AND pl.nip = p.nip AND pl.idpegjab = pj.replid
				AND pj.idjabatan = j.replid AND j.satker = sk.satker
                GROUP BY sk.nama ORDER BY sk.nama";
		
		OpenDb();
		$result = QueryDb($sql);
		while($row = mysql_fetch_row($result))
		{
			$data[] = array($row[1], $row[2]);
			$legend_x[] = $row[0];
		}
		CloseDb();
		
		$legend_y = array("Ever Been", "Not Yet");
		$title = "<font face='Arial' size='-1' color='black'>Amount of Employee based on Diklat</font>"; // title for the diagram
		
		$graph = new CAsBarDiagram;
		$graph->bwidth = 10; // set one bar width, pixels
		$graph->bt_total = 'Total'; // 'totals' column title, if other than 'Totals'
		// $graph->showtotals = 0;  // uncomment it if You don't need 'totals' column
		$graph->precision = 0;  // decimal precision
		// call drawing function
		$graph->DiagramBar($legend_x, $legend_y, $data, $title);
	
    }
	elseif ($stat == 6)
	{
    	$sql = "SELECT j.satker, SUM(IF(p.kelamin = 'L', 1, 0)) AS Pria, SUM(IF(p.kelamin = 'P', 1, 0)) AS Wanita
				  FROM pegawai p, peglastdata pl, pegjab pj, jabatan j
				  WHERE p.aktif = 1 AND p.nip = pl.nip AND pl.idpegjab = pj.replid AND pj.idjabatan = j.replid AND NOT j.satker IS NULL
				  GROUP BY j.satker";
		
		OpenDb();
		$result = QueryDb($sql);
		while($row = mysql_fetch_row($result))
		{
			$data[] = array($row[1], $row[2]);
			$legend_x[] = $row[0];
		}
		CloseDb();
		
		$legend_y = array("Male", "Female");
		
		$title = "<font face='Arial' size='-1' color='black'>Amount of Pegawai based on Gender</font>"; // title for the diagram
		
		$graph = new CAsBarDiagram;
		$graph->bwidth = 10; // set one bar width, pixels
		$graph->bt_total = 'Total'; // 'totals' column title, if other than 'Totals'
		// $graph->showtotals = 0;  // uncomment it if You don't need 'totals' column
		$graph->precision = 1;  // decimal precision
		// call drawing function
		$graph->DiagramBar($legend_x, $legend_y, $data, $title);

    }
	elseif ($stat == 7)
	{
		$sql = "SELECT j.satker, SUM(IF(p.nikah = 'menikah', 1, 0)) AS Nikah, SUM(IF(p.nikah = 'belum', 1, 0)) AS Belum
				  FROM pegawai p, peglastdata pl, pegjab pj, jabatan j
				  WHERE p.aktif = 1 AND p.nip = pl.nip AND pl.idpegjab = pj.replid AND pj.idjabatan = j.replid
				  AND NOT j.satker IS NULL 
				  GROUP BY j.satker";
		
		OpenDb();
		$result = QueryDb($sql);
		while($row = mysql_fetch_row($result))
		{
			$data[] = array($row[1], $row[2]);
			$legend_x[] = $row[0];
		}
		CloseDb();
		
		$legend_y = array("Married", "Not Married");
		
		$title = "<font face='Arial' size='-1' color='black'>Amount of Pegawai based on Marital Status</font>"; 
		
		$graph = new CAsBarDiagram;
		$graph->bwidth = 10; // set one bar width, pixels
		$graph->bt_total = 'Total'; // 'totals' column title, if other than 'Totals'
		// $graph->showtotals = 0;  // uncomment it if You don't need 'totals' column
		$graph->precision = 1;  // decimal precision
		// call drawing function
		$graph->DiagramBar($legend_x, $legend_y, $data, $title);
	
    }
	else
	{
    ?>
    <img src="<?= "statimage.php?type=bar&stat=$stat" ?>" />
    <?
    }
	?>
    </div></td>
  </tr>
  <tr>
    <td><div id="grafikpie" align="center">
    <img src="<?= "statimage.php?type=pie&stat=$stat" ?>" />
    </div></td>
  </tr>
  <tr>
    <td><div id="table" align="center">
    <? if ($stat==5){ ?>
	<table id="table" class="tab" border="1" cellpadding="2" cellspacing="0" width="100%">
		<tr height="25">
			<td class="header" align="center" width="5%">#</td>
			<td class="header" align="center" width="60%">Echelon</td>
			<td class="header" align="center" width="15%">Ever Been</td>
			<td class="header" align="center" width="15%">#</td>
		</tr>
		<?
		OpenDb();
		$sql = "SELECT j.eselon, SUM(IF(NOT pl.idpegdiklat IS NULL, 1, 0)) AS Sudah, SUM(IF(pl.idpegdiklat IS NULL, 1, 0)) AS Belum
					FROM   pegawai p, peglastdata pl, pegjab pj, jabatan j, jenisjabatan jj
					WHERE p.aktif = 1 AND pl.nip = p.nip AND pl.idpegjab = pj.replid 
					AND pj.idjabatan = j.replid AND pj.jenis = jj.jenis AND jj.jabatan = 'S' GROUP BY j.eselon ORDER BY j.eselon";	
		$result = QueryDb($sql);
		while ($row = mysql_fetch_row($result)) {
		?>
		<tr height="20">
			<td align="center" valign="top"><?=++$cnt?></td>
			<td align="center" valign="top"><?=$row[0]?></td>
			<td align="center" valign="top">
				
				<?=$row[1]?>
				
			</td>
			<td align="center" valign="top">
				
				<?=$row[2]?>
				
			</td>
		</tr>
		<?
		}
		CloseDb();
		?>
		</table>
	<? } elseif ($stat==6){
	?>
    <table id="table" class="tab" border="1" cellpadding="2" cellspacing="0" width="100%">
        <tr height="25">
            <td class="header" align="center" width="5%">#</td>
            <td class="header" align="center" width="60%">Work Unit</td>
            <td class="header" align="center" width="15%">Male</td>
            <td class="header" align="center" width="15%">Female</td>
        </tr>
        <?
        OpenDb();
        $sql = "SELECT j.satker, SUM(IF(p.kelamin = 'L', 1, 0)) AS Pria, SUM(IF(p.kelamin = 'P', 1, 0)) AS Wanita
                  FROM pegawai p, peglastdata pl, pegjab pj, jabatan j
                  WHERE p.aktif = 1  AND p.nip = pl.nip AND pl.idpegjab = pj.replid AND pj.idjabatan = j.replid  AND NOT j.satker IS NULL
                  GROUP BY j.satker";	
        $result = QueryDb($sql);
        while ($row = mysql_fetch_row($result)) {
        ?>
        <tr height="20">
            <td align="center" valign="top"><?=++$cnt?></td>
            <td align="center" valign="top"><?=$row[0]?></td>
            <td align="center" valign="top"><?=$row[1]?></td>
            <td align="center" valign="top"><?=$row[2]?></td>
        </tr>
        <?
        }
        CloseDb();
        ?>
    </table>
    <?
	} elseif ($stat==7){
	?>
    <table id="table" class="tab" border="1" cellpadding="2" cellspacing="0" width="100%">
        <tr height="25">
            <td class="header" align="center" width="5%">#</td>
            <td class="header" align="center" width="60%">Work Unit</td>
            <td class="header" align="center" width="15%">Marital Status</td>
            <td class="header" align="center" width="15%">#</td>
        </tr>
        <?
        OpenDb();
        $sql = "SELECT j.satker, SUM(IF(p.nikah = 'menikah', 1, 0)) AS Nikah, SUM(IF(p.nikah = 'belum', 1, 0)) AS Belum
                  FROM pegawai p, peglastdata pl, pegjab pj, jabatan j
                  WHERE p.aktif = 1 AND p.nip = pl.nip AND pl.idpegjab = pj.replid AND pj.idjabatan = j.replid  AND NOT j.satker IS NULL
                  GROUP BY j.satker";	
        $result = QueryDb($sql);
        while ($row = mysql_fetch_row($result)) {
        ?>
        <tr height="20">
            <td align="center" valign="top"><?=++$cnt?></td>
            <td align="center" valign="top"><?=$row[0]?></td>
            <td align="center" valign="top">
                <a href="JavaScript:ShowDetail('<?=$row[0]?>','Nikah')">
                <?=$row[1]?>
                </a>
            </td>
            <td align="center" valign="top">
                <a href="JavaScript:ShowDetail('<?=$row[0]?>','Belum Nikah')">
                <?=$row[2]?>
                </a>
            </td>
        </tr>
    <?
    }
    CloseDb();
    ?>
    </table>
    <?
	} else {
	
		if ($stat == 1)
		{
			$column  = "Work Unit";
			$column2 = "Sum";
			$sql = "SELECT j.satker, count(pj.replid) FROM 
					pegjab pj, peglastdata pl, pegawai p, jabatan j 
					WHERE pl.idpegjab = pj.replid AND pj.idjabatan = j.replid AND pj.nip = p.nip 
					  AND p.aktif=1 AND NOT j.satker IS NULL GROUP BY satker;";	
		}
		elseif ($stat == 2)
		{
			$column  = "Education";
			$column2 = "Sum";
			$sql = "SELECT ps.tingkat, COUNT(p.nip) FROM
					pegawai p, peglastdata pl, pegsekolah ps, jbsumum.tingkatpendidikan pk
					WHERE p.nip = pl.nip AND pl.idpegsekolah = ps.replid AND ps.tingkat = pk.pendidikan AND p.aktif = 1 
					GROUP BY ps.tingkat";	
		}
		elseif ($stat == 3)
		{
			$column  = "Level";
			$column2 = "Sum";
			$sql = "SELECT pg.golongan, COUNT(p.nip) FROM pegawai p, peglastdata pl, peggol pg, golongan g
					WHERE p.nip = pl.nip AND pl.idpeggol = pg.replid AND pg.golongan = g.golongan AND p.aktif = 1 
					GROUP BY pg.golongan ORDER BY g.urutan";	
		}
		elseif ($stat == 4)
		{
			$column  = "Age";
			$column2 = "Sum";
			
			$sql = "SELECT G, COUNT(nip) FROM (
					SELECT nip, IF(usia < 24, '<24',
					IF(usia >= 24 AND usia <= 29, '24-29',
					IF(usia >= 30 AND usia <= 34, '30-34',
					IF(usia >= 35 AND usia <= 39, '35-39',
					IF(usia >= 40 AND usia <= 44, '40-44',
					IF(usia >= 45 AND usia <= 49, '45-49',
					IF(usia >= 50 AND usia <= 55, '50-55', '>56'))))))) AS G FROM
					(SELECT nip, FLOOR(DATEDIFF(NOW(), tgllahir) / 365) AS usia FROM pegawai WHERE aktif = 1) AS X) AS X GROUP BY G";	
		}
		
		?>
		<table id="table" class="tab" border="1" cellpadding="2" cellspacing="0" width="100%">
		<tr height="25">
			<td class="header" align="center" width="5%">#</td>
			<td class="header" align="center" width="60%"><?=$column?></td>
			<td class="header" align="center" width="25%"><?=$column2?></td>
		</tr>
		<?
		OpenDb();
		$result = QueryDb($sql);
		while ($row = mysql_fetch_row($result))
		{
		?>
		<tr height="20">
			<td align="center" valign="top"><?=++$cnt?></td>
			<td align="center" valign="top"><?=$row[0]?></td>
			<td align="center" valign="top"><?=$row[1]?></td>
		</tr>
		<?
		}
		CloseDb();
		?>
		</table>
	<? } ?>
    </div></td>
  </tr>
</table>

</td></tr></table>
</body>
<script language="javascript">
window.print();
</script>
</html>