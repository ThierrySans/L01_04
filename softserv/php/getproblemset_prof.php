<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that retrieves all question data from a single 
problem set. It takes as input a problem set ID and returns a JSON
array consisting of each question (including question text, variables,
and answer) in the original format as inputted by the professor.
*/

// getting our variables
$problemsetid = $_GET["problemsetid"];

// creating a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// our query to get all questions correponding to the given problem set id
$sql_getquestions    = "SELECT * FROM QUESTIONS WHERE PROBLEMSETID = '$problemsetid'";
$result_getquestions = mysqli_query($conn, $sql_getquestions);

// get the rows returned by mysql query
while ($row_getquestions = mysqli_fetch_assoc($result_getquestions)) {
    $return_getquestions[] = $row_getquestions;
}

$questions = array();

// parsing the row data into a JSON array
for ($i = 0; $i < count($return_getquestions); $i++) {
    $questionid   = $return_getquestions[$i]["ID"];
    $questiontext = $return_getquestions[$i]["QUESTIONTEXT"];
    $variabletext = $return_getquestions[$i]["VARIABLES"];
    $answer   = $return_getquestions[$i]["ANSWER"];
    
    $questions[$questionid] = array(
        "text" => $questiontext,
        "answer" => $answer,
        "variables" => $variabletext
    );
    
}

echo json_encode($questions);
mysqli_close($conn);

?>