<?php 

/**
* Simple tests for calendarClassTest
*/

require_once 'PHPUnit/Framework.php';
require_once 'config.php';
require_once getPath('public').'/lib-common.php';
require_once getPath('tests').'/databases/xmldb.class.php';

class libcommonTest extends PHPUnit_Framework_TestCase 
{
	protected function setUp() {
        $this->x = new Xmldb;
        global $_CONF;
        $_CONF = $this->x->getCONF();
    }	
}

?>
