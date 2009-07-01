<?php 

/**
* Tests for lib-common
*/

require_once 'PHPUnit/Framework.php';
require_once 'config.php';
require_once getPath('tests').'files/classes/xmldb.class.php';
require_once getPath('public').'lib-common.php';

class libcommonTest extends PHPUnit_Framework_TestCase 
{	
	
	protected function setUp() {
    }
	
	public function testGetBlockTemplateEmptyBlocknameWithHeader() {		
		$this->assertEquals('blockheader.thtml', COM_getBlockTemplate('user_block', 'header'));
    }
	
	public function testGetBlockTemplateEmptyBlocknameWithOther() {		
		$this->assertEquals('blockfooter.thtml', COM_getBlockTemplate('user_block', 'rand'));
    }
	
	public function testGetBlockTemplateWithBlocknamePositionSpecificNoOverride() {	
		global $_BLOCK_TEMPLATE;
		$_BLOCK_TEMPLATE['_test_block'] = 'testblock.thtml,testblock.thtml';
		$this->assertEquals('testblock.thtml', COM_getBlockTemplate('_test_block', 'header', 'right'));
    }
	
	public function testGetBlockTemplateWithBlocknamePositionSpecificRequestOverride() {	
		global $_BLOCK_TEMPLATE;
		$_BLOCK_TEMPLATE['_test_block'] = 'blockheader.thtml,blockfooter.thtml';
		$this->assertEquals('blockheader-right.thtml', COM_getBlockTemplate('_test_block', 'header', 'right'));
    }
	
	public function testGetBlockTemplateWithBlocknamePositionSpecificBlock() {	
		global $_BLOCK_TEMPLATE;
		$_BLOCK_TEMPLATE['_test_block'] = 'blockheader-right.thtml,blockfooter-right.thtml';
		$this->assertEquals('blockheader-right.thtml', COM_getBlockTemplate('_test_block', 'header', 'right'));
    }
	
	public function testGetThemesNotAllowed() {
		global $_CONF;
		$_CONF['allow_user_themes'] = 0;
		$arr = COM_getThemes();
		$this->assertEquals('professional', $arr[1]);		
	}
	
	public function testGetThemesNotAllowedAll() {
		global $_CONF;
		$_CONF['allow_user_themes'] = 1;
		$arr = COM_getThemes();
		$this->assertEquals('professional', $arr[1]);		
	}	
	
	public function testRenderMenu() {
		// Line 571
		// Come back to this after understand functions called inside
		
		
		//global $_CONF;
		
		//$header = new Template('c:/xampplite/htdocs/geeklog/public_html/layout/professional/');
   	 	//$header->set_file(array('contribute', 'search', 'stats', 'directory', 'plugins'));
		//$plugin_menu = PLG_getMenuItems();		
		//COM_renderMenu($header, $plugin_menu);
		//$this->assertEquals(1, $_CONF['menu_elements']);
		$this->markTestIncomplete(
         'This test has not been implemented yet.');
	}
	
	public function testDebug() {
		// Line 1799
		$dummy = array('Letter 1' => 'a', 'Letter 2' => 'b');
		
		$retval = '<ul><pre><p>---- DEBUG ----</p>';
		foreach($dummy as $k => $v) { 
			$retval .= sprintf("<li>%13s [%s]</li>\n", $k, $v);
		}
		$retval .= '<p>---------------</p></pre></ul>';
		
		$compare = COM_debug($dummy);
		$this->assertEquals($retval, $compare, "Error asserting $output matched $compare");
	}
	
	public function testRefresh() {
		// Line 2794
		$url = 'http://localhost/';
		$dummy = "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
		$this->assertEquals($dummy, COM_refresh($url));
	}
	
	public function testCreateWithHttpUrl() {
        $url = 'http://www.example.com/image.png';
        $fixture = '<img src="' . $url . '" alt="">';
 
        $this->assertEquals($fixture, COM_createImage($url));
    }
	
	/**
    * @link http://project.geeklog.net/tracking/view.php?id=881
    */
	
    public function testCreateWithHttpsUrl() {
        $url = 'https://www.example.com/image.png';
        $fixture = '<img src="' . $url . '" alt="">';
 
        $this->assertEquals($fixture, COM_createImage($url));
    }
 
    public function testCreateWithoutUrl() {
        global $_CONF;

        $image = '/image.png';
        $url = $_CONF['layout_url'] . $image;
        $fixture = '<img src="' . $url . '" alt="">';
 
        $this->assertFalse(empty($_CONF['layout_url']));
        $this->assertEquals($fixture, COM_createImage($url));
    }
}

?>
