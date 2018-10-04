

<?
	echo "Remote Addr: ".$_SERVER['REMOTE_ADDR']."\n";
	echo "Remote Host: ".$_SERVER['REMOTE_HOST']."\n";
	echo "Request Time: ".$_SERVER['REQUEST_TIME']."\n";

	echo "ENV Query String: ".$_SERVER['QUERY_STRING']."\n";

	echo "ENV Post: ".$_POST['browser']."\n";
	echo "          ".$_POST['cookie']."\n";
	echo "          ".$_POST['java']."\n";
	echo "          ".$_POST['os']."\n";
	echo "          ".$_POST['version']."\n";
	echo "          ".$_SERVER['HTTP_USER_AGENT']."\n";
?>
