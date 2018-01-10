<?
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

OpenDb();
$sql = "SELECT * FROM jbsakad.dasarpenilaian WHERE keterangan IS NULL";
$res = QueryDb($sql);
if (mysql_num_rows($res) > 0)
{
	while($row = mysql_fetch_array($res))
	{
		$replid = $row['replid'];
		$dp = $row['dasarpenilaian'];
		
		if ($dp == "Conceptual Comprehension")
			$sql = "UPDATE jbsakad.dasarpenilaian SET dasarpenilaian = 'PKON', keterangan = 'Conceptual Comprehension', issync = 0 WHERE replid = '$replid'";
		else if ($dp == "Practice")
			$sql = "UPDATE jbsakad.dasarpenilaian SET dasarpenilaian = 'PRAK', keterangan = 'Practice', issync = 0 WHERE replid = '$replid'";
		QueryDb($sql);
	}
}
CloseDb();
?>
