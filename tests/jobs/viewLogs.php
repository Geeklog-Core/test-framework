<?php

require_once '../tst.class.php';

if(Tst::access(array(1,3))) {
    require_once Tst::$tests.'files/classes/tests.class.php';
    
    $tests = new Tests;
    $table = '';
    foreach($_POST['logs'] as $log) {
        $table .= json_encode($tests->createTable($tests->getJSONResults(1,1,$log)));
    }
    echo $table;
} else {
    echo 'This is not enabled';
}

?>
