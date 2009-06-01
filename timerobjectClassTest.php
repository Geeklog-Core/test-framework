<?php

/**
* Simple tests for calendarClassTest
*/

require_once 'PHPUnit/Framework.php';

require_once '../../../geeklog/system/classes/timer.class.php';

class timerobjectClass extends PHPUnit_Framework_TestCase 
{
    private $t;
    protected function setUp() {
        $this->t = new timerobject;
    }    
    
    public function testSetPrecisionReturnsDecimalPlaces() {
        $this->t->_precision = 0;
        $this->t->setPrecision(4);
        $this->assertEquals(4, $this->t->_precision);
    }
    
	public function testStartTimerEqualsDummy() {
		$mtime = microtime();
        $mtime = explode(' ', $mtime);
        $var1 = $mtime[1] + $mtime[0];
		$this->t->startTimer();
		$this->assertEquals(0, bccomp($var1, $this->t->_starttime));
	}
    public function testStartTimerReturnsFloat() {
        $this->t->_starttime = 'String';
        $this->t->startTimer();
        $this->assertType(float, $this->t->_starttime);
    }
    
    public function testStopTimeReturnsFloat() {
        $this->t->_endtime = 'String';
        $this->t->stopTimer();
        $this->assertType(float, $this->t->_endtime);
    }
    
    public function test_SetElapsedTime() {
        $this->t->_starttime = .56;
        $this->t->_endtime = .66;
        $this->t->_setElapsedTime();
		$var = bccomp(.10, $this->t->_elapsedtime);
        $this->assertEquals(0, $var);
    }
	
	public function testFloatsCompare() {
        $var1 = 12.1;
		$var2 = 12.1;
        $this->assertEquals($var1, $var2);
    }
	
	
}

?>
