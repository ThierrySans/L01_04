
<?php
header('Content-Type: application/json');

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

// Set SQL query and input the partial course name
$sql_getstudents =<<<EOF
      SELECT * from STUDENTS;
EOF;


$result_getstudents = $conn->query($sql_getstudents);

$frommysql_getstudents = array(); //retrieve from assoc array

// GET students
while ($row_getstudents = $result_getstudents->fetcharray(SQLITE3_ASSOC)) {
	$return_getstudents[] = $row_getstudents;
}
$getstudents = array();
for ($i = 0; $i < count($return_getstudents); $i++) {
	$utorid = $return_getstudents[$i]["UTORID"];
	$firstname = $return_getstudents[$i]["FIRSTNAME"];
	$lastname = $return_getstudents[$i]["LASTNAME"];
	$password = $return_getstudents[$i]["PASSWORD"];
	$getstudents["$utorid"] = array("firstname" => $firstname,
								   "lastname" => $lastname,
								   "password" => $password);
}

echo json_encode($getstudents);
$conn->close();

?>