<?php
/*
 * Filename: 	lot-add-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
$query		= "INSERT INTO lots (id,park_id,lot,vacant,tenant,street_address,city,state,zip,charge_water,charge_sewer,charge_admin,charge_service,charge_fuel,
				lot_rent,pet_charge,extra_person,vehicle_charge,lease_option,late_fee,previous_balance,total_usage) VALUES 
				('','" . $_GET['id'] . "', '" . $_POST['lot'] . "', '" . $_POST['vacant'] . "', '" . $_POST['tenant'] . "', '" . $_POST['address'] . "', '" . 
				$_POST['city'] . "', '" . $_POST['state'] . "', '" . $_POST['zip'] . "', '" . $_POST['chargewater'] . "', '" . $_POST['chargesewer'] . "', '" . 
				$_POST['chargeadmin'] . "', '" . $_POST['chargeservice'] . "', '" . $_POST['chargefuel'] . "', '" . $_POST['rent'] . "', '" . $_POST['pet'] . "', '" . 
				$_POST['person'] . "', '" . $_POST['vehicle'] . "', '" . $_POST['lease'] . "','0.00','0.00','0.00')";

if ($DB->Execute($query) === false) {	//	Run the SQL Query
	header('Location:/index.php?page=lot&action=add-lot&id='. $_GET['id'] . '&status=904');
} else {
	header('Location:/index.php?page=lot&action=add-lot&id='. $_GET['id'] . '&status=806');
}

?>

