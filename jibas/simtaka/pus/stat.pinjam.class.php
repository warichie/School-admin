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
class CStat{
	function OnStart(){
		$this->Limit=10;
		if (isset($_REQUEST[Limit]))
			$this->Limit = $_REQUEST[Limit];
		$this->perpustakaan = $_REQUEST[perpustakaan];
		$this->BlnAwal = date('m');
		if (isset($_REQUEST[BlnAwal]))
			$this->BlnAwal = $_REQUEST[BlnAwal];
		$this->ThnAwal = date('Y');
		if (isset($_REQUEST[ThnAwal]))
			$this->ThnAwal = $_REQUEST[ThnAwal];
		$this->BlnAkhir = date('m');
		if (isset($_REQUEST[BlnAkhir]))
			$this->BlnAkhir = $_REQUEST[BlnAkhir];
		$this->ThnAkhir = date('Y');
		if (isset($_REQUEST[ThnAkhir]))
			$this->ThnAkhir = $_REQUEST[ThnAkhir];
	}
	function reload_page(){
		?>
		<script language='JavaScript'>
			document.location.href="pustaka.baru.php";
        </script>
		<?
	}
	function OnFinish(){
		?>
		<script language='JavaScript'>
			Tables('table', 1, 0);
		</script>
		<?
    }
	function GetPerpus(){
		if (SI_USER_LEVEL()==2){
			$sql = "SELECT replid,nama FROM perpustakaan WHERE replid='".SI_USER_IDPERPUS()."' ORDER BY nama";
		} else {
			$sql = "SELECT replid,nama FROM perpustakaan ORDER BY nama";
		}
		$result = QueryDb($sql);
		?>
		<link href="../sty/style.css" rel="stylesheet" type="text/css" />
		<select name="perpustakaan" id="perpustakaan" class="cmbfrm"  onchange="chg()">
		<?
		if (SI_USER_LEVEL()!=2){
			echo "<option value='-1' ".IntIsSelected('-1',$this->perpustakaan).">(All)</option>";
		}
		while ($row = @mysql_fetch_row($result)){
		if ($this->perpustakaan=="")
			$this->perpustakaan = $row[0];	
		?>
			<option value="<?=$row[0]?>" <?=IntIsSelected($row[0],$this->perpustakaan)?>><?=$row[1]?></option>
		<?
		}
		?>
		</select>
		<?
	}
    function Content(){
		global $G_START_YEAR;
		?>
		<link href="../sty/style.css" rel="stylesheet" type="text/css">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
           	  <div align="left">
                  <table width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                      <td width="20">Library </td>
                      <td width="200"><?=$this->GetPerpus()?></td>
                        <td width="66%" rowspan="3">
                        	<a href="javascript:show()"><img src="../img/view.png" width="48" height="48" border="0" /></a>                        </td>
                    </tr>
                    <tr>
                      <td>Month</td>
                      <td width="*">
                      		<?
							$yearnow = date(Y);
							?>
                            <table width="100%" border="0" cellspacing="0" cellpadding="1">
                              <tr>
                                <td>
                                	<?="<select name='BlnAwal' id='BlnAwal' class='cmbfrm' onchange='chg()'>";
                                    for ($i=1;$i<=12;$i++){
                                        if ($this->BlnAwal=="")
                                            $this->BlnAwal = $i;
                                        echo "<option value='".$i."' ".IntIsSelected($i,$this->BlnAwal).">".NamaBulan($i)."</option>";
                                    }
                                    echo "</select>";
									?>                                </td>
                                <td>
                                	<?="<select name='ThnAwal' id='ThnAwal' class='cmbfrm' onchange='chg()'>";
                                    for ($i=$G_START_YEAR;$i<=$yearnow;$i++){
                                        if ($this->ThnAwal=="")
                                            $this->ThnAwal = $i;
                                        echo "<option value='".$i."' ".IntIsSelected($i,$this->ThnAwal).">".$i."</option>";
                                    }
                                    echo "</select>";
									?>                                </td>
                                <td>
                                	<?="&nbsp;to&nbsp;";
									?>                                </td>
                                <td>
                                	<?="<select name='BlnAkhir' id='BlnAkhir' class='cmbfrm' onchange='chg()'>";
                                    for ($i=1;$i<=12;$i++){
                                        if ($this->BlnAkhir=="")
                                            $this->BlnAkhir = $i;
                                        echo "<option value='".$i."' ".IntIsSelected($i,$this->BlnAkhir).">".NamaBulan($i)."</option>";
                                    }
                                    echo "</select>";
									?>                                </td>
                                <td>
                                	<?="<select name='ThnAkhir' id='ThnAkhir' class='cmbfrm' onchange='chg()'>";
                                    for ($i=$G_START_YEAR;$i<=$yearnow;$i++){
                                        if ($this->ThnAkhir=="")
                                            $this->ThnAkhir = $i;
                                        echo "<option value='".$i."' ".IntIsSelected($i,$this->ThnAkhir).">".$i."</option>";
                                    }
                                    echo "</select>";
									?>                                </td>
                              </tr>
                            </table>						</td>
                    </tr>
                    <tr>
                      <td>Display</td>
                      <td>
                      	<?="<select name='Limit' id='Limit' class='cmbfrm' onchange='chg()'>";
						for ($i=5;$i<=20;$i+=5){
							if ($this->Limit=="")
								$this->Limit = $i;
							echo "<option value='".$i."' ".IntIsSelected($i,$this->Limit).">".$i."</option>";
						}
						echo "</select>";
						?>                      </td>
                    </tr>
                  </table>
              </div>            </td>
            <td valign="top">
            	<div id="title" align="right">
                    <font style="color:#FF9900; font-size:30px;"><strong>.:</strong></font>
                    <font style="font-size:18px; color:#999999">Most Borrowers Statistic</font><br />
                    <a href="pustaka.php" class="welc">Library</a><span class="welc"> > Most Borrowers Statistic</span><br /><br /><br />
                </div>
            </td>
          </tr>
          <tr>
            <td colspan="2" valign="top">
				<? if (isset($_REQUEST[ShowState])) {
					echo $this->ShowStatistik();
				} else {
					echo "&nbsp;";	
				} ?>
            </td>
          </tr>
        </table>
        <br />
        <?
	}
	function ShowStatistik(){
		$filter="";
		if ($this->perpustakaan!='-1')
			$filter=" AND d.perpustakaan=".$this->perpustakaan;
		$sql = "SELECT count(*) as num, p.idanggota FROM pinjam p, daftarpustaka d WHERE p.tglpinjam BETWEEN '".$this->ThnAwal."-".$this->BlnAwal."-01' AND '".$this->ThnAkhir."-".$this->BlnAkhir."-31' AND d.kodepustaka=p.kodepustaka $filter GROUP BY p.idanggota ORDER BY num DESC LIMIT ".$this->Limit;		
		$result = QueryDb($sql);
		$cnt=1;
		$key = $this->ThnAwal."-".$this->BlnAwal."-01,".$this->ThnAkhir."-".$this->BlnAkhir."-31";
		?>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
		  <? if (@mysql_num_rows($result)>0) { ?>
          <tr>
		    <td colspan="2" align="center" valign="top"><a href="javascript:Cetak()"><img src="../img/ico/print1.png" width="16" height="16" border="0" />&nbsp;Print</a></td>
	      </tr>
		  <tr>
			<td width="50%" align="center" valign="top">
            	<img src="<?="statimage.php?type=bar&key=$key&Limit=$this->Limit&krit=1&perpustakaan=$this->perpustakaan" ?>" />            </td>
			<td align="center" valign="top">
            	<img src="<?="statimage.php?type=pie&key=$key&Limit=$this->Limit&krit=1&perpustakaan=$this->perpustakaan" ?>" />            </td>
		  </tr>
          <? } ?>
		  <tr>
			<td colspan="2" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="350" valign="top">
						<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab">
						  <tr>
							<td height="25" align="center" class="header">#</td>
							<td height="25" align="center" class="header">Member</td>
							<td height="25" align="center" class="header">Sum</td>
							<td height="25" align="center" class="header">&nbsp;</td>
						  </tr>
                          <? if (@mysql_num_rows($result)>0) { ?>
						  <? while ($row = @mysql_fetch_row($result)) { ?>
						  <? 
							$this->idanggota = $row[1];
							$NamaAnggota = $this->GetMemberName();
						  ?>
						  <tr>
							<td height="20" align="center"><?=$cnt?></td>
							<td height="20">&nbsp;<?=$this->idanggota?> - <?=$NamaAnggota?></td>
							<td height="20" align="center"><?=$row[0]?></td>
							<td height="20" align="center">
                            	<a href="javascript:ViewList('<?=$this->idanggota?>')"><img src="../img/ico/lihat.png" width="16" height="16" border="0" /></a>                            </td>
						  </tr>
                          <? $cnt++; ?>
                          <? } ?>
						  <? } else { ?>
						  <tr>
							<td height="20" align="center" colspan="4" class="nodata">Data Not Found.</td>
						  </tr>	
						  <? } ?>
				    </table>					</td>
					<td valign="top">
                   	  <div id="ListInfo" style="padding-left:15px">                      </div>                    </td>
				  </tr>
				</table>			</td>
		  </tr>
		</table>
		<?
	}
	function GetMemberName(){
		$idanggota = $this->idanggota;
		$sql1 = "SELECT nama FROM ".get_db_name('akad').".siswa WHERE nis='$idanggota'";
		$result1 = QueryDb($sql1);
		if (@mysql_num_rows($result1)>0){
			$row1 = @mysql_fetch_array($result1);
			return $row1[nama];
		} else {
			$sql2 = "SELECT nama FROM ".get_db_name('sdm').".pegawai WHERE nip='$idanggota'";
			$result2 = QueryDb($sql2);
			if (@mysql_num_rows($result2)>0){
				$row2 = @mysql_fetch_array($result2);
				return $row2[nama];
			} else {
				$sql3 = "SELECT nama FROM anggota WHERE noregistrasi='$idanggota'";
				$result3 = QueryDb($sql3);
				if (@mysql_num_rows($result3)>0){
					$row3 = @mysql_fetch_array($result3);
					return $row3[nama];
				} else {
					return "No name.";
				}
			}
		}
	}
}
?>