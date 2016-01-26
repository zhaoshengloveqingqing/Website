<?php defined('BASEPATH') or exit('No direct script access allowed');

class Device_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('devices');
		$this->load->model('gateway_model');
        $this->load->helper('uagent');
	}

	public function getGateway($serial) {
		return $this->gateway_model->getBySerial($serial);
	}

	public function getByMac($mac) {
		$this->result_mode = 'object';
		return $this->get('mac', $mac);
	}

	public function getOrCreate($serial, $user_id, $mac) {
		$device = $this->getByMac($mac);

		$result = parse_uagent($_SERVER['HTTP_USER_AGENT']);

		if(isset($device->id)) {
			return $device;
		}
		else {
			$gateway = $this->getGateway($serial);
			$id = $this->insert(array(
				'owner_id' => $user_id,
				'gateway_id' => $gateway->id,
				'mac' => $mac,
				'browser' => $result->ua->family,
				'browser_version' => $result->ua->toVersion(),
				'os' => $result->os->family,
				'os_version' => $result->os->toVersion(),
				'uagent' => $result->originalUserAgent
			));
            return $this->load($id);
		}
	}

    public function getTokenByMac($mac){
        $this->db->select('tokens.token');
        $this->db->from('devices');
        $this->db->join('tokens', 'tokens.device_id=devices.id', 'inner');
        $this->db->where('devices.mac', $mac);
        $data = $this->db->get()->row();
        if($data)
            return $data->token;
        else
            return '';
    }
}
