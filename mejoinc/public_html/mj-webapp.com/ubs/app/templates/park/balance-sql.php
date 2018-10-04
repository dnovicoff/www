<?php
/*
 * Filename: 	balance-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
$parkID			= $_GET['id'];
$query			= '';
foreach ($_POST['past'] as $i => $value) {	//	Run through each value and add it to the SQL query	
	$query = "UPDATE lots SET late_fee='" . $_POST['past'][$i] . "', previous_balance='" . $_POST['balance'][$i] . "' WHERE id='" . $i . "'; ";
	$DB->Execute($query);
}

header('Location:/index.php?page=park&action=view&id='. $parkID . '&status=802');
?>	