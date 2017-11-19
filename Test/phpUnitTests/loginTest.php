<?php
use PHPUnit\Framework\TestCase;

class loginTest extends TestCase
{
	public function test_password_validation_when_no_password()
	{
		$this->assertEquals(password_validation("", "");
	}
	
	public function test_password_validation_when_matching()
	{
		$this->assertEquals(password_validation("password", "password"));
	}
	public function test_password_validation_when_not_matching_but_same_length()
	{
		$this->assertNotEquals(password_validation("password0", "password1"));
	}
	public function test_password_validation_when_not_matching()
	{
		$this->assertNotEquals(password_validation("password", "not password"));
	}
}
		
?>
