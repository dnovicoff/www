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
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; Edit Balances</span>
</div>
<h2><?php echo $park->_name; ?></h2>

<form name="lot-balances" id="lot-balances" method="post" action="?page=park&action=balance-sql&id=<?php echo $park->_id; ?>">
<h3>Step 1 - Update Balances</h3>
<hr />
<?php 
$tabIndex	= 1;
$lotQuery 	= $DB->Execute("SELECT DISTINCT * FROM lots WHERE park_id='". $park->_id ."' ORDER BY lot ASC"); 
while (!$lotQuery->EOF) {
	$lot	= new Lot($lotQuery);
?>
<div class="park-action-2col">
	<div class="park-action-2col-header">
    	<a href="?page=lot&action=edit-lot&id=<?php echo $lot->_id; ?>">
    		<img src="/images/ui/calculator_edit.png" width="32" height="32" alt="Edit Balances" />
			<h3>Lot <?php echo $lot->_lotID; ?></h3>
			<p><?php echo $lot->_tenant; ?></p>
		</a>
    </div>
    <div class="park-action-2col-content">
		<input id="lot_id" type="hidden" value="<?php echo $lot->_id; ?>" />
		<label for="past">Late Fee</label>
		<input id="<?php echo $lot->_id; ?>" name="past[<?php echo $lot->_id; ?>]" type="text" size="12" value="<?php echo $lot->_feePastDue; ?>" tabindex="<?php echo $tabIndex; $tabIndex++; ?>" />
		<label for="balance">Balance</label>
		<input id="<?php echo $lot->_id; ?>" name="balance[<?php echo $lot->_id; ?>]" type="text" size="12" value="<?php echo $lot->_feeBalance; ?>" tabindex="<?php echo $tabIndex; $tabIndex++; ?>" />
    </div>
</div>
<?php
	$lotQuery->MoveNext();
}
?>
<div class="clear"></div>
<h3>Step 2 - Submit Balances</h3>
<hr />
<div class="form">
    <div class="form-row alignRight">
  		<input type="submit" id="submit" name="submit" />
  		<input type="reset" id="reset" name="reset" />
  		<button type="button" id="resetall" name="resetall">Reset All Balances &amp; Fees</button>
	</div>
</div>