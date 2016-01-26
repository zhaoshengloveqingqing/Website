<?php defined('BASEPATH') or exit('No direct script access allowed');

class TokenModelTest extends Pinet_PHPUnit_Framework_TestCase {
	
	public function doSetUp() {
		$this->model('token_model');
		$this->library('test_data');

		// Add the user
		$this->test_data->addTheUser();

		// Add the gateway
		$this->test_data->addTheGateway();

		// Add the device
		$this->test_data->addTheDevice();
	}

	public function doTearDown() {
		$this->test_data->reset();
	}

	public function testAdd() {
		$tid = $this->token_model->add(array(
			'serial' => $this->test_data->the_gateway->serial,
			'mac' => $this->test_data->the_device->mac,
		));

		$token = $this->token_model->load($tid);
		$this->assertNotNull($token);
	}

	public function testCreateToken() {
		$token = $this->token_model->createToken('7c:05:07:73:22:ea');
		$s = substr(base64_decode($token),0,2);
		$this->assertEquals($s, '7c');
	}
}
