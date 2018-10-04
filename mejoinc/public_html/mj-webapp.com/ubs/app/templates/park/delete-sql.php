<?php
/*
 * Filename: 	delete-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/26/2011
 */
$parkID			=   mysql_real_escape_string($_GET['id']);
$query			= '';
if ($_POST['confirm'] == 'DELETE') {	//	Run through each value and add it to the SQL query	
	$query = "DELETE FROM parks WHERE id='" . $parkID . "'";
	$DB->Execute($query);
	$query = "DELETE FROM sewer_rates WHERE park_id='" . $parkID . "'";
	$DB->Execute($query);
	$query = "DELETE FROM water_rates WHERE park_id='" . $parkID . "'";
	$DB->Execute($query);
	$query = "DELETE FROM lots WHERE park_id='" . $parkID . "'";
	$DB->Execute($query);
	$query = "DELETE FROM reports WHERE park_id='" . $parkID . "'";
	$DB->Execute($query);
	$query = "DELETE FROM park_usage WHERE park_id='" . $parkID . "'";
	$DB->Execute($query);
	header('Location:/index.php?page=park&status=807');

} else {
	header('Location:/index.php?page=park&action=delete-park&id='. $parkID . '&status=905');
}

?>	
