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


<h3>Delete Lot</h3>
<p>Deleting a lot from the system will:</p>
<ul>
	<li>Remove all tenant information associated with this lot</li>
	<li>Remove all balance and financial information for this lot</li>
	<li>Remove all usage reported for this lot</li>
</ul>
<p class="note">All files (cards &amp; reports) generated prior to removal will NOT be deleted. These can be found in the application directory under /cache/cards/, /cache/reports/, and /cache/summary/.</p>
<p>To remove this park type "DELETE" into the box below and click submit.</p>
<form action="?page=lot&action=delete-sql&id=<?php echo $lot->_id; ?>&park=<?php echo $park->_id; ?>" method="post">
	<input type="text" id="confirm" name="confirm" size="20" />
	<input type="submit" value="Delete Lot" />
</form>