<?php
ob_start();
include_once('../../config.php');
include_once('PHPExcel.php');
include_once('PHPExcel/Writer/Excel5.php');
include_once('park.class.php');
include_once('lot.class.php');
include_once('calculations.php');
include_once('styling.php');

//  Queries
$parkQuery  = $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_GET['id'] . "'");
$lotQuery   = $DB->Execute("SELECT * FROM lots WHERE park_id='" . $_GET['id'] . "'");

//  POST
$readDate = $_GET['date'];
if (isset($_GET['file'])) { $newFile = $_GET['file']; } else { $newFile = TRUE; }

//  Class Construction
$park = new Park($parkQuery);

//  Memory method
/*
$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
*/

$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Birch Reality Inc.")
  ->setLastModifiedBy("Birch Reality Inc.")
  ->setCompany("Birch Reality Inc.")
  ->setTitle($park->_name . ' - Summary - ' . $readDate)
  ->setSubject($park->_name . ' - Summary - ' . $readDate)
  ->setDescription("");
  
// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8); 


//  Page margins
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.15);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.05);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.05);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.15);
$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(0.00);
$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(0.00);

//  Center the page for printing
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(true);


//  Column setup
  // Widths
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(9);
if ($park->_feeFuel != '0.00') {
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
}

//  Park Headers
  //Content
$objPHPExcel->getActiveSheet()->SetCellValue('A1',$park->_name);
$objPHPExcel->getActiveSheet()->SetCellValue('A2',$park->_address);
$objPHPExcel->getActiveSheet()->SetCellValue('A3',$park->_city . ', ' . $park->_state . ' ' . $park->_zip);
$objPHPExcel->getActiveSheet()->SetCellValue('E2','Read Date:');
$objPHPExcel->getActiveSheet()->SetCellValue('F2',$readDate);
  //  Merge
$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
  //  Style
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setItalic(true);

//  Column headers
  // Content
$objPHPExcel->getActiveSheet()->SetCellValue('A5','Lot');
$objPHPExcel->getActiveSheet()->SetCellValue('B5','Tenant');
$objPHPExcel->getActiveSheet()->SetCellValue('C5','Usage');
$objPHPExcel->getActiveSheet()->SetCellValue('D5',"Water\nBill");
$objPHPExcel->getActiveSheet()->SetCellValue('E5',"Sewer\nBill");
$objPHPExcel->getActiveSheet()->SetCellValue('F5',"Lot\nRent");
$objPHPExcel->getActiveSheet()->SetCellValue('G5',"Pet\nCrg");
$objPHPExcel->getActiveSheet()->SetCellValue('H5',"Extra\nCrg");
$objPHPExcel->getActiveSheet()->SetCellValue('I5',"Vehicle\nCrg");
$objPHPExcel->getActiveSheet()->SetCellValue('J5',"Lease\nOpt");
$objPHPExcel->getActiveSheet()->SetCellValue('K5',"Late\nFee");
$objPHPExcel->getActiveSheet()->SetCellValue('L5',"Admin\nFee");
$objPHPExcel->getActiveSheet()->SetCellValue('M5',"Prev.\nBal.");
$objPHPExcel->getActiveSheet()->SetCellValue('N5',"Total\nDue");
$objPHPExcel->getActiveSheet()->SetCellValue('O5',"W+S+A");
if ($park->_feeFuel != '0.00') {
	$objPHPExcel->getActiveSheet()->SetCellValue('P5',$park->_feeOtherName);
} 
  // Style
  $objPHPExcel->getActiveSheet()->getStyle('A5:P5')->applyFromArray($styleHeaderRow);
  $objPHPExcel->getActiveSheet()->getStyle('D5:N5')->getAlignment()->setWrapText(true);

$row  = 6;
$alt  = false;
$page = 1;
//  Totals
$totalBalance   = 0;
$totalUsage     = 0;
$totalWater     = 0;
$totalSewer     = 0;
$totalRent      = 0;
$totalPet       = 0;
$totalExtra     = 0;
$totalVehicle   = 0;
$totalLate      = 0;
$totalLease     = 0;
$totalAdmin     = 0;
$totalDue       = 0;
$totalWSA       = 0;
$totalFuel      = 0;

