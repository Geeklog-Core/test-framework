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
            // Should be /path/to/core/install root
            $path = 'c:/xampplite/htdocs/geeklog';
            return $path;
        case 'tests':
            //Should be path/to/tests package
            $path = 'c:/xampplite/htdocs/geeklog/public_html/gsoc-2009-sclark';
            return $path;
        case 'admin':
            // Shohuld be path/to/admin root
            $path = 'c:/xampplite/htdocs/geeklog/public_html/admin';
            return $path;
    }
}

?>
