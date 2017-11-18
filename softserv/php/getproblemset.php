<?php
header('Content-Type: application/json');
include('./config.php');

// create a connection
$problemsetid = $_GET["problemsetid"];

$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$sql_getquestions = "SELECT * FROM QUESTIONS WHERE PROBLEMSETID = '$problemsetid'";

$result_getquestions = mysqli_query($conn, $sql_getquestions);

$frommysql_getquestions = array(); //retrieve from assoc array

// GET problemsets
while ($row_getquestions = mysqli_fetch_assoc($result_getquestions)) {
	$return_getquestions[] = $row_getquestions;
}

$questions = array();

for ($i = 0; $i < count($return_getquestions); $i++) {
	$questionid = $return_getquestions[$i]["ID"];
	$questiontext = $return_getquestions[$i]["QUESTIONTEXT"];
	$answer= $return_getquestions[$i]["ANSWER"];

	$questions[$questionid] = array("text" => $questiontext,
				"answer" => $answer);

}

echo json_encode($questions);
mysqli_close($conn);
?>