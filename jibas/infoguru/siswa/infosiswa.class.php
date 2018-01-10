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
class CInfoSiswa
{
	private $nis;
	private $nama;
	private $reporttype;
    
    public function __construct()
    {
		if (isset($_REQUEST["nis"]))
		{
			$_SESSION["infosiswa.nis"] = $_REQUEST["nis"];
			$_SESSION["infosiswa.name"] = $this->getSiswaName($_REQUEST["nis"]);	
		}
		
		if (isset($_REQUEST['reporttype']))
		{
			$_SESSION['infosiswa.reporttype'] = $_REQUEST['reporttype'];
		}
		else
		{
			if (!isset($_SESSION['infosiswa.reporttype']))
				$_SESSION['infosiswa.reporttype'] = "PROFILE";
		}
		
		$this->nis = $_SESSION['infosiswa.nis'];
        $this->nama = $_SESSION['infosiswa.name'];
		$this->reporttype = $_SESSION['infosiswa.reporttype'];
    }
	
	public function ShowIdentity()
	{
		echo "<font style='font-size:17px; font-weight:bold; color:#666;'>";
        echo $this->nis;
        echo " - ";
        echo $this->nama;
        echo "</font>";
	}
    
    public function ShowReportComboBox()
    {
        echo "<br><br>";
        echo "Reports : ";
        echo "<select id='reporttype' name='reporttype' onchange='GetReportContent()'>";
        echo "<option value='PROFILE' " . StringIsSelected($this->reporttype, "PROFILE") . ">Personal Data</option>";
        echo "<option value='DAILYPRESENCE' " . StringIsSelected($this->reporttype, "DAILYPRESENCE") . ">Daily Presence</option>";
		echo "<option value='LESSONPRESENCE' " . StringIsSelected($this->reporttype, "LESSONPRESENCE") . ">Class Presence</option>";
        echo "<option value='POINT' " . StringIsSelected($this->reporttype, "POINT") . ">Point</option>";
		echo "<option value='REPORTCARD' " . StringIsSelected($this->reporttype, "REPORTCARD") . ">Report Card</option>";
		echo "<option value='LIBRARY' " . StringIsSelected($this->reporttype, "LIBRARY") . ">Library</option>";
		echo "<option value='STUDENTNOTES' " . StringIsSelected($this->reporttype, "STUDENTNOTES") . ">Student Notes</option>";
		echo "<option value='CLASSPRESENCENOTES' " . StringIsSelected($this->reporttype, "CLASSPRESENCENOTES") . ">Class Presence Notes</option>";
		echo "<option value='DAILYPRESENCENOTES' " . StringIsSelected($this->reporttype, "DAILYPRESENCENOTES") . ">Daily Presence Notes</option>";
        echo "</select>";
    }
    
    private function getSiswaName($nis)
	{
		$sql = "SELECT nama FROM siswa WHERE nis = '$nis'";
		$result = QueryDb($sql);
		$row = @mysql_fetch_array($result);
		return $row['nama'];
	}
	
	public function ShowReportContent()
	{
		if ($this->reporttype == "PROFILE")
			require_once("infosiswa.profile.php");
		elseif ($this->reporttype == "DAILYPRESENCE")
			require_once("infosiswa.presensiharian.php");
		elseif ($this->reporttype == "LESSONPRESENCE")
			require_once("infosiswa.presensipelajaran.php");
		elseif ($this->reporttype == "POINT")
			require_once("infosiswa.nilai.php");
		elseif ($this->reporttype == "REPORTCARD")
			require_once("infosiswa.rapor.php");
		elseif ($this->reporttype == "LIBRARY")
			require_once("infosiswa.perpustakaan.php");
		elseif ($this->reporttype == "STUDENTNOTES")
			require_once("infosiswa.catatansiswa.php");
		elseif ($this->reporttype == "CLASSPRESENCENOTES")
			require_once("infosiswa.catatanpelajaran.php");
		elseif ($this->reporttype == "DAILYPRESENCENOTES")
			require_once("infosiswa.catatanharian.php");			
	}
}