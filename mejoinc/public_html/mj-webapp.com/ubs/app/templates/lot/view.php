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
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; <a href="?page=lot&id=<?php echo $park->_id; ?>">Lots</a> &gt; <?php echo $lot->_lotID . ' - ' . $lot->_tenant; ?></span>
</div>
<h2><?php echo $lot->_lotID . ' - ' . $lot->_tenant; ?></h2>

<div class="park-action-2col">
		<a href="?page=lot&action=edit-lot&id=<?php echo $lot->_id; ?>">
        	<img src="/images/ui/user_edit.png" width="32" height="32" alt="Edit Lot" />
			<h3>Edit Lot</h3>
            <p>Update a tenant name, address, and fees.</p>
        </a>
</div>

<div class="park-action-2col">
		<a href="?page=lot&action=edit-balance&id=<?php echo $lot->_id; ?>">
        	<img src="/images/ui/calculator_edit.png" width="32" height="32" alt="Edit Balances" />
			<h3>Edit Balance</h3>
            <p>Update previous balances for this tenant.</p>
        </a>
</div>

<div class="park-action-2col">
		<a href="?page=lot&action=delete-lot&id=<?php echo $lot->_id; ?>">
        	<img src="/images/ui/user_delete.png" width="32" height="32" alt="Delete Lot" />
			<h3>Delete Lot</h3>
            <p>Remove all information for this lot.</p>
        </a>
</div>