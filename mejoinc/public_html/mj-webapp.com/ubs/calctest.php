<?php
require('app/config.php');
include_once('park.class.php');
include_once('lot.class.php');

define('DEBUG_STRICT',TRUE);
$DB->debug = false;



//North Town Estates (Passed 4/4/10)
runTest(1, 60, '2012-02-10', $DB);
/*
//Leisure Village (Passed 4/4/10)
runTest(2, 446, '2012-01-10', $DB);
runTest(2, 456, '2012-01-10', $DB);
runTest(2, 453, '2012-01-10', $DB);

//Beaver Creek (Passed 4/4/10)
runTest(3, 338, '2011-04-10', $DB);
runTest(3, 343, '2011-04-10', $DB);
//Parkway Estates (Passed 4/4/10)
runTest(4, 713, '2011-03-15', $DB);
runTest(4, 766, '2011-03-15', $DB);

//Quail Run (Passed 4/4/10)
runTest(5, 786, '2012-02-10', $DB);
runTest(5, 815, '2012-02-10', $DB);

//Cortini
runTest(6, 852, '2011-01-10', $DB);
runTest(6, 892, '2011-01-10', $DB);

//Riverview

//Twin Oaks (Passed 4/4/10)
//runTest(8, 1022, '2011-03-10', $DB);
//runTest(8, 1044, '2011-03-10', $DB);

//Green Meadows (Passed 4/4/10)
runTest(9, 1212, '2011-03-10', $DB);
runTest(9, 1213, '2011-03-10', $DB);
*/
//Watertower (Passed 4/4/10)
runTest(10, 1338, '2012-02-10', $DB);
runTest(10, 1362, '2012-02-10', $DB);
runTest(10, 1368, '2012-02-10', $DB);
/*
//Gregory Creek (Passed 4/4/10)
runTest(11, 1391, '2011-03-10', $DB);
runTest(11, 1419, '2011-03-10', $DB);

//Lucky Star (Passed 4/4/10)
runTest(12, 1156, '2012-02-10', $DB);
runTest(12, 1164, '2012-02-10', $DB);

//Colonial Heights (Passed 4/4/10)
runTest(13, 1450, '2011-03-10', $DB);
runTest(13, 1461, '2011-03-10', $DB);

//Avenue A (Passed 4/4/10)
runTest(14, 1636, '2011-04-05', $DB);
runTest(14, 1651, '2011-04-05', $DB);

//Nomad
runTest(16, 1867, '2011-06-01', $DB);

//Skyview Acres
runTest(18, 1985, '2012-02-10', $DB);
runTest(18, 2013, '2012-02-10', $DB);
runTest(18, 2015, '2012-02-10', $DB);
*/

function debugOut($name,$val) {
echo "<p style='color:red;font-weight:bold'>** DEBUG **<ul><li><strong>var:</strong> <em>$name</em></li><li><strong>val:</strong> <em>$val</em></li></ul>";
}

function debugMessage($msg) {
echo "** DEBUG ** Variable: <strong>$msg</strong><br />";
}

function runTest($park, $lot, $date, $DB) {
echo "<h2>Park ID <u>$park</u></h2><h3>Lot $lot		|		Date: $date</h3>";
$results = calculateBill($park, $lot, $date, $DB);
debugOut('$waterBill',$results[0]);
debugOut('$sewerBill', $results[1]);
echo "<hr />";
}

