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
<script type="text/javascript" src="gui/js/jquery-1.3.2.min.js"></script>
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
    <ul id="tablinks">
      <li><a href="#tabs-1">Choose Files</a></li>
      <li><a href="#tabs-2">Console Output</a></li>
      <li><a href="#tabs-3">Log Output</a></li>
    </ul>
    <div id="tabs-1">
      <div id="browse">
        <form id="runTests" name="runTests" id="runTests">
            <fieldset>
              <legend class="h2">Run Tests</legend>
              <span id="runTests_button">
              <input type="button" value="Test Files" id="runTests_submit"/>
              </span> 
              <span id="runTests_loader"><img class='loader' src="gui/images/ajax-loader.gif" alt='Tests are loading...'></span>
              <input type="checkbox" id="logResults" name="logResults" value="1" checked="checked"/>
              Log results
              <input type="checkbox" id="consoleOutput" name="consoleOutput" value="1" checked="checked"/>
              Console output
              <h3>Selecting a folder will include all tests inside</h3>
              <?php echo php_file_tree(getPath('tests').'suite/', "[link]"); ?>
            </fieldset>
        </form>
      </div>
      <div id="viewLogs">
        <form id="logs" name="logs">
          <fieldset>
          <legend class="h2">Logs</legend>
          <label for"howMany">Show:</label>
          <input id="howMany" type="text" name="howMany" value="5" size="2" />
          <span id="logs_button">
          <input type="button" value="View" id="logs_submit"/>
          <input type="button" value="Delete" id="logs_delete"/>
          </span> <span id="logs_loader"><img class='loader' src="gui/images/ajax-loader.gif" alt='Logs are loading...'></span>
          <ul id="logslist">
            <?php 
                    $tests = new Tests;
                    $loglist = $tests->displayLogList(1,5);
                    foreach($loglist as $v) {
                        echo $v;
                    }
                ?>
          </ul>
        </form>
      </div>
      <div id="clear"></div>
    </div>
    <div id="tabs-2"></div>
    <div id="tabs-3"></div>
  </div>
</div>
<script type="text/javascript"> 

$(function() {
    $("#tabs").tabs();
});

var $tabs = $('#tabs').tabs();

$(document).ready(function(){ 
    $("span#logs_loader").hide();
    $("span#runTests_loader").hide();
});

// Renders logs from history 
$("input#logs_submit").click(function() {
    $("span#logs_button").hide();
    $("span#logs_loader").show();
    $.post("viewLogs.php", $("#logs").serialize(), function(json){
        $("span#logs_loader").hide();    
        $("span#logs_button").show();
        var table = eval("(" + json + ")");    
        $("div#tabs-3").html(table);
        $tabs.tabs('select', 2);
        });
});

// Deletes logs from history 
$("input#logs_delete").click(function() {
    $("span#logs_button").hide();
    $("span#logs_loader").show();
    $.post("deleteLogs.php", $("#logs").serialize(), function(json){
        var success = 1;    
    });
    $.post("showLogList.php", $("#howMany").serialize(), function(logsList){    
        $("span#logs_loader").hide();            
        $("#logslist").html(logsList);
    });
});

// Choose many existing logs to list
$("input#howMany").keyup(function() {
    $("span#logs_loader").show();
    $.post("showLogList.php", $("#howMany").serialize(), function(logsList){    
        $("span#logs_loader").hide();            
        $("#logslist").html(logsList);
        });
});

// Run selected tests and return results
$("input#runTests_submit").click(function() {
    $("span#runTests_button").hide();
    $("span#runTests_loader").show();
    $.post("runTests.php", $("#runTests").serialize(), function(data){    
        $("span#runTests_loader").hide();    
        $("span#runTests_button").show();
        var results = eval("(" + data + ")");
        $("div#tabs-2").html(results.simple);
        $("div#tabs-3").html(results.advanced);
        $tabs.tabs('select', 1);
        });
});
</script>
</body>
</html>
