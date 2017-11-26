<?php
header('Content-Type: application/json');
include('./config.php');

$problemsetid = $_GET["problemsetid"];


// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
// Set SQL query and input the partial course name
$sql_deleteproblemset = "DELETE FROM PROBLEMSETS WHERE ID = $problemsetid";
$result_1 = mysqli_query($conn, $sql_deleteproblemset);
$sql_deleteproblemset = "DELETE FROM PROBLEMSETGRADES WHERE ProblemsetID = $problemsetid";
$result_2 = mysqli_query($conn, $sql_deleteproblemset);

if ($result_1 and $result_2) {
    echo json_encode($result_1);
} else {
    echo json_encode($result_1);
}
mysqli_close($conn);
?>