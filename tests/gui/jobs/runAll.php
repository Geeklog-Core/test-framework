<?php
// Script to run all tests, intended for cronjob
require_once 'config.php';
require_once getPath('tests').'files/classes/tests.class.php';

$tests = new Tests;
$suite = array(getPath('tests').'/suite');
$output = json_encode($tests->runTests($suite, 1, 0));
echo $output;

?>
