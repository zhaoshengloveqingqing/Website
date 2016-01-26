<?php defined('BASEPATH') or exit('No direct script access allowed');

// TODO: Add config default support
class Config_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('configs');
		$this->load->model(array('gateway_model'));		
	}

	public function getGateway($serial) {
		return $this->gateway_model->getBySerial($serial);
	}

	public function getOrCreate($gateway_id, $item, $value) {
        $this->result_mode = 'object';
        $config = $this->get(array(
            'gateway_id' => $gateway_id,
            'item' => $item
        ));
        if(isset($config->id))
            return $config;
        $id = $this->insert(array(
            'gateway_id' => $gateway_id,
            'item' => $item,
            'value' => $value
        ));
		return $this->load($id);
	}

    public function changeItem($gateway_id, $item, $value){
        $this->load->model('configchange_model');
        $gateway = $this->gateway_model->load($gateway_id);
        if($gateway){
            $config = $this->getOrCreate($gateway_id, $item, $value);
            if(trim($value) != trim($config->value)){
                $version = $this->configchange_model->getLastVersion($gateway_id, $config->id);
                $this->configchange_model->insert(array(
                    'gateway_id' => $gateway_id,
                    'config_id' => $config->id,
                    'new_value' => $value,
                    'old_value' => $config->value,
                    'version' => $version
                ));
            }
        }
    }

    public function getConfig($gateway_id, $item){
        $this->result_mode = 'object';
        return $this->config_model->get(array(
            'gateway_id'=>$gateway_id,
            'item'=>$item
        ));
    }

    public function getConfigs($gateway_id){
        $this->result_mode = 'object';
        return $this->get_all(array('gateway_id'=>$gateway_id));
    }

	public function getChanges($serial) {
		$this->load->model('configchange_model');
		$gateway = $this->gateway_model->getBySerial($serial);
		return $this->configchange_model->getAllUnapplied($gateway->id);
	}

    public function getChangesForAPI($serial) {
        $ids = array();
        $this->load->library('encryptor');
        $config_list='';
        $this->load->model('configchange_model');
        $gateway = $this->gateway_model->getBySerial($serial);
        $data = $this->configchange_model->getAllUnapplied($gateway->id);
        if(count($data))
            $config_list='CONFIG';
        foreach($data as $config){
            $config_list .= PHP_EOL.$this->encryptor->encrypt($config['new_value']);
            $ids[] = $config['id'];
        }
        if($ids)
            $this->configchange_model->applyConfigChanges($ids);
        return $config_list;
    }

	public function apply($serial, $item) {
		$this->load->model('configchange_model');
		$gateway = $this->getGateway($serial);
		$change = $this->configchange_model->getUnapplied($gateway->id);
		if(isset($change)) {
		}
	}
}
