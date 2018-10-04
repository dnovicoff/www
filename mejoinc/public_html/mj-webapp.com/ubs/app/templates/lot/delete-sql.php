<?php
/*
 * Filename: 	delete-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/26/2011
 */
$lotID			= $_GET['id'];
$parkID			= $_GET['park'];
$query			= '';
if ($_POST['confirm'] == 'DELETE') {	//	Run through each value and add it to the SQL query	
	$query = "DELETE FROM lots WHERE id='" . $lotID . "'";
	$DB->Execute($query);
	$query = "DELETE FROM park_usage WHERE lot_id='" . $lotID . "'";
	$DB->Execute($query);
	header('Location:/index.php?page=lot&id=' . $parkID . '&status=808');
} else {
	header('Location:/index.php?page=lot&action=delete-lot&id='. $lotID . '&status=906');
}

?>	