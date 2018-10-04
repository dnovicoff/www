<?php
/*
 * Filename: 	usage-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
$query			= "INSERT INTO `park_usage` (`id`,`park_id`,`lot_id`,`usage`,`record_date`,`bill_date`,`due_date`) VALUES ";
$queryValues	= '';
$count			= count($_POST['usage']);	//	POST Count
$iter			= 0;	//	Iterator
$parkID			= $_GET['id'];

$recordDate		= date('Y-m-d', strtotime($_POST['record-date']));
$billDate		= date('Y-m-d', strtotime($_POST['bill-date']));
$dueDate		= date('Y-m-d', strtotime($_POST['due-date']));


foreach ($_POST['usage'] as $i => $value) {	//	Run through each value and add it to the SQL query
	$queryValues = $queryValues . "(NULL,'" . $parkID . "','" . $i . "','" . $value . "','" . $recordDate . "','" . $billDate . "','" . $dueDate . "')";
	
	$iter++;
	
	if ($iter != $count) { $queryValues = $queryValues . ', '; }	//	Append an ',', unless it's the last index
}

$query	= $query . $queryValues;

if ($DB->Execute($query) === false) {	//	Run the SQL Query
	header('Location:/index.php?page=park&action=record-usage&id=' . $parkID . '&status=900');
} else {
	header('Location:/index.php?page=park&action=download-reports&id='. $parkID . '&status=800&date=' . $recordDate);
}

?>	