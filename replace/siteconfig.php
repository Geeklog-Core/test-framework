<?php

/*
 * Geeklog site configuration
 *
 * You should not need to edit this file. See the installation instructions
 * for details.
 *
 */

if (strpos(strtolower($_SERVER['PHP_SELF']), 'sitetst.class.php') !== false) {
    die('This file can not be used on its own!');
}

global $_CONF;

// To disable your site quickly, simply set this flag to false
$_CONF['site_enabled'] = true;

// If you have errors on your site, can't login, or can't get to the
// config UI, then you can comment this in to set the root debug option
// on and get detailed error messages. You can set this to 'force' (which the
// Config UI won't allow you to do) to override hiding of password and cookie
// items in the debug trace.
// $_CONF['rootdebug'] = true;

// If you want to enable the PHPUnit test package, comment out this line...
$_CONF['path'] = '/path/to/Geeklog/';

// ... and uncomment this line, replacing path/to/package with the absolute path to
// your PHPUnit testpackage root (path/to/testpackage/files/dummy/).
//$_CONF['path'] = 'path/to/testpackage/files/dummy/';

$_CONF['path_system'] = $_CONF['path'] . 'system/';

$_CONF['default_charset'] = 'iso-8859-1';

$_CONF_FCK['imagelibrary'] = '/images/library';


// Useful Stuff

if (!defined('LB')) {
  define('LB',"\n");
}
if (!defined('VERSION')) {
  define('VERSION', '1.5.2sr4');
}

?>
