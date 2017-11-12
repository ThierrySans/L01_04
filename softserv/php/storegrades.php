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
$get_highmark = "SELECT HighestScore FROM PROBLEMSETGRADES WHERE ProblemsetID = $problemsetid AND StudentID = '$studentid'";
$result = mysqli_query($conn, $test_table);

//If no table
if ($result == false) {
	$query = "CREATE TABLE PROBLEMSETGRADES (
		ProblemsetID Int not null,
		StudentID VARCHAR(20) not null,
		HighestScore Int not null default 0,
		RecentScore Int not null default 0,
		primary key (ProblemsetID, StudentID)
		)";
		mysqli_query($conn, $query);
		$sql_insert_marks= "INSERT INTO PROBLEMSETGRADES(ProblemsetID, StudentID, HighestScore, RecentScore) VALUES('$studentid', $problemsetid, $mark, $mark)";
	    mysqli_query($conn, $sql_insertmarks);
	    $highmark = array("hello" => "hi");
		//new entry in new table
		
} else {
	$highmark_row = mysqli_query($conn, $get_highmark);
	//If student or problemset not in table
	if (mysqli_num_rows($highmark_row) == 0) {
		$query = "INSERT INTO PROBLEMSETGRADES(ProblemsetID, StudentID, HighestScore, RecentScore) VALUES($problemsetid,'$studentid', $mark, $mark)";
		$result = mysqli_query($conn, $query);
	} else {
		$highmark_row = mysqli_fetch_assoc($highmark_row);
		$highmark = $highmark_row["HighestScore"];
		if ($highmark > $mark) {
			$query = "UPDATE PROBLEMSETGRADES SET RecentScore = $mark WHERE ProblemsetID = $problemsetid AND StudentID = '$studentid'";
			$result = mysqli_query($conn, $query);
		} else {
			$query = "UPDATE PROBLEMSETGRADES SET RecentScore = $mark, HighestScore = $mark WHERE ProblemsetID = $problemsetid AND StudentID = '$studentid'";
			$result = mysqli_query($conn, $query);
		}
	}	
}
echo json_encode($query);
mysqli_close($conn);
?>