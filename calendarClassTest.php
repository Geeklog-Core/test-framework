<?php

/**
* Simple tests for calendarClassTest
*/

require_once 'PHPUnit/Framework.php';

require_once '../../../geeklog/system/classes/calendar.class.php';

global $_CONF;
$_CONF = 'spanish';
/* Attempts
require_once '../calendar/event.php';
require_once '../lib-common.php';
global $_CONF, $_TABLES, $_DB_table_prefix, $_DB_mysqldump_path, $_PLUGINS;
$_CONF = $_TABLE = $_DB_table_prefix = $_DB_mysqldump_path = $_PLUGINS = '';
*/
class calendarClass extends PHPUnit_Framework_TestCase 
{
	private $c;
	
	protected function setUp() {
		$this->c = new Calendar;
		
		$lang_days = array(		
			'sunday' => 'Domingo', 
			'monday' => 'Lunes',
			'tuesday' => 'Martes', 
			'wednesday' => 'Miércoles',
			'thursday' => 'Jueves', 
			'friday' => 'Viernes',
			'saturday' => 'Sábado');	
		
		$lang_months = array (							  
			'january'   => 'Enero',
            'february'  => 'Febrero',
            'march'     => 'Marzo',
            'april'     => 'Abril',
            'may'       => 'Mayo',
            'june'      => 'Junio',
            'july'      => 'Julio',
            'august'    => 'Agosto',
            'september' => 'Septiembre',
            'october'   => 'Octubre',
            'november'  => 'Noviembre',
            'december'  => 'Diciembre');
	}
	public function test_isRollingModeIsFalse() {		
		$this->assertFalse($this->c->_isRollingMode());
	}
	public function testCalendar() {		
		throw new PHPUnit_Framework_IncompleteTestError(
		'This test has not been implemented yet.'
		);
	}
	public function testGetDayOfWeekIsInteger() {
		$this->assertType(integer, $this->c->getDayOfWeek());
	}
	public function testGetDayOfWeekEquals() {
		$this->c->_default_year = 2009;
		$this->assertEquals(2, $this->c->getDayOfWeek(26, 5));
	}
	public function testGetWeekOfMonthIsInteger(){
		$this->assertType(integer, $this->c->getDayOfWeek());
	}
	public function testGetWeekOfMonthEquals() {
		$this->c->_default_year = 2009;
		$this->assertEquals(4, $this->c->getWeekOfMonth(26, 5));
	}
	public function testIsLeapYearTrueFalse(){
		$this->assertEquals(1, $this->c->isLeapYear(2000));	
		$this->assertEquals(0, $this->c->isLeapYear(2001));
	}
	public function testGetDaysInMonth(){
		throw new PHPUnit_Framework_IncompleteTestError(
		'This test has not been implemented yet.'
		);
	}
	/*public function testGetDayNameEqualsEng() {
		
		$this->assertEquals('Sunday', $this->c->getDayName(1));
		$this->assertEquals('Monday', $this->c->getDayName(2));
		$this->assertEquals('Tuesday', $this->c->getDayName(3));
		$this->assertEquals('Wednesday', $this->c->getDayName(4));
		$this->assertEquals('Thursday', $this->c->getDayName(5));
		$this->assertEquals('Friday', $this->c->getDayName(6));
		$this->assertEquals('Saturday', $this->c->getDayName(7));
		$this->assertEquals('Sunday', $this->c->getDayName());
		
		throw new PHPUnit_Framework_IncompleteTestError(
		'This test has not been implemented yet.'
		);	
	}*/
	public function testGetDayNameEquals() {
		/*
		$this->c->_week_start = 'Mon';
		$this->assertEquals('Sunday', $this->c->getDayName(7));
		*/
		throw new PHPUnit_Framework_IncompleteTestError(
		'This test has not been implemented yet.'
		);
	}
	public function testGetMonthNameEquals() {
		/*
		$this->assertEquals('January', $this->c->getMonthName(1));
		$this->assertEquals('February', $this->c->getMonthName(2));
		$this->assertEquals('March', $this->c->getMonthName(3));
		$this->assertEquals('April', $this->c->getMonthName(4));
		$this->assertEquals('May', $this->c->getMonthName(5));
		$this->assertEquals('June', $this->c->getMonthName(6));
		$this->assertEquals('July', $this->c->getMonthName(7));
		$this->assertEquals('August', $this->c->getMonthName(8));
		$this->assertEquals('September', $this->c->getMonthName(9));
		$this->assertEquals('October', $this->c->getMonthName(10));
		$this->assertEquals('November', $this->c->getMonthName(11));
		$this->assertEquals('December', $this->c->getMonthName(12));
		$this->assertEquals('January', $this->c->getMonthName());
		*/
		throw new PHPUnit_Framework_IncompleteTestError(
		'This test has not been implemented yet.'
		);
	}	
	public function testSetRollingModeToTrue() {
		$this->c->setRollingMode(true);
		$this->assertEquals(true, $this->c->_isRollingMode());
	}
	public function testSetLanguageDaysTranslate() {		
		$this->c->setLanguage($this->lang_days, $this->lang_month);	
		
		foreach ($this->lang_days as $k) {
			$this->assertEquals($this->lang_days[$k], $this->c->_lang_days[$k]);
		}
		foreach ($this->lang_months as $k) {
			$this->assertEquals($this->lang_months[$k], $this->c->_lang_months[$k]);
		}
	}
	public function testSetCalendarMatrix() {
		throw new PHPUnit_Framework_IncompleteTestError(
		'This test has not been implemented yet.'
		);
	}
	public function testGetDayData() {
		throw new PHPUnit_Framework_IncompleteTestError(
		'This test has not been implemented yet.'
		);
	}
}    

?>
