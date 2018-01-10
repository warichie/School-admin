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
class PengumumanAjax{
	function OnStart(){
		//echo "<pre>";
		//print_r($_REQUEST);
		//echo "</pre>";
		$op = $_REQUEST['op'];
		//echo $op;
		//Select Pegawai
		$bag = $_REQUEST['Section'];
		//echo $bag;
		
		//Search
		$Employee ID 	= $_REQUEST['Employee ID'];
		$Nama 	= $_REQUEST['Nama'];
		
		//Select Student
		$dep 	= $_REQUEST['dep'];
		$thn 	= $_REQUEST['thn'];
		$tkt 	= $_REQUEST['tkt'];
		$kls 	= $_REQUEST['kls'];
		
		//Cari Student
		$Student ID 	= $_REQUEST['Student ID'];
		
		//Source
		$Source = $_REQUEST['Source'];
		$this->bag = $bag;
		$this->Employee ID = $Employee ID;
		$this->Name = $Nama;
		$this->dep = $dep;
		$this->thn = $thn;
		$this->tkt = $tkt;
		$this->kls = $kls;
		$this->Student ID = $Student ID;
		$this->Source = $Source;
		
		if ($op=='GetTablePegawai')
			$this->GetTablePegawai();
		if ($op=='GetTableSiswa')
			$this->GetTableSiswa();
		if ($op=='GetTableOrtu')
			$this->GetTableOrtu();
		if ($op=='GetFilterSiswa')
			$this->GetFilterSiswa();
		if ($op=='GetFilterOrtu')
			$this->GetFilterOrtu();

		if ($op=='GetPegawai')
			$this->GetPegawai();			
	}
	function GetTableSiswa(){
		global $db_name_akad;
		global $db_name_sdm;
		global $db_name_fina;
		global $db_name_user;
		$Nama = $this->Name;
		$kls = $this->kls;
		$Student ID = $this->Student ID;
		$Source = $this->Source;
		?>
		<link href="style/style.css" rel="stylesheet" type="text/css" />
		
		<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab" id="TableSis">
		  <tr class="Header">
			<td width='50'>#</td>
			<td width="100">Student ID</td>
            <td>Name</td>
			<td width="100">Student Mobile Number</td>
			<td><input type="checkbox" id="CheckAllSiswa"></td>
		  </tr>
		  <?
			if ($Source=='Select'){
				$sql = "SELECT nis, nama, hpsiswa, pinsiswa FROM $db_name_akad.siswa WHERE aktif=1 AND idkelas='$kls' ";
			} else {
				$sql = "SELECT nis, nama, hpsiswa, pinsiswa FROM $db_name_akad.siswa WHERE replid>0 ";
				if ($Student ID!="" && $Student ID!="Student ID")
					$sql .= " AND nis LIKE '%$Student ID%'";
				if ($Nama!="" && $Nama!="Name Student")
					$sql .= " AND nama LIKE '%$Nama%'";	
			}
			$sql .= "  ORDER BY nama";	
			$res = QueryDb($sql);
			$num = @mysql_num_rows($res);
			if ($num>0){
				$cnt=1;
				while ($row = @mysql_fetch_array($res)){
		  ?>
		  <tr>
			<td align="center" class="td"><?=$cnt?></td>
			<td class="td" align="center"><?=$row['nis']?></td>
            <td class="td" align="left"><?=$row['nama']?></td>
			<td class="td" align="left"><?=$row['hpsiswa']?></td>
			<td class="td" align="center">
			<? if (strlen($row['hpsiswa'])>0){ ?>
			<!--span style="cursor:pointer" align="center" class="Link" onclick="InsertNewReceipt2('<?=$row['hpsiswa']?>','<?=$row['nama']?>','<?=$row['nis']?>')"  />Select</span-->
			<input type="checkbox" class="checkboxsiswa" hp="<?=$row['hpsiswa']?>" nama="<?=$row['nama']?>" nip="<?=$row['nis']?>" pin="<?=$row['pinsiswa']?>">
			<? } ?>
			</td>
		  </tr>
		  <?
				$cnt++;
				}
			} else {
			?>
		  <tr>
			<td colspan="5" class="Ket" align="center">Data Not Found.</td>
		  </tr>
		  <?
			}
				?>
		</table>
        <?
	}
	
