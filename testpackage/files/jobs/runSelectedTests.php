<?php
/**
* Runs selected tests and returns specified results, intended for use by GUI
*
*/
require_once '../../tst.class.php';
require_once Tst::$tests.'files/classes/tests.class.php';

$tests = new Tests;
$output = json_encode($tests->runTests($_POST['test'], $_POST['logResults'], $_POST['consoleOutput']));
echo $output;

?>
