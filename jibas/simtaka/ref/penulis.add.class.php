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
class CPenulisAdd{
	function OnStart(){
		if (isset($_REQUEST[simpan])){
			$sql = "SELECT kode FROM penulis WHERE kode='$_REQUEST[kode]' ";
			$result = QueryDb($sql);
			$num = @mysql_num_rows($result);
			if ($num>0){
				$this->exist();
			} else {
				$sql = "INSERT INTO penulis SET kode='".CQ($_REQUEST['kode'])."', nama='".CQ($_REQUEST['nama'])."', kontak='".CQ($_REQUEST['kontak'])."', biografi='".CQ($_REQUEST['biografi'])."', keterangan='".CQ($_REQUEST['keterangan'])."', gelardepan='".CQ($_REQUEST['gelardepan'])."', gelarbelakang='".CQ($_REQUEST['gelarbelakang'])."'";
				$result = QueryDb($sql);
				if ($result){
					$sql = "SELECT replid FROM penulis ORDER BY replid DESC LIMIT 1";
					$result = QueryDb($sql);
					$row = @mysql_fetch_row($result);
					
					$this->success($_REQUEST[flag],$row[0]);
				}
			}
		}
	}
	function exist(){
		?>
        <script language="javascript">
			alert('The Code has been used');
			document.location.href="penulis.add.php";
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
				parent.opener.getfresh('penulis','<?=$lastid?>');
				window.close();
			</script>
			<?
		}
		
	}
	function add(){
		?>
        <form name="addpenulis" onSubmit="return validate()">
		<input name="flag" type="hidden" class="inputtxt" id="flag" value="<?=$_REQUEST[flag]?>" >
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td colspan="2" align="left">
            	<font style="color:#FF9900; font-size:30px;"><strong>.:</strong></font>
        		<font style="font-size:18px; color:#999999">Add Author</font>            </td>
  		  </tr>
		  <tr>
            <td width="6%">&nbsp;<strong>Code</strong></td>
            <td width="94%"><input name="kode" type="text" class="inputtxt" id="kode" maxlength="3"></td>
          </tr>
		  <tr>
            <td>&nbsp;Title</td>
            <td><input name="gelardepan" type="text" class="inputtxt" id="gelardepan" size="30" maxlength="45" value="<?=$this->gelardepan?>"></td>
          </tr>
          <tr>
            <td>&nbsp;<strong>Name</strong></td>
            <td><input name="nama" type="text" class="inputtxt" id="nama" size="48" maxlength="100"></td>
          </tr>
		  <tr>
            <td>&nbsp;Academic&nbsp;Title</td>
            <td><input name="gelarbelakang" type="text" class="inputtxt" id="gelarbelakang" size="30" maxlength="45" value="<?=$this->gelarbelakang?>"></td>
          </tr>
          <tr>
            <td>&nbsp;Contact</td>
            <td><input name="kontak" type="text" class="inputtxt" id="kontak" size="48" maxlength="100"></td>
          </tr>
          <tr>
            <td>&nbsp;Bio</td>
            <td><textarea name="biografi" cols="45" rows="8" class="areatxt" id="biografi"></textarea></td>
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