	function GetTableOrtu(){
		global $db_name_akad;
		global $db_name_sdm;
		global $db_name_fina;
		global $db_name_user;
		$Nama = $this->Name;
		$kls = $this->kls;
		$Student ID = $this->Student ID;
		$Source = $this->Source;
		?>
		<link href="style/style.css" rel="stylesheet" type="text/css" />
		
		<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab" id="TableOr">
		  <tr class="Header">
			<td width='50'>#</td>
			<td width='100'>Student ID</td>
			<td>Name</td>
			<td>Parent Mobile Number</td>
			<td><input type="checkbox" id="CheckAllOrtu"></td>
		  </tr>
		  <?
			if ($Source=='Select'){
				$sql = "SELECT * FROM $db_name_akad.siswa WHERE aktif=1 AND idkelas='$kls'";
			} else {
				$sql = "SELECT * FROM $db_name_akad.siswa WHERE replid>0";
				if ($Student ID!="" && $Student ID!="Student ID")
					$sql .= " AND nis LIKE '%$Student ID%'";
				if ($Nama!="" && $Nama!="Name Student")
					$sql .= " AND nama LIKE '%$Nama%'";	
			}
			$sql .= " ORDER BY nama";
			//echo $sql;
			$res = QueryDb($sql);
			$num = @mysql_num_rows($res);
			if ($num>0){
				$cnt=1;
				while ($row = @mysql_fetch_array($res)){
		  ?>
		  <tr>
			<td align="center" class="td"><?=$cnt?></td>
			<td class="td" align='center'><?=$row['nis']?></td>
			<td class="td"><?=$row['nama']?></td>
			<td class="td"><?=$row['hportu']?></td>
			<td class="td" align="center">
			  <? 
			  if (strlen($row['hportu'])>0){ 
			  $nama = $row['namaayah'];
			  if (strlen($row['namaayah'])==0)
				  $nama = $row['nama'];
			  ?>
			<!--span style="cursor:pointer" align="center" class="Link" onclick="InsertNewReceipt2('<?=$row['hportu']?>','<?=$nama?>','<?=$row['nis']?>')"  />Select</span-->
			<input type="checkbox" class="checkboxortu" hp="<?=$row['hportu']?>" nama="<?=$nama?>" nip="<?=$row['nis']?>" pinayah="<?=$row['pinortu']?>" pinibu="<?=$row['pinortuibu']?>">
			<? } ?>
			</td>
		  </tr>
		  <?
				$cnt++;
				}
			} else {
			?>
		  <tr>
			<td colspan="5" class="Ket" align="center">Data Not Found.</td>
		  </tr>
		  <?
			}
				?>
		</table>
        <?
	}

	function GetFilterSiswa(){
		global $db_name_akad;
		global $db_name_sdm;
		global $db_name_fina;
		global $db_name_user;
		
		$dep = $this->dep;
		
		?>
				<select id="CmbKlsSis" name="CmbKlsSis" class="Cmb" onchange="ChgCmbKlsSis()">
					<?
					$sql = "SELECT k.replid,k.kelas FROM $db_name_akad.kelas k, $db_name_akad.tingkat ti, $db_name_akad.tahunajaran ta ".
						   "WHERE k.aktif=1 AND ta.aktif=1 AND ti.aktif=1 AND k.idtahunajaran=ta.replid AND k.idtingkat=ti.replid ".
						   "AND ta.departemen='$dep' AND ti.departemen='$dep' ORDER BY k.kelas"; 
					$res = QueryDb($sql);
					while ($row = @mysql_fetch_row($res)){
						if ($kls=="")
							$kls=$row[0];
					?>
				<option value="<?=$row[0]?>" <?=StringIsSelected($row[0],$kls)?>><?=$row[1]?></option>
					<?
					}
					?>
				</select>
        <?
	}

	function GetFilterOrtu(){
		global $db_name_akad;
		global $db_name_sdm;
		global $db_name_fina;
		global $db_name_user;
		
		$dep = $this->dep;
		
		?>
				<select id="CmbKlsOrtu" name="CmbKlsOrtu" class="Cmb" onchange="ChgCmbKlsOrtu()">
					<?
					$sql = "SELECT k.replid,k.kelas FROM $db_name_akad.kelas k, $db_name_akad.tingkat ti, $db_name_akad.tahunajaran ta ".
						   "WHERE k.aktif=1 AND ta.aktif=1 AND ti.aktif=1 AND k.idtahunajaran=ta.replid AND k.idtingkat=ti.replid ".
						   "AND ta.departemen='$dep' AND ti.departemen='$dep' ORDER BY k.kelas"; 
					$res = QueryDb($sql);
					while ($row = @mysql_fetch_row($res)){
						if ($kls=="")
							$kls=$row[0];
					?>
				<option value="<?=$row[0]?>" <?=StringIsSelected($row[0],$kls)?>><?=$row[1]?></option>
					<?
					}
					?>
				</select>
        <?
	}
	
