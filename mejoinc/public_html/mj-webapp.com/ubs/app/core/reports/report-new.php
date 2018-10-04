<?php 
/*
 * $HeadURL$
 * $Id$
 * $Author$
 * $Revision$
 * $Date$
 */
ob_start();

include_once('../../config.php');
include_once('PHPExcel.php');
include_once('PHPExcel/Writer/Excel5.php');
include_once('park.class.php');
include_once('lot.class.php');
include_once('styling.php');

//  Queries
$parkQuery  = $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_GET['id'] . "'");
$lotQuery = $DB->Execute("SELECT * FROM lots WHERE park_id='" . $_GET['id'] . "'");

//  POST
$readDate = mysql_real_escape_string($_GET['date']);
$nextMonth = strtotime(date("Y-m-d", strtotime($readDate)) . " +1 month");
if (isset($_GET['file'])) { $newFile = mysql_real_escape_string($_GET['file']); } else { $newFile = TRUE; }

//  Class Construction
$park = new Park($parkQuery);

$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Birch Reality Inc.")
  ->setLastModifiedBy("Birch Reality Inc.")
  ->setCompany("Birch Reality Inc.")
  ->setTitle($park->_name . ' - ' . date('F',$nextMonth))
  ->setSubject($park->_name . ' - ' . date('F',$nextMonth))
  ->setDescription("");

// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

//  Page margins
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.35);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.15);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.15);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.35);

//  Center the page for printing
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(true);

//	Globally set the font at 9
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9);

//  Column setup
  // Widths
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

//  Park Headers
  //Content
$objPHPExcel->getActiveSheet()->SetCellValue('A1',$park->_name);
$objPHPExcel->getActiveSheet()->SetCellValue('A2',$park->_address);
$objPHPExcel->getActiveSheet()->SetCellValue('A3',$park->_city . ', ' . $park->_state . ' ' . $park->_zip);
$objPHPExcel->getActiveSheet()->SetCellValue('E2','Read Date:');
$objPHPExcel->getActiveSheet()->SetCellValue('F2',date('F',$nextMonth));
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
$objPHPExcel->getActiveSheet()->SetCellValue('C5','Meter Read');
$objPHPExcel->getActiveSheet()->SetCellValue('D5','Lot Rent');
$objPHPExcel->getActiveSheet()->SetCellValue('E5','Pet Charge');
$objPHPExcel->getActiveSheet()->SetCellValue('F5','Extra Person');
$objPHPExcel->getActiveSheet()->SetCellValue('G5','Vehicle Charge');
$objPHPExcel->getActiveSheet()->SetCellValue('H5','Late Charge');
$objPHPExcel->getActiveSheet()->SetCellValue('I5','Lease Option');
$objPHPExcel->getActiveSheet()->SetCellValue('J5','Previous Balance');
  // Style
  $objPHPExcel->getActiveSheet()->getStyle('A5:J5')->applyFromArray($styleHeaderRow);

$row  = 6;
$alt  = false;
$page = 1;

while (!$lotQuery->EOF) {
  $lot  = new Lot($lotQuery);
  $query  = $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $park->_id . "' AND lot_id='" . $lot->_id . "' AND record_date='" . $readDate . "'");
  $rowStart = $row;
  
  $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row,$lot->_lotID);
  $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,$lot->_tenant);
  $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,number_format($lot->_feeRent, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,number_format($lot->_feePet, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('F'.$row,number_format($lot->_feeExtraPerson, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('G'.$row,number_format($lot->_feeVehicle, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('H'.$row,number_format($lot->_feePastDue, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('I'.$row,number_format($lot->_feeLease, 2, '.', ','));
  $objPHPExcel->getActiveSheet()->SetCellValue('J'.$row,number_format($lot->_feeBalance, 2, '.', ','));
    // Style
  $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleBlankRow);
  
  $row++;
  $page++;
  
  // Style
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleBlankRow);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row.':J'.$row)->applyFromArray($styleBlankRow);
  $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,number_format($query->fields['usage'], 2, '.', ','));
  
  if ($alt == false) {
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':J'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':J'.$row)->getFill()->getStartColor()->setARGB('FFFFFFFF');
    $alt = true;
  } else {
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':J'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowStart.':J'.$row)->getFill()->getStartColor()->setARGB('FFE0E0E0');
    $alt = false;
  }

  $row  = $row + 2;
  
  if ($page % 14 == 1) {
    // Add a page break
    $objPHPExcel->getActiveSheet()->setBreak( 'A'.$row, PHPExcel_Worksheet::BREAK_ROW);
    $row++;
        //  Column headers
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row,'Lot');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'Tenant');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,'Meter Read');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,'Lot Rent');
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,'Pet Charge');
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$row,'Extra Person');
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$row,'Vehicle Charge');
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$row,'Late Charge');
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$row,'Lease Option');
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$row,'Previous Balance');
      // Style
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->applyFromArray($styleHeaderRow);
    $row++;
  }
  
  $lotQuery->MoveNext();
}
    
//  Set Number types
$objPHPExcel->getActiveSheet()->getStyle('D6:J'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
$objPHPExcel->getActiveSheet()->getStyle('C6:C'.$row)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('A6:J'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
//  Prep
$objPHPExcel->setActiveSheetIndex(0);
 
//  File Name
$filename = $park->_name . ' - Management Report - ' . date('F',$nextMonth) . ' - ' . time() . '.xls';
$filedir  = CACHE_DIR . 'reports/';
$filepath = $filedir . $filename;

//  Save to DB
if ($newFile == TRUE) {
  //  Query
  $query    = "INSERT INTO `reports` (`id`,`park_id`,`date`,`name`,`type`) VALUES (NULL,'" . $park->_id . "','" . $readDate . "','" . $filepath . "','R')";
  //  Write to file
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save($filepath);
  //  Update DB
  $DB->Execute($query);
}

// Redirect output to a client’s web browser (Excel2007)
header("Location:/cache/reports/$filename");

?>