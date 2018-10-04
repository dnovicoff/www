<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$reportdata["title"] = "Sales Tax Liability";
$reportdata["description"] = "This report shows sales tax liability for the selected period";

$reportdata["currencyselections"] = true;

$query = "select year(min(date)) as minimum, year(max(date)) as maximum from tblaccounts;";
$result = mysql_query($query);
$data = mysql_fetch_array($result);
$minyear = $data['minimum'];
$maxyear = $data['maximum'];

$reportdata["headertext"] = "<form method=\"post\" action=\"$PHP_SELF?report=$report&currencyid=$currencyid&calculate=true\"><center>Start Date: <input type=\"text\" name=\"startdate\" value=\"$startdate\" class=\"datepick\" /> &nbsp;&nbsp;&nbsp; End Date: <input type=\"text\" name=\"enddate\" value=\"$enddate\" class=\"datepick\" /> &nbsp;&nbsp;&nbsp; <input type=\"submit\" value=\"Generate Report\"></form>";

if ($calculate) {

	$startdate = toMySQLDate($startdate);
	$enddate = toMySQLDate($enddate);

	$enddate .= "235959";

	$query = "SELECT COUNT(*),SUM(total),SUM(tax),SUM(tax2) FROM tblinvoices INNER JOIN tblclients ON tblclients.id=tblinvoices.userid WHERE datepaid>='$startdate' AND datepaid<='$enddate' AND tblinvoices.status='Paid' AND currency='$currencyid'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$numinvoices = $data[0];
	$total = $data[1];
	$tax = $data[2];
    $tax2 = $data[3];
	
	if (!$total) $total="0.00";
	if (!$tax) $tax="0.00";
    if (!$tax2) $tax2="0.00";

	$reportdata["headertext"] .= "<br>$numinvoices Invoices Found<br><B>Total Invoiced:</B> ".formatCurrency($total)." &nbsp; <B>Tax Level 1 Liability:</B> ".formatCurrency($tax)." &nbsp; <B>Tax Level 2 Liability:</B> ".formatCurrency($tax2);
}

$reportdata["headertext"] .= "</center>";

$reportdata["tableheadings"] = array("Invoice ID","Client Name","Invoice Date","Date Paid","Subtotal","Credit","Tax","Total");

$query = "SELECT tblinvoices.*,tblclients.firstname,tblclients.lastname FROM tblinvoices INNER JOIN tblclients ON tblclients.id=tblinvoices.userid WHERE datepaid>='$startdate' AND datepaid<='$enddate' AND tblinvoices.status='Paid' AND currency='$currencyid' ORDER BY date ASC";
$result = mysql_query($query);
while ($data = mysql_fetch_array($result)) {
	$id = $data["id"];
    $userid = $data["userid"];
	$client = $data["firstname"]." ".$data["lastname"];
	$date = fromMySQLDate($data["date"]);
	$datepaid = fromMySQLDate($data["datepaid"]);
    $currency = getCurrency($userid);
	$subtotal = $data["subtotal"];
	$credit = $data["credit"];
	$tax = $data["tax"]+$data["tax2"];
	$total = $data["total"];
	$reportdata["tablevalues"][] = array("$id","$client","$date","$datepaid","$subtotal","$credit","$tax","$total");
}

$data["footertext"]="";

?>