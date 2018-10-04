<?php
/*
 * Filename: 	errors.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
 
$errorArray = array(
	//	Success Messages - 800-899
	'800' => 'Your usage was inserted successfully, please wait for your cards to process',
	'801' => 'Your lot information was updated successfully',
	'802' => 'Your lot balances were updated successfully',
	'803' => 'Your park information was updated successfully',
	'804' => 'Your usage information was updated successfully',
	'805' => 'Your park was added successfully',
	'806' => 'Your lot was added successfully',
	'807' => 'Your park was removed successfully',
	'808' => 'Your lot was removed successfully',
	
	//	Error Messages - 900-999
	'900' => 'Your usage was not inserted, please retry your request',
	'901' => 'Your lot information update was not completed, please retry your request',
	'902' => 'Your lot balances were not completed, please retry your request',
	'903' => 'Your park information update was not completed, please retry your request',	
	'904' => 'Your lot was not added, please retry your request',
	'905' => 'Your must enter DELETE in the field to remove this park',
	'906' => 'Your must enter DELETE in the field to remove this lot'			
);
 ?>