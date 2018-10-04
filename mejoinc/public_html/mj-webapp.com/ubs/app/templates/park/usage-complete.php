<?php 
/*
 * $HeadURL$
 * $Id$
 * $Author$
 * $Revision$
 * $Date$
 */

	include_once('cards/create.php');
	include_once('park.class.php');
	//	Queries
	$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_id . "'");
	
	//	Class Construction
	$park	= new Park($parkQuery);

	$cardFile = createCardsForPark($_GET['id'],$_GET['date'],$DB);
?>
<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; Edit Usage</span>
</div>
<h2><?php echo $park->_name; ?></h2>

<h3>Download New Reports</h3>
<ul class="noList">
	<li><a href="<?php echo CACHE_URL . 'cards/' . $cardFile;?>" icon="pdf">Create Billing Cards -  <?php echo date('F Y', strtotime($_GET['date'])); ?></a></li>
    <li><a href="/app/core/reports/report-new.php?id=<?php echo $park->_id; ?>&file=true&date=<?php echo $_GET['date']; ?>" icon="xls">Create Management Report - <?php echo date('F Y', strtotime($_GET['date'])); ?></a></li>
    <li  class="reportSpacer"><a href="/app/core/reports/summary-new.php?id=<?php echo $park->_id; ?>&file=true&date=<?php echo $_GET['date']; ?>" icon="xls">Create Summary Report - <?php echo date('F Y', strtotime($_GET['date'])); ?></a></li>
</ul>