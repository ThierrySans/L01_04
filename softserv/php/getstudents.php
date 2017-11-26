<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that gets students from our database.
It takes no input and returns the utorid, firstname, lastname and
password of all students.
*/

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Set SQL query
$sql_getstudents = "SELECT * FROM STUDENTS";

$result_getstudents = mysqli_query($conn, $sql_getstudents);

// get all row data from mysql query
while ($row_getstudents = mysqli_fetch_assoc($result_getstudents)) {
	$return_getstudents[] = $row_getstudents;
}

function get_students($return_getstudents){
	$getstudents = array();
	for ($i = 0; $i < count($return_getstudents); $i++) {
		$utorid = $return_getstudents[$i]["UTORID"];
		$firstname = $return_getstudents[$i]["FIRSTNAME"];
		$lastname = $return_getstudents[$i]["LASTNAME"];
		$password = $return_getstudents[$i]["PASSWORD"];
		$getstudents[$utorid] = array("firstname" => $firstname,
								      "lastname" => $lastname);
	}
	return $getstudents;
}

echo json_encode(get_students($return_getstudents));
mysqli_close($conn);
?>
