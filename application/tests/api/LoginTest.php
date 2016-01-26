<?php defined('BASEPATH') or exit('No direct script access allowed');

class LoginTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->library('test_data', 'data');
		$this->model('loginrequest_model');

		// Adding the user
		$this->data->addTheUser();

		// Adding the gateway
		$this->data->addTheGateway();

		// The device
		$this->data->addTheDevice();

		$this->loginrequest_model->clear();
	}

	public function testLogin() {
		// Testing the get
		$this->_urlGet($this->url('/api/login'), array(
			'serial' => $this->data->the_gateway->serial,
			'gateway_ip' => fake_ip(),
			'gateway_port' => 12345,
			'ip' => fake_ip(),
			'mac' => $this->data->the_device->mac,
			'url' => 'http://www.baidu.com'
		));

		$this->assertEquals($this->loginrequest_model->count_all(), 1);
	}

	public function doTearDown() {
		$this->data->reset();
		$this->loginrequest_model->clear();
	}
}
