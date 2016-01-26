<?php defined('BASEPATH') or exit('No direct script access allowed');

class LoginRequest_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('login_requests');
		$this->load->model(array('gateway_model', 'device_model'));
		$this->load->helper('uagent');
	}

	public function add($input) {
		$user_id = isset($input['user_id'])? $input['user_id']: 0;
		$serial = $input['serial'];
		$mac = $input['mac'];
		$the_device = $this->device_model->getOrCreate($serial, $user_id, $mac);
		$the_gateway = $this->gateway_model->getBySerial($serial);
        $this->result_mode = 'object';
        $device = $this->device_model->get('id', $the_device->id);
        $user_id = $device->owner_id;
		if(isset($the_gateway->id)) {
			$the_id = $this->insert(array(
				'user_id' => $user_id,
				'gateway_id' => $the_gateway->id,
				'device_id' => $the_device->id
			));
			return $the_id;
		}
		return -1;
	}
}
