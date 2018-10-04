<?php
/*
 * Filename: 	index.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 */
ob_start();
 
//	Required Files
require('app/config.php');

//	URL Parsing
	// GET
if (isset($_GET['page'])) 	{ $_page = mysql_real_escape_string($_GET['page']); 		} else { $_page = 'park'; }
if (isset($_GET['action'])) { $_action = mysql_real_escape_string($_GET['action']);	} else { $_action = 'index'; }
if (isset($_GET['id'])) 	{ $_id = mysql_real_escape_string($_GET['id']);			} else { $_id = NULL; }
if (isset($_GET['status'])) { $_status = mysql_real_escape_string($_GET['status']); 	} else { $_status = NULL; }	

//	Template Files
include_once('header.php');
include_once("$_page/$_action.php");
include_once('footer.php');
?>


