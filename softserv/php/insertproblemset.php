<?php
header('Content-Type: application/json');
include('./config.php');
$unitid = $_GET["unitid"];
$problemsetname = $_GET["problemsetname"];
$datedue = $_GET["datedue"];
$questions = json_decode($_GET["questions"], true);

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Set SQL query and input the partial course name

$sql_insertproblemset = "INSERT INTO PROBLEMSETS(UNITID, NAME, DATEDUE) VALUES('$unitid','$problemsetname','2019-02-03')";
$result_insertproblemset = mysqli_query($conn, $sql_insertproblemset);
$result_maxproblemsetid = mysqli_query($conn, "SELECT * FROM PROBLEMSETS ORDER BY ID DESC LIMIT 1");
$row_maxproblemsetid = mysqli_fetch_assoc($result_maxproblemsetid);
$problemsetid = $row_maxproblemsetid["ID"];

if ($result_insertproblemset != false) {
	for ($i=0; $i<count($questions); $i++) {
		$questiontext = $questions["$i"]["question"];
		$answer = $questions["$i"]["answer"];
		$variable = $questions["$i"]["variables"];
		$sql_insertquestion = "INSERT INTO QUESTIONS(PROBLEMSETID, QUESTIONTEXT, ANSWER, VARIABLES) VALUES('$problemsetid','$questiontext','$answer', '$variable')";
		
		$result_insertquestion = mysqli_query($conn, $sql_insertquestion);
	}
}
//variables
//$sql_insertproblemset = "INSERT INTO PROBLEMSETS(PROBLEMSETID, UNITID, NAME) VALUES ('$problemsetid','$problemsetunitid','$problemsetname')";

//$result_insertproblemset = mysqli_query($conn, $sql_insertproblemset);
echo json_encode($questions["1"]["question"]);
mysqli_close($conn);

?>