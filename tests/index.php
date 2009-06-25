<?php 
require_once 'config.php';
require_once 'gui/php_file_tree.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geeklog PHPUnit GUI</title>
<script src="gui/jquery.js" type="text/javascript"></script>
<script src="gui/php_file_tree_jquery.js" type="text/javascript"></script>
<link href="gui/default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="head">
    <div id="headwrapper"> <span class="right">
        <h1>PHPUnit GUI for Geeklog</h1>
        </span> <img src="gui/images/geeklog.gif" /> </div>
</div>
<div id="wrapper">
    <?php 
    if (!isset($_POST['testfiles'])) {
    ?>
    <div id="browse">
        <h2><strong>1.</strong> Choose files or folders to be tested</h2>
        Selecting a folder will run all tests inside.
        <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
            <?php echo php_file_tree(getPath('tests').'/suite/', "[link]"); ?>
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
            <?php echo php_file_tree(getPath('tests').'/suite/', "[link]"); ?>
            <input type = "submit" name="testfiles" value="Test Files" />
        </form>
    </div>
    <div id="results">
        <h2><strong>2.</strong> Results</h2>
        <?php        

        $output = array();
        
        function ShellExec() {
            require_once 'config.php';
            // Delete old XML file (so on errors, we don't see old XML results - it's confusing)
            // If we removed it earlier, it would be impossible to physically examine the XML file
            // for details if we wanted to
            @unlink(getPath('tests').'/logs/log.xml');
            // Test files and collect output into array
            foreach($_POST['test'] as $k => $file) {
                $testfile = escapeshellarg($file);
                $output[] = shell_exec("phpunit --log-xml ".getPath('tests')."/logs/log.xml $testfile");
            }
            
            // Echo output
            foreach($output as $k => $v) {
                   $t = $k + 1;
                echo "<div class='output'><strong>$t</strong><br /><strong>Results</strong><pre>:$v</pre></div>";
            }
        }
        
        ShellExec();
        ?>
    </div>
    <div id="advresults">
        <?php
        // Parse XML and echo table of advanced results
        $file = getPath('tests').'/logs/log.xml';
        $log = @simplexml_load_file($file) or die ("Unable to load XML file! (this is normal if test did not run correctly)"); 
        $test_results = array();
              foreach($log->xpath("//testcase") as $testcase) {
                $result = array();
                $result['name'] = (string)$testcase['name'];
                $result['time'] = (string)$testcase['time'];
                $result['assertions'] = (string)$testcase['assertions'];
                $result['line'] = (string)$testcase['line'];
                if(isset($testcase->{'failure'})) {
                    $result['result'] = 'Fail';
                    $result['message'] = (string)$testcase->{'failure'};
                } else {
                    $result['result'] = 'Pass';
                    $result['message'] = '';
                }
                $test_results[] = $result; 
            }    
        ?>
        <table cellspacing="0" class="test_results">
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Result</th>
                    <th>Time</th>
                    <th>Line</th>
                    <th>Assertions</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $n = 0;
                foreach($test_results as $test_result): 
                $n++;
                ?>
                <tr>
                    <td><div class="width"><?php echo '<strong>'.$n.'</strong> '.wordwrap($test_result['name'], 47, "<br />\n", true); ?></div></td>
                    <?php if($test_result['result'] == 'Fail') : ?>
                    <td class="test_fail"/>
                    <?php else: ?>
                    <td class="test_pass"/>
                    <?php endif; ?>
                    <td><?php echo $test_result['time']; ?></td>
                    <td><?php echo $test_result['line']; ?></td>
                    <td><?php echo $test_result['assertions']; ?></td>
                    <td><?php echo wordwrap($test_result['message'], 47, "<br />\n", true); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
</body>
</html>