	function GetPegawai(){
		global $db_name_akad;
		global $db_name_sdm;
		global $db_name_fina;
		global $db_name_user;
		
		$bag = $this->bag;
		$Employee ID = $this->Employee ID;
		$Nama = $this->Name;
		$Source = $this->Source;
		if ($bag=="")
			$bag='-1';
		if ($Source=='' || $Source=='Select'){
			$DispA = "style='display:block'";
			$DispB = "style='display:none'";
		} elseif ($Source=='Search'){
			$DispA = "style='display:none'";
			$DispB = "style='display:block'";
		}
		?>
		<link href="style/style.css" rel="stylesheet" type="text/css" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td style="padding:5px">
			<div style="width:230px; background-color:#CCC; height:18px; font-weight:bold; padding-top:4px; cursor:default; border:1px #666 solid" align="center" onclick="document.getElementById('PegSelect').style.display='block';document.getElementById('PegSearch').style.display='none';">Select Employee	</div>
			<div id="PegSelect" <?=$DispA?>>
				<table border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td style="padding-right:4px">Section</td>
					<td class="td">
					  <select id="CmbBagPeg" name="CmbBagPeg" class="Cmb" onchange="ChgCmbBagPeg(this.value)">
						<option value="-1" <?=StringIsSelected('-1',$bag)?>>- All Sections -</option>
						<?
							$sql = "SELECT bagian FROM $db_name_sdm.bagianpegawai";
							$res = QueryDb($sql);
							while ($row = @mysql_fetch_row($res)){
							?>
						<option value="<?=$row[0]?>" <?=StringIsSelected($row[0],$bag)?>><?=$row[0]?></option>
						<?
							}
							?>
						</select>
					  </td>
					</tr>
				</table>
			</div>
			<div style="width:230px; background-color:#CCC; height:18px; font-weight:bold; padding-top:4px; cursor:default; border:1px #666 solid; margin-top:3px" align="center" onclick="document.getElementById('PegSearch').style.display='block';document.getElementById('PegSelect').style.display='none';document.getElementById('InpNIPPeg').focus()">Search Employee</div>
			<div id="PegSearch" <?=$DispB?>>
				<table border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td style="padding-right:4px" valign="top" class="tdTop">Employee ID</td>
					<td class="td">
						<input type="text" name="InpNIPPeg" id="InpNIPPeg" class="InputTxt" value="<?=$Employee ID?>" />
						<div id="ErrInpNIPPeg" class="ErrMsg"></div>  
					</td>
					<td rowspan="2" align="center" valign="middle" class="td"><img src="images/ico/lihat.png" width="20" height="20" style="cursor:pointer" onclick="SearchPeg()" /></td>
				  </tr>
				  <tr>
					<td style="padding-right:4px" valign="top" class="tdTop">Name</td>
					<td class="td">
						<input type="text" name="InpNamaPeg" id="InpNamaPeg" class="InputTxt" value="<?=$Nama?>" />  
						<div id="ErrInpNamaPeg" class="ErrMsg"></div>
					</td>
				  </tr>
				</table>
			</div>
			</td>
		  </tr>
		  <tr>
			<td>
			<div id="TablePegawai">
			<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab">
			  <tr class="Header">
				<td width='50'>#</td>
				<td width='100'>Employee ID</td>
				<td>Name</td>
				<td>Mobile</td>
				<td><input type="checkbox" id="CheckAllPegawai"></td>
			  </tr>
			  <?
				if ($bag=='-1')
					$sql = "SELECT * FROM $db_name_sdm.pegawai ORDER BY nama";
				else
					$sql = "SELECT * FROM $db_name_sdm.pegawai WHERE bagian='$bag' ORDER BY nama";
				$res = QueryDb($sql);
				$num = @mysql_num_rows($res);
				if ($num>0){
					$cnt=1;
					while ($row = @mysql_fetch_array($res)){
			  ?>
			  <tr>
				<td align="center" class="td"><?=$cnt?></td>
				<td class="td" align='center'><?=$row['nip']?></td>
				<td class="td"><?=$row['nama']?></td>
				<td class="td"><?=$row['handphone']?></td>
				<td class="td" align="center">
				<? if (strlen($row['handphone'])>0){ ?>
				<input type="checkbox" class="checkboxpegawai" hp="<?=$row['handphone']?>" nama="<?=$row['nama']?>" nip="<?=$row['nip']?>"  pin="<?=$row['pinpegawai']?>">
				<!--span style="cursor:pointer" class="Link" onclick="InsertNewReceipt('<?=$row['handphone']?>','<?=$row['nama']?>','<?=$row['nip']?>')" align="center" />Select</span-->
				<? } ?>
				</td>
			  </tr>
			  <?
					$cnt++;
					}
				} else {
				?>
			  <tr>
				<td colspan="4" class="Ket" align="center">Data Not Found.</td>
			  </tr>
			  <?
				}
					?>
			</table>
			</div>
			</td>
		  </tr>
		</table>
        <?
	}
	
