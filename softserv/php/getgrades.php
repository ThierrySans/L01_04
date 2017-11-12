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

$studentid = $_GET["username"];

$sql_getgrades= "SELECT PROBLEMSETID, HIGHESTSCORE, RECENTSCORE FROM PROBLEMSETGRADES WHERE STUDENTID = $studentid";

$result_getgrades= mysqli_query($conn, $sql_getgrades);

$frommysql_getgrades = array(); //retrieve from assoc array

// GET grades
while ($row_getgrades = mysqli_fetch_assoc($result_getgrades)) {
	$return_getgrades[] = $row_getgrades;
}

$grades= array();

for ($i = 0; $i < count($return_getgrades); $i++) {
	$gradesproblemset = $return_getgrades[$i]["PROBLEMSETID"];
	$gradeshighestscore = $return_getgrades[$i]["HIGHESTSCORE"];
	$gradesrecentscore= $return_getproblemsets[$i]["RECENTSCORE"];

	$grades[$gradesproblemset] = array("highestscore" => $gradeshighestscore,
				"recentscore" => $gradesrecentscore);
}

echo json_encode($grades);
mysqli_close($conn);

?>