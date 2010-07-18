<?php
/*
Configuration for PHPUnit tests
*/

class Tst {
    
    /**
    * Permissions for suite. Each flag represents a feature that can be enabled.
    * 1 - Suite allows read operations (e.g: logs can be loaded in GUI)
    * 2 - Suite allows write operations (e.g: tests can be run, but no results viewed)
    * 3 - GUI is enabled
    */
    public static $access = array(1,2,3);
    
    /**
    * Message to display when feature is disabled in GUI
    */
    public static $disabledMessage = 'Sorry, this feature has been disabled.';
    
    /**
    * /path/to/public_html root
    */
    public static $public = 'c:/xampplite/htdocs/geeklog/public_html/';
    
    /**
    * path/to/geeklog/root
    */
    public static $root = 'c:/xampplite/htdocs/geeklog/';
    
    /**
    * path/to/testpackage
    */
    public static $tests = 'c:/xampplite/htdocs/geeklog/public_html/tests/testpackage/';
    
    /**
    * Return true if access level matches parameter provided, else returns false
    * e.g: if a function should have an enabled GUI and write privileges enabled to be used,
    * we would put the function inside 'if(Tst::access(array(2,3))) {'.
    * @param    array    $roles    Roles to be checked 
    * @param    array    $exit    (Optional) Whether to exit on failure
    * @return   bool    $retval    Returns true if all roles are allowed
    */
    public static function access($roles, $exit = 0) {
        $retval = true;
        foreach($roles as $k => $role) {
            if(!in_array($role, Tst::$access)) {
                $retval = false;
                break;
            }
        }
        if(!$retval && $exit == 1) { 
            exit();
        } else {
            return $retval;
        }
    }
    
}

?>
