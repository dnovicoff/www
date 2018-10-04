<?php
/*
 * Filename: 	lot-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
$lotID			= $_GET['id'];

if ($_POST['vacant'] == 'Y') {
	$tenant	= 'VACANT';
} else {
	$tenant	= $_POST['tenant'];
}

$query = "UPDATE lots SET tenant='" . $tenant . "', street_address='" . $_POST['address'] . "', city='" . $_POST['city'] . "', state='" . $_POST['state'] . 
			"', zip='" . $_POST['zip'] . "', lot_rent='" . $_POST['rent'] . "', pet_charge='" . $_POST['pet'] . "', extra_person='" . $_POST['person'] . 
			"', vehicle_charge='" . $_POST['vehicle'] . "', lease_option='" . $_POST['lease'] . "', charge_water='" . $_POST['chargewater'] . 
			"', charge_sewer='" . $_POST['chargesewer'] . "', charge_admin='" . $_POST['chargeadmin'] . "', charge_service='" . $_POST['chargeservice'] . 
			"', charge_fuel='" . $_POST['chargefuel'] . "', vacant='" . $_POST['vacant'] . "' WHERE id='" . $lotID . "'; ";

if ($DB->Execute($query) === false) {	//	Run the SQL Query
	header('Location:/index.php?page=lot&action=edit-lot&id='. $lotID . '&status=901');
} else {
	header('Location:/index.php?page=lot&action=view&id='. $lotID . '&status=801');
}
?>	