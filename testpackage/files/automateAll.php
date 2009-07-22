<?php

require_once('config.php');
require_once getPath('tests').'files/classes/tests.class.php';

$data = array(getPath('tests').'suite/');

$tests = new Tests;

// Runs tests, logs results
$tests->runTests($data);

?>