<?php

/**
* Simple tests for COM_createImage
*/

require_once 'PHPUnit/Framework.php';
require_once 'config.php';
require_once getPath('root').'system/classes/calendar.class.php';
 
class CalendarDayTest extends PHPUnit_Framework_TestCase 
{
    private $cd;
    
    protected function setUp() {
        // Assign default values
        $this->cd = new CalendarDay;
    }
    public function testIsWeekendIsFalse() {        
        $this->assertFalse($this->cd->isWeekend());
    }
    public function testIsHolidayIsFalse() {        
        $this->assertFalse($this->cd->isHoliday());
    }
    public function testIsSelectedIsFalse() {        
        $this->assertFalse($this->cd->isSelected());
    }
}

?>
