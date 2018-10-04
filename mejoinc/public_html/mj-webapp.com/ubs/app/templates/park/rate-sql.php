<?php
/*
 * Filename: 	rate-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
$parkID			= $_GET['id'];
$query			= '';
foreach ($_POST['water-rate'] as $i => $value) {	//	Run through each value and add it to the SQL query	
	$query = "UPDATE `water_rates` SET rate='" . $_POST['water-rate'][$i] . "', cutoff='" . $_POST['water-cutoff'][$i] . 
			"', lower_threshold='" . str_replace('MIN', '0.00', $_POST['water-lower'][$i]) . "', upper_threshold='" . str_replace('MAX', '9999999999.99', $_POST['water-upper'][$i]) . 
			"' WHERE park_id='" . $parkID . "' AND tier='" . $i  . "';";
	$DB->Execute($query);
}

foreach ($_POST['sewer-rate'] as $i => $value) {	//	Run through each value and add it to the SQL query	
	$query = "UPDATE `sewer_rates` SET rate='" . $_POST['sewer-rate'][$i] . "', cutoff='" . $_POST['sewer-cutoff'][$i] . 
			"', lower_threshold='" . str_replace('MIN', '0.00', $_POST['sewer-lower'][$i]) . "', upper_threshold='" . str_replace('MAX', '9999999999.99', $_POST['sewer-upper'][$i]) . 
			"' WHERE park_id='" . $parkID . "' AND tier='" . $i  . "';";
	$DB->Execute($query);
}
header('Location:/index.php?page=park&action=edit-rates&id='. $parkID . '&status=803');
?>	