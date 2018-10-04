<?php
/*
 * Filename: 	config.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 */
 
// Database
define('DB_HOST', 'localhost');
define('DB_USER', 'mejoinc_ubs');
define('DB_PASS', 'mD7;[DyK5if1');
define('DB_DB', 'mejoinc_ubs');
//-------------------------------------------------------------------------------------------------------//

//	Application Paths
define('ROOT_DIR', dirname(dirname(__FILE__)));
define('UPLOAD_DIR', ROOT_DIR . '/uploads/');
define('CACHE_DIR', ROOT_DIR . '/cache/');
define('IMAGE_DIR', ROOT_DIR . '/images/');
define('JS_DIR', ROOT_DIR . '/js/');
define('CSS_DIR', ROOT_DIR . '/css/');
define('CACHE_URL', '/cache/');
//-------------------------------------------------------------------------------------------------------//

//	Library Paths
ini_set('include_path', ini_get('include_path') . ':' . dirname(__FILE__) . ':' . dirname(__FILE__) . '/core/:' . dirname(__FILE__) . '/templates/');
//-------------------------------------------------------------------------------------------------------//

//	Includes
include_once('adodb5/adodb.inc.php');
include_once('errors.php');
//-------------------------------------------------------------------------------------------------------//

//	Database Connection
$DB = NewADOConnection('mysql');
$DB->PConnect(DB_HOST, DB_USER, DB_PASS, DB_DB);
//-------------------------------------------------------------------------------------------------------//


//	Debugging
	//	Poseidon
	define('POSEIDON_DEBUG', 'false');
		
	//	PHP Error Reporting
	ini_set('error_reporting', 'true');
	error_reporting(E_ALL ^ E_NOTICE);
	
	//	Database
	$DB->debug = false;
//-------------------------------------------------------------------------------------------------------//

//	PHP Overrides
	#setlocale(LC_MONETARY, 'en_US');
	ini_set('memory_limit', '84M');
?>