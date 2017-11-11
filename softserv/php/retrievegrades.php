<?php
header('Content-Type: application/json');
include('./config.php');
// create a connection
$problemsetid = $_GET["problemsetid"];
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
$test_table = "SELECT * FROM PROBLEMSETGRADES";
$result_retrievegradesall = mysqli_query($conn, $test_table);

//If no table
if (empty($result_retrievegradesall)) {
	$query = "CREATE TABLE PROBLEMSETGRADES (
		ProblemsetID Int not null,
		StudentID Int not null,
		HighestScore Int not null default 0,
		RecentScore Int not null default 0,
		primary key (ProblemsetID, StudentID)
		)";
	mysqli_query($conn, $query);
}

//retrieving problem set grades for that problem set
$sql_retrievegradesall = "SELECT UTORID,FIRSTNAME,LASTNAME,HighestScore,RecentScore FROM (STUDENTS LEFT JOIN PROBLEMSETGRADES ON PROBLEMSETGRADES.ProblemSetID = STUDENTS.UTORID) WHERE ProblemSetID = $problemsetid";
$result_retrievegradesall = mysqli_query($conn, $sql_retrievegradesall);

//formatting into JSON format
$frommysql_retrievegradesall = array(); //retrieve from assoc array

// GET problemsets
while ($row_retrievegradesall = mysqli_fetch_assoc($result_retrievegradesall)) {
	$return_retrievegradesall[] = $row_retrievegradesall;
}

$retrievegradesall = array();

//converting into JSON data
for ($i = 0; $i < count($return_retrievegradesall); $i++) {
	$utorid = $return_retrievegradesall[$i]["UTORID"];
	$firstname = $return_retrievegradesall[$i]["FIRSTNAME"];
	$lastname = $return_retrievegradesall[$i]["LASTNAME"];
	$highestscore = $return_retrievegradesall[$i]["HighestScore"];
	$recentscore = $return_retrievegradesall[$i]["RecentScore"];

	$retrievegradesall[$utorid] = array("firstname" => $firstname,
										"lastname" => $lastname,
									    "highestscore" => $highestscore,
									    "recentscorre" => $recentscore);
}


echo json_encode($retrievegradesall);
mysqli_close($conn);
?>