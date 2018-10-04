<?php
/*
 * Filename: 	summary.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Description:	Generates a lot listing for a given park based on $_GET['id']
 */

require_once('../../config.php');
require_once('ExcelWriterXML.php');
include_once('park.class.php');
include_once('lot.class.php');
include_once('calculations.php');

//	Queries
$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_GET['id'] . "'");
$lotQuery	= $DB->Execute("SELECT * FROM lots WHERE park_id='" . $_GET['id'] . "'");

//	POST
$readDate	= $_GET['date'];
if (isset($_GET['file'])) { $newFile = $_GET['file']; } else { $newFile = TRUE; }

//	Class Construction
$park	= new Park($parkQuery);
$xml 	= new ExcelWriterXML($park->_name . ' - Report - ' . $readDate . '.xls');
$sheet 	= $xml->addSheet($park->_name);

//	Document META
$xml->docAuthor('Birch Reality Inc.');
$xml->docCompany('Birch Reality Inc.');
$xml->docManager('Birch Reality Inc.');
$xml->docSubject($park->_name . ' - Report - ' . $readDate);
$xml->docTitle($park->_name . ' - Report - ' . $readDate);

//	Column header styling
$format = $xml->addStyle('StyleHeader');
$format->fontBold();
$format->border('Bottom',2,'black');
$format->alignHorizontal('Center');

$format2 = $xml->addStyle('sheetData');
$format2->alignHorizontal('Center');

$format3 = $xml->addStyle('emptyBox');
$format3->border('Bottom',1,'black');

$format4 = $xml->addStyle('borderTop');
$format4->border('Bottom',1,'black','Double');

$format5 = $xml->addStyle('ParkHeader');
$format5->fontBold();

$format6 = $xml->addStyle('ParkHeaderRight');
$format6->fontBold();
$format6->alignHorizontal('Right');

//	Park Headers
$sheet->writeString(1,2,$park->_name,'ParkHeader');
$sheet->writeString(2,2,$park->_address,'ParkHeader');
$sheet->writeString(3,2,$park->_city . ', ' . $park->_state . ' ' . $park->_zip,'ParkHeader');
$sheet->writeString(4,2,'Read Date:','ParkHeaderRight');
$sheet->writeString(4,3,$readDate,'emptyBox');

//	Column headers
$sheet->writeString(6,1,'Lot','StyleHeader');
$sheet->writeString(6,2,'Tenant','StyleHeader');
$sheet->writeString(6,3,'Meter Read','StyleHeader');
$sheet->writeString(6,4,'Lot Rent','StyleHeader');
$sheet->writeString(6,5,'Pet Charge','StyleHeader');
$sheet->writeString(6,6,'Extra Person','StyleHeader');
$sheet->writeString(6,7,'Vehicle Charge','StyleHeader');
$sheet->writeString(6,8,'Late Charge','StyleHeader');
$sheet->writeString(6,9,'Lease Option','StyleHeader');
$sheet->writeString(6,10,'Previous Balance','StyleHeader');

//	Column widths
$sheet->columnWidth(1,30);
$sheet->columnWidth(2,140);
$sheet->columnWidth(5,86);
$sheet->columnWidth(6,86);
$sheet->columnWidth(7,86);
$sheet->columnWidth(8,86);
$sheet->columnWidth(9,86);
$sheet->columnWidth(10,86);

//	Row iterator
$row 	= 7;

//	Lot loop
while (!$lotQuery->EOF) {
	$col	= 1;
	$lot	= new Lot($lotQuery);
	$query	= $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $park->_id . "' AND lot_id='" . $lot->_id . "' AND record_date='" . $readDate . "'");
	
	$sheet->writeString($row,$col,$lot->_lotID,'sheetData');
	$col++;
	$sheet->writeString($row,$col,$lot->_tenant,'sheetData');
	$col++;
	$sheet->writeString($row,$col,'','emptyBox');
	$col++;
	$sheet->writeString($row,$col,number_format($lot->_feeRent, 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,number_format($lot->_feePet, 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,number_format($lot->_feeExtraPerson, 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,number_format($lot->_feeVehicle, 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,number_format($lot->_feePastDue, 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,number_format($lot->_feeLease, 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,number_format($lot->_feeBalance, 2, '.', ','),'sheetData');
	
	$row++;
	$col	= 1;
	
	
	$col++;
	$sheet->writeString($row,$col,'','emptyBox');
	$col++;
	$sheet->writeString($row,$col,number_format($query->fields['usage'], 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,'','emptyBox');
	$col++;
	$sheet->writeString($row,$col,'','emptyBox');
	$col++;
	$sheet->writeString($row,$col,'','emptyBox');
	$col++;
	$sheet->writeString($row,$col,'','emptyBox');
	$col++;
	$sheet->writeString($row,$col,'','emptyBox');
	$col++;
	$sheet->writeString($row,$col,'','emptyBox');
	$col++;
	$sheet->writeString($row,$col,'','emptyBox');
	
	$row++;
	$col	= 1;
	
	$sheet->writeString($row,$col,'','borderTop');
	$col++;
	$sheet->writeString($row,$col,'','borderTop');
	$col++;
	$sheet->writeString($row,$col,'','borderTop');
	$col++;
	$sheet->writeString($row,$col,'','borderTop');
	$col++;
	$sheet->writeString($row,$col,'','borderTop');
	$col++;
	$sheet->writeString($row,$col,'','borderTop');
	$col++;
	$sheet->writeString($row,$col,'','borderTop');
	$col++;
	$sheet->writeString($row,$col,'','borderTop');
	$col++;
	$sheet->writeString($row,$col,'','borderTop');
	$col++;
	$sheet->writeString($row,$col,'','borderTop');
	
	$row++;
	$col	= 1;
	
	$sheet->cellMerge($row,$col,10);
	
	$row++;
	
	$lotQuery->MoveNext();
}

//	File Name
$filename	= $park->_name . ' - Report - ' . $readDate . ' - ' . time() . '.xls';
$filepath	= CACHE_DIR . 'reports/';

if ($newFile == TRUE) {
	//	Query
	$query		= "INSERT INTO `reports` (`id`,`park_id`,`date`,`name`,`type`) VALUES (NULL,'" . $park->_id . "','" . $readDate . "','" . $filepath . $filename . "','R')";
	//	Write to file
	$xml->overwriteFile(TRUE);
	$xml->writeData($filepath . $filename);
	//	Update DB
	$DB->Execute($query);
}
//	Push to user
$xml->sendHeaders();
$xml->writeData();
?>