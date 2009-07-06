<?php

class Tests 
{
    /**
    * $_POST data containing names with paths of tests to be run
    *
    */
    public $data;
    
    public function tests() {
    }    
    
    
    /*
    * Collects PHPUnit console output into array
    * @param    array    $output        PHPUnit console output
    * @return   string  $retval        Console output formatted for HTML
    *
    */    
    public function getConsoleOutput($output) {
        $retval = '<div id="simpleresults"><h2><strong>2.</strong> Results</h2>';
        
        foreach($output as $k => $v) {
            $testnum = $k + 1;
            $retval .= '<div class="output"><strong>'.$testnum.'</strong><br /><strong>Results</strong><pre>'.$v.'</pre></div>';
         }
         
         $retval .= '</div>';
         
         return $retval;
    }
        
    /*
    * Runs tests, returns console output
    * @param    array     $data        Test files to run, defaults to $POST
    * @param    int     $XMLresults    Flag if XML results should be collected and displayed, default on
    * @param    int     $XMLresults    Flag if console output should be collected and displayed, default on
    * @return   array   $retval        Formatted PHPUnit console output
    *
    */
    public function runTests($data = '', $XMLresults = 1, $consoleOutput = 1) {        
        $retval = '';        
        
        $this->setData($data);        
        
        if(empty($testid)) {
                $testid = time();
            }
            if (empty($today)) {
                $today = date("F j, Y, g:i a");
            }
        
        $success = $this->updateMasterLog();        
        ### GIVING MASTER LOG PARAMS AND SUCH ####################################
                
        // Replace / and \ with _ to name logfile
        $replace = array('/', '\'');        
        $output = array();
        // Test files and collect console output into array
        foreach($this->data['test'] as $k => $file) {
            $testfile = escapeshellarg($file);
            if($XMLresults === 1) {
                if(strpos($testfile, '.php') != 0) {
                    $offset = -5;
                }
                $logfilename = 'xmllog'.str_replace($replace, '_', substr($testfile, strpos($testfile, 'suite'), $offset));
                $collectXML = '--log-xml '.getPath('tests').'logs/'.$logfilename.'.xml ';
            }
            $output[] = shell_exec('phpunit '.$collectXML.$testfile);
        }
        
        if($consoleOutput === 1) {
            $retval = $this->getConsoleOutput($output);
        }
        if($XMLresults === 1) {
            $retval .= $this->createXMLtable($this->getXMLResults());
        }
        
        if($success) {
            return $retval;
        } else {
            exit('There was an error updating log');
        }
    }
    
