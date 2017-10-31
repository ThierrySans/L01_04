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

// Set SQL query and input the partial course name

//variables
$studentid = $fieldvals[0];
$studentfirstname = $fieldvals[1];
$studentlastname = $fieldvals[3];
$studentutorid = $fieldvals[4];
$sql_getstudents = "INSERT INTO STUDENTS VALUES ('$studentid', '$studentfirstname', '$studentlastname', '$studentutorid')";

$result_getstudents = mysqli_query($conn, $sql_getstudents);
echo json_encode("done");
mysqli_close($conn);

?>
