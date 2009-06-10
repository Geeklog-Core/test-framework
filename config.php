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
    if($location == 'public') {
        // Should be /path/to/public_html root
        $path = 'c:/xampplite/htdocs/geeklog/public_html';
    } elseif($location == 'restricted') {
        // Should be /path/to/install root
        $path = 'c:/xampplite/htdocs/geeklog';
    } elseif($location == 'admin') {
        // Shohuld be path/to/admin root
        $path = 'c:/xampplite/htdocs/geeklog/public_html/admin';
    }
    return $path;
}

?>
