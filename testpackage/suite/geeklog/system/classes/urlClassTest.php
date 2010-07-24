<?php

/**
* Simple tests for the url class
*/

require_once 'PHPUnit/Framework.php';
require_once 'tst.class.php';
require_once Tst::$root.'system/classes/url.class.php';
 
class urlClass extends PHPUnit_Framework_TestCase
{
    private $cd;

    protected function setUp() {
        // Assign default values
        $this->url = new url();
    }

    public function testIsEnabled() {
        $this->assertTrue($this->url->isEnabled());
    }

    public function testSetEnabled() {
        $this->url->setEnabled(false);
        $this->assertFalse($this->url->isEnabled());
        $this->url->setEnabled(true);
        $this->assertTrue($this->url->isEnabled());
    }

    public function testNumArguments() {
        $this->assertEquals(0, $this->url->numArguments());
    }

    public function testSetArgNames() {
        $this->assertTrue($this->url->setArgNames(array('test')));
    }

    public function testSetWrongArgNames() {
        $this->assertFalse($this->url->setArgNames('test'));
    }

    public function testGetArgument() {
        // unknown argument names always return ''
        $this->assertEquals('', $this->url->getArgument('blah'));
    }

    public function testBuildUrl() {
        $this->assertEquals('http://www.example.com/index.php/value',
            $this->url->buildUrl('http://www.example.com/index.php?name=value'));
    }
}

?>
