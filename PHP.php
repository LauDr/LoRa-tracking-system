<?php

header("Content-type: application/json");
$json = file_get_contents("php://input");
echo $json;
$obj = json_decode($json);


$deviceName = ($obj->deviceName);
$data = ($obj->data);
$devAddr= $obj->devAddr;

$timestamp = date("h:i:sa");

$dec = base64_decode($data);
$ar = unpack("C*", $dec);
$Latitude	= (($ar[1]<<24) + ($ar[2]<<16) + ($ar[3]<<8) + $ar[4]);	///1000000;
$Longitude	= (($ar[5]<<24) + ($ar[6]<<16) + ($ar[7]<<8) + $ar[8]);///1000000;
$Alarm 		= ($ar[9]&0b01000000)>>6;
$Battery	= ((($ar[9]&0b00111111)<<8) + $ar[9])/1000;
$MD			= ($ar[10]&0b11000000)>>6;
$LON		= ($ar[10]&0b00100000)>>5;
$Firm		= $ar[10]&0b00011111;


$toFile = "$timestamp\n$Latitude\n$Longitude\n$Battery\n\n";

	$fp = @fopen("$deviceName.txt", "a");	//Open and write into deviceName.txt
	fwrite($fp,$toFile);	

	fwrite($fp,"\r\n");				
	fclose($fp);
	
$deviceName = "LGT92AA01";

// (A) DATABASE SETTINGS - CHANGE THESE TO YOUR OWN
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

$sql = "INSERT INTO $deviceName (longitude, latitude) VALUES ($Longitude,$Latitude)";
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>