<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that retrieves all grades for all students from our database.
It takes as input a problemsetid and returns all the grades associated
with a student.
*/

// getting our variables
$problemsetid = $_GET["problemsetid"];

// creating a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// query to test if table exists
$test_table = "SELECT * FROM PROBLEMSETGRADES";
$result_retrievegradesall = mysqli_query($conn, $test_table);

//If no table, create a new table
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

$sql_retrievegradesall = "SELECT UTORID,FIRSTNAME,LASTNAME,HighestScore,RecentScore FROM (STUDENTS LEFT JOIN PROBLEMSETGRADES ON PROBLEMSETGRADES.StudentID = STUDENTS.UTORID AND ProblemSetID = $problemsetid)";
$result_retrievegradesall = mysqli_query($conn, $sql_retrievegradesall);

while ($row_retrievegradesall = mysqli_fetch_assoc($result_retrievegradesall)) {
	$frommysql_retrievegradesall[] = $row_retrievegradesall;
}

$retrievegradesall = array();

//converting into JSON data
$len_retrievegradesall = count($frommysql_retrievegradesall);
for ($i = 0; $i < $len_retrievegradesall; $i++) {
	$utorid = $frommysql_retrievegradesall[$i]["UTORID"];
	$firstname = $frommysql_retrievegradesall[$i]["FIRSTNAME"];
	$lastname = $frommysql_retrievegradesall[$i]["LASTNAME"];
	$highestscore = $frommysql_retrievegradesall[$i]["HighestScore"];
	$recentscore = $frommysql_retrievegradesall[$i]["RecentScore"];
	
	if ($highestscore == null) {
		$highestscore = "N/A";
	} else {
		$highestscore = ($highestscore*100)."%";
	}
	if ($recentscore == null) {
		$recentscore = "N/A";
	} else {
		$recentscore = ($recentscore*100)."%";
	}
	$retrievegradesall[$utorid] = array("firstname" => $firstname,
										"lastname" => $lastname,
										"highestscore" => $highestscore,
										"recentscore" => $recentscore);
}
echo json_encode($retrievegradesall);
mysqli_close($conn);
?>
