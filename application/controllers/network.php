<?php defined("BASEPATH") or exit("No direct script access allowed");

class Network extends Pinet_Controller {

    public $title = 'Network Settings';
    public $messages = 'Network Settings';

    public function __construct() {
        parent::__construct();
        $this->load->library(array('datatable', 'navigation'));
        $this->load->model(array('config_model', 'gateway_model', 'user_model', 'group_user_model'));
        $this->default_model = array('index'=>$this->gateway_model);
        $this->jquery_ui();
        $this->jquery_pinet();        
    }

    public function index_datatable_customize($pagination) {
        $search_condition='';
        $user_condition='';
        $user_id = $this->user_model->getLoginUserID();
        if($this->group_user_model->isPartner($user_id)){
            $user_condition = ' and g.owner_id in (select partner_user_id from $$partner_users as pu where pu.user_id='.$user_id.')';
        }elseif(!$this->group_user_model->isAdmin($user_id))
            $user_condition = " and g.owner_id='".$user_id."' ";
        foreach($pagination->where as $column=>$search){
            if($search_condition)
                $search_condition .= ' or '.$column." like '%".$search."%'";
            else
                $search_condition .= $column." like '%".$search."%'";
        }
        if($user_condition){
            $pagination->customized_query->query .= $user_condition;
            $pagination->customized_query->dbtotal_count_query .= $user_condition;
            $pagination->customized_query->total_count_query .= $user_condition;
        }
        if($search_condition){
            $pagination->customized_query->query .= " and (".$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= " and (".$search_condition.")";
            $pagination->customized_query->total_count_query .= " and (".$search_condition.")";
        }
        return $pagination;
    }

    public function index() {
        $this->init_responsive();
        $this->less('network/index_css');
        $this->render('network/index');
    }

    public function lan($gateway_id){
        $settings = new stdClass();
        $settings->lan_type = 'dhcp';
        if(!($this->input->post('radio_switch') || isset($_POST['__nouse__']))){
            if($this->input->post('lan_type') == 'manual'){
                $this->config_model->changeItem($gateway_id, 'lan.ip.mask', $this->input->post('lan_ip_mask'));
                $this->config_model->changeItem($gateway_id, 'lan.ip.router', $this->input->post('lan_ip_router'));
                $this->config_model->changeItem($gateway_id, 'lan.ip.dns', $this->input->post('lan_ip_dns'));
            }
            $this->config_model->changeItem($gateway_id, 'lan.ip.address', $this->input->post('lan_ip_address'));
            $this->config_model->changeItem($gateway_id, 'lan.type', $this->input->post('lan_type'));
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Save successfully!')
            ));
        }
        foreach($this->config_model->getConfigs($gateway_id) as $config){
            $key = str_replace('.', '_', $config->item);
            $settings->$key = $config->value;
        }
        if($this->input->post('radio_switch'))
            $settings->lan_type = $this->input->post('radio_switch');
        if($settings->lan_type == 'dhcp'){
            $this->setState('readonly', 'lan');
        }
        $this->init_responsive();
        $this->jqBootstrapValidation();
        $this->less('network/lan_css');
        $this->render('network/lan', array('form_data' => $settings, 'network_menus' => $this->build_menu($gateway_id)));
    }

    public function wlan($gateway_id){
        $settings = new stdClass();
        $settings->wlan_switch = 'on';
        if(!isset($_POST['__nouse__'])){
            if($this->input->post('wlan_switch') == 'on'){
                $this->config_model->changeItem($gateway_id, 'wlan.ssid1', $this->input->post('wlan_ssid1'));
                $this->config_model->changeItem($gateway_id, 'wlan.ssid2', $this->input->post('wlan_ssid2'));
                $this->config_model->changeItem($gateway_id, 'wlan.channel', $this->input->post('wlan_channel'));
            }
            $this->config_model->changeItem($gateway_id, 'wlan.switch', $this->input->post('wlan_switch'));
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Save successfully!')
            ));
        }
        foreach($this->config_model->getConfigs($gateway_id) as $config){
            $key = str_replace('.', '_', $config->item);
            $settings->$key = $config->value;
        }
        if($settings->wlan_switch == 'off'){
            $this->setState('view', 'wlan');
        }
        $this->init_responsive();
        $this->jqBootstrapValidation();   $this->jquery_selectBoxIt();       
        $this->less('network/wlan_css');
        $channels = array(
            1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12,13=>13
        );
        $this->render('network/wlan', array('form_data' => $settings, 'channels'=>$channels, 'network_menus' => $this->build_menu($gateway_id)));
    }

    public function ibox_basic($gateway_id){
        if(!isset($_POST['__nouse__'])){
            if($this->gateway_model->saveBasicInfo($gateway_id, $this->input->post())){
                $this->addAlert(array(
                    'type' => 'info',
                    'message' => lang('Save successfully!')
                ));
            }else{
                $this->addAlert(array(
                    'type' => 'info',
                    'message' => lang('Save failed!')
                ));
            }
        }
        $settings = $this->gateway_model->getBasicInfo($gateway_id);
        $this->init_responsive();
        $this->jqBootstrapValidation();
        $this->less('network/ibox_basic_css');
        $this->render('network/ibox_basic', array('form_data' => $settings, 'network_menus' => $this->build_menu($gateway_id)));
    }

    private function build_menu($gateway_id){
        return array(
            'network_lan' => copy_new(array(
                'controller' => 'Network',
                'method' => 'lan',
                'args' => $gateway_id,
                'label' => lang('LAN Settings')
            ), 'Action'),
            'network_wlan' => copy_new(array(
                'controller' => 'Network',
                'method' => 'wlan',
                'args' => $gateway_id,
                'label' => lang('WLAN Settings')
            ), 'Action'),
            'network_ibox_basic' => copy_new(array(
                'controller' => 'Network',
                'method' => 'ibox_basic',
                'args' => $gateway_id,
                'label' => lang('iBox Basic Settings')
            ), 'Action'),
        );
    }
}
