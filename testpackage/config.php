<?php
/*
Configuration for PHPUnit tests
*/

class TestConfig {
	
	/**
	* Permissions for suite
	* 1 - Everything is enabled
	* 2 - GUI is read-only (logs can be loaded in GUI)
	* 3 - GUI is write-only (tests can be run, but no results viewed)
	* 4 - GUI is disabled
	* 5 - Entire suite is disabled
	*/
	public static $access = 5;
	
	/**
	* /path/to/public_html root
	*/
	public static $public = 'c:/xampplite/htdocs/geeklog/public_html/';
	
	/**
	* path/to/geeklog/root
	*/
	public static $root = 'c:/xampplite/htdocs/geeklog/';
	
	/**
	* path/to/testpackage
	*/
	public static $tests = 'c:/xampplite/htdocs/geeklog/public_html/tests/testpackage/';

}

?>
