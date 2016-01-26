<?php defined('BASEPATH') or exit('No direct script access allowed');

class ValidateTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->model('token_model');
		$this->library('test_data');

		// Adding user
		$this->test_data->addTheUser();

		// Adding the gateway
		$this->test_data->addTheGateway();

		// Add the device
		$this->test_data->addTheDevice();
	}

	public function doTearDown() {
		$this->test_data->reset();
	}

	public function testAddDeivce() {
		$this->test_data->addTheDevice();
		$this->assertNotNull($this->test_data->the_device);
		print_r($this->test_data->the_device);
	}

	public function testValidateFail() {
		$ret = $this->_urlGet('/api/validation');
		$this->assertNotEquals($ret, 'Auth: 1');
	}

	public function testValidate() {
		$the_device = $this->test_data->the_device;

		$tid = $this->token_model->add(array(
			'serial' => $this->test_data->the_gateway->serial,
			'mac' => $this->test_data->the_device->mac,
		));

		$token = $this->token_model->load($tid);
		$this->assertNotNull($token);

		$ret  = $this->_urlGet('/api/validation', array(
			'serial' => $this->test_data->the_gateway->serial,
			'ip' => fake_ip(),
			'mac' => $the_device->mac,
			'token' => $token->token,
			'incoming' => 0,
			'outgoing' => 0
		));
		$this->assertEquals($ret, 'Auth: 1');
	}
}
