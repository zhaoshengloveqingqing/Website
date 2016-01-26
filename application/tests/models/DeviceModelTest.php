<?php defined('BASEPATH') or exit('No direct script access allowed');

class DeviceModelTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->model(array('device_model', 'device_network_counter_model', 'token_model'));
		$this->library('test_data');

		$this->test_data->addTheUser();
		$this->test_data->addTheGateway();
		$this->test_data->addTheDevice();
	}

	public function doTearDown() {
		$this->test_data->reset();
	}

	public function testGetOrCreate() {
		$_SERVER['HTTP_USER_AGENT'] = fake_uagent();
		$device = $this->device_model->getOrCreate(
			$this->test_data->the_gateway->serial,
			$this->test_data->the_user->id,
			$this->test_data->the_device->mac
		);

		$this->assertEquals($device->id, $this->test_data->the_device->id);

        $device = $this->device_model->getOrCreate(
			$this->test_data->the_gateway->serial,
			$this->test_data->the_user->id,
			fake_mac()
		);

		$this->assertNotEquals($device->id, $this->test_data->the_device->id);
		print_r($this->device_model->load($device->id));
	}

	public function testGetByMac() {
		$this->assertNotNull($this->test_data->the_device);
		$this->assertEquals($this->test_data->the_device, 
			$this->device_model->getByMac($this->test_data->the_device->mac));
	}

    public function testDeviceNetworkInsertRecord(){
        $this->test_data->reset();
        $this->test_data->addToken();
        $this->CI->device_network_counter_model->insertRecord($this->test_data->the_token->token, array(
            'incoming' => 11,
            'outgoing' => 22
        ));
        $this->CI->device_network_counter_model->insertRecord($this->test_data->the_token->token, array(
            'incoming' => 22,
            'outgoing' => 44
        ));
        $this->CI->device_network_counter_model->insertRecord($this->test_data->the_token->token, array(
            'incoming' => 66,
            'outgoing' => 77
        ));
        $this->CI->device_network_counter_model->insertRecord($this->test_data->the_token->token, array(
            'incoming' => 888,
            'outgoing' => 8875
        ));
    }
}
