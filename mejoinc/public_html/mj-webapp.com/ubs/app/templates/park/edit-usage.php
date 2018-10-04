<?php 
/*
 * $HeadURL$
 * $Id$
 * $Author$
 * $Revision$
 * $Date$
 */

//	Includes
include_once('park.class.php');
include_once('lot.class.php');

//	Queries
$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_id . "'");


//	Class Construction
$park	= new Park($parkQuery);


?>
<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; Edit Usage</span>
</div>
<h2><?php echo $park->_name; ?></h2>

<h3>Step 1 - Select Month</h3>
<hr />
<?php
	$query			= "SELECT DISTINCT bill_date,due_date,record_date FROM park_usage WHERE park_id='". $park->_id . "' ORDER BY record_date DESC LIMIT 6";
	$reportQuery	= $DB->Execute($query);
	
	if ($reportQuery->RecordCount() != 0) {
		while (!$reportQuery->EOF) {
?>
<div class="park-action-2col">
	<a href="?page=park&action=edit-usage&id=<?php echo $park->_id; ?>&date=<?php echo $reportQuery->fields['record_date']; ?>">
		<img src="/images/ui/calendar.png" width="32" height="32" alt="Select a date" />
		<h3><?php echo date('F Y', strtotime($reportQuery->fields['record_date'])); ?></h3>
	</a>
</div>

<?php
			$reportQuery->MoveNext();
		}
	} else {
?>
<div class="park-action-2col">
		<img src="/images/ui/calendar.png" width="32" height="32" alt="Select a date" />
		<h3>No previous usage entered for this park</h3>
</div>
<?php
	}
?>

<?php
if (isset($_GET['date'])) {
?>
<br clear="all" />
<form name="lot-usage" method="post" action="?page=park&action=usage-edit-sql&id=<?php echo $park->_id; ?>">
<h3>Step 2 - Enter Tenant Usage</h3>
<hr />
<?php 
$tabIndex	= 1;
$lotQuery 	= $DB->Execute("SELECT DISTINCT * FROM lots WHERE park_id='". $park->_id ."' ORDER BY lot ASC"); 
while (!$lotQuery->EOF) {
	$lot		= new Lot($lotQuery);
	$usageQuery	= $DB->Execute("SELECT * FROM park_usage WHERE park_id='" . $park->_id . "' AND lot_id='" . $lot->_id . "' AND record_date='" . $_GET['date'] . "'");
?>
<div class="park-action-3col">
	<div class="park-action-3col-header">
		<a href="?page=lot&action=edit-lot&id=<?php echo $lot->_id; ?>">
    		<img src="/images/ui/application_form_edit.png" width="32" height="32" alt="Edit Usage" />
			<h3>Lot <?php echo $lot->_lotID; ?></h3>
			<p><?php echo $lot->_tenant; ?></p>
		</a>
    </div>
    <div class="park-action-3col-content">
      <input id="lot_id" type="hidden" value="<?php echo $lot->_id; ?>" />
      <label for="usage">Usage</label>
      <input id="<?php echo $lot->_id; ?>" name="usage[<?php echo $lot->_id; ?>]" type="text" size="12" value="<?php echo $usageQuery->fields['usage']; ?>" tabindex="<?php echo $tabIndex; ?>" />
	</div>
</div>
<?php
	$tabIndex++;
	$lotQuery->MoveNext();
}
?>
<?php
	/*	GET DATES	*/
	
	//	Queries
$dateQuery	= $DB->Execute("SELECT DISTINCT bill_date,due_date FROM park_usage WHERE park_id='" . $park->_id . "' AND record_date='" . $_GET['date'] . "' LIMIT 1");

	//	Variables
$billDate 	= $dateQuery->fields['bill_date'];
$dueDate	= $dateQuery->fields['due_date'];
$recordDate	= $_GET['date'];
?>

<input id="bill_date" name="bill_date" type="hidden" value="<?php echo $billDate; ?>" />
<input id="due_date" name="due_date" type="hidden" value="<?php echo $dueDate; ?>" />
<input id="record_date" name="record_date" type="hidden" value="<?php echo $recordDate; ?>" />

<br clear="both" />
<h3>Step 3 - Submit Tenant Usage</h3>
<hr />
<div class="form">
    <div class="form-row alignRight">
  		<input type="submit" id="submit" name="submit" />
  		<input type="reset" id="reset" name="reset" />
	</div>
</div>
<?php } ?>