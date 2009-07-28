<?php
/**
* Runs selected tests and returns specified results, intended for use by GUI
*
*/
require_once '../../config.php';
require_once TestConfig::$tests.'files/classes/tests.class.php';

$tests = new Tests;
$output = json_encode($tests->runTests($_POST['test'], $_POST['logResults'], $_POST['consoleOutput']));
echo $output;

?>
