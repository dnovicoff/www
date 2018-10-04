

<html>
	<head>
		      <!--  src="https://maps.googleapis.com/maps/api/js?key=API_KEY&sensor=false">  -->
		<title>Smart Bus Route Latitude / Longitude finder</title>
		<script language="javascript" src="/javascript/jQuery-1.4.2/jquery-1.4.2.min.js"></script> 
		<script language="javascript" src="/javascript/jQuery-1.4.2/jquery-timing-min.js"></script> 
		<script language="javascript" src="/javascript/home/smartbusroute/index.js"></script> 
		<script language="javascript"
		      src="https://maps.googleapis.com/maps/api/js?sensor=true">
		</script>
	</head>
	<body onload="getStops()">
<?php
	#$q = intval($_GET['q']);

	$con = mysqli_connect('localhost','smartbususer','smartbususer','smartbusroute');
	if (!$con)  {
  		die('Could not connect: ' . mysqli_error($con));
  	}

	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT * FROM stop";

	$result = mysqli_query($con,$sql);

	echo "<table border='1'>
	<tr>
	<th>Stop ID</th>
	<th>Stop</th>
	<th>Latitude</th>
	<th>Longitude</th>
	</tr>";

	$i=0;
	while($row = mysqli_fetch_array($result))  {
  		echo "<tr>";
  		echo "<td id=\"id".$i."\">" . $row['stop_id'] . "</td>";
  		echo "<td id=\"stop".$i."\">" . $row['stop'] . "</td>";
  		echo "<td id=\"lat".$i."\">" . $row['latitude'] . "</td>";
  		echo "<td id=\"long".$i."\">" . $row['longitude'] . "</td>";
  		echo "</tr>";
		$i++;
  	}
	echo "</table>";

	mysqli_close($con);
?> 
	</body>
</html>
