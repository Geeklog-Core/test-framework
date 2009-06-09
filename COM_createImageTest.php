<?php

/**
* Simple tests for COM_createImage
*/

require_once 'PHPUnit/Framework.php';
require_once 'config.php';
require_once getPath('public_html').'lib-common.php';

global $_CONF, $_TABLES, $_DB_table_prefix, $_DB_mysqldump_path;

class COM_createImageTest extends PHPUnit_Framework_TestCase
{
    public function testCreateWithHttpUrl()
    {
        $url = 'http://www.example.com/image.png';
        $fixture = '<img src="' . $url . '" alt="">';
 
        $this->assertEquals($fixture, COM_createImage($url));
    }
 
    /**
    * @link http://project.geeklog.net/tracking/view.php?id=881
    */
    public function testCreateWithHttpsUrl()
    {
        $url = 'https://www.example.com/image.png';
        $fixture = '<img src="' . $url . '" alt="">';
 
        $this->assertEquals($fixture, COM_createImage($url));
    }
 
    public function testCreateWithoutUrl()
    {
        global $_CONF;

        $image = '/image.png';
        $url = $_CONF['layout_url'] . $image;
        $fixture = '<img src="' . $url . '" alt="">';
 
        $this->assertFalse(empty($_CONF['layout_url']));
        $this->assertEquals($fixture, COM_createImage($url));
    }
 
}

?>
