<?php
/*
 * Filename: 	park-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
$parkID		= $_GET['id'];
$query		= "SELECT DISTINCT * FROM parks WHERE id='" . $parkID . "'";
$rs			= $DB->Execute($query);
$record		= array();

$record['name']         		= $_POST['name'];
$record['address']				= $_POST['address'];
$record['city']				 	= $_POST['city'];
$record['state']			  	= $_POST['state'];
$record['zip']			   		= $_POST['zip'];
$record['readUnit']     		= $_POST['readUnit'];
$record['billingUnit']			= $_POST['billingUnit'];
$record['tax_rate']				= $_POST['taxrate'];
$record['tax_water']			= $_POST['taxwater'];
$record['tax_sewer']			= $_POST['taxsewer'];
$record['admin_fee']			= $_POST['admin'];
$record['service_fee']			= $_POST['service'];
$record['fuel_fee']				= $_POST['fuel'];
$record['other_fee_name']		= $_POST['other'];
$record['min_usage']			= $_POST['min_usage'];

$updateSQL = $DB->GetUpdateSQL($rs, $record); 

if ($DB->Execute($updateSQL) === false) {	//	Run the SQL Query
	header('Location:/index.php?page=park&action=edit-park&id=' . $parkID . '&status=903');
} else {
	header('Location:/index.php?page=park&action=view&id='. $parkID . '&status=803');
}

?>	