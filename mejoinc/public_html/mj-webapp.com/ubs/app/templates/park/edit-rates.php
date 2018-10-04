<?php 
/*
 * $HeadURL$
 * $Id$
 * $Author$
 * $Revision$
 * $Date$
 */
?>
</script>
<?php
//	Includes
include_once('park.class.php');

//	Queries
$parkQuery	= $DB->Execute("SELECT DISTINCT * FROM parks WHERE id='" . $_id . "'");

//	Class Construction
$park	= new Park($parkQuery);
?>
<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; <a href="?page=park&action=view&id=<?php echo $park->_id; ?>"><?php echo $park->_name; ?></a> &gt; Edit Rates</span>
</div>
<h2><?php echo $park->_name; ?></h2>

<form name="rates" method="post" action="?page=park&action=rate-sql&id=<?php echo $park->_id; ?>">
<h3>Step 1 - Water Rates</h3>
<hr />
<p><a href="#" id="rate-example-link" icon="examples">Examples</a></p>
<div id="rate-examples">
<h4>Example 1:</h4>
<p>Flat rate of $2.50 per 100 units*</p>
<table class="rate-table">
<th>
  <tr>
    <th class="rate-blank">&nbsp;</th>
    <th>Rate</th>
    <th>Cut Off </th>
    <th>Lower</th>
    <th>Upper</th>
  </tr>
</th>
  <tr>
    <td>Tier 1</td>
    <td>2.50</td>
    <td>100</td>
    <td>MIN**</td>
    <td>MAX**</td>
  </tr>
</table>
<hr />
<h4>Example 2:</h4>
<p>$4.00 per 1,000 units for the first 10,000 units, $3.00 per 1,000 units after.</p>
<table class="rate-table">
  <tr>
    <th class="rate-blank">&nbsp;</th>
    <th>Rate</th>
    <th>Cut Off </th>
    <th>Lower</th>
    <th>Upper</th>
  </tr>
  <tr>
    <td>Tier 1</td>
    <td>4.00</td>
    <td>1000</td>
    <td>MIN</td>
    <td>10000</td>
  </tr>
    <tr>
    <td>Tier 2</td>
    <td>3.00</td>
    <td>1000</td>
    <td>10001</td>
    <td>MAX</td>
  </tr>
</table>
<hr />
<h4>Example 3:</h4>
<p>$4.00 for the first 5,000 units, $3.00 per 1,000 units over 5,000 units</p>
<table class="rate-table">
<th>
  <tr>
    <th class="rate-blank">&nbsp;</th>
    <th>Rate</th>
    <th>Cut Off </th>
    <th>Lower</th>
    <th>Upper</th>
  </tr>
</th>
  <tr>
    <td>Tier 1</td>
    <td>4.00</td>
    <td>0</td>
    <td>MIN</td>
    <td>5000</td>
  </tr>
    <tr>
    <td>Tier 2</td>
    <td>3.00</td>
    <td>1000</td>
    <td>5001</td>
    <td>MAX</td>
  </tr>
