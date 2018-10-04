<?php
/*
 * Filename: 	park.class.php
 * Author:		Matthew Meehan <matthew@mejoinc.com>
 * Version:		1.0.0
 * Date:		5/24/2010
 */
 
 class Park {
 	// General
 	public $_id;
 	public $_name;
	public $_address;
	public $_city;
	public $_state;
	public $_zip;
	public $_readUnit;
  	public $_billingUnit;
	public $_isTiered;
	public $_minimumUsage;
 		// Fees
 	public $_feeTax;
 	public $_feeAdmin;
 	public $_feeService;
	public $_feeFuel;
	public $_feeOtherName;
 		// Special Charges
 	public $_chargeWaterTax;
 	public $_chargeSewerTax;
 	
 	public function __construct($parkQuery) {
 		// Lot
 		$this->_id			    = $parkQuery->fields['id'];
		$this->_name		    = $parkQuery->fields['name'];
 		$this->_address    		= $parkQuery->fields['address'];
		$this->_city		    = $parkQuery->fields['city'];
		$this->_state		    = $parkQuery->fields['state'];
		$this->_zip			    = $parkQuery->fields['zip'];
		$this->_readUnit		= $parkQuery->fields['readUnit'];
   		$this->_billingUnit 	= $parkQuery->fields['billingUnit'];
		$this->_minimumUsage	= $parkQuery->fields['min_usage'];
		
 		if ($parkQuery->fields['incremental'] == 'Y') {
 			$this->_isTiered = TRUE;
 		} else {
 			$this->_isTiered = FALSE;
 		}
		
		if ($parkQuery->fields['tax_water'] == 'Y') {
 			$this->_chargeWaterTax = TRUE;
 		} else {
 			$this->_chargeWaterTax = FALSE;
 		}
		
		 if ($parkQuery->fields['tax_sewer'] == 'Y') {
 			$this->_chargeSewerTax = TRUE;
 		} else {
 			$this->_chargeSewerTax = FALSE;
 		}

 		// Fees
 		$this->_feeTax			= $parkQuery->fields['tax_rate'];
 		$this->_feeAdmin		= $parkQuery->fields['admin_fee'];
 		$this->_feeService		= $parkQuery->fields['service_fee'];
		$this->_feeFuel			= $parkQuery->fields['fuel_fee'];
		$this->_feeOtherName	= $parkQuery->fields['other_fee_name'];
 	}
 }
 ?>