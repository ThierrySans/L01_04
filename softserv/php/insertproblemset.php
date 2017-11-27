<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that inserts problem sets into our database.
It takes as input a unitid, problemsetname, datedue, questions and
returns the questions. The function also inserts the questions 
(including question text, answers, and variables) into the database.
*/

// getting our variables
$unitid = $_GET["unitid"];
$problemsetname = $_GET["problemsetname"];
$datedue = $_GET["datedue"];
$questions = json_decode($_GET["questions"], true);

// helper function to determine if the date is in valid format
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

if (!var_dump(validateDate('$datedue')){ // if duedate is not in valid format, then remove duedate 
					 // (by changing due date to end of computer time counter)
	$datedue = "2036-01-01";
}


// query to insert the problem set.

$sql_insertproblemset = "INSERT INTO PROBLEMSETS(UNITID, NAME, DATEDUE) VALUES('$unitid','$problemsetname','$datedue')";

$result_insertproblemset = mysqli_query($conn, $sql_insertproblemset);
$result_maxproblemsetid = mysqli_query($conn, "SELECT * FROM PROBLEMSETS ORDER BY ID DESC LIMIT 1");
$row_maxproblemsetid = mysqli_fetch_assoc($result_maxproblemsetid);
$problemsetid = $row_maxproblemsetid["ID"];

// function to insert the question data of that problem set into the QUESTIONS table.
// each question will be inserted
if ($result_insertproblemset != false) {
	for ($i=0; $i<count($questions); $i++) {
		$questiontext = $questions["$i"]["question"];
		$answer = $questions["$i"]["answer"];
		$variable = $questions["$i"]["variables"];
		$sql_insertquestion = "INSERT INTO QUESTIONS(PROBLEMSETID, QUESTIONTEXT, ANSWER, VARIABLES) VALUES('$problemsetid','$questiontext','$answer', '$variable')";
		
		$result_insertquestion = mysqli_query($conn, $sql_insertquestion);
	}
}

echo json_encode($questions["1"]["question"]);
mysqli_close($conn);

?>
