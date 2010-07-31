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

    /***
    * Helper function: strip all linefeed characters (CR + LF) from a string.
    * Just in case our reference files are converted to the native linefeed of
    * the platform we're running on (Unix LF vs. Windows CR+LF).
    */
    private function strip_linefeeds($line) {
        return str_replace(array("\015", "\012"), '', $line);
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

    public function testUnsetVar() {
        $tp2 = new Template;
        $tp2->set_var('test', 'test42');
        $this->assertEquals("test42", $tp2->get_var('test'));
        $tp2->unset_var('test');
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testUnsetVarNotExist() {
        $tp2 = new Template;
        $tp2->unset_var('doesnotexist');
        $this->assertEquals("", $tp2->get_var('doesnotexist'));
    }

    public function testUnsetVarHash() {
        $tp2 = new Template;
        $hash = array('test' => 'test43');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test'));
        $tp2->unset_var('test');
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testUnsetVarHash2() {
        $tp2 = new Template;
        $hash = array('test' => 'test43');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test'));
        $hash2 = array('test');
        $tp2->unset_var($hash2);
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testUnsetVarHashNotExist() {
        $tp2 = new Template;
        $hash = array('doesnotexist');
        $tp2->unset_var($hash);
        $this->assertEquals("", $tp2->get_var('doesnotexist'));
    }

    public function testUnsetVarHashMultiple() {
        $tp2 = new Template;
        $hash = array('test1' => 'test41', 'test2' => 'test42');
        $tp2->set_var($hash);
        $this->assertEquals("test41", $tp2->get_var('test1'));
        $this->assertEquals("test42", $tp2->get_var('test2'));
        $hash2 = array('test1', 'test2');
        $tp2->unset_var($hash2);
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

    public function testFilenameRelative() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertEquals(Tst::$tests . 'files/templates/replace1.thtml',
                            $tp2->filename('replace1.thtml'));
    }

    public function testFilenameAbsolute() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertEquals(Tst::$tests . 'files/templates/replace1.thtml',
                $tp2->filename(Tst::$tests . 'files/templates/replace1.thtml'));
    }

    public function testGetVars() {
        $tp2 = new Template;
        $hash = array('test2' => 'test43', 'test1' => 'test42');
        $tp2->set_var($hash);
        $vars = $tp2->get_vars();
        $this->assertEquals($hash, $vars);
    }

    public function testParse() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $tp2->set_var('test', 'replaced');
        $replaced = $tp2->parse('myform', 'testfile');
        $replaced = $this->strip_linefeeds($replaced);
        $this->assertEquals('<p>replaced</p>', $replaced);
        $now = $tp2->get_var('myform');
        $now = $this->strip_linefeeds($now);
        $this->assertEquals('<p>replaced</p>', $now);
    }

    public function testParseAppend() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $tp2->set_var('test', 'replaced');
        $replaced = $tp2->parse('myform', 'testfile');
        $replaced = $this->strip_linefeeds($replaced);
        $this->assertEquals('<p>replaced</p>', $replaced);
        $now = $tp2->get_var('myform');
        $now = $this->strip_linefeeds($now);
        $this->assertEquals('<p>replaced</p>', $now);

        $tp2->set_var('test', 'appended');
        $appended = $tp2->parse('myform', 'testfile', true);
        $appended = $this->strip_linefeeds($appended);
        $this->assertEquals('<p>appended</p>', $appended);

        $all = $tp2->get_var('myform');
        $all = $this->strip_linefeeds($all);
        $this->assertEquals('<p>replaced</p><p>appended</p>', $all);
    }

    public function testGetUndefined() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $undef = $tp2->get_undefined('testfile');
        $expected = array('test' => 'test'); // a hash of varname/varname pairs
        $this->assertEquals($expected, $undef);
    }

    public function testGetUndefinedLoadError() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        // we don't want the error handler to kick in, so:
        $tp2->halt_on_error = 'no';
        $this->assertTrue($tp2->set_file('testfile', 'doesnotexist.thtml'));
        $this->assertFalse($tp2->get_undefined('testfile'));
    }

    public function testGetUndefinedUnknownVariable() {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $this->assertFalse($tp2->get_undefined('doesnotexist'));
    }
}

?>
