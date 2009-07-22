<?php

require_once 'config.php';
require_once getPath('tests').'files/classes/tests.class.php';

$tests = new Tests;
$output = json_encode($tests->runTests($_POST['test'], $_POST['logResults'], $_POST['consoleOutput']));
echo $output;

?>
