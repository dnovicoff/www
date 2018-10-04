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
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; Lots</span>
</div>
<h2>Lot Selection</h2>
<div class="park-action-2col">
	<a href="?page=lot&id=<?php echo $park->_id; ?>&action=add-lot">
		<img src="/images/ui/user_add.png" width="32" height="32" alt="Add a new lot" />
		<h3>Add a new lot</h3>
		<p>Creates a new lot within this park</p>
	</a>
</div>

<?php 
$lotQuery 	= $DB->Execute("SELECT * FROM lots WHERE park_id='". $park->_id ."' ORDER BY lot ASC"); 
while (!$lotQuery->EOF) {
	$lot	= new Lot($lotQuery);
?>
<div class="park-action-2col">
	<a href="?page=lot&action=view&id=<?php echo $lot->_id; ?>">
		<img src="/images/ui/user.png" width="32" height="32" alt="<?php echo $lot->_tenant; ?>" />
		<h3><?php echo $lot->_lotID; ?></h3>
		<p><?php echo $lot->_tenant; ?></p>
	</a>
</div>
<?php 
	$lotQuery->MoveNext();
}
?>