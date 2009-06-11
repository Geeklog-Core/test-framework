<?php 

require_once '../config.php';
require_once 'php_file_tree.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geeklog PHPUnit GUI</title>
<script src="jquery.js" type="text/javascript"></script>
<script src="php_file_tree_jquery.js" type="text/javascript"></script>
<link href="default.css" rel="stylesheet" type="text/css" />
<link href="parseXML.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="head">
    <div id="headwrapper"> <span class="right">
        <h1>PHPUnit GUI for Geeklog</h1>
        </span> <img src="images/geeklog.gif" /> </div>
</div>
<div id="wrapper">
    <?php 
    if (!isset($_POST['testfiles'])) {
    ?>
    <div id="browse">
        <h2><strong>1.</strong> Choose files or folders to be tested</h2>
        <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
            <?php echo php_file_tree(getPath('gui').'/', "[link]"); ?>
            <input type = "submit" name="testfiles" value="Test Files" />
        </form>
    </div>
    <div id="results">
        <h2><strong>2.</strong> Results</h2>
    </div>
    <?php
    } else { 
    ?>
    <div id="browse">
        <h2><strong>1.</strong> Choose files or folders to be tested</h2>
        <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
            <?php echo php_file_tree(getPath('gui').'/', "[link]"); ?>
            <input type = "submit" name="testfiles" value="Test Files" />
        </form>
    </div>
    <div id="results">
        <h2><strong>2.</strong> Results</h2>
        <?php
        function phpUnit($testfile) {
            $testfile = escapeshellarg($testfile);
            global $output;
            $output[] = shell_exec("phpunit --log-xml logs/log.xml $testfile");
        }
        
        function ShellExec() {
            require_once('../config.php');
            foreach($_POST['test'] as $k => $v) {
                phpUnit($v);
            }
        }
        
        ShellExec();
        
        foreach($output as $k => $v) {
            $t = $k + 1;
            echo "<p><strong>$t</strong><br /> <strong>Results</strong>: $v </p>";
        }
        ?>
    </div>
    <div id="advresults">
        <?php
        // Parse XML
        $file = 'logs/log.xml';
        $log = simplexml_load_file($file) or die ("Unable to load XML file!"); 
        
        $test_results = array();
        $class_results = array();
        $n = 0;
        foreach($log->testsuite->testsuite as $k => $v) {
            $n++; // TRYING TO COUNT TEST SUITES
            $k = '$log->testsuite->'.testsuite.$n.'->testcase';
            echo $k;
            //print_r($log->$testsuite);
              foreach($log->testsuite->testsuite->testcase as $testcase) {
                $result = array();
                $result['name'] = (string)$testcase['name'];
                if(isset($testcase->{'failure'})) {
                    $result['result'] = 'Fail';
                    $result['message'] = (string)$testcase->{'failure'};
                } else {
                    $result['result'] = 'Pass';
                    $result['message'] = '';
                }
                $test_results[] = $result; 
            }    
            //var_dump($test_results);            
            $class_results[] = $test_results;
        }
        //print_r($class_results);
        ?>
        <table cellspacing="0" class="test_results">
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Result</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($class_results as $class_result1): ?>
                <?php foreach($class_result1 as $class_result): ?>
                <tr>
                    <td><div class="width"><?php echo wordwrap($class_result['name'], 47, "<br />\n", true); ?></div></td>
                    <?php if($class_result['result'] == 'Fail') : ?>
                    <td class="test_fail"/>
                    <?php else: ?>
                    <td class="test_pass"/>
                    <?php endif; ?>
                    <td><?php echo wordwrap($class_result['message'], 47, "<br />\n", true); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
</body>
</html>