<?php
//	Includes
include_once('park.class.php');
include_once('lot.class.php');

//	Queries
$lotQuery	= $DB->Execute("SELECT DISTINCT * FROM lots WHERE id='" . $_id . "'");
$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $lotQuery->fields['park_id'] . "'");


//	Class Construction
$lot	= new Lot($lotQuery);
$park	= new Park($parkQuery);
?>

<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; <a href="?page=lot&id=<?php echo $park->_id; ?>">Lots</a> &gt; <a href="?page=lot&action=view&id=<?php echo $lot->_id; ?>"><?php echo $lot->_lotID . ' - ' . $lot->_tenant; ?></a> &gt; Edit Park</span>
</div>
<h2><?php echo $lot->_lotID . ' - ' . $lot->_tenant; ?></h2>

<form id="lot-information" name="lot-information" method="post" action="?page=lot&action=lot-sql&id=<?php echo $lot->_id; ?>">
<fieldset>
  <legend>General Information</legend>
  <div class="form">
  	<div class="form-row">
      <label for="vacant">Vacant <span class="required">*</span></label>
      <select name="vacant" id="vacant">
        <option value="Y" <?php if ($lot->_isVacant == TRUE) { echo 'selected'; } ?>>Yes</option>
        <option value="N" <?php if ($lot->_isVacant == FALSE) { echo 'selected'; } ?>>No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="tenant">Tenant <span class="required">*</span></label>
      <input type="text" size="28" name="tenant" id="tenant" value="<?php echo $lot->_tenant; ?>" />
    </div>
    <div class="form-row">
      <label for="address">Address</label>
      <input type="text" size="28" name="address" id="address" value="<?php echo $lot->_address; ?>" />
    </div>
    <div class="form-row">
      <label for="city">City</label>
      <input type="text" size="24" name="city" id="city" value="<?php echo $lot->_city; ?>" />
    </div>
    <div class="form-row">
      <label for="state">State</label>
      <input type="text" size="10" name="state" id="state" value="<?php echo $lot->_state; ?>" />
    </div>
    <div class="form-row">
      <label for="zip">Zip</label>
      <input type="text" size="18" name="zip" id="zip" value="<?php echo $lot->_zip; ?>" />
    </div>
  </div>
</fieldset>
<fieldset>
  <legend>Fees</legend>
  <div class="form">
  	<div class="form-row">
      <label for="chargewater">Charge for Water <span class="required">*</span></label>
      <select name="chargewater" id="chargewater">
        <option value="Y" <?php if ($lot->_chargeWater == TRUE) { echo 'selected'; } ?>>Yes</option>
        <option value="N" <?php if ($lot->_chargeWater == FALSE) { echo 'selected'; } ?>>No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="chargesewer">Charge for Sewer <span class="required">*</span></label>
      <select name="chargesewer" id="chargesewer">
        <option value="Y" <?php if ($lot->_chargeSewer == TRUE) { echo 'selected'; } ?>>Yes</option>
        <option value="N" <?php if ($lot->_chargeSewer == FALSE) { echo 'selected'; } ?>>No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="chargeadmin">Charge Admin Fee <span class="required">*</span></label>
      <select name="chargeadmin" id="chargeadmin">
        <option value="Y" <?php if ($lot->_chargeAdmin == TRUE) { echo 'selected'; } ?>>Yes</option>
        <option value="N" <?php if ($lot->_chargeAdmin == FALSE) { echo 'selected'; } ?>>No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="chargeservice">Charge Service Fee <span class="required">*</span></label>
      <select name="chargeservice" id="chargeservice">
        <option value="Y" <?php if ($lot->_chargeService == TRUE) { echo 'selected'; } ?>>Yes</option>
        <option value="N" <?php if ($lot->_chargeService == FALSE) { echo 'selected'; } ?>>No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="chargefuel">Charge Other Fee <span class="required">*</span></label>
      <select name="chargefuel" id="chargefuel">
        <option value="Y" <?php if ($lot->_chargeFuel == TRUE) { echo 'selected'; } ?>>Yes</option>
        <option value="N" <?php if ($lot->_chargeFuel == FALSE) { echo 'selected'; } ?>>No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="rent">Rent <span class="required">*</span></label>
      <input type="text" size="18" name="rent" id="rent" value="<?php echo $lot->_feeRent; ?>" />
    </div>
    <div class="form-row">
      <label for="pet">Pet <span class="required">*</span></label>
      <input type="text" size="18" name="pet" id="pet" value="<?php echo $lot->_feePet; ?>" />
    </div>
    <div class="form-row">
      <label for="person">Extra Person <span class="required">*</span></label>
      <input type="text" size="18" name="person" id="person" value="<?php echo $lot->_feeExtraPerson; ?>" />
    </div>
    <div class="form-row">
      <label for="vehicle">Vehicle <span class="required">*</span></label>
      <input type="text" size="18" name="vehicle" id="vehicle" value="<?php echo $lot->_feeVehicle; ?>" />
    </div>
    <div class="form-row">
      <label for="lease">Lease Option <span class="required">*</span></label>
      <input type="text" size="18" name="lease" id="lease" value="<?php echo $lot->_feeLease; ?>" />
    </div>
  </div>
</fieldset>
<fieldset>
  <legend>Process</legend>
  <div class="form">
    <div class="form-row alignRight">
  		<input type="submit" id="submit" name="submit" />
  		<input type="reset" id="reset" name="reset" />
    </div>
  </div>
</fieldset>