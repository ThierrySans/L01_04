<?php
/*
This is a web service that retrieves all units from our database.
It takes no input and returns the unitid and name of all units.
*/
header('Content-Type: application/json');
include('./config.php');

// create a connection and return it

$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// query the database of a given connection and return the units

// Set SQL query and input the partial course name
$sql_getunits = "SELECT * FROM UNITS";

$result_getunits = mysqli_query($conn, $sql_getunits);

// GET units
while ($row_getunits = mysqli_fetch_assoc($result_getunits)) {
	$return_getunits[] = $row_getunits;
}

// split the units into an array
function get_units($query_result){ 
	$getunits = array();
	for ($i = 0; $i < count($query_result); $i++) {
		$unitid = $query_result[$i]["ID"];
		$name = $query_result[$i]["NAME"];

		$getunits[$unitid] = $name;
	}
	return $getunits;
}

// call function to execute the task of getting units
$getunits = get_units($return_getunits);

echo json_encode($getunits);
mysqli_close($conn);

?>
