<?php
header('Content-Type: application/json');
// php config
$servername= 'localhost';
$username = 'softserv_admin';
$password = 'softserv';
$db = 'softserv';

$studentid = $_GET["utorid"];
$studentpassword = $_GET["password"];

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Set SQL query and input the partial course name

$sql_compare= "SELECT PASSWORD FROM STUDENTS WHERE UTORID = " + $studentid;

$password = mysqli_query($conn, $sql_getstudents);

echo json_encode(strcmp($password, password_hash($studentpassword, PASSWORD_DEFAULT)));
mysqli_close($conn);

?>