<?php 

/**
* Simple tests for calendarClassTest
*/

require_once 'PHPUnit/Framework.php';
require_once '../config.php';
require_once getPath('restricted').'/system/lib-mbyte.php';
require_once getPath('tests').'/databases/xmldb.class.php';

class libmbyteClass extends PHPUnit_Framework_TestCase 
{
	protected $x;
	
    protected function setUp() {
		$this->x = new Xmldb;
		global $_CONF;
		$_CONF = $this->x->getCONF();
    }
	
	public function testMBYTE_languageList() {
		$this->assertEquals('english', MBYTE_languageList());
	}
	
}

?>
