<?php
//	Includes
include_once('park.class.php');
include_once('lot.class.php');

//	Queries
$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_id . "'");

//	Class Construction
$park	= new Park($parkQuery);
?>
<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; Edit Lots</span>
</div>
<h2><?php echo $park->_name; ?></h2>

<form name="lot-information" method="post" action="?page=park&action=lot-sql&id=<?php echo $park->_id; ?>">
<h3>Step 1 - Update Lot Information</h3>
<hr />
<?php 
$lotQuery 	= $DB->Execute("SELECT DISTINCT * FROM lots WHERE park_id='". $park->_id ."' ORDER BY lot ASC"); 
while (!$lotQuery->EOF) {
	$lot	= new Lot($lotQuery);
?>
<div class="park-action-1col">
		<div class="park-action-1col-header">
        	<a href="?page=lot&action=edit-lot&id=<?php echo $lot->_id; ?>">
        		<img src="/images/ui/house.png" width="32" height="32" alt="<?php echo $park->_name; ?>" />
				<h3>Lot <?php echo $lot->_lotID; ?></h3>
				<p><?php echo $lot->_tenant; ?></p>
			</a>
        </div>
        <div class="park-action-1col-content">
          <label for="rent">Rent</label>
          <input id="rent" name="rent[<?php echo $lot->_id; ?>]" type="text" size="10" value="<?php echo $lot->_feeRent; ?>" />
          <label for="pet">Pet</label>
          <input id="pet" name="pet[<?php echo $lot->_id; ?>]" type="text" size="10" value="<?php echo $lot->_feePet; ?>" />
          <label for="xper">Extra Person</label>
          <input id="xper" name="xper[<?php echo $lot->_id; ?>]" type="text" size="10" value="<?php echo $lot->_feeExtraPerson; ?>" />
          <label for="vehicle">Vehicle</label>
          <input id="vehicle" name="vehicle[<?php echo $lot->_id; ?>]" type="text" size="10" value="<?php echo $lot->_feeVehicle; ?>" />
          <label for="lease">Lease Option</label>
          <input id="lease" name="lease[<?php echo $lot->_id; ?>]" type="text" size="10" value="<?php echo $lot->_feeLease; ?>" />
          <label for="balance">Balance</label>
          <input id="balance" name="balance[<?php echo $lot->_id; ?>]" type="text" size="10" value="<?php echo $lot->_feeBalance; ?>" />
          <label for="chargewater">Water</label>
          <select name="chargewater[<?php echo $lot->_id; ?>]" id="chargewater">
	        <option value="Y" <?php if ($lot->_chargeWater == TRUE) { echo 'selected'; } ?>>Yes</option>
	        <option value="N" <?php if ($lot->_chargeWater == FALSE) { echo 'selected'; } ?>>No</option>
	      </select>
	      <label for="chargesewer">Sewer</label>
	      <select name="chargesewer[<?php echo $lot->_id; ?>]" id="chargesewer">
	        <option value="Y" <?php if ($lot->_chargeSewer == TRUE) { echo 'selected'; } ?>>Yes</option>
	        <option value="N" <?php if ($lot->_chargeSewer == FALSE) { echo 'selected'; } ?>>No</option>
	      </select>
	      <br />
	      <label for="chargeadmin">Admin</label>
	      <select name="chargeadmin[<?php echo $lot->_id; ?>]" id="chargeadmin">
	        <option value="Y" <?php if ($lot->_chargeAdmin == TRUE) { echo 'selected'; } ?>>Yes</option>
	        <option value="N" <?php if ($lot->_chargeAdmin == FALSE) { echo 'selected'; } ?>>No</option>
	      </select>
	      <label for="chargeservice">Service</label>
	      <select name="chargeservice[<?php echo $lot->_id; ?>]" id="chargeservice">
	        <option value="Y" <?php if ($lot->_chargeService == TRUE) { echo 'selected'; } ?>>Yes</option>
	        <option value="N" <?php if ($lot->_chargeService == FALSE) { echo 'selected'; } ?>>No</option>
	      </select>
	      <label for="chargeservice">Fuel</label>
	      <select name="chargefuel[<?php echo $lot->_id; ?>]" id="chargefuel">
	        <option value="Y" <?php if ($lot->_chargeFuel == TRUE) { echo 'selected'; } ?>>Yes</option>
	        <option value="N" <?php if ($lot->_chargeFuel == FALSE) { echo 'selected'; } ?>>No</option>
	      </select>
		</div>
</div>
<?php
	$lotQuery->MoveNext();
}
?>

<h3>Step 2 - Submit Lot Information</h3>
<hr />
<div class="form">
    <div class="form-row alignRight">
  		<input type="submit" id="submit" name="submit" />
  		<input type="reset" id="reset" name="reset" />
	</div>
</div>