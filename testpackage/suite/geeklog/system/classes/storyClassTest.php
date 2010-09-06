<?php

/**
* (Very) Simple tests for the Story Class
*
* There isn't much we can test without a database or lib-common.php, but
* try it anyway ...
*
*/

require_once 'PHPUnit/Framework.php';
require_once 'tst.class.php';
require_once Tst::$root.'system/classes/story.class.php';
 
class storyClass extends PHPUnit_Framework_TestCase 
{
    protected function setUp() {
    }

    public function testHasNoContent() {
        $st = new Story();
        $this->assertFalse($st->hasContent());
    }

    public function testHasNoContentAdmin() {
        $st = new Story('admin');
        $this->assertFalse($st->hasContent());
    }

    public function testHasContentTitle() { // 'title' counts as content
        $ar = array('title' => 'Some Title',
                    // loadFromArray() insists on a 'unixdate'. Is this a bug?
                    'unixdate' => time());
        $st = new Story();
        $st->loadFromArray($ar);
        $this->assertTrue($st->hasContent());
    }

    public function testHasContentBodytext() { // 'bodytext' counts as content
        $ar = array('bodytext' => 'Some Text',
                    // loadFromArray() insists on a 'unixdate'. Is this a bug?
                    'unixdate' => time());
        $st = new Story();
        $st->loadFromArray($ar);
        $this->assertTrue($st->hasContent());
    }

    public function testHasContentIntrotext() { // 'introtext' counts as content
        $ar = array('introtext' => 'Some Text',
                    // loadFromArray() insists on a 'unixdate'. Is this a bug?
                    'unixdate' => time());
        $st = new Story();
        $st->loadFromArray($ar);
        $this->assertTrue($st->hasContent());
    }

    public function testGetSpamCheckFormatEmpty() {
        $st = new Story();
        $this->assertEquals('<h1></h1><p></p><p></p>',
                            $st->getSpamCheckFormat());
    }

    public function testGetSpamCheckFormat() {
        $st = new Story();
        $ar = array('title'     => 'Title',
                    'introtext' => 'Intro',
                    'bodytext'  => 'Body',
                    'unixdate'  => time());
        $st->loadFromArray($ar);
        $this->assertEquals('<h1>Title</h1><p>Intro</p><p>Body</p>',
                            $st->getSpamCheckFormat());
    }

    public function testGetSidEmpty() {
        $st = new Story();
        $this->assertEquals("", $st->getSid());
    }

    public function testGetSid() {
        $st = new Story();
        $ar = array('sid' => '1234567890', 'unixdate'  => time());
        $st->loadFromArray($ar);
        $this->assertEquals("1234567890", $st->getSid());
    }

    public function testGetSidForDb() {
        $st = new Story();
        $ar = array('sid' => '1234567890', 'unixdate'  => time());
        $st->loadFromArray($ar);
        $this->assertEquals("1234567890", $st->getSid(true));
    }

    public function testGetSidForDbWithSlashes() {
        $st = new Story();
        $ar = array('sid' => "12345'67890", 'unixdate'  => time());
        $st->loadFromArray($ar);
        $this->assertEquals("12345\\'67890", $st->getSid(true));
    }

    public function testGetAccessNotSet() {
        $st = new Story();
        $this->assertNull($st->getAccess());
    }

    public function testGetAccess() {
        $st = new Story();
        $ar = array('access' => 2, 'unixdate'  => time());
        $st->loadFromArray($ar);
        $this->assertEquals(2, $st->getAccess());
    }

    public function testSetTid() {
        $st = new Story();
        $st->setTid('News');
        $this->assertEquals('News', $st->_tid); // how about a getTid() method?
    }

}

?>
