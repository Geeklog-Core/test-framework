
<?php /*
require_once 'tst.class.php';
require_once 'gui/php_file_tree.php';
require_once Tst::$tests.'files/classes/tests.class.php';
*/
?>
<?php 
/** 
* Redirects user to index_js if javascript is enabled.
*
* This page was originally designed so the test suite GUI could be used without javascript. 
* The test suite has changed since then, so this page is no longer function. If you're feeling
* ambitious, feel free to use the scripts in tests/jobs to make this a functioning page.
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geeklog PHPUnit GUI</title>
<script type="text/JavaScript">
window.location = "index_js.php"
</script>
<!-- 
<link href="gui/default.css" rel="stylesheet" type="text/css" />-->
</head>
<body><noscript>Sory, but this page currently requires javascript.</noscript></body></html><!-- 
<div id="head">
    <div id="headwrapper"> <span class="right">
        <h1>PHPUnit GUI for Geeklog</h1>
        </span> <img src="gui/images/geeklog.gif" /> </div>
</div>
<div id="wrapper">
    <?php 
   // if (!isset($_POST['testfiles']) && !isset($_POST['logs'])) {
    ?>
    <div id="browse">
        <h2><strong>1.</strong> Choose files or folders to be tested</h2>
        <h3>Selecting a folder will include all tests inside</h3>
        <form action = "<?php// echo $_SERVER['PHP_SELF']; ?>" method = "POST" name='testfiles'>
            <?php// echo php_file_tree(Tst::$tests.'suite/', "[link]"); ?>
            <input type = "submit" name="testfiles" value="Test Files" />
        </form>
        <form action = "<?php// echo $_SERVER['PHP_SELF']; ?>" method = "POST" name='logs'>
            <input id="text" type="text" name="text" value="5" size="2" />
            <ul id="logs">
                <?php /*
					$tests = new Tests;
					$output = $tests->displayLogList(1,5);
					foreach($output as $v) {
						echo $v;
					}*/
				?>
            </ul>
            <p id="results_button">
                <input type="submit" value="Load Results" />
            </p>
        </form>
    </div>
    <div id="resultswrapper">
        <h2><strong>2.</strong> Results</h2>
    </div>
    <?php /*
    } else { 

        require_once('tst.class.php');
        require_once Tst::$tests.'files/classes/tests.class.php';

        $tests = new Tests;
        // Outputs array with results
        $output = $tests->runTests();
        */
    ?>
    <div id="browse">
        <h2><strong>1.</strong> Choose files or folders to be tested</h2>
        <h3>Selecting a folder will include all tests inside</h3>
        <form action = "<?php //echo $_SERVER['PHP_SELF']; ?>" method = "POST">
            <?php //echo php_file_tree(Tst::$tests.'suite/', "[link]"); ?>
            <input type = "submit" name="testfiles" value="Test Files" />
        </form>
        <form action = "<?php //echo $_SERVER['PHP_SELF']; ?>" method = "POST" name='logs'>
            <input id="text" type="text" name="text" value="5" size="2" />
            <ul id="logs">
                <?php /*
					$tests = new Tests;
					$loglist = $tests->displayLogList(1,5);
					foreach($loglist as $v) {
						echo $v;
					}*/
				?>
            </ul>
            <p id="results_button">
                <input type="submit" value="Load Results" />
            </p>
        </form>
    </div>
    <div id="resultswrapper">
        <h2><strong>2.</strong> Results</h2>
        <div id="simpleresults"> <?php// echo $output['simple']; ?> </div>
        <div id="advresults"> <?php// echo $output['advanced']; ?> </div>
        <?php// } ?>
    </div>
</div>
</body>
</html>
-->