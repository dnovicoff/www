<?php
//	Includes
include_once('park.class.php');

//	Queries
$parkQuery	= $DB->Execute("SELECT * FROM parks ORDER BY name");
?>
<h2>Park Selection</h2>
<div class="park-action-2col">
	<a href="?page=park&action=add-park">
		<img src="/images/ui/building_add.png" width="32" height="32" alt="Add a new park" />
		<h3>Add a new park</h3>
		<p>Creates a new park within the system; be sure to have your water and sewer rates, as well as your fees</p>
	</a>
</div>
<?php while (!$parkQuery->EOF) { 
	//	Class Construction
	$park	= new Park($parkQuery);
?>
<div class="park-action-2col">
	<a href="?page=park&action=view&id=<?php echo $park->_id; ?>">
		<img src="/images/ui/building.png" width="32" height="32" alt="<?php echo $park->_name; ?>" />
		<h3><?php echo $park->_name; ?></h3>
		<p><?php echo $park->_address . '<br /> ' . $park->_city . ', ' . $park->_state . ' ' . $park->_zip; ?></p>
	</a>
</div>
<?php 
	$parkQuery->MoveNext();
}
?>