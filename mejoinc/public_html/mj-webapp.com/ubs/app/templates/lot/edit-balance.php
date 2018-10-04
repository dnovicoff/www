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
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; <a href="?page=lot&id=<?php echo $park->_id; ?>">Lots</a> &gt; <a href="?page=lot&action=view&id=<?php echo $lot->_id; ?>"><?php echo $lot->_lotID . ' - ' . $lot->_tenant; ?></a> &gt; Edit Balance</span>
</div>
<h2><?php echo $lot->_lotID . ' - ' . $lot->_tenant; ?></h2>

<form name="lot-balance" method="post" action="?page=lot&action=balance-sql&id=<?php echo $lot->_id; ?>">
<h3>Step 1 - Update Balance</h3>
<hr />
<div class="park-action-1col">
	<div class="park-action-1col-header">
    	<a href="?page=lot&action=edit-lot&id=<?php echo $lot->_id; ?>">
    		<img src="/images/ui/calculator_edit.png" width="32" height="32" alt="Edit Balances" />
			<h3>Lot <?php echo $lot->_lotID; ?></h3>
			<p><?php echo $lot->_tenant; ?></p>
		</a>
    </div>
    <div class="park-action-1col-content">
		<label for="past">Late Fee</label>
		<input id="past" name="past" type="text" size="12" value="<?php echo $lot->_feePastDue; ?>" tabindex="1" />
		<label for="balance">Balance</label>
		<input id="balance" name="balance" type="text" size="12" value="<?php echo $lot->_feeBalance; ?>" tabindex="2" />
    </div>
</div>

<h3>Step 2 - Submit Balances</h3>
<hr />
<div class="form">
    <div class="form-row alignRight">
  		<input type="submit" id="submit" name="submit" />
  		<input type="reset" id="reset" name="reset" />
	</div>
</div>