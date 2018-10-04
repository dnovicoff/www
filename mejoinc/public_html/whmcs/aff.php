<?php

define("CLIENTAREA",true);

include("dbconnect.php");
include("includes/functions.php");

if (isset($aff)) {
	update_query("tblaffiliates",array("visitors"=>"+1"),array("id"=>$aff));
	setcookie("WHMCSAffiliateID", $aff, time()+90*24*60*60);
}

if ($pid) redir("a=add&pid=".(int)$pid,"cart.php");

if ($gid) redir("gid=".(int)$gid,"cart.php");

if ($register) redir("","register.php");

if ($gocart) {
    $reqvars = '';
    foreach ($_GET AS $k=>$v) $reqvars .= $k.'='.urlencode($v).'&';
    redir($reqvars,"cart.php");
}

header("HTTP/1.1 301 Moved Permanently");
header("Location: ".$CONFIG["Domain"],true,301);

?>