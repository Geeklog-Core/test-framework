<?php

/**
* Simple tests for the Template class
*/

require_once 'PHPUnit/Framework.php';
require_once 'tst.class.php';
require_once Tst::$root.'system/classes/template.class.php';
 
class templateClass extends PHPUnit_Framework_TestCase 
{
    private $tp;

    protected function setUp() {
        // Assign default values
        $this->tp = new Template;
        $this->tp->set_root(Tst::$tests . 'files/templates');
    }

    public function testGetVarDefault() {
        $tp2 = new Template;
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testSetVar() {
        $tp2 = new Template;
        $tp2->set_var('test', 'test42');
        $this->assertEquals("test42", $tp2->get_var('test'));
    }

    public function testSetVarHash() {
        $tp2 = new Template;
        $hash = array('test' => 'test41');
        $tp2->set_var($hash);
        $this->assertEquals("test41", $tp2->get_var('test'));
    }

    public function testSetVarHashMultiple() {
        $tp2 = new Template;
        $hash = array('test1' => 'test43', 'test2' => 'test42');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test1'));
        $this->assertEquals("test42", $tp2->get_var('test2'));
    }

    public function testSetVarAppend() {
        $tp2 = new Template;
        $tp2->set_var('test', 'test42');
        $this->assertEquals("test42", $tp2->get_var('test'));
        $tp2->set_var('test', '42test', true);
        $this->assertEquals("test4242test", $tp2->get_var('test'));
    }

    public function testSetVarHashAppend() {
        $tp2 = new Template;
        $hash = array('test' => 'test41');
        $tp2->set_var($hash);
        $hash2 = array('test' => '41test');
        $tp2->set_var($hash2, '', true);
        $this->assertEquals("test4141test", $tp2->get_var('test'));
    }

    public function testClearVar() {
        $tp2 = new Template;
        $tp2->set_var('test', 'test42');
        $this->assertEquals("test42", $tp2->get_var('test'));
        $tp2->clear_var('test');
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testClearVarNotExist() {
        $tp2 = new Template;
        $tp2->clear_var('doesnotexist');
        $this->assertEquals("", $tp2->get_var('doesnotexist'));
    }

    public function testClearVarHash() {
        $tp2 = new Template;
        $hash = array('test' => 'test43');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test'));
        $tp2->clear_var('test');
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testClearVarHash2() {
        $tp2 = new Template;
        $hash = array('test' => 'test43');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test'));
        $hash2 = array('test');
        $tp2->clear_var($hash2);
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testClearVarHashNotExist() {
        $tp2 = new Template;
        $hash = array('doesnotexist');
        $tp2->clear_var($hash);
        $this->assertEquals("", $tp2->get_var('doesnotexist'));
    }

    public function testClearVarHashMultiple() {
        $tp2 = new Template;
        $hash = array('test1' => 'test41', 'test2' => 'test42');
        $tp2->set_var($hash);
        $this->assertEquals("test41", $tp2->get_var('test1'));
        $this->assertEquals("test42", $tp2->get_var('test2'));
        $hash2 = array('test1', 'test2');
        $tp2->clear_var($hash2);
        $this->assertEquals("", $tp2->get_var('test1'));
        $this->assertEquals("", $tp2->get_var('test2'));
    }

    public function testSetRoot() {
        $tp2 = new Template;
        $this->assertTrue($tp2->set_root('.'));
    }

    public function testSetRootTestpackageFiles() {
        $this->assertTrue($this->tp->set_root(Tst::$tests . 'files/templates'));
    }

    public function testSetRootInConstructors() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertEquals(Tst::$tests . 'files/templates', $tp2->root);
    }

    public function testSetFile() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
    }

    public function testSetFileEmpty() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        // we don't want the error handler to kick in, so:
        $tp2->halt_on_error = 'no';
        $this->assertFalse($tp2->set_file('testfile', ''));
    }

    public function testSetFileNotExist() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        // we don't want the error handler to kick in, so:
        $tp2->halt_on_error = 'no';
        // somewhat odd behavior: if halt_on_error is disabled, set_file()
        // returns with true, even though the file does not exist
        $this->assertTrue($tp2->set_file('missing', 'doesnotexist.thtml'));
        $this->assertEquals(Tst::$tests . 'files/templates/doesnotexist.thtml',
                            $tp2->file['missing']);
    }

    public function testSetFileMultiple() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $files = array(
            'testfile1' => 'replace1.thtml',
            'testfile2' => 'replace2.thtml'
        );
        $this->assertTrue($tp2->set_file($files));
    }

    public function testSetFileMultipleEmpty() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        // we don't want the error handler to kick in, so:
        $tp2->halt_on_error = 'no';
        $files = array(
            'testfile1' => 'replace1.thtml',
            'testfile2' => ''
        );
        $this->assertFalse($tp2->set_file($files));
    }

    public function testReplaceVariable() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $tp2->set_var('test', 'replaced');
        $replaced = $tp2->parse('myform', 'testfile');
        $replaced = rtrim($replaced); // strip whitespace from end of string
        $this->assertEquals('<p>replaced</p>', $replaced);
    }

}

?>
