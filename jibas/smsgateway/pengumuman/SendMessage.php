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
//echo "<pre>";
//print_r($_REQUEST);
//echo "</pre>";
$Sender		= CQ($_REQUEST['Sender']);// => Ellyf TS
$Message	= stripslashes($_REQUEST['Message']);// => Pesannnya
$Message	= str_replace("^","&",$Message);
$NoPe		= $_REQUEST['NoPe'];// =>; 085624084062,085624084062
$SendTime	= $_REQUEST['SendTime'];// => 2010-2-2 16:37:00
$NoIn		= $_REQUEST['NoIn'];
$pin1		= $_REQUEST['Pin1'];
$pin2		= $_REQUEST['Pin2'];
$Nama		= $_REQUEST['Nama'];
$X			= split(' ',$SendTime);
$smsgeninfo	  = "Announcement";	

$idsmsgeninfo = GetLastId('replid','smsgeninfo');	
//echo "Ini loh".$idsmsgeninfo;
//exit;
//echo $pin1."_".$pin2;
$sql = "INSERT INTO smsgeninfo SET replid='$idsmsgeninfo',tanggal='$X[0]',tipe='2',info='$smsgeninfo',pengirim='$Sender'";
$res = QueryDb($sql);

/*
$sql = "INSERT INTO pesan SET tanggal='$SendTime',pesan='$Message',pengirim='$Sender'";
QueryDb($sql);

$sql = "SELECT replid FROM pesan ORDER BY replid DESC LIMIT 1";
$res = QueryDb($sql);
$row = @mysql_fetch_row($res);
$idpesan = $row[0];
*/
$No		= split('>',$NoPe);
$Nama	= split('>',$Nama);
$NoID	= split('>',$NoIn);
$PIN1	= split('>',$pin1);
$PIN2	= split('>',$pin2);
$Recipient = 0;
for ($i=0; $i<count($No);$i++){
	//$sql = "INSERT INTO pesanpenerima SET jadwal=now(),idpesan='$idpesan',penerima='$No[$i]'";
	if ($No[$i]!=""){
		//if ($result){
			if ($NoID[$i]=='NULL')
				$newformat = str_replace('[NOINDUK]','',$Message);
			else
				$newformat = str_replace('[NOINDUK]',$NoID[$i],$Message);
			
			$newformat = str_replace('[NAMA]',$Nama[$i],$newformat);
			$pinortu   = "";
			if ($PIN2[$i]=="X" || $PIN2[$i]=="" || $PIN2[$i]=="undefined"){
				if ($PIN1[$i]!='undefined')
					$newformat = str_replace('[PIN]',$PIN1[$i],$newformat);
			} else {
				$pinortu   = "Father PIN = ".$PIN1[$i].", Mother PIN = ".$PIN2[$i];
				$newformat = str_replace('[PIN]',$pinortu,$newformat);
				
			}
	
			$nohp = $No[$i];
			$nohp = str_replace(" 62","0",$nohp);

			$TextMsg = CQ($newformat);
			//echo $PIN1[$i].",".$PIN2[$i]."#".$No[$i]."->".$TextMsg."<br>";
			//$sql_insert = "INSERT INTO smsd.outbox SET InsertIntoDB=now(),SendingDateTime=now(),Text='$Message',DestinationNumber='$No[$i]',SenderID='$Sender'";
			$sql_insert = "INSERT INTO outbox SET InsertIntoDB=now(), SendingDateTime='$SendTime', Text='$TextMsg', DestinationNumber='$nohp', SenderID='$Sender', CreatorID='$Sender',idsmsgeninfo=$idsmsgeninfo";
			QueryDb($sql_insert);

			$sql_insert = "INSERT INTO outboxhistory SET InsertIntoDB=now(), SendingDateTime='$SendTime', Text='$TextMsg', DestinationNumber='$nohp', SenderID='$Sender', idsmsgeninfo=$idsmsgeninfo";
			QueryDb($sql_insert);
			//echo $sql_insert."<br>";
			$Recipient++;
	}
}
?>
<script language='javascript'>
	parent.bottom.PengumumanAfterSend('<?=$Recipient?>');
</script>