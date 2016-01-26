<?php defined('BASEPATH') or exit('No direct script access allowed');

class Syslog_Model extends Pinet_Model{
	public function __construct(){
		parent::__construct('syslogs');
        $this->load->model(array('gateway_model'));
	}

    public function getLogs($ids){
        $logs='';
        $this->result_mode='object';
        $gateways = $this->myget_all('gateways', 'id', $ids);
        foreach($gateways as $gateway){
            $this->db->select('content');
            $this->db->from('syslogs');
            $this->db->where('serial', $gateway->serial);
            $this->db->order_by("timestamp desc");
            $data = $this->db->get()->result();
            foreach($data as $log){
                $logs .= $log->content.PHP_EOL;
            }
        }
        return $logs;
    }
}