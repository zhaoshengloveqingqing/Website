<?php defined('BASEPATH') or exit('No direct script access allowed');

class Token {
	private $mac;
	private $timestamp;
	private $type;
	private $name;

	public function __construct($mac, $timestamp, $type, $name) {
		$this->mac = $mac;
		$this->timestamp = $timestamp;
		$this->type = $type;
		$this->name = $name;		
	}

	public function create() {
		$mac = str_replace(':', '', $this->mac);
		$timestamp = str_replace(array(" ",":","-"), 
								  array("","",""), 
								  $this->timestamp);
		$str = $mac . $timestamp . $this->type . $this->name;
		return base64_encode($str);
	}
}

class Token_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('tokens');
		$this->load->model(array('gateway_model', 'device_model'));
	}

	public function tokenString($data) {
		return md5(implode(array(
			$data['serial'],
			$data['mac'],
			$data['timestamp'],
		)));
	}

	public function createToken($mac, $type = 1, $name = 'nobody') {
		$timestamp = date("YmdHis",time());
		$token = new Token($mac, $timestamp, $type, $name);
		return $token->create();
	}

	public function getByToken($token) {
		$this->result_mode = 'object';
		return $this->get('token', $token);
	}

	public function getByIp($ip) {
		$this->result_mode = 'object';
		return $this->get('ip', $ip);		
	}

	public function haveToken($key, $value) {
		$ret = $this->get($key, $value);
		if(empty($ret)) {
			return false;
		}
		return $ret;
	}

	public function add($data) {
		$device = $this->device_model->getByMac($data['mac']);
		if(isset($device->id)) {
			$data['device_id'] = $device->id;
			$gateway = $this->gateway_model->getBySerial($data['serial']);
			if(isset($gateway->id)) {
				$datetime = new DateTime();
				$data['gateway_id'] = $gateway->id;
				$data['timestamp'] = $datetime->format('Y-m-d H:i:s');
				$data['token'] = $this->tokenString($data);
				$data['ip'] = ip2long($_SERVER['REMOTE_ADDR']);
				return $this->insert($data);
			}
		}
		return FALSE;
	}

	public function madd($data) {
		$device = $this->device_model->getByMac($data['mac']);
		if(isset($device->id)) {
			$data['device_id'] = $device->id;
			$gateway = $this->gateway_model->getBySerial($data['serial']);
			if(isset($gateway->id)) {
                $token = $this->createToken($data['mac']);
				$datetime = new DateTime();
				$data['gateway_id'] = $gateway->id;
				$data['timestamp'] = $datetime->format('Y-m-d H:i:s');
				$data['token'] = $token;
				$data['ip'] = ip2long($_SERVER['REMOTE_ADDR']);
				$data['status'] = 'ENABLE';
                if($this->insert($data)){
                    return $data['token'];
                }
			}
		}
		return FALSE;
	}

	public function validate($token) {
		return isset($this->getByToken($token)->id);
	}
}
