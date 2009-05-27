<?php

/**
* Simple tests for conversion.class.php
*/

require_once 'PHPUnit/Framework.php';

require_once '../../../geeklog/system/classes/conversion.class.php';

class calendarClass extends PHPUnit_Framework_TestCase 
{
	private $c;
	
	protected function setUp() {
		$this->c = new conversion;
	}	
	public function testAddHtmlEquals () {
		$this->c->html = '<p>';
		$this->c->addHtml('<b>Hello World</b></p>');
		$this->assertEquals('<p><b>Hello World</b></p>', $this->c->html);
	}
	public function testConvert () {
		// In progress
	}	
}

?>

 