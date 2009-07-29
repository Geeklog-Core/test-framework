<?php

require_once '../tst.class.php';
require_once Tst::$tests.'files/classes/tests.class.php';

$tests = new Tests;
$loglist = $tests->displayLogList(1,$_POST['howMany']);
if(!empty($loglist)) {
    foreach($loglist as $v) {
        echo $v;
    }
} else {
    echo 'There aren\'t any logs yet.';
}

?>
