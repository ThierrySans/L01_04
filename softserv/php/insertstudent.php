<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that inserts a student into our database.
It takes as input a utorid, firstname, lastname and password
and returns the fieldvals.
*/

// getting our variables
$studentid = $_GET["utorid"];
$studentfirstname = $_GET["firstname"];
$studentlastname = $_GET["lastname"];
$studentpassword = $_GET["password"];

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// query to insert the student
$sql_getstudents = "INSERT INTO STUDENTS VALUES ('$studentid', '$studentfirstname', '$studentlastname', '$studentpassword')";

$result_getstudents = mysqli_query($conn, $sql_getstudents);
echo json_encode($fieldvals);

mysqli_close($conn);
?>
