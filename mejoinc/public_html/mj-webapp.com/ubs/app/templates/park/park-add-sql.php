<?php
/*
 * Filename: 	park-add-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
 
$query		= "INSERT INTO parks (id,name,address,city,state,zip,readUnit,billingUnit,tax_rate,tax_water,tax_sewer,admin_fee,service_fee,fuel_fee,other_fee_name,min_usage) VALUES 
				('','" . $_POST['name'] . "', '" . $_POST['address'] . "', '" . $_POST['city'] . "', '" . $_POST['state'] . "', '" . $_POST['zip'] . "', '" . 
				$_POST['readUnit'] . "', '" . $_POST['billingUnit'] . "', '" . $_POST['taxrate'] . "', '" . $_POST['taxwater'] . "', '" . $_POST['taxsewer'] . "', '" . 
				$_POST['admin'] . "', '" . $_POST['service'] . "', '" . $_POST['fuel'] . "','" . $_POST['other'] . "','" . $_POST['min_usage'] . "')";

	$DB->Execute($query);
	$query2	= "SELECT DISTINCT id FROM parks ORDER BY id DESC LIMIT 1";
	$result2 = $DB->Execute($query2);
	$parkID = $result2->fields['id'];
	
	$rateQuery	= "INSERT INTO water_rates (id,park_id,rate,tier,cutoff,lower_threshold,upper_threshold) VALUES ";
	for ($i = 0; $i < 11; $i++) {
		$rateQuery .= "(NULL,'" . $parkID . "',NULL,'" . $i . "',NULL,NULL,NULL)";
		if ($i != 10) {
			$rateQuery .= ', ';
		} else {
			$rateQuery .= '; ';
		}
	}
	$DB->Execute($rateQuery);
	
	$rateQuery	= "INSERT INTO sewer_rates (id,park_id,rate,tier,cutoff,lower_threshold,upper_threshold) VALUES ";
	for ($i = 0; $i < 11; $i++) {
		$rateQuery .= "(NULL,'" . $parkID . "',NULL,'" . $i . "',NULL,NULL,NULL)";
		if ($i != 10) {
			$rateQuery .= ', ';
		} else {
			$rateQuery .= ';';
		}
	}
	
	
	if ($DB->Execute($rateQuery) === false) {
		header('Location:/index.php?page=park&action=add-park&status=903');
	} else {
		header('Location:/index.php?page=park&action=view&status=805');
	}
?>