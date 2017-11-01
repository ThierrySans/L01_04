
<?php
header('Content-Type: application/json');
// php config
$servername= 'localhost';
$username = 'softserv_admin';
$password = 'softserv';
$db = 'softserv';

$problemsetid = $_GET["problemsetid"];
$problemsetunitid = $_GET["problemsetunitid"];
$problemsetname = $_GET["problemsetname"];
$problemsetdatedue = $_GET["problemsetdatedue"];
// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Set SQL query and input the partial course name

//variables
$sql_insertproblemset = "INSERT INTO PROBLEMSETS(PROBLEMSETID, UNITID, NAME) VALUES ('$problemsetid','$problemsetunitid','$problemsetname')";

$result_insertproblemset = mysqli_query($conn, $sql_insertproblemset);
echo json_encode($problemsetid);
mysqli_close($conn);

?>