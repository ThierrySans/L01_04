<?php
header('Content-Type: application/json');
include('./config.php');

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$sql_getproblemsets= "SELECT UNITID, UNITS.NAME AS UNITNAME, PROBLEMSETS.ID AS ID, PROBLEMSETS.NAME AS NAME, DATEDUE FROM PROBLEMSETS JOIN UNITS WHERE UNITS.ID = PROBLEMSETS.UNITID ORDER BY UNITID";

$result_getproblemsets = mysqli_query($conn, $sql_getproblemsets);

$frommysql_getproblemsets = array(); //retrieve from assoc array

// GET problemsets
while ($row_getproblemsets = mysqli_fetch_assoc($result_getproblemsets)) {
	$return_getproblemsets[] = $row_getproblemsets;
}

$problemsets = array();

for ($i = 0; $i < count($return_getproblemsets); $i++) {
	$problemsetunitid = $return_getproblemsets[$i]["UNITID"];
	$problemsetunitname = $return_getproblemsets[$i]["UNITNAME"];
	$problemsetid = $return_getproblemsets[$i]["ID"];
	$problemsetname = $return_getproblemsets[$i]["NAME"];
	$problemsetdatedue = $return_getproblemsets[$i]["DATEDUE"];
	
	
	$problemsets[$problemsetunitid]["unitdata"][$problemsetid] = array("name" => $problemsetname,
				"datedue" => $problemsetdatedue);
	$problemsets[$problemsetunitid]["unitname"] = $problemsetunitname;
}

echo json_encode($problemsets);
mysqli_close($conn);

?>