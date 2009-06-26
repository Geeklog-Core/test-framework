<?php 
require_once 'config.php';
require_once 'gui/php_file_tree.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geeklog PHPUnit GUI</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
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
    <div id="browse">
        <h2><strong>1.</strong> Choose files or folders to be tested</h2>
        <h3>Selecting a folder will include all tests inside</h3>
        <form id="testfiles" onsubmit="return false">
            <?php echo php_file_tree(getPath('tests').'/suite/', "[link]"); ?>
            <p id="submit_button">
                <input type="submit" value="Test Files" />
            </p>
        </form>
    </div>
    <div id="resultswrapper">
        <h2><strong>2.</strong> Results</h2>
    </div><img src=""
</div>
<script type="text/javascript"> 
 $(document).ready(function(){ 
     $("#testfiles").submit(function(){ 
		$("div#resultswrapper").html("<img class='loader' src='gui/images/ajax-loader.gif' alt='Tests are loading...'>");
         $.post( 
             "runTests.php", 
             $("#testfiles").serialize(), 
             function(data){ 
			 $("div#resultswrapper").html(data);
             } 
         ); 
     }); 
}); 
</script>
</body>
</html>
