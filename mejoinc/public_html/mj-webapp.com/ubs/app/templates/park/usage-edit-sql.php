<?php
/*
 * Filename: 	usage-edit-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
$parkID		= $_GET['id'];
$billDate	= $_POST['bill_date'];
$dueDate	= $_POST['due_date'];
$recordDate	= $_POST['record_date'];
foreach ($_POST['usage'] as $i => $value) {	//	Run through each value and add it to the SQL query	
	$checkForRecord = $DB->Execute("SELECT id FROM park_usage WHERE lot_id='" . $i ."' AND record_date='" . $recordDate . "' LIMIT 1");
	
	if ($checkForRecord->RecordCount() == 0) {
		$query = "INSERT INTO `park_usage` (`id`,`park_id`,`lot_id`,`usage`,`record_date`,`bill_date`,`due_date`) VALUES 
					(NULL,'" . $parkID . "','" . $i . "','" . $value . "','" . $recordDate . "','" . $billDate . "','" . $dueDate . "')";
					
		$DB->Execute($query);
	} else {
		$query = "UPDATE `park_usage` SET `usage`='" . $_POST['usage'][$i] . "' WHERE lot_id=" . $i . " AND record_date='" . $recordDate . "' LIMIT 1";
		$DB->Execute($query);
	}
	
}

header('Location:/index.php?page=park&action=usage-complete&id='. $parkID . '&status=800&date=' . $recordDate);
?>	