	function GetSiswa(){
		global $db_name_akad;
		global $db_name_sdm;
		global $db_name_fina;
		global $db_name_user;
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding:5px">
            <div style="width:400px; background-color:#CCC; height:18px; font-weight:bold; padding-top:4px; cursor:default; border:1px #666 solid" align="center" onclick="document.getElementById('SisSelect').style.display='block';document.getElementById('SisSearch').style.display='none';">Select Student	</div>
            <div id="SisSelect" <?=$DispA?>>
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="padding-right:4px">Department</td>
                    <td class="td">
                      <select id="CmbDepSis" name="CmbDepSis" class="Cmb" onchange="ChgCmbDepSis()">
                            <?
                            $sql = "SELECT departemen FROM $db_name_akad.departemen WHERE aktif=1 ORDER BY urutan";
                            $res = QueryDb($sql);
                            while ($row = @mysql_fetch_row($res)){
                            if ($dep=="")
                                $dep=$row[0];
                            ?>
                        <option value="<?=$row[0]?>" <?=StringIsSelected($row[0],$dep)?>><?=$row[0]?></option>
                            <?
                            }
                            ?>
                        </select>
                      </td>
                    <td class="td">Grade</td>
                    <td class="td">
                        <select id="CmbTktSis" name="CmbTktSis" class="Cmb" onchange="ChgCmbTktThnSis()">
                            <?
                            $sql = "SELECT replid,tingkat FROM $db_name_akad.tingkat WHERE aktif=1 AND departemen='$dep'";
                            $res = QueryDb($sql);
                            while ($row = @mysql_fetch_row($res)){
                            if ($tkt=="")
                                $tkt=$row[0];
                            ?>
                        <option value="<?=$row[0]?>" <?=StringIsSelected($row[0],$tkt)?>><?=$row[1]?></option>
                            <?
                            }
                            ?>
                        </select>
                    </td>
                    </tr>
                  <tr>
                    <td style="padding-right:4px">Year</td>
                    <td class="td">
                        <select id="CmbThnSis" name="CmbThnSis" class="Cmb" onchange="ChgCmbTktThnSis()">
                            <?
                            $sql = "SELECT replid,tahunajaran FROM $db_name_akad.tahunajaran WHERE aktif=1 AND departemen='$dep'";
                            $res = QueryDb($sql);
                            while ($row = @mysql_fetch_row($res)){
                            if ($thn=="")
                                $thn=$row[0];
                            ?>
                        <option value="<?=$row[0]?>" <?=StringIsSelected($row[0],$thn)?>><?=$row[1]?></option>
                            <?
                            }
                            ?>
                        </select>
                    </td>
                    <td class="td">Class</td>
                    <td class="td">
                        <select id="CmbKlsSis" name="CmbKlsSis" class="Cmb" onchange="ChgCmbKlsSis()">
                            <?
                            $sql = "SELECT replid,kelas FROM $db_name_akad.kelas WHERE aktif=1 AND idtahunajaran='$thn' AND idtingkat='$tkt' ";
                            $res = QueryDb($sql);
                            while ($row = @mysql_fetch_row($res)){
                            if ($kls=="")
                                $kls=$row[0];
                            ?>
                        <option value="<?=$row[0]?>" <?=StringIsSelected($row[0],$kls)?>><?=$row[1]?></option>
                            <?
                            }
                            ?>
                        </select>
                    </td>
                  </tr>
                </table>
            </div>
            <div style="width:400px; background-color:#CCC; height:18px; font-weight:bold; padding-top:4px; cursor:default; border:1px #666 solid; margin-top:3px" align="center" onclick="document.getElementById('SisSearch').style.display='block';document.getElementById('SisSelect').style.display='none';">Search Student</div>
            <div id="SisSearch" style="display:none">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="padding-right:4px" valign="top" class="tdTop">Student ID</td>
                    <td class="td">
                        <input type="text" name="InpNISSis" id="InpNISSis" class="InputTxt" value="<?=$nis?>" />
                        <div id="ErrInpNISSis" class="ErrMsg"></div>  
                    </td>
                    <td rowspan="2" align="center" valign="middle" class="td"><img src="images/ico/lihat.png" width="20" height="20" style="cursor:pointer" onclick="SearchSis()" /></td>
                  </tr>
                  <tr>
                    <td style="padding-right:4px" valign="top" class="tdTop">Name</td>
                    <td class="td">
                        <input type="text" name="InpNamaSis" id="InpNamaSis" class="InputTxt" value="<?=$Nama?>" />  
                        <div id="ErrInpNamaSis" class="ErrMsg"></div>
                    </td>
                  </tr>
                </table>
            </div>
            </td>
          </tr>
          <tr>
            <td>
            <div id="TableSiswa">
            <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab">
              <tr class="Header">
                <td width='50'>#</td>
                <td width='100'>Student ID</td>
				<td>Name</td>
                <td>Mobile</td>
                <td>&nbsp;</td>
              </tr>
              <?
                $sql = "SELECT * FROM $db_name_akad.siswa WHERE aktif=1 AND idkelas='$kls' ORDER BY nama";
                $res = QueryDb($sql);
                $num = @mysql_num_rows($res);
                if ($num>0){
                    $cnt=1;
                    while ($row = @mysql_fetch_array($res)){
              ?>
              <tr>
                <td align="center" class="td"><?=$cnt?></td>
                <td class="td" align='center'><?=$row['nis']?></td>
				<td class="td"><?=$row['nama']?></td>
                <td class="td"><?=$row['hpsiswa']?></td>
                <td class="td" align="center">
                <? if (strlen($row['hpsiswa'])>0){ ?>
                <span style="cursor:pointer" align="center" class="Link" onclick="InsertNewReceipt2('<?=$row['hpsiswa']?>_<?=$row['hportu']?>','<?=$row['nama']?>_<?=$row['namaayah']?>','<?=$row['nis']?>')"  />Select</span>
                <? } ?>
                </td>
              </tr>
              <?
                    $cnt++;
                    }
                } else {
                ?>
              <tr>
                <td colspan="5" class="Ket" align="center">Data Not Found.</td>
              </tr>
              <?
                }
                    ?>
            </table>
            </div>
            </td>
          </tr>
        </table>
    <?
	}
	
