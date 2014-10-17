<?php
class CashMachineTest extends PHPUnit_Framework_TestCase
{
	public function testGeTCash() {
		$notes = [50.00, 20.00, 10.00];
		$CM = new CashMachine($notes);
		$this->assertEquals([20.00, 10.00], $CM->getCash(30.00));
		$this->assertEquals([50.00, 20.00, 10.00], $CM->getCash(80.00));
		$this->assertEmpty($CM->getCash(null));
	}

	public function testNoteException() {
		$notes = [50.00, 20.00, 10.00];
		$CM = new CashMachine($notes);

		$this->setExpectedException('NoteUnavailableException');
		$CM->getCash(125);
	}

	public function testInvalidException() {
		$notes = [50.00, 20.00, 10.00];
		$CM = new CashMachine($notes);

		$this->setExpectedException('InvalidArgumentException');
		$CM->getCash(-130);
	}
}