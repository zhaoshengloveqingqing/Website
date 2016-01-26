<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * TODO: Add the configuration change and operation support test
 */
class HeartbeatTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->library('test_data', 'data');
		$this->model(array('gateway_model', 'user_model', 'heartbeat_model', 'operation_model'));

		// Adding the user
		$this->data->addTheUser();

		// Adding the gateway
		$this->data->addTheGateway();
	}

	public function doTearDown() {
		$this->data->reset();
		$this->heartbeat_model->clear();
	}

	public function testPingFail() {
		$this->assertNotNull($this->gateway_model->load(
			$this->data->the_gateway->id));

		$the_serial = $this->data->the_gateway->serial;
		// Server will tell us that the request is not working by using a 400
		$this->assertTrue(strpos($this->_urlGet('/api/ping'), 'The field was not set')!==false);
	}

	public function testPingSuccess() {
		$the_serial = $this->data->the_gateway->serial;
		$the_uptime = 123456;
		$the_load = 50;
		$the_mem_free = 123456;
		$the_firmware_version = '1.0';
		$the_sys_version = '1.0';

		// Assert that the gateway is in the database
		$this->assertNotNull($this->gateway_model->getBySerial($the_serial));
        $this->CI->operation_model->addOperation(array($this->CI->test_data->the_gateway->id),array('operation'=>'testing'));
		// Doing a success ping
		$this->assertTrue(strpos($this->_urlGet('/api/ping', array(
			'serial' => $the_serial,
			'sys_uptime' => $the_uptime,
			'sys_load' => $the_load,
			'sys_memfree' => $the_mem_free,
			'firmware_version' => $the_firmware_version,
			'system_version' => $the_sys_version
		)), 'OPERATION')!==false);

		// Assert that a heartbeat record is in the database
		$this->assertEquals($this->heartbeat_model->count_all(), 1);

		// The heartbeat record is for the gateway
		$this->assertNotNull($this->heartbeat_model->get('gateway_id',
			$this->data->the_gateway->id));
	}
}
