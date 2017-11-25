<?php
header('Content-Type: application/json');
include('./config.php');
/*
*Given the string in the variables text field (must be no space in input, use new line to seperate variable)
*returns an array of variables, where index of the array is the name of the variable (string) and the content of the entries are random numbers that are assigned to the variables using the range given in the input string
*/
function get_variables($variabletext){
	$variables_array = array();
    	$n = strlen($variabletext);
	$j = 0; // index, explained in the loop
	$u = 0; 
	$v = 0;
	$w = 0; // index of "-"
	for ($k = 0; $k < $n; $k++){
   		if ($variabletext[$k] == '('){ $u = $k; }
		else if ($variabletext[$k] == '-'){ $w = $k; }
		else if ($variabletext[$k] == ')'){ $v = $k; }
	    	if ($variabletext[$k] == '\n' || $k == $n - 1){  
			// done with current line, variable starts at j, ends at u - 1 (inclusive on both end points)
			//                         range starts at u + 1, ends at v - 1 (inclusive on both end points)
			$range_from = (int) substr($variabletext, $u + 1, $w - ($u + 1));
			$range_to = (int) substr($variabletext, $w + 1, $v - ($w + 1));
			// generate a random number between the 2 number user specified (integer)
			$variables_array[substr($variabletext,  $j, $u - $j)] = rand($range_from, $range_to);		
			# update j and k for next line
			$j = $k + 1;
			$k = $k + 1;
		}	
	}
	return $variables_array;
}
/*
*Given the question as a string, and variable_array computed from get_variables
*return the questions as a string with variables replaced with actual numbers.
*/
function replace_question_w_variables($questiontext, $variables_array){
    	$resultquestion = "";
	$n = strlen($questiontext);
	$j = 0; // index of start of string to concat next
	$u = 0; // index of start of var
	$v = 0; // index of end of var
	for ($k = 1; $k < $n; $k++){
   		if ($questiontext[$k] == '{' && $questiontext[$k - 1] == '{'){ 
   		    	$resultquestion = $resultquestion.substr($questiontext, $j, $k - $j - 1);
   		   	$u = $k + 1;
   		   	$k = $k + 3; // variable length is at least 1, no need to check k+1 nor k+2
   			while ($k < $n){ // loop condition is only used for invalid input syntax to question input
   				if ($questiontext[$k] == '}' && $questiontext[$k - 1] == '}'){ // end of variable name
   					$v = $k - 1;
   					$j = $k + 1;
   					break;
   				}
   				$k = $k + 1;
   			}
   			// replace variable name with its value
   			$resultquestion = $resultquestion.$variables_array[substr($questiontext,  $u, $v - $u)];
   		}
   		else if ($k == $n - 1) // end of the string, add the remaining of the string
   		    $resultquestion = $resultquestion.substr($questiontext, $j, $n - $j);
	}
	return $resultquestion;
}

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

//function get_problems($return_getquestions){
$questions = array();

for ($i = 0; $i < count($return_getquestions); $i++) {
	$questionid = $return_getquestions[$i]["ID"];
	$questiontext = $return_getquestions[$i]["QUESTIONTEXT"];
	$answer= $return_getquestions[$i]["ANSWER"];
	$variabletext = $return_getquestions[$i]["VARIABLES"];

	$variables_array = get_variables($variabletext);
	$questiontext = replace_question_w_variables($questiontext, $variables_array);

	$questions[$questionid] = array("text" => $questiontext,
				"answer" => $answer);
	
}

echo json_encode($questions);
mysqli_close($conn);

?>
