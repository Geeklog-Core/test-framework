<?php

require_once('config.php');
require_once('tests.class.php');

$tests = new Tests;
$output = $tests->runTests();
echo $output;

?>
