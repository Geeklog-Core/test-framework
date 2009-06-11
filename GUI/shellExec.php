<?php

class ShellExec {
    
    public $testfile;
    public $output;
    
    public function ShellExec() {
        require_once('../config.php');
        $this->output = array();
        foreach($_POST['test'] as $k => $v) {
            $this->phpUnit($v);
        }
    }
    
    public function phpUnit($testfile) {
        $this->output[] = shell_exec("phpunit ".getPath("public")."/gsoc-2009-sclark/geeklog/$this->testfile)");
    }
}



?>
