<?php

require_once '../../tst.class.php';
require_once Tst::$tests.'files/classes/tests.class.php';
$tests = new Tests;
$loglist = $tests->deleteLogs($_POST['logs']);

?>
