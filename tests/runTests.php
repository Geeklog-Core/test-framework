<?php

$data = $_POST;

/*
* Runs phpunit tests and echoes console output, essentially extending the console.
* Also logs results to XML files.
*/

function ShellExec($data) {
	require_once 'config.php';
	
	// Delete old XML files (so on errors, we don't see old XML results - it's confusing)
	// If we removed it earlier, it would be impossible to physically examine the XML file
	// for details if we wanted to
	$i=0;
	$ret = true;
	while($ret) {
		$ret = @unlink(getPath('tests').'logs/'.$i.'.xml');
		$i++;
	}
	// Test files and collect output into array;
	$output = array();
	$i = 0;
	foreach($data['test'] as $k => $file) {
		$testfile = escapeshellarg($file);
		$output[] = shell_exec("phpunit --log-xml ".getPath('tests')."/logs/$i.xml $testfile");
		$i++;
	}
    // Echo output
    foreach($output as $k => $v) {
    	$t = $k + 1;
    	$retval[] = '<div class="output"><strong>'.$t.'</strong><br /><strong>Results</strong><pre>'.$v.'</pre></div>';
     }
	return $retval;
}

/*
* Loads XML logs, parses, and returns results into array.
*
*/
function getXMLResults($data) {
	$class_results = array();
	foreach($data['test'] as $k => $v) {
		$file = getPath('tests').'logs/'.$k.'.xml';
        $log = @simplexml_load_file($file) or die ("<br /><strong>Unable to load XML file! 
												   (this is normal if test did not run correctly)</strong>"); 
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
		$class_results[] = $test_results;
		
	}
	return $class_results;
}

/*
* Run everything if $data is sent.
*
*/

if(isset($data)) {
	
	//Run PHPUnit tests and echo console output
	$simpleoutput = ShellExec($data); 
	echo '<div id="simpleresults"><h2><strong>2.</strong> Results</h2>';
	foreach($simpleoutput as $result) {
		echo $result;
	}
	echo '</div>';
	
	// Now we get advanced results from XML and show.
	
	$class_results = getXMLResults($data);
	// Echo table row with data from XML results 
	foreach($class_results as $test_results) {
		echo '<div class="advresults"><table cellspacing="0" class="test_results">
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
            <tbody>';
		foreach($test_results as $test_result) {
			static $n = 0;
			$n++;
				echo '<tr>
				<td><div class="width"><strong>'.$n.'</strong> '.wordwrap($test_result['name'], 47, "<br />\n", true).'</div></td>';
				if($test_result['result'] == 'Fail') {
					echo '<td class="test_fail"/>';
				} else {
					echo '<td class="test_pass"/>';
				}
				echo '
				<td>'.$test_result['time'].'</td>
				<td>'.$test_result['line'].'</td>
				<td>'.$test_result['assertions'].'</td>
				<td>'.wordwrap($test_result['message'], 47, "<br />\n", true).'</td>
				</tr>';
		}
		echo '</tbody></table></div>';
	}
}
?>