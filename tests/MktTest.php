<?php 

class MktTest extends PHPUnit_Framework_TestCase {
	
	public function setUp() {
		$this->Mkt = new Mkt;
	}
	
	public function testGetName() {
		$this->assertEquals($this->Mkt->getName(), 'Mkt Virtual');
	}
}
