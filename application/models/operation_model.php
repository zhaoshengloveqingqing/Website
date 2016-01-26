<?php defined('BASEPATH') or exit('No direct script access allowed');

class Operation_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('operations');
		$this->load->model('gateway_model');
	}

	public function getAllUnApplied($serial) {
		$gateway = $this->gateway_model->getBySerial($serial);
		if(isset($gateway->id)) {
			$this->result_mode = 'object';
			return $this->get_all(array(
                'applied' => 0,
				'gateway_id' => $gateway->id
			));
		}
        return NULL;
	}

    public function getOperation($gateway_id, $operation, $applied=null){
        $this->result_mode = 'object';
        $condition = array('gateway_id'=>$gateway_id, 'operation'=>$operation);
        if($applied !== null)
            $condition['applied'] = $applied;
        return $this->get($condition);
    }

    public function getOperationsForAPI($serial) {
        $ids = array();
        $this->load->library('encryptor');
        $operation_list='';
        $data = $this->getAllUnApplied($serial);
        if(count($data))
            $operation_list='OPERATION';
        foreach($data as $operation){
            $operation_list .= PHP_EOL.$this->encryptor->encrypt($operation->operation);
            $ids[] = $operation->id;
        }
        if($ids){
            $this->db->where_in('id', $ids);
            $update = array(
                'applied'=>1
            );
            $this->db->update('operations', $update);
        }
        return $operation_list;
    }

    public function addOperation($ids, $data){
        $this->config->load('operations');
        $result = -1;
        foreach($ids as $id){
            $data['gateway_id'] = $id;
            $data['operation'] = get_ci_config($data['operation'],$data['operation']);
            $operation = $this->getOperation($id, $data['operation'], 0);
            if($operation){
                $now = new DateTime();
                $data['timestamp'] = $now->format('Y-m-d H:i:s');
                $result = $this->update($operation->id, $data);
            }
            else
                $result = $this->insert($data);
        }
        return $result;
    }
}
