<?php
// Script to run all tests, intended for cronjob
require_once 'tst.class.php';
require_once Tst::$tests.'files/classes/tests.class.php';

$tests = new Tests;
$suite = array(Tst::$tests.'/suite');
$output = json_encode($tests->runTests($suite, 1, 0));
echo $output;

?>
