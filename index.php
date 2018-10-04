

<?php
	$con = mysqli_connect("127.0.0.1","smartbususer","smartbususer","smartbusroute"); 
	$ip = $_SERVER['REMOTE_ADDR'];


	$location=geoip_record_by_name('76.226.143.254');
	$latlng = [];
	$radius = 3;
        foreach ($location as $key=>$value) {
                if ($key == "latitude" or $key == "longitude")  {
			$latlng[$key] = $value;
                }
        }

	if (!mysqli_connect_errno($con))  {

		$query = sprintf("SELECT address, name, lat, lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * 
			cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance 
			FROM markers HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
  			mysql_real_escape_string($latlng['latitude']),
  			mysql_real_escape_string($latlng['longitude']),
  			mysql_real_escape_string($latlng['latitude']),
  			mysql_real_escape_string($radius));
			$result = mysql_query($query);
		print "{'People':".
			"[".
				"{'firstname':'$ip','lastname':'Carlson'},".
			"]".
		"}"; 
  	}  else  {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	mysqli_close($con);
?>
