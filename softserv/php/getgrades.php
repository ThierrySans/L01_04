<?php
header('Content-Type: application/json');
include('./config.php');

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$studentid = $_GET["username"];

$sql_getgrades= "SELECT PROBLEMSETS.ID AS ID, UNITID, UNITS.NAME AS UNITNAME, PROBLEMSETS.NAME AS NAME, DATEDUE, HighestScore, RecentScore FROM (PROBLEMSETGRADES RIGHT JOIN PROBLEMSETS ON ID = ProblemsetID AND StudentID = '$studentid') JOIN UNITS ON UNITS.ID = PROBLEMSETS.UNITID;";

$result_getgrades= mysqli_query($conn, $sql_getgrades);

$frommysql_getgrades = array(); //retrieve from assoc array

// GET grades
while ($row_getgrades = mysqli_fetch_assoc($result_getgrades)) {
	$return_getgrades[] = $row_getgrades;
}

$grades= array();

for ($i = 0; $i < count($return_getgrades); $i++) {
	$problemsetid = $return_getgrades[$i]["ID"];
	$unitid = $return_getgrades[$i]["UNITID"];
	$unitname = $return_getgrades[$i]["UNITNAME"];
	$problemsetname = $return_getgrades[$i]["NAME"];
	$datedue = $return_getgrades[$i]["DATEDUE"];
	
	
	$highestscore = $return_getgrades[$i]["HighestScore"];
	if ($highestscore == null) {
		$highestscore = 0;
	}
	
	$recentscore = $return_getgrades[$i]["RecentScore"];
	if ($recentscore == null) {
		$recentscore = 0;
	}
	

	$grades[$unitid]["unitdata"][$problemsetid] = array("name" => $problemsetname,
		  "datedue" => $datedue,
		  "highestscore" => $highestscore,
		  "recentscore" => $recentscore);
	$grades[$unitid]["unitname"] = $unitname;
}

echo json_encode($grades);
mysqli_close($conn);

?>