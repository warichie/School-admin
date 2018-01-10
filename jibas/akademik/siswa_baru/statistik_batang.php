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
require_once('../include/config.php');
require_once('../include/db_functions.php');
include("../library/class/jpgraph.php");
include("../library/class/jpgraph_bar.php");
include("../library/class/jpgraph_line.php");

$idproses=(int)$_REQUEST['idproses'];
$departemen=$_REQUEST['departemen'];
$iddasar = $_REQUEST['iddasar'];
OpenDb();
if ($departemen=="-1" && $idproses<0)
	$kondisi="a.replid=s.idproses ";
if ($departemen<>"-1" && $idproses<0)
	$kondisi="a.departemen='$departemen' AND a.replid=s.idproses ";
if ($departemen<>"-1" && $idproses>0)
	$kondisi="s.idproses=$idproses AND a.replid=s.idproses AND a.departemen='$departemen' ";
	
if ($iddasar=="12"){	
	$query1 = "SELECT COUNT(*) As Jum FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = '1' AND s.penghasilanayah+s.penghasilanibu <> 0 AND s.penghasilanayah+s.penghasilanibu<1000000 ";

	$query2 = "SELECT COUNT(*) As Jum FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = '1' AND s.penghasilanayah+s.penghasilanibu>=1000000 AND s.penghasilanayah+s.penghasilanibu<2500000";

	$query3 = "SELECT COUNT(*) As Jum FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = '1' AND s.penghasilanayah+s.penghasilanibu>=2500000 AND s.penghasilanayah+s.penghasilanibu<5000000";

	$query4 = "SELECT COUNT(*) As Jum FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = '1' AND s.penghasilanayah+s.penghasilanibu>=5000000";

	$query5 = "SELECT COUNT(*) As Jum FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = '1' AND s.penghasilanayah+s.penghasilanibu = 0";

	$result1 = QueryDb($query1);
	$row1 = @mysql_fetch_array($result1);
	$j1 = $row1[Jum];

	$result2 = QueryDb($query2);
	$row2 = @mysql_fetch_array($result2);
	$j2 = $row2[Jum];

	$result3 = QueryDb($query3);
	$row3 = @mysql_fetch_array($result3);
	$j3 = $row3[Jum];

	$result4 = QueryDb($query4);
	$row4 = @mysql_fetch_array($result4);
	$j4 = $row4[Jum];

	$result5 = QueryDb($query5);
	$row5 = @mysql_fetch_array($result5);
	$j5 = $row5[Jum];

	//=====================================================

	$sum = $j1 + $j2 +$j3 + $j4 + $j5;
	//=====================================================
	if($sum == 0) {
	  echo "<table width='100%' height='100%'><tr><td align='center' valign='middle'>
			<font size='2' face='verdana'>Failed to show Bar Chart<br> because student don't have any data<br> for Department <b>$_REQUEST[departemen]</b> and Graduates <b>$row[angkatan]</b></font></td></tr></table>";
	} else {
		//data group 1
		$data1 = array($j1);
		$data2 = array($j2);
		$data3 = array($j3);
		$data4 = array($j4);
		$data5 = array($j5);

		//Buat grafik
		$graph = new Graph(450,300,"auto");
		$graph->SetScale("textlin");

		$lab = array("Income");

		//setting kanvas
		$graph->SetShadow();
		$graph->img->SetMargin(40,100,20,10);
		$graph->xaxis->SetTickLabels($lab);

		//Create bar plots
		$b1plot = new BarPlot($data1);
		$b2plot = new BarPlot($data2);
		$b3plot = new BarPlot($data3);
		$b4plot = new BarPlot($data4);
		$b5plot = new BarPlot($data5);

		$b1plot->SetLegend("< Rp. 1.000.000");
		$b2plot->SetLegend("Rp. 1.000.000 - Rp. 2.500.000");
		$b3plot->SetLegend("Rp. 2.500.000 - Rp. 5.000.000");
		$b4plot->SetLegend("> Rp. 5.000.000");
		$b5plot->SetLegend("No data.");

		$b1plot->SetShadow('darkgray@0.5');
		$b2plot->SetShadow('darkgray@0.5');
		$b3plot->SetShadow('darkgray@0.5');
		$b4plot->SetShadow('darkgray@0.5');
		$b5plot->SetShadow('darkgray@0.5');

		$b1plot->value->Show();
		$b2plot->value->Show();
		$b3plot->value->Show();
		$b4plot->value->Show();
		$b5plot->value->Show();

		$b1plot->SetFillGradient("navy@0.5","navy@0.5",GRAD_VER);
		$b2plot->SetFillGradient("red@0.5","red@0.5",GRAD_VER);
		$b3plot->SetFillGradient("green@0.5","green@0.5",GRAD_VER);
		$b4plot->SetFillGradient("blue@0.5","blue@0.5",GRAD_VER);
		$b5plot->SetFillGradient("yellow@0.5","yellow@0.5",GRAD_VER);

		$b1plot->value->SetAlign('center','center');
		$b2plot->value->SetAlign('center','center');
		$b3plot->value->SetAlign('center','center');
		$b4plot->value->SetAlign('center','center');
		$b5plot->value->SetAlign('center','center');

		$b1plot->value->SetFormat('%d');
		$b2plot->value->SetFormat('%d');
		$b3plot->value->SetFormat('%d');
		$b4plot->value->SetFormat('%d');
		$b5plot->value->SetFormat('%d');

		$b1plot->SetValuePos('center');
		$b2plot->SetValuePos('center');
		$b3plot->SetValuePos('center');
		$b4plot->SetValuePos('center');
		$b5plot->SetValuePos('center');

		//Membuat group
		$gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot,$b4plot,$b5plot));

		//memasukkan kedalam grafik
		$graph->Add($gbplot);

		$graph->title->Set("Active Student Statistic based on Parent Income");
		$graph->xaxis->title->Set("Income");
		$graph->yaxis->title->Set("Total Student");

		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);

		//Settings sumbu x and sumbu y
		$graph->yaxis->HideZeroLabel();
		$graph->ygrid->SetFill(true,'#dedede','#FFFFFF');

		//Menamplikan ke browser
		$graph->Stroke();
	}
} else {
	OpenDb();

	if ($iddasar=="1") {
		$xaxis="Religion";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Religion";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.agama, g.replid FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a, jbsumum.agama g WHERE $kondisi AND s.aktif = 1 AND g.agama = s.agama GROUP BY s.agama ORDER BY g.agama";
	} if ($iddasar=="2") {
		$xaxis="Past School";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Past School";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.asalsekolah FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = 1 GROUP BY s.asalsekolah";
	} if ($iddasar=="3"){
		$xaxis="Blood Type";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Blood Type";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.darah FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE  $kondisi AND s.aktif = 1 GROUP BY s.darah";
	} if ($iddasar=="4"){
		$xaxis="Gender";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Gender";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.kelamin FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE  $kondisi AND s.aktif = 1 GROUP BY s.kelamin";
	} if ($iddasar=="5"){
		$xaxis="Citizenship";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Citizenship";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.warga FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE  $kondisi AND s.aktif = 1 GROUP BY s.warga ORDER BY s.warga DESC";
	} if ($iddasar=="6"){
		$xaxis="Student Post Code";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Student Post Code";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.kodepossiswa FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = 1 GROUP BY s.kodepossiswa";
	} if ($iddasar=="7"){
		$xaxis="Conditions";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Student Conditions";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.kondisi FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE  $kondisi AND s.aktif = 1 GROUP BY s.kondisi";
	} if ($iddasar=="8"){
		$xaxis="Father Occupation Type";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Father Occupation";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.pekerjaanayah FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = 1 GROUP BY s.pekerjaanayah";
	} if ($iddasar=="9"){
		$xaxis="Mother Occupation Type";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Mother Occupation";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.pekerjaanibu FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = 1 GROUP BY s.pekerjaanibu";
	} if ($iddasar=="10"){
		$xaxis="Father Education Level";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Father Education";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.pendidikanayah FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = 1 GROUP BY s.pendidikanayah";
	} if ($iddasar=="11"){
		$xaxis="Mother Education Level";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Mother Education";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.pendidikanibu FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = 1 GROUP BY s.pendidikanibu";
	} if ($iddasar=="13"){
		$xaxis="Status Active";
		$yaxis="Student Candidate Sum";
		$titlenya="Student Candidate Statistic based on Status Active";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.aktif FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi GROUP BY s.aktif";
	} if ($iddasar=="14"){
		$xaxis="Student Status";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Student Status";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.status FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE  $kondisi AND s.aktif = 1 GROUP BY s.status";
	} if ($iddasar=="15"){
		$xaxis="Ethnicity";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Ethnicity";
		$query1 = "SELECT COUNT(s.replid) As Jum, s.suku FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE  $kondisi AND s.aktif = 1 GROUP BY s.suku";
	} if ($iddasar=="16"){
		$xaxis="Year of Birth";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Year of Birth";
		$query1 = "SELECT COUNT(s.replid) As Jum, YEAR(s.tgllahir) as thnlahir FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = 1 GROUP BY thnlahir";
	} if ($iddasar=="17"){
		$xaxis="Age";
		$yaxis="Student Candidate Sum";
		$titlenya="Active Student Candidate Statistic based on Age";
		$query1 = "SELECT COUNT(s.replid) As Jum, YEAR(now())-YEAR(s.tgllahir) As usia FROM jbsakad.calonsiswa s, jbsakad.prosespenerimaansiswa a WHERE $kondisi AND s.aktif = 1 GROUP BY usia";
	}

	$resultstatus = QueryDb($query1);
	$num = @mysql_num_rows($resultstatus);
	
	while ($rowstatus = @mysql_fetch_row($resultstatus)) {
		
		$data[] = $rowstatus[0];
		if ($iddasar == '4') {
			if ($rowstatus[1] == 'l') 
				$status[] = 'Male';
			else
				$status[] = 'Female';	
		} elseif ($iddasar == '13') {
			if ($rowstatus[1] == '1') 
				$status[] = 'Active';
			else
				$status[] = 'Inactive';	
		} else {
			if ($rowstatus[1] == NULL) 
				$status[] = 'No data.';
			else 
				$status[] = $rowstatus[1];
		}
	}

	
	$color = array('red@0.5','green@0.5','yellow@0.5','blue@0.5','orange@0.5','darkblue@0.5','gold@0.5','navy@0.5','gray@0.5','darkred@0.5','darkgreen@0.5', 'pink@0.5','black@0.5');
	if($num == 0) {
	  echo "<table width='100%' height='100%'><tr><td align='center' valign='middle'>
			<font size='2' face='verdana'>Failed to show Bar Chart<br> because student don't have any data<br> for Department <b>$_REQUEST[departemen]</b> and Graduates <b>$row[angkatan]</b></font></td></tr></table>";
	} else {
		if ($iddasar == "2" || $iddasar=="6" ) { 
			
			//Buat grafik
			$graph = new Graph(450,300,"auto");
			$graph->SetScale("textlin");
		
			//setting kanvas
			$graph->SetShadow();
			$graph->img->SetMargin(50,40,50,40);
			$graph->xaxis->SetTickLabels(array($xaxis));
			//$graph->xaxis->SetTickSide(SIDE_LEFT);
		
			//Create bar plots
			$plot = new BarPlot($data);
			$plot->SetFillColor($color);
		
			$plot->SetShadow('darkgray@0.5');
			//$plot->SetLegend($data);
			$plot->value->Show();
			//$plot->value->SetFont(FF_FONT1,FS_BOLD);
		
			$plot->value->SetFormat('%d');
			//$plot->value->SetAlign('center','center');
			
			//Create bar plots
			for ($i=0;$i<count($status);$i++) {
				$vardata = "plot".$i;
				$vardata = new BarPlot (array($data[$i]));
				$vardata->SetLegend($status[$i]);
				$vardata->SetShadow('darkgray@0.5');
				$vardata->value->Show();
				$vardata->value->SetAlign('center','center');
				$vardata->value->SetFormat('%d');
				$vardata->SetValuePos('center');
				$arraydata[$i] = $vardata;
				$vardata->SetFillColor($color[$i]);
			}
			
			$gbplot = new GroupBarPlot($arraydata);
			//memasukkan kedalam grafik
			$graph->Add($gbplot);
		
			$graph->title->Set($titlenya);
			$graph->xaxis->title->Set($xaxis);
			$graph->yaxis->title->Set($yaxis);
		
			$graph->title->SetFont(FF_FONT1,FS_BOLD);
			$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
			$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		
			//Settings sumbu x and sumbu y
			$graph->yaxis->HideZeroLabel();
			$graph->ygrid->SetFill(true,'#dedede','#FFFFFF');
		
			//Menamplikan ke browser
			$graph->Stroke();
		} else {
		
			//Buat grafik
			$graph = new Graph(450,300,"auto");
			$graph->SetScale("textlin");
		
			//setting kanvas
			$graph->SetShadow();
			$graph->img->SetMargin(50,40,50,40);
			$graph->xaxis->SetTickLabels($status);
			$graph->xaxis->SetTickSide(SIDE_LEFT);
		
			//Create bar plots
			$plot = new BarPlot($data);
			$plot->SetFillColor($color);
		
			$plot->SetShadow('darkgray@0.5');
			//$plot->SetLegend($data);
			$plot->value->Show();
			//$plot->value->SetFont(FF_FONT1,FS_BOLD);
		
			$plot->value->SetFormat('%d');
			//$plot->value->SetAlign('center','center');
		
			//memasukkan kedalam grafik
			$graph->Add($plot);
		
			$graph->title->Set($titlenya);
			$graph->xaxis->title->Set($xaxis);
			$graph->yaxis->title->Set($yaxis);
		
			$graph->title->SetFont(FF_FONT1,FS_BOLD);
			$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
			$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		
			//Settings sumbu x and sumbu y
			$graph->yaxis->HideZeroLabel();
			$graph->ygrid->SetFill(true,'#dedede','#FFFFFF');
		
			//Menamplikan ke browser
			$graph->Stroke();
		}
	}
}
?>