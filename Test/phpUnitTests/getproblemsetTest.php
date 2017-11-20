<?php
use PHPUnit\Framework\TestCase;

class getproblemsetTest extends TestCase
{
	public function test_get_problems_when_empty()
	{
    $return_getquestions = [];
		$this->assertEquals(array(), get_problems($return_getquestions));
	}

  public function test_get_problems_when_not_empty()
  {
    $id["ID"] = "id";
    $text["QUESTIONTEXT"] = "questiontext";
    $answer["ANSWER"] = "answer";
    $return_getquestions = [$id, $text, $answer];
    $resultText["text"] = "questiontext";
    $resultAnswer["answer"] = "answer";
    //$result["id"] = [[$resultText], [$resultAnswer]];
    $result["id"] = array("text" => "questiontext",
					"answer" => "answer");
    //$result["id"] = [$resultText, $resultAnswer];
    $this->assertEquals($result, get_problems($return_getquestions));
  }

}

?>
