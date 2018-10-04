<?php
/*
 * $HeadURL: svn://mejoinc.com/repos/php/birch-realty/trunk/app/core/calculations.php $
 * $Id: calculations.php 9 2010-12-22 22:50:48Z matt $
 * $Author: matt $
 * $Revision: 9 $
 * $Date: 2010-12-22 17:50:48 -0500 (Wed, 22 Dec 2010) $
 */
 
function calculateBill($parkID, $lotID, $recDate, &$DB) {
	// Park and Lot queries
	$parkQuery    = $DB->Execute("SELECT * FROM parks WHERE id='" . $parkID . "'");
	$lotQuery     = $DB->Execute("SELECT DISTINCT * FROM lots WHERE id='". $lotID ."' AND vacant='N'");

	//  Create our Park and Lot objects
	$park = new Park($parkQuery);
	$lot  = new Lot($lotQuery);

	//  Set our return values to 0
	$waterBill  = 0;
	$sewerBill  = 0;
	$usage      = 0;

	//  Find our new usage (based on recDate) and our old usage (the month prior to recDate)
	$newUsage = $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date='" . $recDate . "'");
	//$oldUsage = $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date=DATE_SUB('". $recDate . "', INTERVAL 31 DAY)");
	$oldUsage = $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date!='". $recDate . "' ORDER BY id DESC LIMIT 1");
	$previousMonth = ($oldUsage->fields['record_date']);
	$usage    = ($newUsage->fields['usage'] - $oldUsage->fields['usage']);
	
	//	Check for minimum usage
	if ($usage < $park->_minimumUsage) {
		$usage = $park->_minimumUsage;
	}

	//  Is this a new park?  Check for 0 usage
	$lotCount = $DB->Execute("SELECT id FROM lots WHERE park_id='". $parkID . "'");
	$usageCheck = $DB->Execute("SELECT `id` FROM park_usage WHERE `park_id`='". $parkID . "' AND `usage`='0.00' AND `record_date`='". $previousMonth . "'");

	if ($lotCount->RecordCount() == $usageCheck->RecordCount()) {
		$isNewPark = TRUE;
	} else {
		$isNewPark = FALSE;
	}

/*
 *            CONVERSIONS
 */
	// Gallons (All gallon reads are in thousand gallon increments)
	if ($park->_readUnit == 'HG' && $park->_billingUnit == 'F') {  // Convert Hgallons to CCF
		$usage = $usage * 100;
		$usage = $usage * 0.133680556;
	}
	if ($park->_readUnit == 'TG' && $park->_billingUnit == 'F') {  // Convert Tgallons to CCF
		$usage = $usage * 1000;
		$usage = $usage * 0.133680556;
	}
	if ($park->_readUnit == 'HG' && $park->_billingUnit == 'HG') {  // Convert Hgallons to Hgallons
		//	Change made 01-25-2012
		//$usage = $usage * 100;
	}
	if ($park->_readUnit == 'HG' && $park->_billingUnit == 'TG') {  // Convert Hgallons to Hgallons
		$usage = $usage * 10;
	}
	if ($park->_readUnit == 'TG' && $park->_billingUnit == 'TG') {  // Convert decimal to Tgallons
		//	Change made 01-25-2012
		//$usage = $usage * 1000;
	}
	// Cubic Feet
	if ($park->_readUnit == 'F' && $park->_billingUnit == 'HG') { // Convert CCF to Hgallons
		$usage = $usage * 100;
		$usage = $usage * 7.48051948;
	}
	if ($park->_readUnit == 'F' && $park->_billingUnit == 'TG') { // Convert CCF to Tgallons
		$usage = $usage * 100;
		$usage = $usage * 7.48051948;
	}
	if ($park->_readUnit == 'F' && $park->_billingUnit == 'F') { // Convert CCF to gallons
		//	Change made 01-25-2012
		//$usage = $usage * 100;	
	}

	/*
	 *            WATER BILLING
	 */
	
	if ($lot->_chargeWater == TRUE) {
		$ADODB_FETCH_MODE   = ADODB_FETCH_NUM;
		#	'SELECT * FROM water_rates WHERE park_id='" . $park->_id . "' AND (lower_threshold < '". $usage ."' OR upper_threshold > '". $usage ."') AND lower_threshold < '". $usage ."' ORDER BY tier ASC'
		
		$waterQuery         = $DB->EXECUTE("SELECT * FROM water_rates WHERE park_id='" . $park->_id . "' ORDER BY tier ASC");
		$loopUsage          = number_format($usage, 2, '.', '');

		foreach($waterQuery as $k => $row) {
			/**
			 *  row[0] = id
			 *  row[1] = park_id
			 *  row[2] = rate
			 *  row[3] = tier
			 *  row[4] = cutoff
			 *  row[5] = lower_threshold
			 *  row[6] = upper_threshold
			 */
			
			//  Tier 0
			if ($row[3] == 0) 
			{
				$waterBill = $waterBill + $row[2]; // Add the base rate to the total
			}
			
			//	Flat fee for when the tier is 1 and the cutoff is 0 (for minimum usage)
			if ($row[3] == 1 && $row[4] == 0)
			{
				if ($loopUsage > $row[6])
				{
					$tierPrice = $row[2];
					$loopUsage = $loopUsage - $row[6];
					$waterBill = $waterBill + $tierPrice;

				}
				else
				{
					$tierPrice = $row[2];
					$loopUsage = 0;
					$waterBill = $waterBill + $tierPrice;
				}
			}
			
			if ($row[5] != NULL && $row[6] != NULL && $row[3] != 0 && $row[4] != 0) 
			{
				//  When usage is inbetween the upper and lower thresholds
				if (($loopUsage >= $row[5]) && ($loopUsage <= $row[6]) && ($loopUsage != 0)) 
				{
					if ($row[4] != 0) 
					{  // Check for division by 0; if cutoff is 0
						//	Check for base range tier
						$tierPrice = (($loopUsage / $row[4]) * $row[2]);
						//$tierPrice = ($loopUsage * $row[2]);
					} 
					else 
					{ //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice =  $row[2];
					}
					$waterBill = $waterBill + $tierPrice;
					$loopUsage = 0;
				}
			
				//  When usage exceeds the upper threshold
				if (($row[5] <= $loopUsage) && ($loopUsage >= $row[6]) && ($loopUsage != 0)) 
				{
					if ($row[4] != 0) 
					{  // Check for division by 0
						//	Change made 01-25-2012
						$tierPrice = ($row[6] / $row[4]) * $row[2];
						//$tierPrice = $loopUsage * $row[2];
						$loopUsage = $loopUsage - $row[6];
					} 
					else 
					{ //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice = $loopUsage * $row[2];
					}

					$waterBill = $waterBill + $tierPrice;
				}
				
				//  Remainder usage
				if (($loopUsage <= $row[5]) && ($loopUsage <= $row[6]) && ($loopUsage != 0)) 
				{
					if ($row[4] != 0 && $row[4] != NULL) 
					{  // Check for division by 0
					/*
					*		CHANGE FOR BC & TO
					*/
						$tierPrice = ($loopUsage / $row[4]) * $row[2];
						//$tierPrice = $loopUsage * $row[2];
					} 
					else 
					{ //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice = $row[2];
					}
					
					$waterBill = $waterBill + $tierPrice;
					$loopUsage = 0;
				}
			}
		}
	}
	
	/*
	 *            SEWER BILLING
	 */
	
	if ($lot->_chargeSewer == TRUE) {
	$ADODB_FETCH_MODE   = ADODB_FETCH_NUM;
	$sewerQuery         = $DB->EXECUTE("SELECT * FROM sewer_rates WHERE park_id='" . $park->_id . "' ORDER BY tier ASC");
	$loopUsage          = number_format($usage, 2, '.', '');
	
	foreach($sewerQuery as $k => $row) {
			/**
			 *  row[0] = id
			 *  row[1] = park_id
			 *  row[2] = rate
			 *  row[3] = tier
			 *  row[4] = cutoff
			 *  row[5] = lower_threshold
			 *  row[6] = upper_threshold
			 */
			
			//  Tier 0
			if ($row[3] == 0) 
			{
				$sewerBill = $sewerBill + $row[2]; // Add the base rate to the total
			}
			
			//	Flat fee for when the tier is 1 and the cutoff is 0 (for minimum usage)
			if ($row[3] != 0 && $row[4] == 0)
			{
				if ($loopUsage > $row[6])
				{
					$tierPrice = $row[2];
					$loopUsage = $loopUsage - $row[6];
					$sewerBill = $sewerBill + $tierPrice;

				}
				else
				{
					if ($loopUsage != 0)
					{
						$tierPrice = $row[2];
						$loopUsage = 0;
						$sewerBill = $sewerBill + $tierPrice;
					}
				}
			}
			
			if ($row[5] != NULL && $row[6] != NULL && $row[3] != 0 && $row[4] != 0) 
			{
				//  When usage is inbetween the upper and lower thresholds
				if (($loopUsage >= $row[5]) && ($loopUsage <= $row[6]) && ($loopUsage != 0)) 
				{
					if ($row[4] != 0) 
					{  // Check for division by 0; if cutoff is 0
						//	Check for base range tier
						
						$tierPrice = ($loopUsage / $row[4]) * $row[2];
						//$tierPrice = ($loopUsage * $row[2]);

					} 
					else 
					{ //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice =  $row[2];
					}
					
					$sewerBill = $sewerBill + $tierPrice;
					$loopUsage = 0;
				}
			
				//  When usage exceeds the upper threshold
				if (($row[5] <= $loopUsage) && ($loopUsage >= $row[6]) && ($loopUsage != 0)) 
				{
					if ($row[4] != 0) 
					{  // Check for division by 0		
						//	Change made 01-25-2012
						$tierPrice = ($row[6] / $row[4]) * $row[2];
						//$tierPrice = $loopUsage * $row[2];
						$loopUsage = $loopUsage - $row[6];
					} 
					else 
					{ //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice = $loopUsage * $row[2];
					}
					$sewerBill = $$sewerBill + $tierPrice;
				}
				
				//  Remainder usage
				if (($row[5] >= $loopUsage) && ($loopUsage <= $row[6]) && ($loopUsage != 0)) 
				{
					if ($row[4] != 0 && $row[4] != NULL) 
					{  // Check for division by 0
						$tierPrice = ($loopUsage / $row[4]) * $row[2];
					} 
					else 
					{ //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice = $row[2];
					}
					
					$sewerBill = $sewerBill + $tierPrice;
					$loopUsage = 0;
				}
			}
		}
	}
	
	/*
	 *            TAXES
	 */
	if ($park->_chargeWaterTax == TRUE) {
		$waterBill = ($waterBill * $park->_feeTax);
	}
	
	if ($park->_chargeSewerTax == TRUE) {
		$sewerBill = ($sewerBill * $park->_feeTax);
	}
	
	/*
	 *            CONVERSIONS
	 */
	if ($park->_readUnit == 'F' && $park->_billingUnit == 'HG') {
		$waterBill = ($waterBill / 1000);
		$sewerBill = ($sewerBill / 1000);
	}
	//  if ($park->_readUnit == 'TG' && $park->_billingUnit == 'TG') {  // This breaks Parkway Estates & Watertower but fixes Gregory Creek
	//	$waterBill = ($waterBill / 1000);
	//    $sewerBill = ($sewerBill / 1000);
	//  }
	
	$usage    = ($newUsage->fields['usage'] - $oldUsage->fields['usage']);
	
	return array($waterBill,$sewerBill,$usage);
}
?>