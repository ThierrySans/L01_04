<?php
header('Content-Type: application/json');
// php config
$servername= 'localhost';
$username = 'softserv_admin';
$password = 'softserv';
$db = 'softserv';

$fieldvals = $_GET["fieldvals"];
// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

//variables
$unitname = $fieldvals[0];
$unitstart = $fieldvals[1];
$unitend = $fieldvals[2];
$sql_getunits = "INSERT INTO UNITS (NAME, START, END) VALUES ('$unitname', '$unitstart', '$unitend')";

$result_getunits = mysqli_query($conn, $sql_getunits);
echo json_encode("done");
mysqli_close($conn);

?>