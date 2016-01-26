<?php defined('BASEPATH') or exit('No direct script access allowed');

class ConfigTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->model('config_model');
		$this->library(array('test_data', 'log'));
		
		// Adding user
		$this->test_data->addTheUser();

		// Adding the gateway
		$this->test_data->addTheGateway();
	}

	public function doTearDown() {
		$this->test_data->reset();
	}

	public function testGetConfigFail() {
		$ret = $this->getJSON('/api/config');
		$this->assertNotEquals($ret->code, 0);
		$this->log->write_log('error', 'This is a test');
	}
}
