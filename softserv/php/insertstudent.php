
<?php
header('Content-Type: application/json');
// php config
class database extends SQLite3 {
	function __construct() {
		$this->open('homework.db')
	}
}

$conn = new database();

  if(!$conn) {
      echo $conn->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }
 
$fieldvals = $_GET["fieldvals"];

// Set SQL query and input the partial course name

//variables
$studentid = $fieldvals[0];
$studentfirstname = $fieldvals[1];
$studentlastname = $fieldvals[3];
$studentutorid = $fieldvals[4];
$sql_addstudent =<<<EOF 
"INSERT INTO STUDENTS VALUES ('$studentid', '$studentfirstname', '$studentlastname', '$studentutorid')";

EOF; 

$conn->query($sql_addstudent);
echo json_encode("done");
$conn->close();

?>