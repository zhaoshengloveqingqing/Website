<?php defined('BASEPATH') or exit('No direct script access allowed');

class Configchange_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('config_changes');
		$this->load->model('gateway_model');
	}

	public function getAllUnApplied($gateway_id, $apply = FALSE) {
		$this->result_mode = 'array';
		return $this->get_all(array(
			'applied' => $apply,
			'gateway_id' => $gateway_id
		));
	}

	public function getUnApplied($gateway_id, $config_id, $apply = FALSE) {
		$this->result_mode = 'object';
		return $this->get(array(
			'applied' => $apply,
			'gateway_id' => $gateway_id,
			'config_id' => $config_id
		));
	}

	public function updateOrCreate($gateway_id, $config_id, $value, $old_value, $apply = FALSE) {
		$change = $this->getUnApplied($gateway_id, $config_id, $apply);
		if(isset($change->id)) {
			$this->update($change->id, array(
				'new_value' => $value
			));
		}
		else {
            $change =  $this->insert(array(
				'gateway_id' => $gateway_id,
				'config_id' => $config_id,
				'new_value' => $value,
				'old_value' => $old_value,
                'applied' => $apply
			));
		}
        return $this->load($change->id);
	}

	public function apply($config_change_id) {
		$this->update($config_change_id, array(
			'applied' => true
		));
	}

    public function getLastVersion($gateway_id, $config_id){
        $this->db->select('version');
        $this->db->from('config_changes');
        $this->db->where('gateway_id', $gateway_id);
        $this->db->where('config_id', $config_id);
        $this->db->order_by("version desc");
        $result = $this->db->get()->row();
        if($result)
            return $result->version;
        return 1;
    }

    public function getLastConfigChange($gateway_id, $config_id=0){
        $this->db->select('id');
        $this->db->from('config_changes');
        $this->db->where('gateway_id', $gateway_id);
        if($config_id)
            $this->db->where('config_id', $config_id);
        $this->db->order_by("timestamp desc");
        $result = $this->db->get()->row();
        if($result)
            return $result->id;
        return -1;
    }

    public function applyConfigChanges($ids){
        $this->db->where_in('id', $ids);
        $update = array(
            'applied'=>1
        );
        return $this->db->update('config_changes', $update);
    }
}
