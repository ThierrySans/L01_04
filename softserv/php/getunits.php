<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that retrieves all units from our database.
It takes no input and returns the unitid and name of all units.
*/

// create a connection and return it
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// query to get all units
$sql_getunits = "SELECT * FROM UNITS";

$result_getunits = mysqli_query($conn, $sql_getunits);

// get all row data from mysql query
while ($row_getunits = mysqli_fetch_assoc($result_getunits)) {
	$return_getunits[] = $row_getunits;
}

// create a JSON array from the row data
function get_units($query_result){ 
	$getunits = array();
	for ($i = 0; $i < count($query_result); $i++) {
		$unitid = $query_result[$i]["ID"];
		$name = $query_result[$i]["NAME"];

		$getunits[$unitid] = $name;
	}
	return $getunits;
}

$getunits = get_units($return_getunits);

echo json_encode($getunits);
mysqli_close($conn);

?>
