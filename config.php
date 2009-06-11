<?php
/*
Configuration for PHPUnit tests
*/

/**
* Sets paths for PHPUnit, as tests need to be able to run without
* an install, but local setups can differ.
*
* @param    string  $location   set root folder for public_html, 
*                                main geeklog install, or admin
* @return   string  $path       username or empty string
*
*/

function getPath($location) {
    switch($location) {
		case 'public':
			// Should be /path/to/public_html root
			$path = 'c:/xampplite/htdocs/geeklog/public_html';
			return $path;
  		case 'restricted':
			// Should be /path/to/install root
			$path = 'c:/xampplite/htdocs/geeklog';
			return $path;
		case 'gui':
			//Should be path to public_html/tests/tests/geeklog
			$path = 'c:/xampplite/htdocs/geeklog/public_html/gsoc-2009-sclark/tests';
			return $path;
    	case 'admin':
			// Shohuld be path/to/admin root
			$path = 'c:/xampplite/htdocs/geeklog/public_html/admin';
			return $path;
    }
}

?>
