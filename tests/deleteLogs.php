<?php

require_once 'config.php';
require_once getPath('tests').'files/classes/tests.class.php';
var_dump($_POST['logs']);
$tests = new Tests;
$loglist = $tests->deleteLogs($_POST['logs']);
?>
