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
	
    protected function setUp() {
		$xml = new Xmldb;
		$this->xml->getCONF();
        global $_CONF;
    }
	
}

?>
