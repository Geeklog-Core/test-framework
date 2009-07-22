<?php

require_once 'config.php';
require_once getPath('tests').'files/classes/tests.class.php';

$tests = new Tests;
$logs = $tests->getJSONResults();
$table = json_encode($tests->createTable($logs));
echo $table;

?>
