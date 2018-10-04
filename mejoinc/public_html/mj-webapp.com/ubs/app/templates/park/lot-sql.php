<?php
/*
 * Filename: 	lot-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
$parkID			= $_GET['id'];
$query			= '';
foreach ($_POST['rent'] as $i => $value) {	//	Run through each value and add it to the SQL query	
	$query = "UPDATE lots SET lot_rent='" . $value . "', pet_charge='" . $_POST['pet'][$i] . "', extra_person='" . $_POST['xper'][$i] . 
			"', charge_water='" . $_POST['chargewater'][$i] . "', charge_sewer='" . $_POST['chargesewer'][$i] . "', charge_admin='" . $_POST['chargeadmin'][$i] . 
			"', charge_service='" . $_POST['chargeservice'][$i] .  "', charge_fuel='" . $_POST['chargefuel'][$i] . "', vehicle_charge='" . $_POST['vehicle'][$i] . 
			"', lease_option='" . $_POST['lease'][$i] . "', previous_balance='" . $_POST['balance'][$i] . "' WHERE id='" . $i . "'; ";
	$DB->Execute($query);
}

header('Location:/index.php?page=park&action=view&id='. $parkID . '&status=801');
?>	