<?php defined('BASEPATH') or exit('No direct script access allowed');

class Firewall_Model extends Pinet_Model{
	public function __construct(){
		parent::__construct('firewalls');
        $this->load->model(array('config_model', 'configchange_model', 'gateway_model'));
	}

    private function _addFirewall($values){
        if(!$values['ip_host'])
            return;
        if($values['protocol'] == 'BOTH'){
            $values['protocol']='UDP';
            $this->insert($values);

            $values['protocol']='TCP';
            $this->insert($values);
        }else{
            $this->insert($values);
        }
    }

    public function addFirewall($values){
        $gateways = $this->gateway_model->getGateways($values['user_id']);
        foreach($gateways as $gateway){
            $this->_addFirewall($values);
            $this->config_model->changeItem($gateway->id, 'firewall.rules', $this->_buildFirewall($values['user_id']));
        }
    }

    public function deleteFirewall($user_id, $ids){
        $this->delete('id', $ids);
        $gateways = $this->gateway_model->getGateways($user_id);
        foreach($gateways as $gateway){
            $this->config_model->changeItem($gateway->id, 'firewall.rules', $this->_buildFirewall($user_id));
        }
    }

    private function _buildFirewall($user_id){
        $this->result_mode='object';
        $firewalls = $this->get_all('user_id', $user_id);
        $firewall_rules = '';
        foreach($firewalls as $firewall){
            $firewall_rules .= 'FirewallRule ' . strtolower($firewall->action) . ' ' . strtolower($firewall->protocol) . ' to ' . $firewall->ip_host;
            if($firewall->port)
                $firewall_rules .= '/'. $firewall->port;
            $firewall_rules .= PHP_EOL;
        }
        $path = FCPATH.APPPATH.'config/firewall_rules.php';
        $firewall_rules = str_replace('{firewall.rules}', $firewall_rules, @file_get_contents($path));
        return $firewall_rules;
    }
}