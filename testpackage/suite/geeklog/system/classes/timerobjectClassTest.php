<?php

/**
* Simple tests for timerobjectClassTest
*/

require_once 'PHPUnit/Framework.php';
require_once 'tst.class.php';
require_once Tst::$root.'system/classes/timer.class.php';

class timerobjectClass extends PHPUnit_Framework_TestCase 
{
    private $t;
    
    protected function setUp() {
        $this->t = new timerobject;
        $this->prec = 0.001;
    }    
    
    public function testSetPrecisionReturnsDecimalPlaces() {
        $this->t->_precision = 0;
        $this->t->setPrecision(3);
        $this->assertEquals(3, $this->t->_precision);
    }

    public function testStartTimerEqualsDummy() {
        $mtime = microtime();
        $mtime = explode(' ', $mtime);
        $var1 = $mtime[1] + $mtime[0];
        $this->t->startTimer();
        $this->assertEquals($var1, $this->t->_starttime, '', $this->prec);
    }
    
    public function testStartTimerReturnsFloat() {
        $this->t->_starttime = 'String';
        $this->t->startTimer();
        $this->assertType('float', $this->t->_starttime);
    }
    
    public function testStopTimerEqualsDummy() {
        $mtime = microtime();
        $mtime = explode(' ',$mtime);
        $var1 = $mtime[1] + $mtime[0];
        $this->t->stopTimer();
        $this->assertEquals($var1, $this->t->_endtime, '', $this->prec);
    }
    
    public function testStopTimerReturnsCorrectDefaultDegreeOfPrecision() {
        $parts = explode('.', $this->t->stopTimer());
        $this->assertEquals(2, count($parts));
        $this->assertEquals($this->t->_precision, strlen($parts[1]));
    }
    
    public function testStopTimerReturnsCorrectDefinedDegreeOfPrecision() {
        $this->t->_precision = 3;
        $parts = explode('.', $this->t->stopTimer());
        $this->assertEquals(2, count($parts));
        $this->assertEquals(3, strlen($parts[1]));
    }

    public function testStopTimerReturnsString() {
        $this->t->_starttime = .56;
        $this->assertType('string', $this->t->stopTimer());
    }
    
    public function testRestartResets_Endtime() {
        $this->t->restart();
        $this->assertEquals('', $this->t->_endtime);
    }
    
    public function testRestartRedefines_Starttime(){
        $this->t->restart();        
        $mtime = microtime();
        $mtime = explode(' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $this->assertEquals($mtime, $this->t->_starttime, '', $this->prec);
    }
    
    public function testGetElapsedTimeReturnsDefaultDegreeofPrecision() {
        $this->t->_elapsedtime = .12345;
        $var1 = sprintf('%.2f', .12345);
        $this->assertEquals($var1, $this->t->getElapsedTime());
    }
    
    public function testGetElapsedTimeReturnsDefinedDegreeofPrecision() {
        $this->t->_elapsedtime = .12345;
        $this->t->_precision = 3;
        $var1 = sprintf('%.3f', .12345);
        $this->assertEquals($var1, $this->t->getElapsedTime());
    }
    
    public function test_SetElapsedTime() {
        $this->t->_starttime = .56;
        $this->t->_endtime = .66;
        $this->t->_setElapsedTime();
        $this->assertEquals(.10, $this->t->_elapsedtime, '', $this->prec);
    }
}

?>
