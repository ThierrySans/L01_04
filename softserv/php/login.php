<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that alows students to login to access their grades
stored in the database. It takes as input a username and password. It returns
the string comparison between the password entered and the password in the
database.
*/

// getting our variables
$studentid = $_GET["username"];
$studentpassword = $_GET["password"];

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// query to select the student with a given utorid
$sql_compare= "SELECT PASSWORD FROM STUDENTS WHERE UTORID = '$studentid'";

$expected_hashed_password = mysqli_query($conn, $sql_compare);
$expected_hashed_password = mysqli_fetch_assoc($expected_hashed_password);
$expected_hashed_password = $expected_hashed_password["PASSWORD"];

// check if the passwords match
function password_validation($studentpassword, $expected_hashed_password) {
	$cmp_result = strcmp("$expected_hashed_password","$studentpassword");
	return $cmp_result;
}

echo json_encode(password_validation($studentpassword, $expected_hashed_password));
mysqli_close($conn);

?>
