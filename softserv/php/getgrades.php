<?php
header('Content-Type: application/json');
include('./config.php');
$student_id = $_GET["username"];
//function getGrades($studentid) {
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

//$sql_getgrades= "SELECT PROBLEMSETS.ID AS ID, UNITID, UNITS.NAME AS UNITNAME, PROBLEMSETS.NAME AS NAME, DATEDUE, HighestScore, RecentScore FROM (PROBLEMSETGRADES RIGHT JOIN PROBLEMSETS ON ID = ProblemsetID AND StudentID = '$studentid') JOIN UNITS ON UNITS.ID = PROBLEMSETS.UNITID;";

$sql_getgrades = "SELECT o.UNITID AS UNITID, o.ID AS ID, o.NAME AS NAME, o.DATEDUE AS DATEDUE, p.HighestScore AS HighestScore, o.HighestScore AS HighestScoreAvg, p.RecentScore AS RecentScore, o.RecentScore AS RecentScoreAvg FROM (SELECT UNITID, UNITNAME, t.ID AS ID, NAME, DATEDUE, HighestScore, RecentScore FROM (SELECT UNITID, UNITS.NAME AS UNITNAME, PROBLEMSETS.ID AS ID, PROBLEMSETS.NAME AS NAME, DATEDUE FROM PROBLEMSETS JOIN UNITS WHERE UNITS.ID = PROBLEMSETS.UNITID ORDER BY UNITID) AS t LEFT OUTER JOIN (SELECT AVG(HighestScore) AS HighestScore, AVG(RecentScore) AS RecentScore, ProblemSetID AS ID FROM PROBLEMSETGRADES GROUP BY ProblemSetID) AS s ON t.ID=s.ID) AS o JOIN (SELECT PROBLEMSETS.ID AS ID, UNITID, UNITS.NAME AS UNITNAME, PROBLEMSETS.NAME AS NAME, DATEDUE, HighestScore, RecentScore FROM (PROBLEMSETGRADES RIGHT JOIN PROBLEMSETS ON ID = ProblemsetID AND StudentID = '$student_id') JOIN UNITS ON UNITS.ID = PROBLEMSETS.UNITID) AS p ON o.ID=p.ID";

$result_getgrades= mysqli_query($conn, $sql_getgrades);

$return_getgrades = array(); //retrieve from assoc array

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
	$highestscoreavg = $return_getgrades[$i]["HighestScoreAvg"];
	$recentscore = $return_getgrades[$i]["RecentScore"];
	$recentscoreavg = $return_getgrades[$i]["RecentScoreAvg"];
	
	
	if ($highestscore == NULL) {
		$highestscore = "N/A";
	} else {
		$highestscore = ($highestscore*100)."%";
	}
	
	if ($recentscore == NULL) {
		$recentscore = "N/A";
	} else {
		$recentscore = ($recentscore*100)."%";
	}

	if ($highestscoreavg == NULL) {
		$highestscoreavg = "N/A";
	} else {
		$highestscoreavg = ($highestscoreavg*100)."%";
	}

	if ($recentscoreavg == NULL) {
		$recentscoreavg = "N/A";
	} else {
		$recentscoreavg = ($recentscoreavg*100)."%";
	}

	$grades[$unitid]["unitdata"][$problemsetid] = array("name" => $problemsetname,
		  "datedue" => $datedue,
		  "highestscore" => $highestscore,
		  "recentscore" => $recentscore,
		  "highestscoreavg" => $highestscoreavg,
		  "recentscoreavg" => $recentscoreavg);
	$grades[$unitid]["unitname"] = $unitname;
}
	//mysqli_close($conn);
	//return $grades;
	
//}
//$student_id = $_GET["username"];
//json_encode(getGrades($student_id));

echo json_encode($grades);
mysqli_close($conn);
?>