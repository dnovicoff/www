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
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; Record Usage</span>
</div>
<h2><?php echo $park->_name; ?></h2>

<form name="lot-usage" method="post" action="?page=park&action=usage-sql&id=<?php echo $park->_id; ?>">
<h3>Step 1 - Select Dates</h3>
<hr />
<div class="park-action-3col">
	<img src="/images/ui/calendar_view_day.png" width="32" height="32" alt="Record Usage" />
	<label for="record-date">Record Date</label>
	<input id="record-date" name="record-date" type="text" size="14" />
</div>
<div class="park-action-3col">
	<img src="/images/ui/calendar_view_day.png" width="32" height="32" alt="Record Usage" />
	<label for="bill-date">Bill Date</label>
	<input id="bill-date" name="bill-date" type="text" size="14" />
</div>
<div class="park-action-3col">
	<img src="/images/ui/calendar_view_day.png" width="32" height="32" alt="Record Usage" />
	<label for="due-date">Due Date</label>
	<input id="due-date" name="due-date" type="text" size="14" />
</div>

<h3>Step 2 - Enter Tenant Usage</h3>
<hr />
<?php 
$tabIndex	= 1;
$lotQuery 	= $DB->Execute("SELECT DISTINCT * FROM lots WHERE park_id='". $park->_id ."' ORDER BY id,lot ASC"); 
while (!$lotQuery->EOF) {
	$lot	= new Lot($lotQuery);
?>
<div class="park-action-3col">
	<div class="park-action-3col-header">
   		<a href="?page=lot&action=edit-lot&id=<?php echo $lot->_id; ?>">
			<img src="/images/ui/application_form_add.png" width="32" height="32" alt="Record Usage" />
			<h3>Lot <?php echo $lot->_lotID; ?></h3>
			<p><?php echo $lot->_tenant; ?></p>
		</a>
    </div>
    <div class="park-action-3col-content">
		<input id="lot_id" type="hidden" value="<?php echo $lot->_id; ?>" />
        <label for="usage">Usage</label>
		<input id="<?php echo $lot->_id; ?>" name="usage[<?php echo $lot->_id; ?>]" type="text" size="12" tabindex="<?php echo $tabIndex; ?>" />
    </div>
</div>
<?php
	$tabIndex++;
	$lotQuery->MoveNext();
}
?>

<h3>Step 3 - Submit Tenant Usage</h3>
<hr />
<div class="form">
    <div class="form-row alignRight">
  		<input type="submit" id="submit" name="submit" />
  		<input type="reset" id="reset" name="reset" />
	</div>
</div>