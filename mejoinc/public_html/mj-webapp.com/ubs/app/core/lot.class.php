<?php
/*
 * Filename: 	lot.class.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
 class Lot {
 	// Lot
 	public $_id;
	public $_parkID;
 	public $_lotID;
 	public $_isVacant;
 	public $_tenant;
	public $_address;
	public $_city;
	public $_state;
	public $_zip;
	//	
	public $_chargeWater;
	public $_chargeSewer;
	public $_chargeAdmin;
	public $_chargeService;
	public $_chargeFuel;
 	// Fees
 	public $_feeRent;
 	public $_feePet;
 	public $_feeExtraPerson;
 	public $_feeVehicle;
 	public $_feeLease;
 	public $_feePastDue;
 	public $_feeBalance;
 	
 	public function __construct($lotQuery) {
 		// Lot
 		$this->_id			= $lotQuery->fields['id'];
		$this->_parkID		= $lotQuery->fields['park_id'];
 		$this->_lotID		= $lotQuery->fields['lot'];
		$this->_address		= $lotQuery->fields['street_address'];
		$this->_city		= $lotQuery->fields['city'];
 		$this->_state		= $lotQuery->fields['state'];
		$this->_zip			= $lotQuery->fields['zip'];
 		if ($lotQuery->fields['vacant'] == 'Y') {
 			$this->_isVacant = TRUE;
			$this->_tenant		= 'VACANT';
 		} else {
 			$this->_isVacant = FALSE;
			$this->_tenant		= $lotQuery->fields['tenant'];
 		}
	
		//
		if ($lotQuery->fields['charge_water'] == 'Y') {
 			$this->_chargeWater = TRUE;
 		} else {
 			$this->_chargeWater = FALSE;
 		}
		
		 if ($lotQuery->fields['charge_sewer'] == 'Y') {
 			$this->_chargeSewer = TRUE;
 		} else {
 			$this->_chargeSewer = FALSE;
 		}
 		if ($lotQuery->fields['charge_admin'] == 'Y') {
 			$this->_chargeAdmin = TRUE;
 		} else {
 			$this->_chargeAdmin = FALSE;
 		}
		if ($lotQuery->fields['charge_service'] == 'Y') {
 			$this->_chargeService = TRUE;
 		} else {
 			$this->_chargeService = FALSE;
 		}
 		if ($lotQuery->fields['charge_fuel'] == 'Y') {
 			$this->_chargeFuel = TRUE;
 		} else {
 			$this->_chargeFuel = FALSE;
 		}
 		
 		
 		// Fees
 		$this->_feeRent			= $lotQuery->fields['lot_rent'];
 		$this->_feePet			= $lotQuery->fields['pet_charge'];
 		$this->_feeExtraPerson	= $lotQuery->fields['extra_person'];
 		$this->_feeVehicle		= $lotQuery->fields['vehicle_charge'];
 		$this->_feeLease		= $lotQuery->fields['lease_option'];
 		$this->_feePastDue		= $lotQuery->fields['late_fee'];
 		$this->_feeBalance		= $lotQuery->fields['previous_balance'];
 	}
	
	public function currentBalance() {
		return $this->_feeRent + $this->_feePet + $this->_feeExtraPerson + $this->_feeVehicle + $this->_feeLease + $this->_feePastDue + $this->_feeBalance;
	}
 }
 ?>