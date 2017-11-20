<?php
use PHPUnit\Framework\TestCase;

class getunitsTest extends TestCase
{
	public function test_get_student_empty()
	{
		$return_getstudents = [];
		$this->assertEquals(array(), get_students($return_getstudents));
	}
	
	public function test_get_student()
	{
		$name["UTORID"] = "bob123";
		$id["ID"] = "id";
		$firstname["FIRSTNAME"] = "FIRSTNAME";
		$lastname["LASTNAME"] = "LASTNAME";
		$password["PASSWORD"] = "PASSWORD";
		$return_getstudent = [$name, $id, $firstname, $lastname, $password];
		
		$expected_return_getstudent[$utorid] = array("firstname" => $firstname,
								      "lastname" => $lastname);


		$this->assertEquals(get_students($return_getstudent), $expected_return_getstudent);
	}
	
}
		
?>
