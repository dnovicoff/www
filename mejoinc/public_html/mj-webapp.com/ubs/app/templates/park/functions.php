<?php
/*
 * Filename: 	functions.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 * Description:	Holds park functions
 */
 
//	Includes
include_once('../../config.php');
include_once('park.class.php');
include_once('lot.class.php');
include_once('calculations-new.php');
include_once('fpdf/fpdf.php');

function createCardsForPark($parkID,$recDate,&$DB) {
	//	Queries
	$parkQuery		= $DB->Execute("SELECT * FROM parks WHERE id='" . $parkID . "'");
	$lotQuery 		= $DB->Execute("SELECT DISTINCT * FROM lots WHERE park_id='". $parkID ."' AND vacant='N' ORDER BY lot");
	 
	// Class construction
	$park	= new Park($parkQuery);
	 
	// Create the card Object 
	$card	= new FPDF('L','mm',array(101.6,152.4));
	
	//	Margins
	$card->SetMargins(12.7,5.08,12.7);
	$card->SetAutoPageBreak(true,5.08);
	
	//	Meta data
	$card->SetAuthor('Birch Reality, Inc.');
	$card->SetTitle('Monthly Usage');
	$card->SetSubject('Monthly Usage');
	$card->SetKeywords('pdf usage ' . $park->_name . ' ' . $lot->_lotID);
	$card->SetCreator('Birch Reality, Inc.');
		
	 //	Loop
	 while (!$lotQuery->EOF) {
		$lot		= new Lot($lotQuery);
		$calc		= calculateBill($parkID,$lot->_id,$recDate,$DB);
			
		//	Later values
		$waterBill	= number_format($calc[0], 2, '.', ',');
		$sewerBill	= number_format($calc[1], 2, '.', ',');
		$usage		= number_format($calc[2], 2, '.', ',');
		$newUsage	= $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date='" . $recDate . "'");
		$oldUsage	= $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date=DATE_SUB('". $recDate . "', INTERVAL 31 DAY)");
		$balance	= number_format($lot->currentBalance() + $waterBill + $sewerBill + $park->_feeAdmin + $park->_feeService + $park->_feeFuel, 2, '.', ',');
	
		//	Add a new page	
		$card->AddPage();
		
		//	Card Header
		$card->SetFont('Times', '', 6);
		$card->Cell(35,3,$park->_name,0,1);
		$card->Cell(35,3,$park->_address,0,0);
		$card->Cell(37,3,$lot->_tenant,0,1);
		$card->Cell(35,3,$park->_city . ', ' . $park->_state . ' ' . $park->_zip,0,0);
	
		$card->Cell(37,3,'Bill Date: ' . $newUsage->fields['bill_date'],0,2);
		$card->Cell(37,3,'Due Date: ' . $newUsage->fields['due_date'],0,1);
		
		$card->SetFont('Times', 'BI', 6);
		$card->Cell(76,6,'Address Correction Requested',0,0);
		$card->Cell(60,6,'Pay To:  ' . $park->_name,0,1);
		
		//	Column Headers
		$card->SetFont('Times', 'B', 6);
		$card->Cell(13,3,"Date",'B',0,'C');
		$card->Cell(13,3,"Meter",'B',0,'C');
		$card->Cell(13,3,"Usage",'B',0,'C');
		$card->Cell(20,3,"Items",'B',0,'C');
		$card->Cell(13,3,"Amount",'B',0,'C');
		$card->Cell(4,3,"",0,0);
		$card->Cell(13,3,"Acct. Num.",'B',0,'C');
		$card->Cell(13,3,"Due Date",'B',1,'C');
		
		//	Row Data
		$card->SetFont('Times', '', 6);
		//	First Row
		$card->Cell(13,3,$newUsage->fields['record_date'],0,0);
		$card->Cell(13,3,$newUsage->fields['usage'],0,0);		// CHANGE TO - Current months "meter read"
		$card->Cell(13,3,$usage,0,0);		// CHANGE TO - "previous meter read" - "current meter read"
		$card->Cell(20,3,'Lot Rent',0,0,'L');
		$card->Cell(13,3,$lot->_feeRent,0,0,'R');
		$card->Cell(4,3,'',0,0);	// Spacer
		$card->Cell(13,3,$lot->_lotID,0,0,'C');
		$card->Cell(13,3,$newUsage->fields['due_date'],0,1,'C');
		
		//	Second Row
		$card->Cell(13,3,$oldUsage->fields['record_date'],0,0);	// CHANGE TO - Previous months record date
		$card->Cell(26,3,$oldUsage->fields['usage'],0,0);		// CHANGE TO - Previous months "meter read"
		$card->Cell(20,3,"Water Bill",0,0,'L');
		$card->Cell(13,3,$waterBill,0,1,'R');
		
		//	Subsequent Rows
		$card->Cell(39,3,"",0,0);	//	Spacer
		$card->Cell(20,3,"Sewer Bill",0,0,'L');
		$card->Cell(13,3,$sewerBill,0,0,'R');
		//	Right Side
		$card->Cell(4,3,"",0,0);	// Spacer
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Rent:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$lot->_feeRent,0,0,'R');
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Vehicle:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$lot->_feeVehicle,0,1,'R');
		
		$card->Cell(39,3,"",0,0);	//	Spacer
		$card->Cell(20,3,"Pet Charge",0,0,'L');
		$card->Cell(13,3,$lot->_feePet,0,0,'R');
		//	Right Side
		$card->Cell(4,3,"",0,0);	// Spacer
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Water:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$waterBill,0,0,'R');
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Late:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$lot->_feePastDue,0,1,'R');
		
		$card->Cell(39,3,"",0,0);	//	Spacer
		$card->Cell(20,3,"Extra Charge",0,0,'L');
		$card->Cell(13,3,$lot->_feeExtraPerson,0,0,'R');
		//	Right Side
		$card->Cell(4,3,"",0,0);	// Spacer
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Sewer:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$sewerBill,0,0,'R');
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Lease:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$lot->_feeLease,0,1,'R');
		
		$card->Cell(39,3,"",0,0);	//	Spacer
		$card->Cell(20,3,"Vehicle Charge",0,0,'L');
		$card->Cell(13,3,$lot->_feeVehicle,0,0,'R');
		//	Right Side
		$card->Cell(4,3,"",0,0);	// Spacer
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Pet:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$lot->_feePet,0,0,'R');
		$card->SetFont('Times','B',6);
		
		if ($park->_feeAdmin != '0.00') {
			$card->Cell(10,3,"Admin Fee:",0,0,'L');
			$card->SetFont('Times','',6);
			$card->Cell(10,3,$park->_feeAdmin,0,1,'R');
		} elseif ($park->_feeService != '0.00') {
			$card->Cell(10,3,"Service Fee:",0,0,'L');
			$card->SetFont('Times','',6);
			$card->Cell(10,3,$park->_feeService,0,1,'R');
		} elseif ($park->_feeFuel != '0.00') {
			$card->Cell(10,3,"Fuel Fee:",0,0,'L');
			$card->SetFont('Times','',6);
			$card->Cell(10,3,$park->_feeFuel,0,1,'R');
		}
		
		$card->Cell(39,3,"",0,0);	//	Spacer
		$card->Cell(20,3,"Late Fee",0,0,'L');
		$card->Cell(13,3,$lot->_feePastDue,0,0,'R');
		//	Right Side
		$card->Cell(4,3,"",0,0);	// Spacer
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Extra:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$lot->_feeVehicle,0,0,'R');
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Bal:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$lot->_feeBalance,0,1,'R');
		
		$card->Cell(39,3,"",0,0);	//	Spacer
		$card->Cell(20,3,"Lease Option",0,0,'L');
		$card->Cell(13,3,$lot->_feeLease,0,0,'R');
			//	Right Side
		$card->Cell(4,3,"",0,0);	// Spacer
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Due:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,$balance,0,1,'R');
		
		$card->Cell(39,3,"",0,0);	//	Spacer
		if ($park->_feeAdmin != '0.00') {
			$card->Cell(20,3,"Admin Fee",0,0,'L');
			$card->Cell(13,3,$park->_feeAdmin,0,1,'R');
		} elseif ($park->_feeService != '0.00') {
			$card->Cell(20,3,"Service Fee",0,0,'L');
			$card->Cell(13,3,$park->_feeService,0,1,'R');
		} elseif ($park->_feeFuel != '0.00') {
			$card->Cell(20,3,"Fuel Fee",0,0,'L');
			$card->Cell(13,3,$park->_feeFuel,0,1,'R');
		}
		$card->Cell(39,3,"",0,0);	//	Spacer
		$card->Cell(20,3,"Previous Balance",0,0,'L');
		$card->Cell(13,3,$lot->_feeBalance,0,0,'R');
			//	Right Side
		$card->Cell(4,3,"",0,0);	// Spacer
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Amount:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(14,3,"",'B',0,'C');
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Check #:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(10,3,"",'B',1,'C');
		
		//	Final Data Row
		$card->SetFont('Times','B',6);
		$card->Cell(39,3,"",0,0);	//	Spacer
		$card->Cell(20,3,"Amount Due:",'T',0,'L');
		$card->Cell(13,3,$balance,'T',0,'R');
			//	Right Side
		$card->Cell(4,3,"",0,0);	// Spacer
		$card->SetFont('Times','B',6);
		$card->Cell(10,3,"Date:",0,0,'L');
		$card->SetFont('Times','',6);
		$card->Cell(14,3,"",'B',1,'C');
		
		//	Right Side - Address
		$card->SetFont('Times','B',6);
		$card->Cell(136,3,"",0,1);	//	Line Break
		$card->Cell(76,3,"",0,0);	//	Spacer
		$card->Cell(60,3,"To:",0,2,'L');
		$card->SetFont('Times', '', 6);
	  if ($lot->_address != '' && $lot->_city != '' && $lot->_state != '' && $lot->_zip != '') {
		$card->Cell(60,3,$lot->_tenant,0,2,'L');
		$card->Cell(60,3,$lot->_address,0,2,'L');
		$card->Cell(60,3,$lot->_city . ', ' . $lot->_state . ' ' . $lot->_zip,0,1,'L');
	  } else {
		$card->Cell(60,3,"Office",0,2,'L');
		$card->Cell(60,3,$park->_address,0,2,'L');
		$card->Cell(60,3,$park->_city . ', ' . $park->_state . ' ' . $park->_zip,0,1,'L');
	  }
	
		
		//	Footer
		$card->Cell(136,3,"",0,1);	//	Line Break
		$card->SetFont('Times', 'I', 6);
		$card->Cell(76,6,"(KEEP THIS PORTION FOR YOUR RECORDS)",0,0,'C');
		$card->Cell(60,6,"(RETURN THIS PORTION)",0,1,'C');
		
		$lotQuery->MoveNext();
	 }
	 
	$filename	= $park->_name . ' - Card List - ' . $recDate . ' - ' . time() . '.pdf';
	$filepath	= CACHE_DIR . 'cards/';
	$query		= "INSERT INTO `reports` (`id`,`park_id`,`date`,`name`,`type`) VALUES (NULL,'" . $parkID . "','" . $recDate . "','" . $filepath . $filename . "','C')";
	$card->Output($filepath . $filename, 'F');
	$DB->Execute($query);
	
	return $filename;
}
?>