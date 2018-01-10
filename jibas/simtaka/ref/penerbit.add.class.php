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
class CPenerbitAdd{
	function OnStart(){
		if (isset($_REQUEST[simpan])){
			$sql = "SELECT kode FROM penerbit WHERE kode='$_REQUEST[kode]' ";
			$result = QueryDb($sql);
			$num = @mysql_num_rows($result);
			if ($num>0){
				$this->exist();
			} else {
				$sql = "INSERT INTO penerbit SET kode='".CQ($_REQUEST['kode'])."', nama='".CQ($_REQUEST['nama'])."', alamat='".CQ($_REQUEST['alamat'])."', telpon='".CQ($_REQUEST['telpon'])."', email='".CQ($_REQUEST['email'])."', fax='".CQ($_REQUEST['fax'])."', website='".CQ($_REQUEST['website'])."', kontak='".CQ($_REQUEST['kontak'])."', keterangan='".CQ($_REQUEST['keterangan'])."'";
				$result = QueryDb($sql);
				if ($result){
					$sql = "SELECT replid FROM penerbit ORDER BY replid DESC LIMIT 1";
					$result = QueryDb($sql);
					$row = @mysql_fetch_row($result);
					//echo $row[0];
					$this->success($_REQUEST[flag],$row[0]);	
				}
			}
		}
	}
	function exist(){
		?>
        <script language="javascript">
			alert('Code has been used');
			document.location.href="penerbit.add.php";
		</script>
        <?
	}
	function success($flag,$lastid){
		if ($flag=='' || $flag=='0') {
			?>
			<script language="javascript">
				parent.opener.getfresh();
				window.close();
			</script>
			<?
		} else {
			?>
			<script language="javascript">
				parent.opener.getfresh('penerbit','<?=$lastid?>');
				window.close();
			</script>
			<?
		}
	}
	function add(){
		?>
        <form name="addpenerbit" onSubmit="return validate()">
		<input name="flag" type="hidden" class="inputtxt" id="flag" value="<?=$_REQUEST[flag]?>" >
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td colspan="2" align="left">
            	<font style="color:#FF9900; font-size:30px;"><strong>.:</strong></font>
        		<font style="font-size:18px; color:#999999">Add Publisher</font>            </td>
  		  </tr>
		  <tr>
            <td width="6%">&nbsp;<strong>Code</strong></td>
            <td width="94%"><input name="kode" type="text" class="inputtxt" id="kode" maxlength="3"></td>
          </tr>
          <tr>
            <td>&nbsp;<strong>Name</strong></td>
            <td><input name="nama" type="text" class="inputtxt" id="nama" size="48" maxlength="100"></td>
          </tr>
          <tr>
            <td>&nbsp;Address</td>
            <td><textarea name="alamat" cols="45" rows="5" class="areatxt" id="alamat"></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;Phone</td>
            <td><input name="telpon" type="text" class="inputtxt" id="telpon" size="48" maxlength="100"></td>
          </tr>
          <tr>
            <td>&nbsp;Email</td>
            <td><input name="email" type="text" class="inputtxt" id="email" size="48" maxlength="100"></td>
          </tr>
          <tr>
            <td>&nbsp;Fax</td>
            <td><input name="fax" type="text" class="inputtxt" id="fax" size="48" maxlength="100"></td>
          </tr>
          <tr>
            <td>&nbsp;Website</td>
            <td><input name="website" type="text" class="inputtxt" id="website" size="48" maxlength="100"></td>
          </tr>
          <tr>
            <td>&nbsp;Contact</td>
            <td><input name="kontak" type="text" class="inputtxt" id="kontak" size="48" maxlength="100"></td>
          </tr>
          <tr>
            <td>&nbsp;Info</td>
            <td><textarea name="keterangan" cols="45" rows="5" class="areatxt" id="keterangan"></textarea></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" class="cmbfrm2" name="simpan" value="Save" >&nbsp;<input type="button" class="cmbfrm2" name="batal" value="Cancel" onClick="window.close()" ></td>
          </tr>
        </table>
		</form>
		<?
	}
}
?>