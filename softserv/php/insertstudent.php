<?php
header('Content-Type: application/json');
include('./config.php');

$studentid = $_GET["utorid"];
$studentfirstname = $_GET["firstname"];
$studentlastname = $_GET["lastname"];
$studentpassword = $_GET["password"];
// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Set SQL query and input the partial course name
//variables
$sql_getstudents = "INSERT INTO STUDENTS VALUES ('$studentid', '$studentfirstname', '$studentlastname', '$studentpassword')";

$result_getstudents = mysqli_query($conn, $sql_getstudents);
echo json_encode($fieldvals);
mysqli_close($conn);

?>