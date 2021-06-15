<?php

	$q = intval($_GET['q']);

	//(A) DATABASE SETTINGS
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "lora";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT id, timestamp, latitude, longitude FROM lgt92aa01";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
		//echo "id: " . $row["id"]. " - time: " . $row["timestamp"]. " " . $row["latitude"]. " " . $row["longitude"]. "<br>";
		$latitude[$row["id"]] = $row["latitude"]/1000000;
		$longitude[$row["id"]] = $row["longitude"]/1000000;
		$lastId = $row["id"];
		$timestamp[$row["id"]] = $row["timestamp"];
	  }
	} 

	$conn->close();
		
	$time = strtotime($timestamp[$lastId - $q]);

	$JSON = '{"latitude":' . $latitude[$lastId - $q] . ', "longitude":' . $longitude[$lastId - $q] . ', "timestamp":' . $time . '}';

	echo $JSON;
?>