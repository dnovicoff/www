

<?php
	$lat = number_format($_GET['lat'],9);
	$long = number_format($_GET['long'],9);
	$id = number_format($_GET['id']);

	$con = mysqli_connect('localhost','smartbususer','smartbususer','smartbusroute');
	if (!$con)  {
  		die('Could not connect: ' . mysqli_error($con));
  	}

	mysqli_select_db($con,"smartbusroute");
	$sql="UPDATE stop SET latitude=".$lat.", longitude=".$long." WHERE stop_id=".$id;

	$result = mysqli_query($con,$sql);

	mysqli_close($con);
?> 

<html>
	<head>
		<title>Whatever</title>
	</head>
	<body>
		Latitude <?php echo $lat ?><br />
		Longitude <?php echo $long ?><br />
		ID <?php echo $id ?><br />
	</body>
</html>
