<?php
use PHPUnit\Framework\TestCase;
require_once('../../softserv/php/getunits.php');
class getunitsTest extends TestCase
{
	public function test_get_units_when_empty()
	{
		$units = [];
		$this->assertEquals(get_units($units, array()));
	}
	
	public function test_get_units_when_one_element()
	{
		$name["Name"] = "name";
		$id["ID"] = "id";
		$units = [[$id, $name]];
		$result["id"] = "name";
		$this->assertEquals(get_units($units, $result));
	}
	public function test_get_units_when_many()
	{
		$name["Name"] = "name";
		$id["ID"] = "id";
		$name0["Name"] = "name0";
		$id0["ID"] = "id0";
		$name1["Name"] = "name1";
		$id1["ID"] = "id1";
		$units = [[$id, $name],[$id0, $name0], [$id1, $name1]];
		$result["id"] = "name";
		$result["id0"] = "name0";
		$result["id1"] = "name1";
		$this->assertEquals(get_units($units, $result));
	}
}
		
?>
