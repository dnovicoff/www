<?php
/*
 * $HeadURL: svn://mejoinc.com/repos/php/birch-realty/trunk/app/core/cards/create.php $
 * $Id: create.php 11 2010-12-23 01:28:40Z matt $
 * $Author: matt $
 * $Revision: 11 $
 * $Date: 2010-12-22 20:28:40 -0500 (Wed, 22 Dec 2010) $
 */
 
//	Includes
include_once('config.php');
include_once('park.class.php');
include_once('lot.class.php');
include_once('calculations.php');
include_once('fpdf/fpdf.php');

function createCardsForPark($parkID,$recDate,&$DB) {
	
	//	Queries
	$parkQuery		= $DB->Execute("SELECT * FROM parks WHERE id='" . $parkID . "'");
	$lotQuery 		= $DB->Execute("SELECT DISTINCT * FROM lots WHERE park_id='". $parkID ."' AND vacant='N' ORDER BY lot ASC");
	 
	// Class construction
	$park	= new Park($parkQuery);
	 
	// Create the card Object 
	$card	= new FPDF('L','mm',array(101.8,151.6));
	
	//	Margins
	$card->SetMargins(2.7,3.08,2.7);
	$card->SetAutoPageBreak(true,3.08);
	
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
		
		$newUsage	= $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date='" . $recDate . "'");
		//$oldUsage	= $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date=DATE_SUB('". $recDate . "', INTERVAL 31 DAY)");
		$oldUsage = $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date!='". $recDate . "' ORDER BY id DESC LIMIT 1");
		$preBalance	= $lot->currentBalance() + $waterBill + $sewerBill;
		
		$usage		= number_format($newUsage->fields['usage'] - $oldUsage->fields['usage'], 2, '.', ',');
		

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
		
		//	Add a new page	
		$card->AddPage();
		
		//	Card Header
		$card->SetFont('Arial', '', 8);
		$card->Cell(48,3,$park->_name,0,1);
		if ($lot->_address != '' && $lot->_city != '')
		{
			$card->Cell(48,3,$lot->_address . ' Lot ' . $lot->_lotID,0,0);
		}
		else
		{
			$card->Cell(48,3,$park->_address . ' Lot ' . $lot->_lotID,0,0);
		}
		$card->Cell(28,3,$lot->_tenant,0,1,'R');
		$card->Cell(48,3,$park->_city . ', ' . $park->_state . ' ' . $park->_zip,0,0);
	
		$card->Cell(42,3,'Bill Date: ' . $newUsage->fields['bill_date'],0,2);
		$card->Cell(42,3,'Due Date: ' . $newUsage->fields['due_date'],0,1);
		
		$card->SetFont('Arial', 'BI', 8);
		$card->Cell(85.6,6,'Address Correction Requested',0,0);
		$card->Cell(60,6,'Pay To:  ' . $park->_name,0,1);
		
		//	Column Headers
		$card->SetFont('Arial', 'B', 8);
		$card->Cell(17,3,"Date",'B',0,'C');
		$card->Cell(13,3,"Meter",'B',0,'C');
		$card->Cell(13,3,"Usage",'B',0,'C');
		$card->Cell(22,3,"Items",'B',0,'C');
		$card->Cell(15,3,"Amount",'B',0,'C');
		$card->Cell(10,3,"",0,0);
		$card->Cell(20,3,"Acct. Num.",'B',0,'C');
		$card->Cell(20,3,"Due Date",'B',1,'C');
		
		//	Row Data
		$card->SetFont('Arial', '', 8);
		//	First Row
		$card->Cell(17,3,$newUsage->fields['record_date'],0,0);
		$card->Cell(13,3,$newUsage->fields['usage'],0,0);		// CHANGE TO - Current months "meter read"
		$card->Cell(13,3,$usage,0,0);		// CHANGE TO - "previous meter read" - "current meter read"
		$card->Cell(22,3,'Lot Rent',0,0,'L');
		$card->Cell(15,3,$lot->_feeRent,0,0,'R');
		$card->Cell(10,3,'',0,0);	// Spacer
		$card->Cell(20,3,$lot->_lotID,0,0,'C');
		$card->Cell(20,3,$newUsage->fields['due_date'],0,1,'C');
		
		//	Second Row
		$card->Cell(17,3,$oldUsage->fields['record_date'],0,0);	// CHANGE TO - Previous months record date
		$card->Cell(13,3,$oldUsage->fields['usage'],0,0);		// CHANGE TO - Previous months "meter read"
		$card->Cell(13,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Water Bill",0,0,'L');
		$card->Cell(15,3,$waterBill,0,1,'R');
		
		//	Subsequent Rows
		$card->Cell(43,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Sewer Bill",0,0,'L');
		$card->Cell(15,3,$sewerBill,0,0,'R');
		//	Right Side
		$card->Cell(6,3,"",0,0);	// Spacer
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Rent:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(14,3,$lot->_feeRent,0,0,'R');
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Vehicle:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(14,3,$lot->_feeVehicle,0,1,'R');
		
		$card->Cell(43,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Pet Charge",0,0,'L');
		$card->Cell(15,3,$lot->_feePet,0,0,'R');
		//	Right Side
		$card->Cell(6,3,"",0,0);	// Spacer
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Water:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(14,3,$waterBill,0,0,'R');
		$card->SetFont('Arial','B',8);
		$card->Cell(14,3,"Late:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(10,3,$lot->_feePastDue,0,1,'R');
		
		$card->Cell(43,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Extra Charge",0,0,'L');
		$card->Cell(15,3,$lot->_feeExtraPerson,0,0,'R');
		//	Right Side
		$card->Cell(6,3,"",0,0);	// Spacer
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Sewer:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(14,3,$sewerBill,0,0,'R');
		$card->SetFont('Arial','B',8);
		$card->Cell(14,3,"Lease:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(10,3,$lot->_feeLease,0,1,'R');
		
		$card->Cell(43,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Vehicle Charge",0,0,'L');
		$card->Cell(15,3,$lot->_feeVehicle,0,0,'R');
		//	Right Side
		$card->Cell(6,3,"",0,0);	// Spacer
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Pet:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(14,3,$lot->_feePet,0,0,'R');
		$card->SetFont('Arial','B',8);
		$card->Cell(14,3,"Admin:",0,0,'L');
		$card->SetFont('Arial','',8);
		if ($lot->_isVacant == TRUE) {
			$card->Cell(10,3,'0.00',0,1,'R');
		} else {
			if ($lot->_chargeAdmin == FALSE) {
				$card->Cell(10,3,'0.00',0,1,'R');
			} else {
				$card->Cell(10,3,$park->_feeAdmin,0,1,'R');
			}
		}
	
		$card->Cell(43,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Late Fee",0,0,'L');
		$card->Cell(15,3,$lot->_feePastDue,0,0,'R');
		//	Right Side
		$card->Cell(6,3,"",0,0);	// Spacer
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Extra:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(14,3,$lot->_feeExtraPerson,0,0,'R');
		$card->SetFont('Arial','B',8);
		$card->Cell(14,3,"Bal:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(10,3,$lot->_feeBalance,0,1,'R');
		
		$card->Cell(43,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Lease Option",0,0,'L');
		$card->Cell(15,3,$lot->_feeLease,0,0,'R');
			//Right Side
		$card->Cell(6,3,"",0,0);	// Spacer
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Due:",0,0,'L');
		$card->SetFont('Arial','',8);
		
	 	if ($park->_feeFuel != '0.00') {
	 		$card->Cell(14,3,$balance,0,0,'R');
	 		$card->SetFont('Arial','B',8);
			$card->Cell(10,3,$park->_feeOtherName . ':',0,0,'L');
			$card->SetFont('Arial','',8);
			if ($lot->_isVacant == TRUE) {
				$card->Cell(14,3,'0.00',0,1,'R');
			} else {
				if ($lot->_chargeFuel == FALSE) {
					$card->Cell(14,3,'0.00',0,1,'R');
				} else {
					$card->Cell(14,3,$park->_feeFuel,0,1,'R');
				}
			}
		} else {
			$card->Cell(14,3,$balance,0,1,'R');
		}
		if ($park->_feeService != '0.00') {
	 		$card->SetFont('Arial','B',8);
			$card->Cell(10,3,"Service:",0,0,'L');
			$card->SetFont('Arial','',8);
			if ($lot->_isVacant == TRUE) {
				$card->Cell(14,3,'0.00',0,1,'R');
			} else {
				if ($lot->_chargeService == FALSE) {
					$card->Cell(14,3,'0.00',0,1,'R');
				} else {
					$card->Cell(14,3,$park->_feeService,0,1,'R');
				}
			}
		}
		
		$card->Cell(43,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Admin Fee",0,0,'L');
	 	if ($lot->_isVacant == TRUE) {
			$card->Cell(15,3,'0.00',0,1,'R');
		} else {
			if ($lot->_chargeAdmin == FALSE) {
				$card->Cell(15,3,'0.00',0,1,'R');
			} else {
				$card->Cell(15,3,$park->_feeAdmin,0,1,'R');
			}
		}
		
	 	/*
		 * Service & Fuel Fee logic
		 * This determines the remainder of the card's layout
		 */
		
		if ($park->_feeFuel != '0.00') {
			$card->Cell(43,3,"",0,0);	//	Spacer
			$card->Cell(22,3,$park->_feeOtherName,0,0,'L');
			$card->SetFont('Arial','',8);
			if ($lot->_isVacant == TRUE) {
				$card->Cell(15,3,'0.00',0,1,'R');
			} else {
				if ($lot->_chargeFuel == FALSE) {
					$card->Cell(15,3,'0.00',0,1,'R');
				} else {
					$card->Cell(15,3,$park->_feeFuel,0,1,'R');
				}
			}
		}
		if ($park->_feeService != '0.00') {
			$card->Cell(43,3,"",0,0);	//	Spacer
			$card->Cell(22,3,"Service Fee",0,0,'L');
			$card->SetFont('Arial','',8);
			if ($lot->_isVacant == TRUE) {
				$card->Cell(15,3,'0.00',0,1,'R');
			} else {
				if ($lot->_chargeService == FALSE) {
					$card->Cell(15,3,'0.00',0,1,'R');
				} else {
					$card->Cell(15,3,$park->_feeService,0,1,'R');
				}
			}
		}
		
		$card->Cell(43,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Previous Balance",0,0,'L');
		$card->Cell(15,3,$lot->_feeBalance,0,0,'R');
			//	Right Side
		$card->Cell(10,3,"",0,0);	// Spacer
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Amount:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(14,3,"",'B',0,'C');
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Check #:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(10,3,"",'B',1,'C');
		
		//	Final Data Row
		$card->SetFont('Arial','B',8);
		$card->Cell(43,3,"",0,0);	//	Spacer
		$card->Cell(22,3,"Amount Due:",'T',0,'L');
		$card->Cell(15,3,$balance,'T',0,'R');
			//	Right Side
		$card->Cell(10,3,"",0,0);	// Spacer
		$card->SetFont('Arial','B',8);
		$card->Cell(10,3,"Date:",0,0,'L');
		$card->SetFont('Arial','',8);
		$card->Cell(14,3,"",'B',1,'C');
		
		//	Right Side - Address
		$card->SetFont('Arial','B',8);
		$card->Cell(136,3,"",0,1);	//	Line Break
		$card->Cell(85.6,3,"",0,0);	//	Spacer
		$card->Cell(60,3,"To:",0,2,'L');
		$card->SetFont('Arial', '', 8);
	  if ($lot->_address != '' && $lot->_city != '' && $lot->_state != '' && $lot->_zip != '') {
		$card->Cell(60,3,$lot->_tenant,0,2,'L');
		$card->Cell(60,3,$lot->_address . ' ' . $lot->_lotID ,0,2,'L');
		$card->Cell(60,3,$lot->_city . ', ' . $lot->_state . ' ' . $lot->_zip,0,1,'L');
	  } else {
		$card->Cell(60,3,"Office",0,2,'L');
		$card->Cell(60,3,$park->_address,0,2,'L');
		$card->Cell(60,3,$park->_city . ', ' . $park->_state . ' ' . $park->_zip,0,1,'L');
 	  } 
	
		
		//	Footer
		$card->Cell(136,3,"",0,1);	//	Line Break
		$card->SetFont('Arial', 'I', 8);
		$card->Cell(76,6,"(KEEP THIS PORTION FOR YOUR RECORDS)",0,0,'C');
		$card->Cell(60,6,"(RETURN THIS PORTION)",0,1,'C');
			
		$lotQuery->MoveNext();
	 }
	 
	$filename	= $park->_name . ' - Card List - ' . $recDate . ' - ' . time() . '.pdf';
	$filepath	= CACHE_DIR . 'cards/';
	
	$query		= "INSERT INTO `reports` (`id`,`park_id`,`date`,`name`,`type`) VALUES (NULL,'" . $parkID . "','" . $recDate . "','" . $filepath . $filename . "','C')";
	$DB->Execute($query);
	$card->Output($filepath . $filename, 'F');
	#$card->Output($filename, 'D');
	
	
	return $filename;
}
?>