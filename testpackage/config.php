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
* IMPORTANT: NO TRAILING SLASHES!
*/

function getPath($location) {
    switch($location) {
        case 'public':
            // Should be /path/to/public_html root
            $path = 'c:/xampplite/htdocs/geeklog/public_html';
            return $path;
        case 'root':
            // Should be /path/to/geeklog/root. 
            $path = 'c:/xampplite/htdocs/geeklog';
            return $path;
        case 'tests':
            //Should be path/to/testpackage (with children files, logs, and suite)
            $path = 'c:/xampplite/htdocs/geeklog/public_html/tests/testpackage';
            return $path;
    }
}

?>
