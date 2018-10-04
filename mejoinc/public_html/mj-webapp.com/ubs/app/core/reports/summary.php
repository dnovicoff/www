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
$xml 	= new ExcelWriterXML($park->_name . ' - Summary - ' . $readDate . '.xls');
$sheet 	= $xml->addSheet($park->_name);

//	Document META
$xml->docAuthor('Birch Reality Inc.');
$xml->docCompany('Birch Reality Inc.');
$xml->docManager('Birch Reality Inc.');
$xml->docSubject($park->_name . ' - Summary - ' . $readDate);
$xml->docTitle($park->_name . ' - Summary - ' . $readDate);

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

$format7 = $xml->addStyle('StyleFooter');
$format7->fontBold();
$format7->border('Top',2,'black');
$format7->alignHorizontal('Center');

//	Park Headers
$sheet->writeString(1,2,$park->_name,'ParkHeader');
$sheet->writeString(2,2,$park->_address,'ParkHeader');
$sheet->writeString(3,2,$park->_city . ', ' . $park->_state . ' ' . $park->_zip,'ParkHeader');
$sheet->writeString(4,2,'Summary Report','ParkHeader');
$sheet->writeString(5,2,'Read Date:','ParkHeaderRight');
$sheet->writeString(5,3,$readDate,'emptyBox');

//	Column headers
$sheet->writeString(7,1,'Lot','StyleHeader');
$sheet->writeString(7,2,'Tenant','StyleHeader');
$sheet->writeString(7,3,'Usage','StyleHeader');
$sheet->writeString(7,4,'Water Bill','StyleHeader');
$sheet->writeString(7,5,'Sewer Bill','StyleHeader');
$sheet->writeString(7,6,'Lot Rent','StyleHeader');
$sheet->writeString(7,7,'Pet Charge','StyleHeader');
$sheet->writeString(7,8,'Extra Charge','StyleHeader');
$sheet->writeString(7,9,'Vehicle Charge','StyleHeader');
$sheet->writeString(7,10,'Lease Option','StyleHeader');
$sheet->writeString(7,11,'Late Fee','StyleHeader');
$sheet->writeString(7,12,'Admin Fee','StyleHeader');
$sheet->writeString(7,13,'Previous Balance','StyleHeader');
$sheet->writeString(7,14,'Total Due / w+s+a','StyleHeader');

//	Column widths
$sheet->columnWidth(1,30);
$sheet->columnWidth(2,140);
$sheet->columnWidth(5,96);
$sheet->columnWidth(6,96);
$sheet->columnWidth(7,96);
$sheet->columnWidth(8,86);
$sheet->columnWidth(9,86);
$sheet->columnWidth(10,86);
$sheet->columnWidth(11,86);
$sheet->columnWidth(12,86);
$sheet->columnWidth(13,126);
$sheet->columnWidth(14,126);

//	Row iterator
$row 	= 8;

//	Totals
$totalBalance		= 0;
$totalUsage			= 0;
$totalWater			= 0;
$totalSewer			= 0;
$totalRent			= 0;
$totalPet			= 0;
$totalExtra			= 0;
$totalVehicle		= 0;
$totalLate			= 0;
$totalLease			= 0;
$totalAdmin			= 0;
$totalDue			= 0;
$totalWSA			= 0;

