<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$pmonth = str_pad((int)$month, 2, "0", STR_PAD_LEFT);

$reportdata["title"] = "Income by Product for ".$months[(int)$month]." ".$year;
$reportdata["description"] = "This report provides a breakdown per product/service of invoices paid in a given month. Please note this excludes overpayments & other payments made to deposit funds (credit), and includes invoices paid from credit added in previous months, and thus may not match the income total for the month.";
$reportdata["currencyselections"] = true;

$reportdata["tableheadings"] = array("Product Name","Units Sold","Value");

$products = $addons = array();

# Loop Through Products
$result = full_query("SELECT tblhosting.packageid,SUM(tblinvoiceitems.amount) FROM tblinvoiceitems INNER JOIN tblinvoices ON tblinvoices.id=tblinvoiceitems.invoiceid INNER JOIN tblhosting ON tblhosting.id=tblinvoiceitems.relid WHERE tblinvoices.datepaid LIKE '".(int)$year."-".$pmonth."-%' AND (tblinvoiceitems.type='Hosting' OR tblinvoiceitems.type LIKE 'ProrataProduct%') GROUP BY tblhosting.packageid");
while ($data = mysql_fetch_array($result)) {
    $products[$data[0]] = $data[1];
}

# Loop Through Product Discounts
$result = full_query("SELECT tblhosting.packageid,SUM(tblinvoiceitems.amount) FROM tblinvoiceitems INNER JOIN tblinvoices ON tblinvoices.id=tblinvoiceitems.invoiceid INNER JOIN tblhosting ON tblhosting.id=tblinvoiceitems.relid WHERE tblinvoices.datepaid LIKE '".(int)$year."-".$pmonth."-%' AND tblinvoiceitems.type='PromoHosting' GROUP BY  tblhosting.packageid");
while ($data = mysql_fetch_array($result)) {
    $products[$data[0]] += $data[1];
}

# Loop Through Addons
$result = full_query("SELECT tblhostingaddons.addonid,SUM(tblinvoiceitems.amount) FROM tblinvoiceitems INNER JOIN tblinvoices ON tblinvoices.id=tblinvoiceitems.invoiceid INNER JOIN tblhostingaddons ON tblhostingaddons.id=tblinvoiceitems.relid WHERE tblinvoices.datepaid LIKE '".(int)$year."-".$pmonth."-%' AND tblinvoiceitems.type='Addon' GROUP BY  tblhostingaddons.addonid");
while ($data = mysql_fetch_array($result)) {
    $addons[$data[0]] += $data[1];
}

$total = 0;

$itemtotal = 0;
$firstdone = false;
$result = select_query("tblproducts","tblproducts.id,tblproducts.name,tblproductgroups.name AS groupname","","tblproductgroups`.`order` ASC,`tblproducts`.`order` ASC,`name","ASC","","tblproductgroups ON tblproducts.gid=tblproductgroups.id");
while($data = mysql_fetch_array($result)) {
	$pid = $data["id"];
	$group = $data["groupname"];
	$prodname = $data["name"];

    if ($group!=$prevgroup) {
        $total += $itemtotal;
        if ($firstdone) {
            $reportdata["tablevalues"][] = array('','<strong>Sub-Total</strong>','<strong>'.formatCurrency($itemtotal).'</strong>');
            $chartdata['rows'][] = array('c'=>array(array('v'=>$prevgroup),array('v'=>$itemtotal,'f'=>formatCurrency($itemtotal))));
        }
        $reportdata["tablevalues"][] = array("**<strong>$group</strong>");
        $itemtotal = 0;
    }

    $amount = $products[$pid];

    $itemtotal += $amount;

    $amount = formatCurrency($amount);

    $reportdata["tablevalues"][] = array($prodname,$number,$amount);

    $prevgroup = $group;
    $firstdone = true;

}

$total += $itemtotal;
$reportdata["tablevalues"][] = array('','<strong>Sub-Total</strong>','<strong>'.formatCurrency($itemtotal).'</strong>');
$chartdata['rows'][] = array('c'=>array(array('v'=>$group),array('v'=>$itemtotal,'f'=>formatCurrency($itemtotal))));

$reportdata["tablevalues"][] = array("**<strong>Addons</strong>");

$itemtotal = 0;
$result = select_query("tbladdons","id,name","","name","ASC");
while($data = mysql_fetch_array($result)) {

    $addonid = $data["id"];
    $prodname = $data["name"];

    $amount = $addons[$addonid];

    $itemtotal += $amount;

    $amount = formatCurrency($amount);

    $reportdata["tablevalues"][] = array($prodname,$number,$amount);

    $prevgroup = $group;

}

$itemtotal += $addons[0];
$reportdata["tablevalues"][] = array('Miscellaneous Custom Addons','',$addons[0]);

$total += $itemtotal;
$reportdata["tablevalues"][] = array('','<strong>Sub-Total</strong>','<strong>'.formatCurrency($itemtotal).'</strong>');
$chartdata['rows'][] = array('c'=>array(array('v'=>"Addons"),array('v'=>$itemtotal,'f'=>formatCurrency($itemtotal))));

$itemtotal = 0;
$reportdata["tablevalues"][] = array("**<strong>Miscellaneous</strong>");

$result = full_query("SELECT SUM(tblinvoiceitems.amount) FROM tblinvoiceitems INNER JOIN tblinvoices ON tblinvoices.id=tblinvoiceitems.invoiceid WHERE tblinvoices.datepaid LIKE '".(int)$year."-".$pmonth."-%' AND tblinvoiceitems.type='Item'");
$data = mysql_fetch_array($result);
$itemtotal += $data[0];
$reportdata["tablevalues"][] = array('Billable Items','',$data[0]);

$result = full_query("SELECT SUM(tblinvoiceitems.amount) FROM tblinvoiceitems INNER JOIN tblinvoices ON tblinvoices.id=tblinvoiceitems.invoiceid WHERE tblinvoices.datepaid LIKE '".(int)$year."-".$pmonth."-%' AND tblinvoiceitems.type=''");
$data = mysql_fetch_array($result);
$itemtotal += $data[0];
$reportdata["tablevalues"][] = array('Custom Invoice Line Items','',$data[0]);

$total += $itemtotal;
$reportdata["tablevalues"][] = array('','<strong>Sub-Total</strong>','<strong>'.formatCurrency($itemtotal).'</strong>');
$chartdata['rows'][] = array('c'=>array(array('v'=>"Miscellaneous"),array('v'=>$itemtotal,'f'=>formatCurrency($itemtotal))));

$total = formatCurrency($total);

$chartdata['cols'][] = array('label'=>'Days Range','type'=>'string');
$chartdata['cols'][] = array('label'=>'Value','type'=>'number');

$args = array();
$args['legendpos'] = 'right';

$reportdata["footertext"] = $chart->drawChart('Pie',$chartdata,$args,'300px');

$reportdata["monthspagination"] = true;

?>