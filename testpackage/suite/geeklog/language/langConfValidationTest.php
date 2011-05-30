<?php

/**
* There is now a dependency between the entries for dropdown menus in
* $LANG_configselects and $_CONF_VALIDATE. If you accidentally translate
* the keyword, it gets written to the database and fails the validation.
* These tests ensure that all selection list entries match their equivalent
* in the list of to-be-validated entries.
*/

require_once 'PHPUnit/Framework.php';
require_once 'tst.class.php';
 
class langConfValidation extends PHPUnit_Framework_TestCase 
{
    private $c;

    protected function setUp() {
        global $_CONF, $_CONF_VALIDATE;

        // set dummy values for the $_CONF options used in the language files
        $_CONF = array();
        $_CONF['site_url'] = 'http://www.example.com';
        $_CONF['site_admin_url'] = 'http://www.example.com/admin';
        $_CONF['site_name'] = 'Test Site';
        $_CONF['speedlimit'] = 42;
        $_CONF['commentspeedlimit'] = 42;
        $_CONF['backup_path'] = '/path/to/geeklog/';
        $_DB_mysqldump_path = '/usr/bin/mysqldump';

        if (! defined('XHTML')) {
            define("XHTML",'');
        }

        // there's a date() call somewhere - make PHP 5.2 shut up
        $system_timezone = @date_default_timezone_get();
        date_default_timezone_set($system_timezone);

        $this->c =& config::get_instance();

        include Tst::$root.'language/english.php';
        include Tst::$public.'admin/configuration_validation.php';
        require_once Tst::$public.'admin/install/config-install.php';

        install_config();
    }
    protected function checkForMissingEntries($type, $lang = '') {
        global $_CONF_VALIDATE, $LANG_configselects;

        // loop through validation rules
        foreach ($_CONF_VALIDATE[$type] as $key => $val) {
            if (is_array($val['rule'])) {
                $rule = $val['rule'];
                // pick only those comparing against a list
                if ($rule[0] == 'inList') {
                    $values = $rule[1];
                    $numeric = false;
                    foreach ($values as $v) {
                        if (is_numeric($v)) {
                            $numeric = true;
                            break;
                        }
                    }
                    // we're only interested in lists with non-numeric entries
                    if (! $numeric) {
                        $sel = $this->c->has_sel($key);
                        // does it refer to a $LANG_configselects?
                        if ($sel !== false) {
                            if (isset($LANG_configselects[$type][$sel])) {
                                // entries we compare against (reference)
                                $ref = $LANG_configselects[$type][$sel];
                                // should have same number of entries, obviously
                                $this->assertEquals(count($ref), count($values));
                                // key/value is flipped in language file
                                $flipped = array_flip($ref);
                                foreach ($values as $v) {
                                    $this->assertTrue(isset($flipped[$v]),
                                        "$lang: '$key' missing '$v'");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function testBasics() {
        global $_CONF_VALIDATE;

        // dummy entry, should not be set
        $this->assertFalse($this->c->has_sel('does_not_exist'));

        // is not a selection
        $this->assertFalse($this->c->has_sel('maximagesperarticle'));

        // is a selection and the index is 7
        $this->assertEquals(7, $this->c->has_sel('page_break_comments'));

        // look at one validation entry a little closer
        $rule = $_CONF_VALIDATE['Core']['page_break_comments']['rule'];
        $this->assertEquals($rule[0], "inList");
        $this->assertTrue(is_array($rule[1]));
        $this->assertEquals(3, count($rule[1]));
        $this->assertEquals("all", $rule[1][0]);
    }
/* covered by testCoreLanguages() below
    public function testCoreEnglish() {
        global $_CONF,
               $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        include Tst::$root.'language/english.php';
        $this->checkForMissingEntries('Core');
    }
    public function testLinksPluginEnglish() {
        global $_CONF,
               $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        include Tst::$root.'plugins/links/language/english.php';
        include Tst::$root.'plugins/links/configuration_validation.php';
        $this->checkForMissingEntries('links', 'english.php');
    }
*/
    public function testCoreLanguages() {
        global $_CONF,
               $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $fd = opendir(Tst::$root.'language');
        while ((false !== ($file = @readdir($fd)))) {
            if ($file <> '.' && $file <> '..') {
                include Tst::$root.'language/'.$file;
                $this->checkForMissingEntries('Core', $file);
            }
        }
        closedir($fd);
    }
    public function testCalendarPluginLanguages() {
        global $_CONF,
               $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $fd = opendir(Tst::$root.'language');
        while ((false !== ($file = @readdir($fd)))) {
            if ($file <> '.' && $file <> '..') {
                include Tst::$root.'language/'.$file;
                include Tst::$root.'plugins/calendar/configuration_validation.php';
                $this->checkForMissingEntries('calendar', $file);
            }
        }
        closedir($fd);
    }
    public function testLinksPluginLanguages() {
        global $_CONF,
               $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $fd = opendir(Tst::$root.'language');
        while ((false !== ($file = @readdir($fd)))) {
            if ($file <> '.' && $file <> '..') {
                include Tst::$root.'language/'.$file;
                include Tst::$root.'plugins/links/configuration_validation.php';
                $this->checkForMissingEntries('links', $file);
            }
        }
        closedir($fd);
    }
    public function testPollsPluginLanguages() {
        global $_CONF,
               $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $fd = opendir(Tst::$root.'language');
        while ((false !== ($file = @readdir($fd)))) {
            if ($file <> '.' && $file <> '..') {
                include Tst::$root.'language/'.$file;
                include Tst::$root.'plugins/polls/configuration_validation.php';
                $this->checkForMissingEntries('polls', $file);
            }
        }
        closedir($fd);
    }
    public function testSpamXPluginLanguages() {
        global $_CONF,
               $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $fd = opendir(Tst::$root.'language');
        while ((false !== ($file = @readdir($fd)))) {
            if ($file <> '.' && $file <> '..') {
                include Tst::$root.'language/'.$file;
                include Tst::$root.'plugins/spamx/configuration_validation.php';
                $this->checkForMissingEntries('spamx', $file);
            }
        }
        closedir($fd);
    }
    public function testStaticPagesPluginLanguages() {
        global $_CONF,
               $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $fd = opendir(Tst::$root.'language');
        while ((false !== ($file = @readdir($fd)))) {
            if ($file <> '.' && $file <> '..') {
                include Tst::$root.'language/'.$file;
                include Tst::$root.'plugins/staticpages/configuration_validation.php';
                $this->checkForMissingEntries('staticpages', $file);
            }
        }
        closedir($fd);
    }
    public function testXMLSitemapPluginLanguages() {
        global $_CONF,
               $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $fd = opendir(Tst::$root.'language');
        while ((false !== ($file = @readdir($fd)))) {
            if ($file <> '.' && $file <> '..') {
                include Tst::$root.'language/'.$file;
                include Tst::$root.'plugins/xmlsitemap/configuration_validation.php';
                $this->checkForMissingEntries('xmlsitemap', $file);
            }
        }
        closedir($fd);
    }
}

class config {

    private $cfg;

    function __construct()
    {
        $this->cfg = array();
    }

    function &get_instance()
    {
        static $instance;

        if (!$instance) {
            $instance = new config();
        }

        return $instance;
    }

    function add($param_name, $default_value, $type, $subgroup, $fieldset=null,
         $selection_array=null, $sort=0, $set=true, $group='Core', $tab=null)
    {
        if ($selection_array !== null) {
            $this->cfg[$param_name] = $selection_array;
        }
    }

    function has_sel($param_name)
    {
        if (isset($this->cfg[$param_name]) && ($this->cfg[$param_name] !== null)) {
            return $this->cfg[$param_name];
        } else {
            return false;
        }
    }

}

?>
