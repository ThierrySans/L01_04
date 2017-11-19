<?php
use PHPUnit\Framework\TestCase;

class loginTest extends TestCase
{
	public function password_validation_when_no_password_test()
	{
		$this->assertEquals(password_validation("", "");
	}
	
	public function password_validation_when_match_test()
	{
		$this->assertEquals(password_validation("password", "password"));
	}
	public function password_validation_when_not_matching_but_same_length_test()
	{
		$this->assertNotEquals(password_validation("password0", "password1"));
	}
	public function password_validation_when_not_matching_test()
	{
		$this->assertNotEquals(password_validation("password", "not password"));
	}
}
		
?>