function calculateBill($parkID, $lotID, $recDate, &$DB) {
	// Park and Lot queries
	$parkQuery    = $DB->Execute("SELECT * FROM parks WHERE id='" . $parkID . "'");
	$lotQuery     = $DB->Execute("SELECT DISTINCT * FROM lots WHERE id='". $lotID ."' AND vacant='N'");

	//  Create our Park and Lot objects
	$park = new Park($parkQuery);
	$lot  = new Lot($lotQuery);
	
	if (DEBUG_STRICT == TRUE) {
		echo "Billing: $park->_billingUnit<br />";
		echo "Read: $park->_readUnit<br />";
	}
	
	//  Set our return values to 0
	$waterBill  = 0;
	$sewerBill  = 0;
	$usage      = 0;

	//  Find our new usage (based on recDate) and our old usage (the month prior to recDate)
	$newUsage = $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date='" . $recDate . "'");
	$oldUsage = $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $parkID . "' AND lot_id='" . $lot->_id . "' AND record_date!='". $recDate . "' ORDER BY id DESC LIMIT 1");
	$previousMonth = ($oldUsage->fields['record_date']);
	
	if (DEBUG_STRICT == TRUE) {
		echo "Old Usage: " . $oldUsage->fields['usage'] . "<br />";
		echo "New Usage: " . $newUsage->fields['usage'] . "<br />";
	}
	
	$usage    = ($newUsage->fields['usage'] - $oldUsage->fields['usage']);
	if ($usage == 0)
	{
		
		$usage = $park->_minimumUsage;
	}
	
		echo "Usage: $usage<br />";

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
		//$usage = $usage * 100;
	}
	if ($park->_readUnit == 'HG' && $park->_billingUnit == 'TG') {  // Convert Hgallons to Hgallons
		$usage = $usage * 10;
	}
	if ($park->_readUnit == 'TG' && $park->_billingUnit == 'TG') {  // Convert Tgallons to Tgallons
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
		$staticUsage		= $usage;
		
		echo '<br />----------WATER ------------<br /><br />';
		foreach($waterQuery as $k => $row) {
		
			if (DEBUG_STRICT == TRUE) {
				
				//echo "[id] : $row[0]<br />";
				//echo "[park_id] : $row[1]<br />";
				echo "[rate] : $row[2]<br />";
				echo "[tier] : $row[3]<br />";
				echo "[cutoff] : $row[4]<br />";
				echo "[lower] : $row[5]<br />";
				echo "[upper] : $row[6]<br />";
				echo "[loopUsage] : $loopUsage<br />";
			}
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
			if ($row[3] == 0) {
				$waterBill = $waterBill + $row[2]; // Add the base rate to the total
			}
			
			//	Flat fee for when the tier is 1 and the cutoff is 0 (for minimum usage)
			if ($row[3] == 1 && $row[4] == 0)
			{
				echo $loopUsage . ' & ' . $row[6];
				if ($loopUsage > $row[6])
				{
					echo 'HERE 1';
					$tierPrice = $row[2];
					$loopUsage = $loopUsage - $row[6];
					$waterBill = $waterBill + $tierPrice;

				}
				else
				{
					echo 'HERE 2';
					$tierPrice = $row[2];
					$loopUsage = 0;
					$waterBill = $waterBill + $tierPrice;
				}
			}
			
			if ($row[5] != NULL && $row[6] != NULL && $row[3] != 0 && $row[4] != 0) {
				//  When usage is inbetween the upper and lower thresholds
				//echo "$row[5] $row[6] $row[3] $loopUsage<br />";
				if (($loopUsage >= $row[5]) && ($loopUsage <= $row[6]) && ($loopUsage != 0)) {
				//	echo "$row[5] $row[6] $row[3] $loopUsage<br />";
					if ($row[4] != 0) {  // Check for division by 0; if cutoff is 0
						//	Check for base range tier
/*
						$cutoffCheck = $DB->EXECUTE("SELECT cutoff FROM water_rates WHERE park_id='" . $park->_id . "' AND tier='1'");
						if ($cutoffCheck->fields['cutoff'] != 0) {
							$loopUsage = $loopUsage - $row[5];
						}
*/
						$tierPrice = (($loopUsage / $row[4]) * $row[2]);
						//$tierPrice = ($loopUsage * $row[2]);
					} else { //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice =  $row[2];
					} 
					echo "Bill: $waterBill <br /><br />";
					echo "Between: $tierPrice <br /><br />";
					$waterBill = $waterBill + $tierPrice;
					echo "Bill: $waterBill <br /><br />";
					$loopUsage = 0;
				}
			
				//  When usage exceeds the upper threshold
				if (($row[5] <= $loopUsage) && ($loopUsage >= $row[6]) && ($loopUsage != 0)) {
					if ($row[4] != 0) {  // Check for division by 0
						//	Change made 01-25-2012
						$tierPrice = ($row[6] / $row[4]) * $row[2];
						//$tierPrice = $loopUsage * $row[2];
						$loopUsage = $loopUsage - $row[6];
					} else { //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice = $loopUsage * $row[2];
					}
					echo "Exceeds upper: $tierPrice <br /><br />";
					$waterBill = $waterBill + $tierPrice;
				}

				
				//  Remainder usage
				if (($loopUsage >= $row[5]) && ($loopUsage <= $row[6]) && ($loopUsage != 0)) {
					if ($row[4] != 0 && $row[4] != NULL) {  // Check for division by 0
					/*
					*		CHANGE FOR BC & TO
					*/
						$tierPrice = ($loopUsage / $row[4]) * $row[2];
						//$tierPrice = $loopUsage * $row[2];
					} else { //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice = $row[2];
					}
					echo "Bill: $waterBill <br /><br />";
					echo "Remainder: $tierPrice <br /><br />";
					$waterBill = $waterBill + $tierPrice;
					echo "Bill: $waterBill <br /><br />";
					$loopUsage = 0;
				}
				
				echo "Loop Usage: $loopUsage <br /> <br />";
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
	
	echo '<br />----------SEWER ------------<br /><br />';
	foreach($sewerQuery as $k => $row) {
		
			if (DEBUG_STRICT == TRUE) {
				//echo "[id] : $row[0]<br />";
				//echo "[park_id] : $row[1]<br />";
				echo "[rate] : $row[2]<br />";
				echo "[tier] : $row[3]<br />";
				echo "[cutoff] : $row[4]<br />";
				echo "[lower] : $row[5]<br />";
				echo "[upper] : $row[6]<br />";
				echo "[loopUsage] : $loopUsage<br />";
			}
			/**
			 *  row[0] = id
			 *  row[1] = park_id
			 *  row[2] = rate
			 *  row[3] = tier
			 *  row[4] = cutoff
			 *  row[5] = lower_threshold
			 *  row[6] = upper_threshold
			 */
			echo "$row[4] $row[5] $row[6] $row[3] $loopUsage<br />";
			//  Tier 0
			if ($row[3] == 0) {
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
					echo 'here';
					$sewerBill = $sewerBill + $tierPrice;
					}
				}
			}
			
			if ($row[5] != NULL && $row[6] != NULL && $row[3] != 0 && $row[4] != 0) {
				//  When usage is inbetween the upper and lower thresholds
				if (($loopUsage >= $row[5]) && ($loopUsage <= $row[6]) && ($loopUsage != 0)) {
					echo "Between Usage $row[5] $row[6] $row[3] $loopUsage<br />";
					if ($row[4] != 0) {  // Check for division by 0; if cutoff is 0
						//	Check for base range tier
						$cutoffCheck = $DB->EXECUTE("SELECT cutoff FROM sewer_rates WHERE park_id='" . $park->_id . "' AND tier='1'");
						if ($cutoffCheck->fields['cutoff'] != 0) {
							$loopUsage = $loopUsage - $row[5];
						}
						$tierPrice = ($loopUsage / $row[4]) * $row[2];
						//$tierPrice = ($loopUsage * $row[2]);

					} else { //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice =  $row[2];
					}
					echo "Between: $tierPrice <br /><br />";
					$sewerBill = $sewerBill + $tierPrice;
					$loopUsage = 0;
				}
			
				//  When usage exceeds the upper threshold
				if (($row[5] <= $loopUsage) && ($loopUsage >= $row[6]) && ($loopUsage != 0)) {
					if ($row[4] != 0) {  // Check for division by 0
						//	Change made 01-25-2012
						$tierPrice = ($row[6] / $row[4]) * $row[2];
						//$tierPrice = $loopUsage * $row[2];
						$loopUsage = $loopUsage - $row[6];
					} else { //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice = $loopUsage * $row[2];
					}
					echo "Exceeds upper: $tierPrice <br /><br />";
					$sewerBill = $$sewerBill + $tierPrice;
				}
				
				//  Remainder usage
				if (($row[5] >= $loopUsage) && ($loopUsage <= $row[6]) && ($loopUsage != 0) && ($row[3] != 1)) {
					if ($row[4] != 0 && $row[4] != NULL) {  // Check for division by 0
						$tierPrice = ($loopUsage / $row[4]) * $row[2];
					} else { //  If the cutoff is 0, then the rate is the tierPrice
						$tierPrice = $row[2];
					}
					echo "Remainder: $tierPrice <br /><br />";
					$sewerBill = $sewerBill + $tierPrice;
					$loopUsage = 0;
				}
				
				echo "Loop Usage: $loopUsage <br /> <br />";
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
