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
		$this->t->_starttime = 1234.56;
		$this->t->_endtime = 1234.66;
		$this->t->_setElapsedTime();
		$this->assertEquals(.10, $this->t->_elapsedtime);
	}
}

?>
