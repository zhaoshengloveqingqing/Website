<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gateway_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('gateways');
        $this->load->model(array('account_model'));
	}
	
	public function getBySerial($serial) {
		$this->result_mode = 'object';
		return $this->get('serial', $serial);
	}

    public function getBasicInfo($id){
        $this->result_mode = 'object';
        $gateway = $this->load($id);
        if($gateway){
            $account = $this->account_model->getAccount($gateway->owner_id);
            if($account)
                $gateway->owner_name = $account->name;
            if($gateway->ip)
                $gateway->ip = long2ip($gateway->ip);
            else
                $gateway->ip = '';
            return $gateway;
        }
        return null;
    }

    public function saveBasicInfo($id, $data){
        $data['ip'] = ip2long($data['ip']);
        $result = $this->update($id, $data);
        $account = $this->account_model->getAccountByID($id);
        if($account)
            $result = $this->account_model->update($account->id, array('name'=>$data['owner_name']));
        return $result;
    }

    public function register($data){
        $gateway = $this->getBySerial($data['serial']);
        if($gateway){
            $this->update($gateway->id, $data);
            return $gateway->id;
        }
        return $this->insert($data);
    }

    public function operateStatus($ids, $status='ACTIVE'){
        $this->db->where_in('id', $ids);
        $update = array(
            'status'=>$status
        );
        return $this->db->update('gateways', $update);
    }

    public function getGateways($user_id){
        $this->result_mode = 'object';
        return $this->get_all('owner_id', $user_id);
    }

    public function getOrCreate($data) {
        $this->result_mode = 'object';
        $gateway = $this->get(array(
            'serial' => $data['serial']
        ));
        if(isset($gateway->id))
            return $gateway;
        $id = $this->insert($data);
        return $this->load($id);
    }

    public function assignOwner($id, $user_id){
        return $this->update($id, array('owner_id'=>$user_id));
    }
}
