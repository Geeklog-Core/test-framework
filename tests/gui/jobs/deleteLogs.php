<?php

require_once '../../config.php';
require_once getPath('tests').'files/classes/tests.class.php';
$tests = new Tests;
$loglist = $tests->deleteLogs($_POST['logs']);

?>
