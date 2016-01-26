<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SNS_Operation_Queue_Model extends Pinet_Model {
    const STATUS_NEW = 'New';
    const STATUS_DONE = 'Done';
    const STATUS_ERROR = 'Error';
    const STATUS_FAILED = 'Failed';
    public function __construct() {
        parent::__construct('sns_operation_queues');
        $this->load->model(array('gateway_model'));
    }

    public function getActiveQueue(){
        $this->db->select('sns_operation_queues.id,sns_operation_queues.retry, sns_operation_queues.config_id, sns_tokens.token, sns_accounts.provider, sns_accounts.uid');
        $this->db->from('sns_operation_queues');
        $this->db->join('sns_tokens', 'sns_tokens.id=sns_operation_queues.sns_token_id', 'inner');
        $this->db->join('sns_accounts', 'sns_accounts.id=sns_tokens.sns_account_id', 'inner');
        $this->db->where_in('sns_operation_queues.status', array(SNS_Operation_Queue_Model::STATUS_NEW, SNS_Operation_Queue_Model::STATUS_ERROR));
        $this->db->where('sns_tokens.status', 'ENABLE');
        $this->db->order_by("sns_accounts.provider, sns_operation_queues.create_time asc");
        return $this->db->get()->result_array();
    }

    public function updateStatus($ids, $status){
        $datetime = new DateTime();
        $this->db->where_in('id', $ids);
        $update = array(
            'status'=>$status,
            'finish_time'=>$datetime->format('Y-m-d H:i:s')
        );
        if($status != SNS_Operation_Queue_Model::STATUS_DONE){
            $this->db->set('retry', 'retry+1', FALSE);
        }
        return $this->db->update('sns_operation_queues', $update);
    }

    public function saveRecord($sns_token_id, $provider, $serial){
        $gateway = $this->gateway_model->getBySerial($serial);
        $this->result_mode='object';
        $config = $this->myget('sns_operation_configurations', array(
            'platform'=>$provider,
            'user_id'=>$gateway->owner_id
        ));
        if($config){
            return $this->insert(array(
                'config_id'=>$config->id,
                'sns_token_id'=>$sns_token_id,
                'status'=>SNS_Operation_Queue_Model::STATUS_NEW
            ));
        }
    }
}