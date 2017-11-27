<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that retrieves all grades for all students from our database
and sorts them by gpa range. It takes as input a problemsetid and returns all the grades 
associated to that problemset.
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

$sql_retrievegradesall = "SELECT HighestScore FROM PROBLEMSETGRADES WHERE ProblemSetID='$problemsetid'";
$result_retrievegradesall = mysqli_query($conn, $sql_retrievegradesall);

while ($row_retrievegradesall = mysqli_fetch_assoc($result_retrievegradesall)) {
	$frommysql_retrievegradesall[] = $row_retrievegradesall;
}

$retrievegradesall = array();

//converting into JSON data
$len_retrievegradesall = count($frommysql_retrievegradesall);
$distribution["0-20"] = 0;
$distribution["21-40"] = 0;
$distribution["41-60"] = 0;
$distribution["61-80"] = 0;
$distribution["81-100"] = 0;
for ($i = 0; $i < $len_retrievegradesall; $i++) {
	$highestscore = $frommysql_retrievegradesall[$i]["HighestScore"];
	$highestscore = $highestscore*100;
	
	if ($highestscore < 21) {
		$distribution["0-20"] = $distribution["0-20"] + 1;
	}
	else if ($highestscore < 41) { 
		$distribution["21-40"] = $distribution["21-40"] + 1;
	}
	else if ($highestscore < 61) { 
		$distribution["41-60"] = $distribution["41-60"] + 1;
	}
	else if ($highestscore < 81) { 
		$distribution["61-80"] = $distribution["61-80"] + 1;
	}
	else if ($highestscore < 101) { 
		$distribution["81-100"] = $distribution["81-100"] + 1;
	}
}
echo json_encode($distribution);
mysqli_close($conn);
?>
