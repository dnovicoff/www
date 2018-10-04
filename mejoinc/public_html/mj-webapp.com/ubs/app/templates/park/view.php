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

<div class="park-action-2col">
		<a href="?page=park&action=record-usage&id=<?php echo $park->_id; ?>">
			<img src="/images/ui/calendar_add.png" width="32" height="32" alt="Record Usage" />
			<h3>Record Usage</h3>
            <p>Record the monthly water and sewage rates for a park.</p>
		</a>
</div>
<div class="park-action-2col">
		<a href="?page=park&action=edit-usage&id=<?php echo $park->_id; ?>">
        	<img src="/images/ui/calendar_edit.png" width="32" height="32" alt="Edit Usage" />
			<h3>Edit Usage</h3>
            <p>Update a previous month's water and sewer usage.</p>
        </a>
</div>
<div class="park-action-2col">
		<a href="?page=park&action=edit-park&id=<?php echo $park->_id; ?>">
        	<img src="/images/ui/building_edit.png" width="32" height="32" alt="Edit Park" />
			<h3>Edit Park</h3>
            <p>Update park name, address, taxes and fees.</p>
        </a>
</div>
<div class="park-action-2col">
		<a href="?page=park&action=edit-lots&id=<?php echo $park->_id; ?>">
        	<img src="/images/ui/house_go.png" width="32" height="32" alt="Edit Lots" />
			<h3>Edit Lots</h3>
            <p>Update lot rent and other fees.</p>
        </a>
</div>
<div class="park-action-2col">
		<a href="?page=lot&id=<?php echo $park->_id; ?>">
        	<img src="/images/ui/group_edit.png" width="32" height="32" alt="Edit Lots" />
			<h3>Edit Tenants</h3>
            <p>Update tenant information, lot rent, and other fees.</p>
        </a>
</div>
<div class="park-action-2col">
		<a href="?page=park&action=download-reports	&id=<?php echo $park->_id; ?>">
        	<img src="/images/ui/chart_line_link.png" width="32" height="32" alt="Download Reports" />
			<h3>Download Reports</h3>
            <p>Download monthly reports and cards.</p>
        </a>
</div>
<div class="park-action-2col">
		<a href="?page=park&action=edit-balances&id=<?php echo $park->_id; ?>">
        	<img src="/images/ui/calculator_edit.png" width="32" height="32" alt="Edit Balances" />
			<h3>Edit Balances</h3>
            <p>Update previous balances for tenants of this park.</p>
        </a>
</div>
<div class="park-action-2col">
    <a href="?page=park&action=edit-rates&id=<?php echo $park->_id; ?>">
        <img src="/images/ui/chart_bar_edit.png" width="32" height="32" alt="Edit Rates" />
        <h3>Edit Rates</h3>
        <p>Update water and sewer rates.</p>
	</a>
</div>
<div class="park-action-2col">
    <a href="?page=park&action=delete-park&id=<?php echo $park->_id; ?>">
        <img src="/images/ui/building_delete.png" width="32" height="32" alt="Delete Park" />
        <h3>Delete Park</h3>
        <p>Remove this park, all lots, usage, and rates.</p>
	</a>
</div>
