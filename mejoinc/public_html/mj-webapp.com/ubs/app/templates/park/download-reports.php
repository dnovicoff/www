<?php
//	Includes
include_once('park.class.php');

//	Queries
$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_id . "'");

//	Class Construction
$park	= new Park($parkQuery);
?>
<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; Download Reports</span>
</div>
<h2><?php echo $park->_name; ?></h2>

<h3>Select a Report</h3>
<ul class="noList">
<?php
$query			= "SELECT DISTINCT type, date FROM reports WHERE park_id='". $park->_id . "' ORDER BY date";
$reportQuery	= $DB->Execute($query);

if ($reportQuery->RecordCount() != 0) {
	while (!$reportQuery->EOF) {

	if ($reportQuery->fields['type'] == 'C') {
?>
<li><a href="?page=park&action=download-cards&id=<?php echo $park->_id; ?>&file=false&date=<?php echo date('Y-m-d', strtotime($reportQuery->fields['date'])); ?>" icon="pdf"><?php echo date('F Y', strtotime($reportQuery->fields['date'])); ?> - Billing Cards</a></li>
<?php
	} elseif ($reportQuery->fields['type'] == 'S') {
?>
<li class="reportSpacer"><a href="/app/core/reports/summary-new.php?id=<?php echo $park->_id; ?>&file=false&date=<?php echo date('Y-m-d', strtotime($reportQuery->fields['date'])); ?>" icon="xls"><?php echo date('F Y', strtotime($reportQuery->fields['date'])); ?> - Summary Report</a></li>
<?php
	} elseif ($reportQuery->fields['type'] == 'R') {
?>
<li><a href="/app/core/reports/report-new.php?id=<?php echo $park->_id; ?>&file=false&date=<?php echo date('Y-m-d', strtotime($reportQuery->fields['date'])); ?>" icon="xls"><?php echo date('F Y', strtotime($reportQuery->fields['date'])); ?> - Management Report</a></li>
<?php	
	}
		$reportQuery->MoveNext();
	}

} else {
	echo '<li>No previous reports created for this park.  To have reports generated, please enter water &amp; sewer usage for 2 consecutive months for this park.  The reports will be generated and you will be prompted to download them.  Additionally, all reports are stored on this server.</li>';
}
?>
</ul>