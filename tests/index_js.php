<?php 
require_once 'tst.class.php';
require_once 'gui/php_file_tree.php';
require_once Tst::$tests.'files/classes/tests.class.php';
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
      <?php if(Tst::access(array(3))): ?>
      <li><a href="#tabs-1">Choose Files</a></li>
      <?php endif; ?>
      <?php if(Tst::access(array(1,3))): ?>
      <li><a href="#tabs-2">Log Output</a></li>
      <?php endif; ?>
      <?php if(Tst::access(array(1,2,3))): ?>
      <li><a href="#tabs-3">Console Output</a></li>
      <?php endif; ?>
    </ul>
    <div id="tabs-1">
      <div id="browse">
        <form id="runTests" name="runTests" id="runTests">
        <fieldset>
          <legend class="h2">Run Tests</legend>
          <?php if(Tst::access(array(2,3))): ?>
          <span id="runTests_button">
          <input type="button" value="Test Files" id="runTests_submit"/>
          </span> <span id="runTests_loader"><img class='loader' src="gui/images/ajax-loader.gif" alt='Tests are loading...'></span>
          <input type="checkbox" id="logResults" name="logResults" value="1" checked="checked"/>
          Log results
          <input type="checkbox" id="consoleOutput" name="consoleOutput" value="1" checked="checked"/>
          Console output
          <h3>Selecting a folder will include all tests inside</h3>
          <?php echo php_file_tree(Tst::$tests.'suite/', "[link]"); ?>
          <? else: echo '<span class="disabled">'.Tst::$disabledMessage.'</span>'; endif;?>
        </fieldset>
        </form>
      </div>
      <div id="viewLogs">
        <form id="logs" name="logs">
          <fieldset>
            <legend class="h2">Logs</legend>
            <?php if(Tst::access(array(1,3))): ?>
            <label for"howMany">Show:</label>
            <input id="howMany" type="text" name="howMany" value="5" size="2" />
            <span id="logs_button">
            <input type="button" value="View" id="logs_submit"/>
            <input type="button" value="Delete" id="logs_delete"/>
            </span> <span id="logs_loader"><img class='loader' src="gui/images/ajax-loader.gif" alt='Logs are loading...'></span>
            <ul id="logslist">
            </ul>
            <? else: echo '<span class="disabled">'.Tst::$disabledMessage.'</span>'; endif;?>
          </fieldset>
        </form>
      </div>
      <div id="clear"></div>
    </div>
    <?php if(Tst::access(array(1,2,3))): ?>
    <div id="tabs-2"></div>
    <? endif;?>
    <?php if(Tst::access(array(1,2,3))): ?>
    <div id="tabs-3"></div>
    <?  endif;?>
  </div>
</div>
<script type="text/javascript"> 
$(function() {
    $("#tabs").tabs();
});

var $tabs = $('#tabs').tabs();
var path = "jobs/";

$(document).ready(function(){ 
    $("span#runTests_loader").hide();
    $("span#logs_button").hide();
    $("span#logs_loader").show();
    $.post(path+"showLogList.php", $("#howMany").serialize(), function(logsList){    
        $("span#logs_loader").hide();  
        $("span#logs_button").show();
        $("#logslist").html(logsList);        
    });
});

// Read features
// Renders logs from history 
$("input#logs_submit").click(function() {
    $("span#logs_button").hide();
    $("span#logs_loader").show();
    $.post(path+"viewLogs.php", $("#logs").serialize(), function(json){
        $("span#logs_loader").hide();    
        $("span#logs_button").show();
        var table = eval("(" + json + ")");    
        $("div#tabs-2").html(table);
        $tabs.tabs('select', 1);
        });
});

// Choose how many existing logs to list
$("input#howMany").keyup(function() {
    $("span#logs_loader").show();
    $.post(path+"showLogList.php", $("#howMany").serialize(), function(logsList){        
        $("span#logs_loader").hide();  
          $("span#logs_button").show();
          $("#logslist").html(logsList);        
    });
});

// Write features
// Deletes logs from history 
$("input#logs_delete").click(function() {
    $("span#logs_loader").show();
    $.post(path+"deleteLogs.php", $("#logs").serialize(), function(json){
        $.post(path+"showLogList.php", $("#howMany").serialize(), function(logsList){ 
            $("span#logs_loader").hide();  
            $("span#logs_button").show();
            $("#logslist").html(logsList);            
        });
    });    
});


// Run selected tests and return results
$("input#runTests_submit").click(function() {
    $("span#runTests_button").hide();
    $("span#runTests_loader").show();
    $.post(path+"runSelectedTests.php", $("#runTests").serialize(), function(data){
        $("span#runTests_loader").hide();    
        $("span#runTests_button").show();
        var results = eval("(" + data + ")");
        $("div#tabs-2").html();
        $("div#tabs-2").html(results.advanced);
        $("div#tabs-3").html();
        $("div#tabs-3").html(results.simple);
        if($("input#consoleOutput").serialize() == 'consoleOutput=1') {
            $tabs.tabs('select', 2);
        } else if($("input#logResults").serialize() == 'logResults=1') {
            $tabs.tabs('select', 1);
        }  
        $.post(path+"showLogList.php", $("#howMany").serialize(), function(logsList){                
            $("#logslist").html(logsList);
        });
    });
});
</script>
</body>
</html>