while (!$lotQuery->EOF) {
  $lot  = new Lot($lotQuery);
  $calc = calculateBill($park->_id,$lot->_id,$readDate,$DB);
    
  //  Later values
  $waterBill  = number_format($calc[0], 2, '.', ',');
  $sewerBill  = number_format($calc[1], 2, '.', ',');
  $usage    = number_format($calc[2], 2, '.', ',');
  $preBalance	= $lot->currentBalance() + $waterBill + $sewerBill;

		if ($lot->_chargeAdmin == TRUE) {
			$preBalance = $preBalance + $park->_feeAdmin;
		}
		if ($lot->_chargeService == TRUE) {
			$preBalance = $preBalance + $park->_feeService;
		}
		if ($lot->_chargeFuel == TRUE) {
			$preBalance = $preBalance + $park->_feeFuel;
		}
		
		$balance	= number_format($preBalance, 2, '.', ',');
  
  $rowStart = $row;
  
  $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row,$lot->_lotID);
  $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,$lot->_tenant);
  $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$usage);
  if ($lot->_chargeWater == TRUE) {
  	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,$waterBill);
  } else {
  	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,'0.00');
  }
  if ($lot->_chargeSewer == TRUE) {
  	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,$sewerBill);
  } else {
  	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,'0.00');
  }
  $objPHPExcel->getActiveSheet()->SetCellValue('F'.$row,number_format($lot->_feeRent, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('G'.$row,number_format($lot->_feePet, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('H'.$row,number_format($lot->_feeExtraPerson, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('I'.$row,number_format($lot->_feeVehicle, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('J'.$row,number_format($lot->_feeLease, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('K'.$row,number_format($lot->_feePastDue, 2, '.', ','));
  if ($lot->_isVacant == TRUE) {
  	$objPHPExcel->getActiveSheet()->SetCellValue('L'.$row,number_format('0.00', 2, '.', ','));
  } else {
  	if ($lot->_chargeWater == TRUE) {
	  $objPHPExcel->getActiveSheet()->SetCellValue('L'.$row,number_format($park->_feeAdmin, 2, '.', ','));
	 } else {
	  $objPHPExcel->getActiveSheet()->SetCellValue('L'.$row,number_format('0.00', 2, '.', ','));
	 }
  	
  }

  if ($lot->_isVacant == TRUE) {
  	$objPHPExcel->getActiveSheet()->SetCellValue('M'.$row,number_format('0.00', 2, '.', ','));
  	$objPHPExcel->getActiveSheet()->SetCellValue('N'.$row,number_format('0.00', 2, '.', ','));
  } else {
  	$objPHPExcel->getActiveSheet()->SetCellValue('M'.$row,number_format($lot->_feeBalance, 2, '.', ','));
  	$objPHPExcel->getActiveSheet()->SetCellValue('N'.$row,$balance);
  }
  
  if ($lot->_isVacant == TRUE) {
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$row,'0.00');
  } else {
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$row,number_format($waterBill + $sewerBill + $park->_feeAdmin, 2, '.', ','));  
  }
  if ($park->_feeFuel != '0.00') {
  	if ($lot->_isVacant == TRUE) {
	  	$objPHPExcel->getActiveSheet()->SetCellValue('P'.$row,number_format('0.00', 2, '.', ','));
	} else {
		$objPHPExcel->getActiveSheet()->SetCellValue('P'.$row,number_format($park->_feeFuel, 2, '.', ','));
	}
  }
  
  if ($alt == false) {
  	if ($park->_feeFuel != '0.00') {
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':P'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':P'.$row)->getFill()->getStartColor()->setARGB('FFFFFFFF');
    } else {
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':O'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':O'.$row)->getFill()->getStartColor()->setARGB('FFFFFFFF');
    }
    $alt = true;
  } else {
  	if ($park->_feeFuel != '0.00') {
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':P'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':P'.$row)->getFill()->getStartColor()->setARGB('FFE0E0E0');
	} else {
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':O'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':O'.$row)->getFill()->getStartColor()->setARGB('FFE0E0E0');
	}
    $alt = false;
  }

  $row++;
  $page++;
  
  if ($page % 42 == 1) {
    // Add a page break
    $objPHPExcel->getActiveSheet()->setBreak('A'.$row, PHPExcel_Worksheet::BREAK_ROW);
    $row++;
        //  Column headers
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row,'Lot');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'Tenant');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,'Usage');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,"Water\nBill");
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,"Sewer\nBill");
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$row,"Lot\nRent");
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$row,"Pet\nCrg");
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$row,"Extra\nCrg");
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$row,"Vehicle\nCrg");
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$row,"Lease\nOpt.");
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$row,"Late\nFee");
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$row,"Admin\nFee");
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$row,"Prev.\nBal.");
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$row,"Total\nDue");
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$row,"W+S+A");
    if ($park->_feeFuel != '0.00') {
    	$objPHPExcel->getActiveSheet()->SetCellValue('P'.$row,$park->_feeOtherName);
    }
      // Style
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':P'.$row)->applyFromArray($styleHeaderRow);
    $objPHPExcel->getActiveSheet()->getStyle('D'.$row.':N'.$row)->getAlignment()->setWrapText(true);
    
    $row++;
  }
  
  //  Update Totals
  $totalUsage	= $totalUsage + $usage;
  
  if ($lot->_chargeWater == TRUE) {
  	$totalWater	= $totalWater + $waterBill;
  }
  if ($lot->_chargeSewer == TRUE) {
  	$totalSewer	= $totalSewer + $sewerBill;
  }
  $totalRent	= $totalRent + $lot->_feeRent;
  $totalPet		= $totalPet + $lot->_feePet;
  $totalExtra	= $totalExtra + $lot->_feeExtraPerson;
  $totalVehicle	= $totalVehicle + $lot->_feeVehicle;
  $totalLate	= $totalLate + $lot->_feePastDue;
  $totalLease	= $totalLease + $lot->_feeLease;
  if ($lot->_isVacant == FALSE) {
  	if ($lot->_chargeFuel == TRUE) {
  		$totalFuel	= $totalFuel + $park->_feeFuel;
  	}
  }
  if ($lot->_isVacant == FALSE) {
  	if ($lot->_chargeAdmin == TRUE) {
    	$totalAdmin = $totalAdmin + ($park->_feeAdmin + $park->_feeService);
    }
  }
  $totalBalance    = $totalBalance + $lot->_feeBalance;
  $totalDue        = $totalDue + $balance;
  if ($lot->_isVacant == FALSE) {
     $totalWSA = $totalWSA + ($waterBill + $sewerBill + $park->_feeAdmin);
  }
 
  $lotQuery->MoveNext();
}
    
