<?php
/*
 * Filename: 	balance-sql.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
$lotID			= $_GET['id'];

$query = "UPDATE lots SET late_fee='" . $_POST['past'] . "', previous_balance='" . $_POST['balance'] . "' WHERE id='" . $lotID . "'; ";

if ($DB->Execute($query) === false) {	//	Run the SQL Query
	header('Location:/index.php?page=lot&action=edit-lot&id='. $lotID . '&status=902');
} else {
	header('Location:/index.php?page=lot&action=view&id='. $lotID . '&status=802');
}
?>	