	function GetTablePegawai(){
		global $db_name_akad;
		global $db_name_sdm;
		global $db_name_fina;
		global $db_name_user;		
		
		$bag = $this->bag;
		$Employee ID = $this->Employee ID;
		$Nama = $this->Name;
		$Source = $this->Source;
		if ($bag=="")
			$bag='-1';
		?>
		<link href="style/style.css" rel="stylesheet" type="text/css" />
		<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab" id="TablePeg">
		  <tr class="Header">
			<td width='50'>#</td>
			<td width='100'>Employee ID</td>
			<td>Name</td>
			<td>Mobile</td>
			<td><input type="checkbox" id="CheckAllPegawai"></td>
		  </tr>
		  <?
			if ($Source=='Select'){
				if ($bag=='-1')
					$sql = "SELECT * FROM $db_name_sdm.pegawai ORDER BY nama";
				else
					$sql = "SELECT * FROM $db_name_sdm.pegawai WHERE bagian='$bag' ORDER BY nama";
			} else {
				$sql = "SELECT * FROM $db_name_sdm.pegawai WHERE replid>0";
				if ($Employee ID!="" && $Employee ID!="Employee ID")
					$sql .= " AND nip LIKE '%$Employee ID%'";
				if ($Nama!="" && $Nama!="Employee Name")
					$sql .= " AND nama LIKE '%$Nama%'";	
			}
			//echo $sql;
			$res = QueryDb($sql);
			$num = @mysql_num_rows($res);
			if ($num>0){
				$cnt=1;
				while ($row = @mysql_fetch_array($res)){
		  ?>
		  <tr>
			<td align="center" class="td"><?=$cnt?></td>
			<td class="td" align='center'><?=$row['nip']?></td>
			<td class="td"><?=$row['nama']?></td>
			<td class="td"><?=$row['handphone']?></td>
			<td class="td" align="center">
			<? if (strlen($row['handphone'])>0){ ?>
			<!--span style="cursor:pointer" class="Link" onclick="InsertNewReceipt('<?=$row['handphone']?>','<?=$row['nama']?>','<?=$row['nip']?>')" align="center"  />Select</span-->
			<input type="checkbox" class="checkboxpegawai" hp="<?=$row['handphone']?>" nama="<?=$row['nama']?>" nip="<?=$row['nip']?>" pin="<?=$row['pinpegawai']?>">
			<? } ?>
			</td>
		  </tr>
		  <?
				$cnt++;
				}
			} else {
			?>
		  <tr>
			<td colspan="4" class="Ket" align="center">Data Not Found.</td>
		  </tr>
		  <?
			}
				?>
		</table>
		<?
	}
}
?>