//	Lot loop
while (!$lotQuery->EOF) {
	$col	= 1;
	$lot	= new Lot($lotQuery);
	$calc	= calculateBill($park->_id,$lot->_id,$readDate,$DB);
		
	//	Later values
	$waterBill	= number_format($calc[0], 2, '.', ',');
	$sewerBill	= number_format($calc[1], 2, '.', ',');
	$usage		= number_format($calc[2], 2, '.', ',');
	$balance	= number_format($lot->currentBalance() + $waterBill + $sewerBill + $park->_feeAdmin + $park->_feeService + $park->_feeFuel, 2, '.', ',');
	
	$sheet->writeString($row,$col,$lot->_lotID,'sheetData');
	$col++;
	$sheet->writeString($row,$col,$lot->_tenant,'sheetData');
	$col++;
	$sheet->writeString($row,$col,number_format($usage, 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,number_format($waterBill, 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,number_format($sewerBill, 2, '.', ','),'sheetData');
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
	
	if ($park->_feeAdmin != '0.00') {
		$sheet->writeString($row,$col,number_format($park->_feeAdmin + $park->_feeService + $park->_feeFuel, 2, '.', ','),'sheetData');
	} elseif ($park->_feeService != '0.00') {
		$sheet->writeString($row,$col,number_format($park->_feeService, 2, '.', ','),'sheetData');
	} elseif ($park->_feeFuel != '0.00') {
		$sheet->writeString($row,$col,number_format($park->_feeFuel, 2, '.', ','),'sheetData');
	}
	
	$col++;
	$sheet->writeString($row,$col,number_format($lot->_feeBalance, 2, '.', ','),'sheetData');
	$col++;
	$sheet->writeString($row,$col,$balance . ' / ' . number_format($waterBill + $sewerBill + $park->_feeAdmin + $park->_feeService + $park->_feeFuel, 2, '.', ','),'sheetData');
	
	$row++;
	$col	= 1;
	$sheet->cellMerge($row,$col,14);
	$row++;
	
	//	Update Totals
	$totalUsage			= $totalUsage + $usage;
	$totalWater			= $totalWater + $waterBill;
	$totalSewer			= $totalSewer + $sewerBill;
	$totalRent			= $totalRent + $lot->_feeRent;
	$totalPet			= $totalPet + $lot->_feePet;
	$totalExtra			= $totalExtra + $lot->_feeExtraPerson;
	$totalVehicle		= $totalVehicle + $lot->_feeVehicle;
	$totalLate			= $totalLate + $lot->_feePastDue;
	$totalLease			= $totalLease + $lot->_feeLease;
	$totalAdmin			= $totalAdmin + ($park->_feeAdmin + $park->_feeService + $park->_feeFuel);
	$totalBalance		= $totalBalance + $lot->_feeBalance;
	$totalDue			= $totalDue + $balance;
	$totalWSA			= $totalWSA + ($waterBill + $sewerBill + $park->_feeAdmin + $park->_feeService + $park->_feeFuel);
	
	//	Next Lot
	$lotQuery->MoveNext();
}
//	Footer
$sheet->writeString($row,1,'','StyleFooter');
$sheet->writeString($row,2,'','StyleFooter');
$sheet->writeString($row,3,'Usage','StyleFooter');
$sheet->writeString($row,4,'Water Bill','StyleFooter');
$sheet->writeString($row,5,'Sewer Bill','StyleFooter');
$sheet->writeString($row,6,'Lot Rent','StyleFooter');
$sheet->writeString($row,7,'Pet Charge','StyleFooter');
$sheet->writeString($row,8,'Extra Charge','StyleFooter');
$sheet->writeString($row,9,'Vehicle Charge','StyleFooter');
$sheet->writeString($row,10,'Lease Option','StyleFooter');
$sheet->writeString($row,11,'Late Fee','StyleFooter');
$sheet->writeString($row,12,'Admin Fee','StyleFooter');
$sheet->writeString($row,13,'Previous Balance','StyleFooter');
$sheet->writeString($row,14,'Total Due / w+s+a','StyleFooter');
$row++;
$sheet->writeString($row,1,'','StyleHeader');
$sheet->writeString($row,2,'Totals:','StyleHeader');
$sheet->writeString($row,3,number_format($totalUsage, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,4,number_format($totalWater, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,5,number_format($totalSewer, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,6,number_format($totalRent, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,7,number_format($totalPet, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,8,number_format($totalExtra, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,9,number_format($totalVehicle, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,10,number_format($totalLate, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,11,number_format($totalLease, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,12,number_format($totalAdmin, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,13,number_format($totalBalance, 2, '.', ','),'StyleHeader');
$sheet->writeString($row,14,number_format($totalDue, 2, '.', ',') . ' / ' . number_format($totalWSA, 2, '.', ',') ,'StyleHeader');

//	File Name
$filename	= $park->_name . ' - Summary - ' . $readDate . '.xls';
$filepath	= CACHE_DIR . 'summary/';

if ($newFile == TRUE) {
  //	Query
  $query		= "INSERT INTO `reports` (`id`,`park_id`,`date`,`name`,`type`) VALUES (NULL,'" . $park->_id . "',NULL,'" . $filepath . $filename . "','S')";
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