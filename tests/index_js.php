<?php 
require_once 'config.php';
require_once 'gui/php_file_tree.php';
require_once getPath('tests').'files/classes/tests.class.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geeklog PHPUnit GUI</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="gui/php_file_tree_jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="gui/js/jquery-ui-1.7.2.custom.min.js"></script>
<link href="gui/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="gui/css/custom-theme/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
</head>
<body>
<div id="head">
    <div id="headwrapper"> <span class="right">
        <h1>PHPUnit GUI for Geeklog</h1>
        </span> <img src="gui/images/geeklog.gif" /> </div>
</div>
<div id="wrapper">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Choose Files</a></li>
            <li><a href="#tabs-2">Console Output</a></li>
            <li><a href="#tabs-3">Advanced Results</a></li>
        </ul>
        <div id="tabs-1">
            <h3>Selecting a folder will include all tests inside</h3>
            <form id="testfiles" name="testfiles">
                <?php echo php_file_tree(getPath('tests').'suite/', "[link]"); ?>
                <p id="submit_button">
                    <input type="submit" value="Test Files" />
                </p>
            </form>
            <div id="logslist">
            <form id="logs" name="logs">
                <label for"howMany">Show this many logs</label>
                <input id="howMany" type="text" name="howMany" value="5" size="2" />
                <ul id="loglist">
                    <?php 
					$tests = new Tests;
					$loglist = $tests->displayLogList(1,5);
					foreach($loglist as $v) {
						echo $v;
					}
				?>
                </ul>
                <p id="results_button">
                    <input type="submit" value="Load Results" />
                </p>
            </form>
            </div>
            <div id="loader"><img class='loader' src='gui/images/ajax-loader.gif' alt='Tests are loading...'></div>
        </div>
        <div id="tabs-2"></div>
        <div id="tabs-3"></div>
    </div>
</div>
<script type="text/javascript"> 

$(function() {
    $("#tabs").tabs();
});

$(document).ready(function(){ 
	$("div#loader").hide();
	$("input#howMany").keyup(function() {
		$("div#loader").show();
		$.post("showLogList.php", $("#howMany").serialize(), function(data){
			$("div#loader").hide();	
			$("#loglist").html(data);
			});
	});
    $("#testfiles").submit(function(){ 
		$("p#submit_button").hide();
		$("div#loader").show();
        $.post("runTests.php", $("#testfiles").serialize(), function(data){ 
			// Not getting to this point for some reason?
			alert('here');

                var results = eval("(" + data + ")");
				$("div#loader").hide();	
				$("p#submit_button").show();
                $("div#tabs-2").html(results.simple);
                $("div#tabs-3").html(results.advanced);
		});
	});
});
</script>
</body>
</html>