    /*
    * Parses XML logs to PHP array
    * @param    string    $test        Which test to load (i.e: 1 is last test run), defaults to 1
    * @param    string    $length        How many tests to return files for, defaults to 1
    * @return   array   $parsedXML    Parsed data from XML file
    *
    */    
    public function getXMLResults($test = 1, $length = 1) {
        $parsedXML = array();
        $test_results = array();
        
        $testentry = $this->readMasterLog($test, length);
        
        if(!empty($testentry)) {        
            $file = getPath('tests').'logs/'.$testentry['testid'];        
            $log = @simplexml_load_file($file) or die ("<br /><strong>Unable to load XML file! 
                                                       (this is normal if test did not run correctly)</strong>"); 
                
            foreach($log->xpath("//testcase") as $testcase) {
                $result = array();
                $result['name'] = (string)$testcase['name'];
                $result['time'] = (string)$testcase['time'];
                $result['assertions'] = (string)$testcase['assertions'];
                $result['line'] = (string)$testcase['line'];
                if(isset($testcase->{'failure'})) {
                    $result['result'] = 'Fail';
                    $result['message'] = (string)$testcase->{'failure'};
                } elseif(isset($testcase->{'error'})) {
                    $result['result'] = 'Error';
                    $result['message'] = (string)$testcase->{'error'};
                } else {
                    $result['result'] = 'Pass';
                    $result['message'] = '';
                }
                    $test_results[] = $result; 
                }
                
            $parsedXML[] = $test_results;            
            var_dump($parsedXML);
            return $parsedXML;
        } else {
            exit('The logfile doesn\'t exist.');
        }
    }
    
    /*
    * Creates table from parsed XML data
    * @param    array    $parsedXML    XML parsed into PHP array                    
    * @return   string  $retval        HTML table showing results
    *
    */
    public function createXMLTable($parsedXML) {        
        $retval = '';
        
        foreach($parsedXML as $test_results) {
            $retval .= '<div class="advresults"><table cellspacing="0" class="test_results">
                            <thead>
                            <tr></tr>
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
                    $retval .= '<tr>
                    <td><div class="width"><strong>'.$n.'</strong> '.wordwrap($test_result['name'], 47, "<br />\n", true).'</div></td>';
                    if($test_result['result'] == 'Fail') {
                        $retval .= '<td class="test_fail"/>';
                    } elseif($test_result['result'] == 'Error') {
                        $retval .= '<td class="test_error"/>';
                    } else {
                        $retval .= '<td class="test_pass"/>';
                    }
                    $retval .= '
                    <td>'.$test_result['time'].'</td>
                    <td>'.$test_result['line'].'</td>
                    <td>'.$test_result['assertions'].'</td>
                    <td>'.wordwrap($test_result['message'], 47, "<br />\n", true).'</td>
                    </tr>';
            }
        $retval .= '</tbody></table></div>';
        }
        
        return $retval;
    }

    /*
    * Updates master log of tests run with last-run test, creates dir and file if not exist
    * @return    bool    $ret    Whether the update was successful or not
    *
    */
    public function updateMasterLog($testid, $today) {
        $path = getPath('tests').'logs/';
        if(is_dir($path)) {
            if(empty($testid)) {
                $testid = time();
            }
            if (empty($today)) {
                $today = date("F j, Y, g:i a");
            }
            $ret = $this->writeMasterLog($path, $testid, $today);
        } else {
            mkdir($path, 0700);
            $ret = $this->writeMasterLog($path);
        }
        return $ret;
    }
    
    /*
    * Writes test to master log in format Date, TestId (the result of time())
    * @return    bool     $ret    If write was successful
    */
    public function writeMasterLog($path, $testid, $today) {
        $file = "masterlog.txt";
        $handle = fopen($path.$file, 'a') or die("There was a problem opening master log");
        $entry = "$testid - $today\n";
        $ret = fwrite($handle, $entry);
        fclose($handle);
        return $ret;
    }
    
    /*
    * Reads and returns test information from master log
    * @param    int     $offset    Which test to return (defaults to last test in log)
    * @param    int     $length    How many tests to return (defaults to 1)
    * @return    array     $ret    Array of testID and time run
    *
    */
    public function readMasterLog($offset = 1, $length = 1) {
        $ret = array();
        $offset = '-'.$offset;
        $path = getPath('tests').'logs/';
        
        $arr = file($path.'masterlog.txt', FILE_IGNORE_NEW_LINES);
        $test = array_slice($arr, $offset, $length);
        
        $ret['testid'] = substr($test, 0, 10);
        $ret['testtime'] = substr($test, strpos($test, '- '));
        return $ret;        
    }
    
    
    
    /*
    * Set data with specified, defaults to POST if available, error if none
    * @param    array     $data        Should be test files to run
    *    
    */
    public function setData($data = '') {
        if(empty($data) || !isset($data) || $data = '') {
            $this->data = $this->getPOST();
        } else {
            $this->data = $data;
        }
    }
    
    /*
    * Set $_POST data as $this->data
    *
    */
    public function getPOST() {
        if(!empty($_POST) && isset($_POST)) {
            return $_POST;
        } else {
            exit('No test files specified');
        }
    }
    
    
}

?>
