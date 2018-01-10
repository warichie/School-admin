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
require_once('../include/common.php');
OpenDb();
?>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:5px">
    
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding-right:4px">Class</td>
            <td class="td">
              <select id="CmbDepOrtu" name="CmbDepOrtu" class="Cmb" onchange="ChgCmbDepOrtu()">
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
			<td class="td">
            	<div id="DivCmbKelasOrtu">
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
				</div>
            </td>
			<td class="td">	
				<div class="Btn" onclick="ChgCmbKlsOrtu()" align="center" />View</div>
			</td>
			<td style="padding-right:4px" valign="top" class="tdTop">&nbsp;&nbsp;&nbsp;Search&nbsp;</td>
            <td class="td">
            	<input type="text" name="InpNISOrtu" id="InpNISOrtu" class="InputTxt" value='Student Registraion Number'  onfocus="InputHover('Student Registraion Number','InpNISOrtu','1')" onblur="InputHover('Student Registraion Number','InpNISOrtu','0')" style="color:#636363" size='10' />
            </td>
            <td class="td">
            	<input type="text" name="InpNamaOrtu" id="InpNamaOrtu" class="InputTxt"  value='Student Name'  onfocus="InputHover('Student Name','InpNamaOrtu','1')" onblur="InputHover('Student Name','InpNamaOrtu','0')" style="color:#636363" size='15' />  
            </td>
			<td align="center" valign="middle" class="td">
			<div class="Btn" onclick="SearchOrtu()" align="center" />Search</div>
			</td>
		  </tr>
		  <tr>
			<td colspan='8' align='center'>
				<table cellpadding='0' cellspacing='0' border='0'>
					<tr>
						<td>
							<div id="ErrInpNISOrtu" class="ErrMsg"></div><div id="ErrInpNamaOrtu" class="ErrMsg"></div>
						</td>
					</tr>
				</table>
			</td>
		  </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    <div id="TableOrtu">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab" id="TableOr">
      <tr class="Header">
        <td width='50'>#</td>
        <td width='100'>Student ID</td>
		<td>Name</td>
        <td>Mobile</td>
        <td><input type="checkbox" id="CheckAllOrtu"></td>
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
        <td class="td" align="center"><?=$row['nis']?></td>
		<td class="td" ><?=$row['nama']?></td>
        <td class="td"><?=$row['hportu']?></td>
        <td class="td" align="center">
		  <? 
		  if (strlen($row['hportu'])>0){
		  $nama = $row['namaayah'];
		  if (strlen($row['namaayah'])==0)
			  $nama = $row['nama'];
		  ?>
        <!--<span style="cursor:pointer" align="center" class="Link" onclick="InsertNewReceipt2('<?=$row['hportu']?>','<?=$nama?>','<?=$row['nama']?>')"  />Select</span>-->
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
	</div>
    </td>
  </tr>
</table>