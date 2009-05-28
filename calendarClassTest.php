<?php

/**
* Simple tests for calendarClassTest
*/

require_once 'PHPUnit/Framework.php';

require_once '../../../geeklog/system/classes/calendar.class.php';

class calendarClass extends PHPUnit_Framework_TestCase 
{
	private $c;
	
	protected function setUp() {
		$this->c = new Calendar;
	}
	
	public function test_isRollingModeIsFalse() {		
		$this->assertFalse($this->c->_isRollingMode());
	}
	
	public function testCalendarConstructor() {	
		$this->c->_rollingmode = true;
		$this->c->_default_year = 2008;
		$this->c->setLanguage();
		
		$testDateArray = getdate(time());
		
		$this->c->Calendar();
		
		$this->assertFalse($this->c->_rollingmode);
		$this->assertEquals($testDateArray['year'], $this->c->_default_year);
		$this->assertEquals('January', $this->c->_lang_months['january']);														
	}
	
	public function testGetDayOfWeekIsInteger() {
		$this->assertType(integer, $this->c->getDayOfWeek());
	}
	
	public function testGetDayOfWeekEqualsCorrectNum() {
		$this->c->_default_year = 2009;
		$this->assertEquals(2, $this->c->getDayOfWeek(26, 5));
	}
	
	public function testGetWeekOfMonthIsInteger(){
		$this->assertType(integer, $this->c->getDayOfWeek());
	}
	
	public function testGetWeekOfMonthEqualsCorrectNum() {
		$this->c->_default_year = 2009;
		$this->assertEquals(4, $this->c->getWeekOfMonth(26, 5));
	}
	
	public function testIsLeapYearTrueFalse(){
		$this->assertEquals(1, $this->c->isLeapYear(2000));	
		$this->assertEquals(0, $this->c->isLeapYear(2001));
	}
	
	public function testGetDaysInMonthEqualsCorrectTotal(){
		
		$testDays = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		
		foreach ($testDays as $k => $v) {
			$this->assertEquals($v, $this->c->getDaysInMonth($k + 1, 2009), 
								'Error asserting that the '.($k + 1).' month of 2009 had '.$v.' days.');
		}
		$this->assertEquals(29, $this->c->getDaysInMonth(2, 2008, 
							'Error asserting that February 2008 had 29 days.'));
		$this->assertEquals(31, $this->c->getDaysInMonth(1), 
							'Error asserting that January of (default year) had 31 days.');
	}
	
	public function testGetDayNameEqualsEnglishDefaultOnWkStrtSunday() {
		$this->c->_lang_days = array (	
			'sunday' => 'Domingo', 
			'monday' => 'Lunes',
			'tuesday' => 'Martes', 
			'wednesday' => 'Mi�rcoles',
			'thursday' => 'Jueves', 
			'friday' => 'Viernes',
			'saturday' => 'S�bado');
		
		$i = 1;
		foreach ($this->c->_lang_days as $k => $v) {
			$this->assertEquals($v, $this->c->getDayName($i),
								'Error asserting that day '.$i.' of week is '.$v.'.');
			$i++;
		}
		$this->assertEquals('Domingo', $this->c->getDayName(), 
							'Error asserting default value is '.$k.'.');
	}
	
		public function testGetDayNameEqualsEnglishDefaultOnWkStrtMon() {
		$this->c->_week_start = 'Mon';
		$this->c->_lang_days = array (			 
			'monday' => 'Lunes',
			'tuesday' => 'Martes', 
			'wednesday' => 'Mi�rcoles',
			'thursday' => 'Jueves', 
			'friday' => 'Viernes',
			'saturday' => 'S�bado',
			'sunday' => 'Domingo');
		
		$i = 1;
		foreach ($this->c->_lang_days as $k => $v) {
			$this->assertEquals($v, $this->c->getDayName($i),
								'Error asserting that day '.$i.' of week is '.$v.'.');
			$i++;
		}
		$this->assertEquals('Lunes', $this->c->getDayName(),
							'Error asserting default value is '.$k.'.');
	}
	public function testGetDayNameEquals() {
		/*
		$this->c->_week_start = 'Mon';
		$this->assertEquals('Sunday', $this->c->getDayName(7));
		*/
		throw new PHPUnit_Framework_IncompleteTestError(
		'This test has not been implemented yet.'
		);
	}
	public function testGetMonthNameTranslates() {
		$this->c->_lang_months = array (							  
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
		$i = 1;
		foreach($this->c->_lang_months as $k => $v) {
			$this->assertEquals($v, $this->c->getMonthName($i));
			$i++;
		}
		$this->assertEquals('Enero', $this->c->getMonthName());
	}
		public function testGetMonthNameDefaultsEnglish() {						
		$i = 1;
		foreach($this->c->_lang_months as $k => $v) {
			$this->assertEquals($v, $this->c->getMonthName($i));
			$i++;
		}
		$this->assertEquals('January', $this->c->getMonthName());
	}
	public function testSetRollingModeToTrue() {
		$this->c->setRollingMode(true);
		$this->assertEquals(true, $this->c->_isRollingMode());
	}
	public function testSetLanguageTranslates() {				
		$this->lang_days = array(		
			'sunday' => 'Domingo', 
			'monday' => 'Lunes',
			'tuesday' => 'Martes', 
			'wednesday' => 'Mi�rcoles',
			'thursday' => 'Jueves', 
			'friday' => 'Viernes',
			'saturday' => 'S�bado');	
		
		$this->lang_months = array (							  
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
	
		$this->c->setLanguage($this->lang_days, $this->lang_month);			
		foreach ($this->lang_days as $k) {
			$this->assertEquals($this->lang_days[$k], $this->c->_lang_days[$k], 
								'Error translating _lang_days['.$k.'] to Spanish.');
		}
		foreach ($this->lang_months as $k) {
			$this->assertEquals($this->lang_months[$k], $this->c->_lang_months[$k], 
								'Error translating _lang_months['.$k.'] to Spanish.');
		}
	}
	public function testSetLanguageDefaults() {	
		$this->lang_days = array(		
			'sunday' => 'Sunday', 
			'monday' => 'Monday',
			'tuesday' => 'Tuesday', 
			'wednesday' => 'Wednesday',
			'thursday' => 'Thursday', 
			'friday' => 'Friday',
			'saturday' => 'Saturday');	
		
		$this->lang_months = array (							  
			'january'   => 'January',
            'february'  => 'February',
            'march'     => 'March',
            'april'     => 'April',
            'may'       => 'May',
            'june'      => 'June',
            'july'      => 'July',
            'august'    => 'August',
            'september' => 'September',
            'october'   => 'October',
            'november'  => 'November',
            'december'  => 'December');
		
		$this->c->setLanguage();	
		
		foreach ($this->lang_days as $k => $v) {
			$this->assertEquals($v, $this->c->_lang_days[$k], 
								'Error translating _lang_days['.$k.'] to default.');
		}		
		foreach ($this->lang_months as $k => $v) {
			$this->assertEquals($v, $this->c->_lang_months[$k], 
								'Error translating _lang_months['.$k.'] to default.');
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
