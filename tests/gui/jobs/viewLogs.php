<?php

require_once '../../config.php';
require_once getPath('tests').'files/classes/tests.class.php';

$tests = new Tests;
foreach($_POST['logs'] as $log) {
	$table .= json_encode($tests->createTable($tests->getJSONResults(1,1,$log)));
}
echo $table;

?>
