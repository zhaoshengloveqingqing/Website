<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Device_Network_Counter_Model
 * @author jake
 * @since 2014-08-08
 */
class Device_Network_Counter_Model extends Pinet_Model{
    public function __construct(){
        parent::__construct('device_network_counters');
        $this->load->model(array('token_model', 'sns_account_model'));
    }

    public function insertRecord($token, $data){
        $incoming = 0;
        $outgoing = 0;
        $token = $this->token_model->getByToken($token);
        if($token){
            $sns_account_id = $this->sns_account_model->getIdByDeviceId($token->device_id);
            $this->result_mode = 'object';
            $last = $this->orderBy('timestamp DESC')->get(array(
                'device_id' => $token->device_id,
                'gateway_id' => $token->gateway_id,
                'sns_account_id' => $sns_account_id
            ));
            if($last){
                $incoming = (int)$data['incoming'] - $last->incoming;
                $outgoing = (int)$data['outgoing'] - $last->outgoing;
            }else{
                $incoming = (int)$data['incoming'];
                $outgoing = (int)$data['outgoing'];
            }
            return $this->insert(array(
                'device_id' => $token->device_id,
                'incoming' => $incoming,
                'outgoing' => $outgoing,
                'gateway_id' => $token->gateway_id,
                'sns_account_id' => $sns_account_id,
                'token' => $token->token
            ));
        }
    }
}