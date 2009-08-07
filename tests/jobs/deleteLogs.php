<?php

require_once '../tst.class.php';
Tst::access(array(2,3),1);

require_once Tst::$tests.'files/classes/tests.class.php';
$tests = new Tests;
$loglist = $tests->deleteLogs($_POST['logs']);

?>
