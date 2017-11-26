<?php
header('Content-Type: application/json');
include('./config.php');

/*
This is a web service that deletes a problem set from our database.
It takes as input a problem set ID and deletes all instances of 
that problem set in our tables PROBLEMSETGRADES and PROBLEMSETS.
*/

// getting our variables
$problemsetid = $_GET["problemsetid"];

// create a connection
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL Queries to delete problem set from two tables
$sql_deleteproblemset = "DELETE FROM PROBLEMSETS WHERE ID = $problemsetid";
$result_1             = mysqli_query($conn, $sql_deleteproblemset);
$sql_deleteproblemset = "DELETE FROM PROBLEMSETGRADES WHERE ProblemsetID = $problemsetid";
$result_2             = mysqli_query($conn, $sql_deleteproblemset);

// testing that we returned correct data
if ($result_1 and $result_2) {
    echo json_encode($result_1);
} else {
    echo json_encode($result_1);
}
mysqli_close($conn);
?>