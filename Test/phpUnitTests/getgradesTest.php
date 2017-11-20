<?php
use PHPUnit\Framework\TestCase;

class getGradesTest extends TestCase
{
	public function test_empty()
	{
		$return_getgrades = [];
		$this->assertEquals(array(), get_problems($return_getgrades));
	}

	public function test_non_empty()
	{
		$grades[$unitid]["unitdata"][$problemsetid] = array("name" => $problemsetname,
			  "datedue" => $datedue,
			  "highestscore" => $highestscore,
			  "recentscore" => $recentscore);
		$grades[$unitid]["unitname"] = $unitname;
		
		$id["ID"] = "id";
		$duedate["DATEDUE"] = "datedue";
		$highest["HIGHESTSCORE"] = "highestscore";
		$recent["RECENT"] = "recentscore";
		$return_getgrades = [$id, $duedate, $highest, $recent];
		
		$result_id["ID"] = "id";
		$result_duedate["DATEDUE"] = "datedue";
		$result_highest["HIGHESTSCORE"] = "highestscore";
		$result_recent["RECENT"] = "recentscore";
		$result["id"] = array("ID" => "id", "DATEDUE" => "datedue", "HIGHESTSCORE" => "highestscore", "RECENT" => "recentscore");

		//$result["id"] = [$resultText, $resultAnswer];
		$this->assertEquals($result, getGrades($return_getgrades));
	}
}
		
?>
