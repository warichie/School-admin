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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('departemen.php');

OpenDb();
$flag = 0;
if (isset($_REQUEST['flag']))
	$flag = (int)$_REQUEST['flag'];

$departemen = $_REQUEST['departemen'];
/*$sql_tambahdep = "AND pel.departemen = '$departemen' "; 	
if (isset($_REQUEST['departemen']) == -1){
	$sql_tambahdep = "";
}*/

$pelajaran = $_REQUEST['pelajaran'];
//echo 'pelajaran '.strlen($pelajaran).' pelajaran '.$pelajaran;
//$sql_tambahpel ="AND pel.replid=$pelajaran "; 


//if (isset($_REQUEST['pelajaran']) == -1 || strlen($pelajaran) == 0){	
//	$sql_tambahpel ="";
//} 


?>

<table border="0" width="100%" cellpadding="2" cellspacing="2" align="center">
<tr>
    <td colspan="2">
    <input type="hidden" name="flag" id="flag" value="<?=$flag ?>" />    </td>
</tr>     
<tr>
    <td width="9%"><font color="#000000"><strong>Department </strong></font><br /></td>
    <td width="91%"><select name="depart" id="depart" onchange="change_departemen()" style="width:80px;" onkeypress="return focusNext('pelajaran', event)">
      <!--<option value="-1" <? if ($departemen=="-1") echo "selected"; ?>>(All)</option>-->
      <option value="-1" <?=StringIsSelected("-1", $departemen) ?>>(All)</option>
      <?	$dep = getDepartemen(SI_USER_ACCESS());    
		foreach($dep as $value) {
		if ($departemen == "")
			$departemen = $value; ?>
      <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> >
      <?=$value ?>
      </option>
      <?	} ?>
    </select>
      <? if ($departemen == -1)  {
        $disable = 'disabled="disabled"';
        $sql_tambahdep = "";					
    } else	{
        $disable = "";
        $sql_tambahdep = "AND pel.departemen = '$departemen' "; 					
    } 
    
    ?></td>
</tr>
<tr>
  <td><font color="#000000"><strong>Class Subject</strong></font></td>
  <td><select name="pelajaran" id="pelajaran" onchange="get_guru()" <?=$disable?> style="width:250px;">
    <option value="-1" <? if ($pelajaran=="-1") echo "selected"; ?>>(All Class Subject)</option>
    <?
        $sql_pel="SELECT * FROM jbsakad.pelajaran pel WHERE pel.aktif=1 $sql_tambahdep ORDER BY pel.nama";
    
        $result_pel=QueryDb($sql_pel);
        while ($row_pel=@mysql_fetch_array($result_pel)){
            
        ?>
    <option value="<?=$row_pel[replid]?>" <?=StringIsSelected($pelajaran,$row_pel[replid])?>>
      <?=$row_pel[nama]?>
      </option>
    <?
        }
        ?>
  </select>
    <? if ($pelajaran == -1 || strlen($pelajaran) == 0)  {
            $sql_tambahpel = "";					
        } else	{			
            $sql_tambahpel = "AND pel.replid = $pelajaran "; 					
        } 
    ?></td>
</tr>
<tr>
	<td colspan="2" align="center">
        <br />
        <? 
        OpenDb();
		$sql = "SELECT p.nip, p.nama, pel.replid, pel.departemen FROM jbssdm.pegawai p, jbsakad.guru g, jbsakad.pelajaran pel, jbsakad.departemen d WHERE g.nip=p.nip AND g.idpelajaran=pel.replid AND pel.departemen = d.departemen AND g.aktif = 1 $sql_tambahpel $sql_tambahdep GROUP BY p.nip ORDER BY p.nama";
		
		$result = QueryDb($sql);
		if (@mysql_num_rows($result)>0){
			
		?>
		
		<table width="100%" align="center" cellpadding="2" cellspacing="0" class="tab" border="1" id="table" bordercolor="#000000">
		<tr height="30">
			<td class="header" width="7%" align="center">#</td>
    		<td class="header" width="15%" align="center">Employee ID</td>
            <td class="header" align="center" >Name</td>
            <? if ($sql_tambahdep == "") { ?>
            <td class="header" align="center" >Department</td>          
            <? } ?>
    		<td class="header" width="10%" align="center">&nbsp;</td>
		</tr>
		<?
		
		$cnt = 0;
		while($row = @mysql_fetch_row($result)) { 
			if ($sql_tambahdep == "") {
				unset($depart);
				unset($ajar);
				//$sql1 = "SELECT d.departemen, pel.departemen FROM pelajaran pel, departemen d, guru g WHERE g.idpelajaran = pel.replid AND g.nip = '$row[0]' AND pel.departemen = d.departemen GROUP BY pel.departemen ORDER BY d.urutan";					
				$sql1 = "SELECT pel.departemen, pel.replid FROM pelajaran pel, departemen d, guru g WHERE g.idpelajaran = pel.replid AND g.nip = '$row[0]' AND pel.departemen = d.departemen GROUP BY pel.departemen ORDER BY d.urutan, pel.nama";
				$result1 = QueryDb($sql1);
				$i = 0;
				while ($row1=mysql_fetch_array($result1)) {									
					$depart[$i] = $row1['departemen'];
					$ajar[$i] =$row1['replid']; 	
					$i++;
				}
			} else {
				$depart[0] = $departemen;
			}
			
		?>
		<tr height="25" onClick="pilih('<?=$row[0]?>','<?=$row[1]?>','<?=$depart[0]?>','<?=$ajar[0]?>')" style="cursor:pointer">
			<td align="center"><?=++$cnt ?></td>              
    		<td align="center"><?=$row[0] ?></td>
    		<td align="left"><?=$row[1] ?></td>
         <? if ($sql_tambahdep == "") { 				
				
			?>
            <td align="center"><?=implode(", ",$depart) ?></td>			
            <? } ?>
    		<td align="center">
    		<input type="button" name="pilih" class="but" id="pilih" value="Select" onclick="pilih('<?=$row[0]?>', '<?=$row[1]?>', '<?=$depart[0]?>', '<?=$ajar[0]?>')" />    	   	</td>
		</tr>
		<? 	} ?> 
        </table>
     
	<? } else { ?>    		
        <table width="100%" align="center" cellpadding="2" cellspacing="0" border="0" id="table">
		<tr height="30" align="center">
        	<td>
        <br /><br />	
		<font size = "2" color ="red"><b>Data Not Found. <br /><br />
        <? 	if ($pelajaran == -1 || strlen($pelajaran) == 0) { ?>
        
			Add teacher data on Department <?=$departemen?> in the Teacher Data menu on Teacher and Class Subject section. </b></font>	
		
        <?  } else {
			$sql="SELECT * FROM jbsakad.pelajaran WHERE replid = $pelajaran";
			
			$result=QueryDb($sql);
			$row = mysql_fetch_array($result);
		?> 		
        Add teacher who will teach <?=$row['nama']?> on Department <?=$departemen?> in the Teacher Data menu on Teacher and Class Subject section. </b></font>
        <? } ?>
        <br /><br />        	</td>
        </tr>
        </table>
	<? } ?>	</td>    
</tr>
<tr>
	<td colspan="2" align="center" >
	<input type="button" class="but" name="tutup" id="tutup" value="Close" onclick="window.close()" style="width:80px;"/>	</td>
</tr>
</table>