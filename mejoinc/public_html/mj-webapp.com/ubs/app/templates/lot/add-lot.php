<?php
//	Includes
include_once('park.class.php');

//	Queries
$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_id . "'");


//	Class Construction
$park	= new Park($parkQuery);
?>

<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; <a href="?page=lot&id=<?php echo $park->_id; ?>">Lots</a> &gt; Add a Lot</span>
</div>

<form id="lot-information" name="lot-information" method="post" action="?page=lot&action=lot-add-sql&id=<?php echo $park->_id; ?>">
<fieldset>
  <legend>General Information</legend>
  <div class="form">
   <div class="form-row">
      <label for="lot">Lot <span class="required">*</span></label>
      <input type="text" size="10" name="lot" id="lot" />
    </div>
  	<div class="form-row">
      <label for="vacant">Vacant <span class="required">*</span></label>
      <select name="vacant" id="vacant">
      	<option value=""></option>
        <option value="Y">Yes</option>
        <option value="N">No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="tenant">Tenant <span class="required">*</span></label>
      <input type="text" size="28" name="tenant" id="tenant" />
    </div>
    <div class="form-row">
      <label for="address">Address</label>
      <input type="text" size="28" name="address" id="address" />
    </div>
    <div class="form-row">
      <label for="city">City</label>
      <input type="text" size="24" name="city" id="city" />
    </div>
    <div class="form-row">
      <label for="state">State</label>
      <input type="text" size="10" name="state" id="state" />
    </div>
    <div class="form-row">
      <label for="zip">Zip</label>
      <input type="text" size="18" name="zip" id="zip" />
    </div>
  </div>
</fieldset>
<fieldset>
  <legend>Fees</legend>
  <div class="form">
  	<div class="form-row">
      <label for="chargewater">Charge for Water <span class="required">*</span></label>
      <select name="chargewater" id="chargewater">
      	<option value=""></option>
        <option value="Y">Yes</option>
        <option value="N">No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="chargesewer">Charge for Sewer <span class="required">*</span></label>
      <select name="chargesewer" id="chargesewer">
      	<option value=""></option>
        <option value="Y">Yes</option>
        <option value="N">No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="chargeadmin">Charge Admin Fee <span class="required">*</span></label>
      <select name="chargeadmin" id="chargeadmin">
      	<option value=""></option>
        <option value="Y">Yes</option>
        <option value="N">No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="chargeservice">Charge Service Fee <span class="required">*</span></label>
      <select name="chargeservice" id="chargeservice">
      	<option value=""></option>
        <option value="Y">Yes</option>
        <option value="N">No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="chargefuel">Charge Other Fee <span class="required">*</span></label>
      <select name="chargefuel" id="chargefuel">
      	<option value=""></option>
        <option value="Y">Yes</option>
        <option value="N">No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="rent">Rent <span class="required">*</span></label>
      <input type="text" size="18" name="rent" id="rent" />
    </div>
    <div class="form-row">
      <label for="pet">Pet <span class="required">*</span></label>
      <input type="text" size="18" name="pet" id="pet" />
    </div>
    <div class="form-row">
      <label for="person">Extra Person <span class="required">*</span></label>
      <input type="text" size="18" name="person" id="person" />
    </div>
    <div class="form-row">
      <label for="vehicle">Vehicle <span class="required">*</span></label>
      <input type="text" size="18" name="vehicle" id="vehicle" />
    </div>
    <div class="form-row">
      <label for="lease">Lease Option <span class="required">*</span></label>
      <input type="text" size="18" name="lease" id="lease" />
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