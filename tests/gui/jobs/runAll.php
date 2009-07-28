<?php
// Script to run all tests, intended for cronjob
require_once 'config.php';
require_once TestConfig::$tests.'files/classes/tests.class.php';

$tests = new Tests;
$suite = array(TestConfig::$tests.'/suite');
$output = json_encode($tests->runTests($suite, 1, 0));
echo $output;

?>
