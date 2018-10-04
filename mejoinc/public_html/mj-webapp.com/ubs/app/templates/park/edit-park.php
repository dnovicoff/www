<?php
//	Includes
include_once('park.class.php');

//	Queries
$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_id . "'");

//	Class Construction
$park	= new Park($parkQuery);
?>

<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; Edit Park</span>
</div>
<h2><?php echo $park->_name; ?></h2>

<form id="park-information" name="park-information" method="post" action="?page=park&action=park-sql&id=<?php echo $park->_id; ?>">
<fieldset>
  <legend>General Information</legend>
  <div class="form">
    <div class="form-row">
      <label for="name">Name <span class="required">*</span></label>
      <input type="text" size="28" name="name" id="name" value="<?php echo $park->_name; ?>" />
    </div>
    <div class="form-row">
      <label for="address">Address <span class="required">*</span></label>
      <input type="text" size="28" name="address" id="address" value="<?php echo $park->_address; ?>" />
    </div>
    <div class="form-row">
      <label for="city">City <span class="required">*</span></label>
      <input type="text" size="24" name="city" id="city" value="<?php echo $park->_city; ?>" />
    </div>
    <div class="form-row">
      <label for="state">State <span class="required">*</span></label>
      <input type="text" size="10" name="state" id="state" value="<?php echo $park->_state; ?>" />
    </div>
    <div class="form-row">
      <label for="zip">Zip <span class="required">*</span></label>
      <input type="text" size="18" name="zip" id="zip" value="<?php echo $park->_zip; ?>" />
    </div>
    <div class="form-row">
      <label for="readUnit">Read Unit <span class="required">*</span></label>
      <select name="readUnit" id="readUnit">
        <option value="HG" <?php if ($park->_readUnit == 'HG') { echo 'selected'; } ?>>Gallons (Hundreds)</option>
        <option value="F" <?php if ($park->_readUnit == 'F') { echo 'selected'; } ?>>Cubic Feet</option>
        <option value="TG" <?php if ($park->_readUnit == 'TG') { echo 'selected'; } ?>>Gallons (Thousand)</option>
      </select>
    </div>
    <div class="form-row">
      <label for="billingUnit">Billing Unit <span class="required">*</span></label>
      <select name="billingUnit" id="billingUnit">
        <option value="HG" <?php if ($park->_billingUnit == 'HG') { echo 'selected'; } ?>>Gallons (Hundreds)</option>
        <option value="F" <?php if ($park->_billingUnit == 'F') { echo 'selected'; } ?>>Cubic Feet</option>
        <option value="TG" <?php if ($park->_billingUnit == 'TG') { echo 'selected'; } ?>>Gallons (Thousand)</option>
      </select>
    </div>
    <div class="form-row">
      <label for="min_usage">Minimum Usage <span class="required">*</span></label>
      <input type="text" size="18" name="min_usage" id="min_usage" value="<?php echo $park->_minimumUsage; ?>" />
    </div>
  </div>
</fieldset>
<fieldset>
  <legend>Taxes</legend>
  <div class="form">
    <div class="form-row">
      <label for="taxrate">Tax Rate <span class="required">*</span></label>
      <select name="taxrate" id="taxrate">
        <option value="0.00" <?php if ($park->_feeTax == '0.00') { echo 'selected'; } ?>>0%</option>
        <option value="1.01" <?php if ($park->_feeTax == '1.01') { echo 'selected'; } ?>>1%</option>
        <option value="1.02" <?php if ($park->_feeTax == '1.02') { echo 'selected'; } ?>>2%</option>
        <option value="1.03" <?php if ($park->_feeTax == '1.03') { echo 'selected'; } ?>>3%</option>
        <option value="1.04" <?php if ($park->_feeTax == '1.04') { echo 'selected'; } ?>>4%</option>
        <option value="1.05" <?php if ($park->_feeTax == '1.05') { echo 'selected'; } ?>>5%</option>
        <option value="1.06" <?php if ($park->_feeTax == '1.06') { echo 'selected'; } ?>>6%</option>
        <option value="1.07" <?php if ($park->_feeTax == '1.07') { echo 'selected'; } ?>>7%</option>
        <option value="1.08" <?php if ($park->_feeTax == '1.08') { echo 'selected'; } ?>>8%</option>
        <option value="1.09" <?php if ($park->_feeTax == '1.09') { echo 'selected'; } ?>>9%</option>
        <option value="1.10" <?php if ($park->_feeTax == '1.10') { echo 'selected'; } ?>>10%</option>
        <option value="1.11" <?php if ($park->_feeTax == '1.11') { echo 'selected'; } ?>>11%</option>
        <option value="1.12" <?php if ($park->_feeTax == '1.12') { echo 'selected'; } ?>>12%</option>
        <option value="1.13" <?php if ($park->_feeTax == '1.13') { echo 'selected'; } ?>>13%</option>
        <option value="1.14" <?php if ($park->_feeTax == '1.14') { echo 'selected'; } ?>>14%</option>
        <option value="1.15" <?php if ($park->_feeTax == '1.15') { echo 'selected'; } ?>>15%</option>
      </select>
    </div>
    <div class="form-row">
      <label for="taxwater">Tax Water <span class="required">*</span></label>
      <select name="taxwater" id="taxwater">
        <option value="Y" <?php if ($park->_chargeWaterTax == TRUE) { echo 'selected'; } ?>>Yes</option>
        <option value="N" <?php if ($park->_chargeWaterTax == FALSE) { echo 'selected'; } ?>>No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="taxsewer">Tax Sewer <span class="required">*</span></label>
      <select name="taxsewer" id="taxsewer">
        <option value="Y" <?php if ($park->_chargeSewerTax == TRUE) { echo 'selected'; } ?>>Yes</option>
        <option value="N" <?php if ($park->_chargeSewerTax == FALSE) { echo 'selected'; } ?>>No</option>
      </select>
    </div>
  </div>
</fieldset>
<fieldset>
  <legend>Fees</legend>
  <div class="form">
    <div class="form-row">
      <label for="admin">Admin Fee <span class="required">*</span></label>
      <input type="text" size="18" name="admin" id="admin" value="<?php echo $park->_feeAdmin; ?>" />
    </div>
    <div class="form-row">
      <label for="service">Service Fee <span class="required">*</span></label>
      <input type="text" size="18" name="service" id="service" value="<?php echo $park->_feeService; ?>" />
    </div>
    <div class="form-row">
      <label for="other">Fee Name <span class="required">*</span></label>
      <input type="text" size="18" name="other" id="other" value="<?php echo $park->_feeOtherName; ?>" />
      <label for="fuel">Fee Value <span class="required">*</span></label>
      <input type="text" size="18" name="fuel" id="fuel" value="<?php echo $park->_feeFuel; ?>" />
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