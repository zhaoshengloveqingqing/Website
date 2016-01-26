<?php defined('BASEPATH') or exit('No direct script access allowed');

class LoginRequestModelTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->library('test_data');
		$this->model('loginrequest_model');
		$this->test_data->addTheUser();
		$this->test_data->addTheGateway();
		$this->test_data->addTheDevice();
		$_SERVER['HTTP_USER_AGENT'] = fake_uagent();
	}

	public function doTearDown() {
		$this->test_data->reset();
	}

	public function testAdd() {
		$ret = $this->loginrequest_model->add(array(
			'serial' => 'not exists',
			'mac' => $this->test_data->the_device->mac
		));

		$this->assertEquals($ret, -1);

		$the_request_id = $this->loginrequest_model->add(array(
			'serial' => $this->test_data->the_gateway->serial,
			'mac' => $this->test_data->the_device->mac
		));

		$the_request = $this->loginrequest_model->load($the_request_id);
		$this->assertEquals($the_request->device_id, $this->test_data->the_device->id);

		$the_request_id = $this->loginrequest_model->add(array(
			'serial' => $this->test_data->the_gateway->serial,
			'mac' => fake_mac()
		));

		$the_request = $this->loginrequest_model->load($the_request_id);
		$this->assertNotEquals($the_request->device_id, $this->test_data->the_device->id);
	}
}