//  Footer
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'Totals:');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$totalUsage);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,$totalWater);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,$totalSewer);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$row,$totalRent);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$row,$totalPet);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$row,$totalExtra);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$row,$totalVehicle);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$row,$totalLate);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$row,$totalLease);
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$row,$totalAdmin);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$row,$totalBalance);
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$row,$totalDue);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$row,$totalWSA);
    if ($park->_feeFuel != '0.00') {
    	$objPHPExcel->getActiveSheet()->SetCellValue('P'.$row,$totalFuel);
    }
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':P'.$row)->applyFromArray($styleFooterRow);
    
//  Set Number types
$objPHPExcel->getActiveSheet()->getStyle('D6:P'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
$objPHPExcel->getActiveSheet()->getStyle('C6:C'.$row)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('A6:P'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
//  Prep
$objPHPExcel->getActiveSheet()->setTitle($park->_name . ' - Summary');
$objPHPExcel->setActiveSheetIndex(0);
 
//  File Name
$filename = $park->_name . ' - Summary - ' . $readDate . ' - ' . time() . '.xls';
$filedir  = CACHE_DIR . 'summary/';
$filepath = $filedir . $filename;

//  Save to DB
if ($newFile == TRUE) {
  //  Query
  $query    = "INSERT INTO `reports` (`id`,`park_id`,`date`,`name`,`type`) VALUES (NULL,'" . $park->_id . "','" . $readDate . "','" . $filepath . "','S')";
  //  Write to file
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save($filepath);
  //  Update DB
  $DB->Execute($query);
}

// Redirect output to a client’s web browser (Excel2007)
header("Location:/cache/summary/$filename");
?>