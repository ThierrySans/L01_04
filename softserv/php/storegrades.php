<?php
header('Content-Type: application/json');
include('./config.php');
// create a connection
$studentid = $_GET["username"];
$problemsetid = $_GET["problemsetid"];
$mark= $_GET["mark"];

$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
$test_table = "SELECT * FROM PROBLEMSETGRADES";
$get_highmark = "SELECT HIGHESTSCORE FROM PROBLEMSETGRADES WHERE PROBLEMSETID = $problemsetid AND StudentID = $studentid";
$result = mysqli_query($conn, $test_table);

//If no table
if (empty($result)) {
	$query = "CREATE TABLE PROBLEMSETGRADES (
		ProblemsetID Int not null,
		StudentID Int not null,
		HighestScore Int not null default 0,
		RecentScore Int not null default 0,
		primary key (ProblemsetID, StudentID)
		)";
		mysqli_query($conn, $query);
		$sql_insert_marks= "INSERT INTO PROBLEMSETGRADES(ProblemsetID, StudentID, HighestScore, RecentScore) VALUES('$studentid','$problemsetid', '$mark', '$mark')";
		
} else {
	$highmark = mysqli_query($conn, $sql_highmark);
	//If student or problemset not in table
	if (empty($highmark)) {
		$query = "INSERT INTO PROBLEMSETGRADES(ProblemsetID, StudentID, HighestScore, RecentScore) VALUES('$studentid','$problemsetid', '$mark', '$mark')";
		$result = mysqli_query($conn, $query);
	} else {
		$highmark = mysqli_fetch_assoc($highmark);
		$highmark = highmark["HighestScore"];
		if ($highmark > $mark) {
			$query = "UPDATE PROBLEMSETGRADES SET RecentScore = $mark WHERE ProblemsetID = $problemsetid AND StudentID = $studentid";
			$result = mysqli_query($conn, $query);
		} else {
			$query = "UPDATE PROBLEMSETGRADES SET RecentScore = $mark, HighestScore = $mark WHERE ProblemsetID = $problemsetid AND StudentID = $studentid";
			$result = mysqli_query($conn, $query);
		}
	}	
}
$result = "";
echo json_encode($result);
mysqli_close($conn);
?>