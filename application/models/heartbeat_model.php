<?php defined('BASEPATH') or exit('No direct script access allowed');

class Heartbeat_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('heart_beats');
		$this->load->model('gateway_model');
	}

	public function addHeartBeat($input) {
		$gateway = $this->gateway_model->getBySerial($input->get('serial'));
		if($gateway) {
			return $this->insert(array(
				'gateway_id' => $gateway->id,
				'sys_uptime' => $input->get('sys_uptime'),
				'sys_load' => $input->get('sys_load'),
				'sys_memfree' => $input->get('sys_memfree'),
				'sys_memory' => $input->get('sys_memory'),
				'firmware_version' => $input->get('firmware_version'),
				'sys_version' => $input->get('sys_version')
			));
		}
		else {
			return -1;
		}
	}
}
