

<? 
	$location=geoip_record_by_name('php.net');
	print_r(geoip_record_by_name('php.net'));
	echo "<br />";
	foreach ($location as $key=>$value) {
		if ($key == "latitude" or $key == "longitude")  {
			echo $key."|  |".$value;
			echo "<br />";
		}
	}
	echo "<br />";
?>
