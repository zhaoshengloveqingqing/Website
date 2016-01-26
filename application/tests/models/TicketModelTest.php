<?php defined('BASEPATH') or exit('No direct script access allowed');

class TicketModelTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->model('ticket_model');
	}

	public function doTearDown() {
		$this->ticket_model->clear();
	}

	public function testHaveTicket() {
		$this->ticket_model->clear();
		$this->ticket_model->insert(array(
			'name'=>'jack'
		));
		$this->assertTrue($this->ticket_model->haveTicket('jack'));
	}

	public function testMacReplace() {
		$mac = "7c:05:07:73:22:ea";
		echo str_replace(':', '', $mac)."\n";
		$phptime = strtotime('2014-07-29 17:22:05');
		echo $phptime."\n";
		$mysqltime=date('Y-m-d H:i:s',$phptime);
		echo $mysqltime."\n";
		$tickettime = str_replace(array(" ",":","-"), 
								  array("","",""), 
								  '2014-07-29 17:22:05');
		echo $tickettime;
	}

}