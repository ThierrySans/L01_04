<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that inserts a unit into our database.
It takes as input a unitname and returns a unitid.
*/

$unitname = $_GET["unitname"];
// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Set SQL query and input the partial course name

//variables
$sql_insertunit = "INSERT INTO UNITS(NAME) VALUES ('$unitname')";

$result_insertunit = mysqli_query($conn, $sql_insertunit);
echo json_encode($unitid);
mysqli_close($conn);

?>
