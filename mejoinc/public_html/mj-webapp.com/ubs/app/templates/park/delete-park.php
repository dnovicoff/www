<?php
//	Includes
include_once('park.class.php');

//	Queries
$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_id . "'");

//	Class Construction
$park	= new Park($parkQuery);
?>
<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; <?php echo $park->_name; ?></span>
</div>
<h2><?php echo $park->_name; ?></h2>

<h3>Delete Park</h3>
<p>Deleting a park from the system will:</p>
<ul>
	<li>Remove all lots associated with this park</li>
	<li>Remove all rates loaded for this park</li>
	<li>Remove all usage reported for this park</li>
</ul>
<p class="note">All files (cards &amp; reports) generated prior to removal will NOT be deleted. These can be found in the application directory under /cache/cards/, /cache/reports/, and /cache/summary/.</p>
<p>To remove this park type "DELETE" into the box below and click submit.</p>
<form action="?page=park&action=delete-sql&id=<?php echo $park->_id; ?>" method="post">
	<input type="text" id="confirm" name="confirm" size="20" />
	<input type="submit" value="Delete Park" />
</form>