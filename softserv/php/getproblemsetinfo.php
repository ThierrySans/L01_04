<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that retrieves all problem sets from our database.
It takes no input and returns the the unitid, unitname, id, name, duedate,
highscore and recentscore of every problem set.
*/

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// query to retrieve all problem sets
$sql_getproblemsets= "SELECT UNITID, UNITNAME, t.ID AS ID, NAME, DATEDUE, HighestScore, RecentScore FROM (SELECT UNITID, UNITS.NAME AS UNITNAME, PROBLEMSETS.ID AS ID, PROBLEMSETS.NAME AS NAME, DATEDUE FROM PROBLEMSETS JOIN UNITS WHERE UNITS.ID = PROBLEMSETS.UNITID ORDER BY UNITID) AS t LEFT OUTER JOIN (SELECT AVG(HighestScore) AS HighestScore, AVG(RecentScore) AS RecentScore, ProblemSetID AS ID FROM PROBLEMSETGRADES GROUP BY ProblemSetID) AS s ON t.ID=s.ID";

$result_getproblemsets = mysqli_query($conn, $sql_getproblemsets);

// getting all row data from mysql queries
while ($row_getproblemsets = mysqli_fetch_assoc($result_getproblemsets)) {
	$return_getproblemsets[] = $row_getproblemsets;
}

$problemsets = array();

// split data retrieved from query into a php associative array
for ($i = 0; $i < count($return_getproblemsets); $i++) {
	$problemsetunitid = $return_getproblemsets[$i]["UNITID"];
	$problemsetunitname = $return_getproblemsets[$i]["UNITNAME"];
	$problemsetid = $return_getproblemsets[$i]["ID"];
	$problemsetname = $return_getproblemsets[$i]["NAME"];
	$problemsetdatedue = $return_getproblemsets[$i]["DATEDUE"];
	
	$problemsetrecentavg = $return_getproblemsets[$i]["RecentScore"];
	
	if ($problemsetrecentavg == NULL) {
		$problemsetrecentavg = "N/A";
	} else {
		$problemsetrecentavg = ($problemsetrecentavg*100)."%";
	}
	
	$problemsethighestavg = $return_getproblemsets[$i]["HighestScore"];
	
	if ($problemsethighestavg == NULL) {
		$problemsethighestavg = "N/A";
	} else {
		$problemsethighestavg = ($problemsethighestavg*100)."%";
	}
	
	$problemsets[$problemsetunitid]["unitdata"][$problemsetid] = array("name" => $problemsetname,
				"datedue" => $problemsetdatedue, "recentavg" => $problemsetrecentavg, "highestavg" => $problemsethighestavg);
	$problemsets[$problemsetunitid]["unitname"] = $problemsetunitname;
}

echo json_encode($problemsets);
mysqli_close($conn);

?>
