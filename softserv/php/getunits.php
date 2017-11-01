
<?php
header('Content-Type: application/json');
// php config
$servername= 'localhost';
$username = 'softserv_admin';
$password = 'softserv';
$db = 'softserv';

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Set SQL query and input the partial course name
$sql_getunits = "SELECT * FROM UNITS";

$result_getunits = mysqli_query($conn, $sql_getunits);

// GET students
while ($row_getunits = mysqli_fetch_assoc($result_getunits)) {
	$return_getunits[] = $row_getunits;
}
$getunits = array();
for ($i = 0; $i < count($return_getunits); $i++) {
	$unitid = $return_getunits[$i]["ID"];
	$name = $return_getunits[$i]["NAME"];

	$getunits[$unitid] = $name;
}

echo json_encode($getunits);
mysqli_close($conn);

?>