</table>
<hr />
<p class="note">* Units are determined at the park level.</p>
<p class="note">** The terms 'MIN' and 'MAX' can be used to delimit the minimum and maximum values that can be entered into this application (MIN = 0, MAX = infinity).  MIN is only accepted by the Lower field, and MAX is only accepted by the Upper field.</p>
</div>
<?php 
$waterQuery 	= $DB->Execute("SELECT * FROM water_rates WHERE park_id='". $park->_id ."' ORDER BY tier ASC"); 
while (!$waterQuery->EOF) {
?>
<div class="park-action-1col">
		<div class="park-action-1col-header">
	        <?php if ($waterQuery->fields['tier'] == '0' && $waterQuery->fields['rate'] != 'NULL') { ?>
	          <img src="/images/ui/coins.png" width="32" height="32" alt="<?php echo $park->_name; ?>" />
            <h3>Base Charge</h3>
            <?php } else { ?>
            <img src="/images/ui/chart_bar.png" width="32" height="32" alt="<?php echo $park->_name; ?>" />
			      <h3>Tier <?php echo $waterQuery->fields['tier']; ?></h3>
            <?php } ?>
        </div>
        <?php if ($waterQuery->fields['tier'] == '0') { ?>
         <div class="park-action-1col-content">
          <label for="rate">Rate</label>
          <input id="rate" name="water-rate[<?php echo $waterQuery->fields['tier']; ?>]" type="text" size="10" value="<?php echo $waterQuery->fields['rate']; ?>" />
		</div>
        <?php } else { ?>
        <div class="park-action-1col-content">
          <input id="tier" name="water-tier[<?php echo $waterQuery->fields['tier']; ?>" type="hidden" />
          <label for="rate">Rate</label>
          <input id="rate" name="water-rate[<?php echo $waterQuery->fields['tier']; ?>]" type="text" size="10" value="<?php echo $waterQuery->fields['rate']; ?>" />
          <label for="cutoff">Cut Off</label>
          <input id="cutoff" name="water-cutoff[<?php echo $waterQuery->fields['tier']; ?>]" type="text" size="10" value="<?php echo $waterQuery->fields['cutoff']; ?>" />
          <label for="lower">Lower</label>
          <input id="lower" name="water-lower[<?php echo $waterQuery->fields['tier']; ?>]" type="text" size="10" value="<?php if ($waterQuery->fields['lower_threshold'] == '0.00') { echo 'MIN'; } else { echo $waterQuery->fields['lower_threshold']; } ?>" />
          <label for="upper">Upper</label>
          <input id="upper" name="water-upper[<?php echo $waterQuery->fields['tier']; ?>]" type="text" size="10" value="<?php if ($waterQuery->fields['upper_threshold'] == '9999999999.99') { echo 'MAX'; } else { echo $waterQuery->fields['upper_threshold']; } ?>" />
		</div>
        <?php } ?>
</div>
<?php
	$waterQuery->MoveNext();
}
?>
<h3>Step 2 - Sewer Rates</h3>
<hr />
<?php 
$sewerQuery 	= $DB->Execute("SELECT * FROM sewer_rates WHERE park_id='". $park->_id ."' ORDER BY tier ASC"); 
while (!$sewerQuery->EOF) {
?>
<div class="park-action-1col">
		<div class="park-action-1col-header">
	        <?php if ($sewerQuery->fields['tier'] == '0' && $sewerQuery->fields['rate'] != 'NULL') { ?>
	          <img src="/images/ui/coins.png" width="32" height="32" alt="<?php echo $park->_name; ?>" />
            <h3>Base Charge</h3>
            <?php } else { ?>
            <img src="/images/ui/chart_bar.png" width="32" height="32" alt="<?php echo $park->_name; ?>" />
			      <h3>Tier <?php echo $sewerQuery->fields['tier']; ?></h3>
            <?php } ?>
        </div>
        <?php if ($sewerQuery->fields['tier'] == '0') { ?>
         <div class="park-action-1col-content">
          <label for="rate">Rate</label>
          <input id="rate" name="sewer-rate[<?php echo $sewerQuery->fields['tier']; ?>]" type="text" size="10" value="<?php echo $sewerQuery->fields['rate']; ?>" />
		</div>
        <?php } else { ?>
        <div class="park-action-1col-content">
          <input id="tier" name="sewer-tier[<?php echo $sewerQuery->fields['tier']; ?>" type="hidden" />
          <label for="rate">Rate</label>
          <input id="rate" name="sewer-rate[<?php echo $sewerQuery->fields['tier']; ?>]" type="text" size="10" value="<?php echo $sewerQuery->fields['rate']; ?>" />
          <label for="cutoff">Cut Off</label>
          <input id="cutoff" name="sewer-cutoff[<?php echo $sewerQuery->fields['tier']; ?>]" type="text" size="10" value="<?php echo $sewerQuery->fields['cutoff']; ?>" />
          <label for="lower">Lower</label>
          <input id="lower" name="sewer-lower[<?php echo $sewerQuery->fields['tier']; ?>]" type="text" size="10" value="<?php if ($sewerQuery->fields['lower_threshold'] == '0.00') { echo 'MIN'; } else { echo $sewerQuery->fields['lower_threshold']; } ?>" />
          <label for="upper">Upper</label>
          <input id="upper" name="sewer-upper[<?php echo $sewerQuery->fields['tier']; ?>]" type="text" size="10" value="<?php if ($sewerQuery->fields['upper_threshold'] == '9999999999.99') { echo 'MAX'; } else { echo $sewerQuery->fields['upper_threshold']; } ?>" />
		</div>
        <?php } ?>
</div>
<?php
	$sewerQuery->MoveNext();
}
?>

<h3>Step 3 - Submit Rates</h3>
<hr />
<div class="form">
    <div class="form-row alignRight">
  		<input type="submit" id="submit" name="submit" />
  		<input type="reset" id="reset" name="reset" />
	</div>
</div>