<?php
/*
 * Filename: 	download-cards.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 * Description:	Creates a multiple usage cards in PDF form
 */
 
// We'll be outputting a PDF
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="' . $_GET['filename']);
readfile($_GET['filepath'] . $_GET['filename']);
?>