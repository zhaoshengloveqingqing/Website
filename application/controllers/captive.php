<?php defined("BASEPATH") or exit("No direct script access allowed");

class Captive extends Pinet_Controller {

    public $title = '';
    public $messages = '';

    public function __construct() {
        parent::__construct();
        $this->title = lang('Captive Portal Settings');
        $this->messages = lang('Captive Portal Settings');
        $this->load->library(array('session', 'datatable', 'navigation'));
        $this->load->model(array('user_model','firewall_model', 'blacklist_model', 'sns_operation_configuration_model', 'group_user_model', 'portal_page_model'));
        $this->default_model = array('index'=>$this->gateway_model, 'walled_garden'=>$this->gateway_model, 'blacklist'=>$this->blacklist_model);
        $this->jquery_ui();
        $this->jquery_pinet();
        $this->jquery_file_upload();
    }

    public function index_datatable_customize($pagination) {
        $search_condition='';
        $user_condition='';
        $user_id = $this->user_model->getLoginUserID();
        if(!$this->group_user_model->isAdmin($user_id))
            $user_condition = " and u.id='".$user_id."' ";
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
            $pagination->customized_query->query .= ' and ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= ' and ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= ' and ('.$search_condition.")";
        }
        return $pagination;
    }

    public function index() {
        $this->walled_garden();
    }

    public function walled_garden_datatable_customize($pagination) {
        $search_condition='';
        $user_condition='';
        $user_id = $this->user_model->getLoginUserID();
        if(!$this->group_user_model->isAdmin($user_id))
            $user_condition = " and u.id='".$user_id."' ";
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
            $pagination->customized_query->query .= ' and ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= ' and ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= ' and ('.$search_condition.")";
        }
        return $pagination;
    }

    public function walled_garden() {
        if($this->input->post('ids')){//don't move to walled_garden_form function
            $this->load->library('session');
            $user_id = $this->user_model->getLoginUserID();
            $ids = explode(',', $this->input->post('ids'));
            $this->firewall_model->deleteFirewall($user_id, $ids);
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Delete successfully!')
            ));
        }
        $this->init_responsive();
        $this->less('captive/walled_garden_css');
        $this->render('captive/walled_garden');
    }

    public function add_form(){
        $this->load->library('session');
        $user_id = $this->user_model->getLoginUserID();
        $this->firewall_model->addFirewall(array(
            'user_id' => $user_id,
            'ip_host' => $this->input->post('firewall_rules_ip_address'),
            'protocol' => $this->input->post('firewall_rules_protocol'),
            'port' => $this->input->post('firewall_rules_port'),
            'action' => $this->input->post('firewall_rules_action'),
            'description' => $this->input->post('firewall_rules_comments')
        ));
        $this->addAlert(array(
            'type' => 'info',
            'message' => lang('Save successfully!')
        ));
        $save_type = $this->input->post('save_type');
        if($save_type)
            redirect(site_url('captive/index'));
        $this->init_responsive();
        $this->less('captive/add_css');
        $this->render('captive/add');
    }

    public function add(){
        $this->init_responsive();
        $this->less('captive/add_css');
        $this->render('captive/add');
    }

    public function blacklist_datatable_customize($pagination) {
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
            $pagination->customized_query->query .= ' and ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= ' and ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= ' and ('.$search_condition.")";
        }
        return $pagination;
    }

    public function blacklist_form(){
        $ids = explode(',', $this->input->post('ids'));
        $result = $this->blacklist_model->deleteBlacklists($ids);
        if($result){
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Delete successfully!')
            ));
        }
        $this->init_responsive();
        $this->less('captive/blacklist_css');
        $this->render('captive/blacklist');
    }

    public function blacklist(){
        $this->init_responsive();
        $this->less('captive/blacklist_css');
        $this->render('captive/blacklist');
    }

    public function portal_form(){
        if(!$this->input->post('operate_type')){
            $files = array_keys($_FILES);
            $post_name = $files[0];
            $this->load->library(array('upload', 'session'));
            $this->upload->allowed_types = '*';
            $this->jquery_file_upload();
            if($this->upload->do_upload($post_name)){
                $this->upload->done_upload('portal_photo');
                if(is_array($this->session->userdata('portal_photo'))){
                    $temp = $this->session->userdata('portal_photo');
                    $temp[$post_name] = $this->upload->relative_path;
                    $this->session->set_userdata('portal_photo', $temp);
                }else{
                    $temp = array($post_name=>$this->upload->relative_path);
                    $this->session->set_userdata('portal_photo', $temp);
                }
                $this->jsonOut(array(
                    'path' => $this->upload->relative_path
                ));
            }
        }else{
            $data = $this->input->post();
            if(is_array($this->session->userdata('portal_photo')))
                $data = array_merge($data, $this->session->userdata('portal_photo'));
            unset($data['operate_type']);
            $result = $this->portal_page_model->addPortalSettings($this->user_model->getLoginUserID(), $data);
            if($result){
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
            $settings = $this->portal_page_model->getPortalSettings($this->user_model->getLoginUserID());
            $setting = new stdClass();
            copyArray2Obj($settings, $setting);
            $this->init_responsive();
            $this->less('captive/portal_css');
            $this->render('captive/portal', array('form_data'=>$setting));
        }
    }

    public function portal(){
        $settings = $this->portal_page_model->getPortalSettings($this->user_model->getLoginUserID());
        $setting = new stdClass();
        copyArray2Obj($settings, $setting);
        if($settings){
            if($setting->login_wechat == 'off'){
                $this->setState('off', 'wechat_switch');
            }
            if($setting->login_weibo == 'off'){
                $this->setState('off', 'weibo_switch');
            }
            if($setting->login_qq == 'off'){
                $this->setState('off', 'qq_switch');
            }
            if($setting->login_yixin == 'off'){
                $this->setState('off', 'yixin_switch');
            }
        }
        $this->init_responsive();
        $this->less('captive/portal_css');
        $this->render('captive/portal', array('form_data'=>$setting));
    }

    public function sns_form(){
        if(count($_FILES)){
            $files = array_keys($_FILES);
            $post_name = $files[0];
            $this->load->library(array('upload', 'session'));
            $this->upload->allowed_types = '*';
            $this->jquery_file_upload();
            if($this->upload->do_upload($post_name)){
                $this->upload->done_upload('sns_settings');
                if(is_array($this->session->userdata('sns_settings'))){
                    $temp = $this->session->userdata('sns_settings');
                    $temp[$post_name] = $this->upload->relative_path;
                    $this->session->set_userdata('sns_settings', $temp);
                }else{
                    $temp = array($post_name=>$this->upload->relative_path);
                    $this->session->set_userdata('sns_settings', $temp);
                }
                $this->jsonOut(array(
                    'path' => $this->upload->relative_path
                ));
            }
        }else{
            $data = $this->input->post();
            if(is_array($this->session->userdata('sns_settings')))
                $data = array_merge($data, $this->session->userdata('sns_settings'));
            $result = $this->sns_operation_configuration_model->saveSnsSettings($this->user_model->getLoginUserID(), $data);
            if($result){
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
            $this->init_responsive();
            $this->less('captive/sns_css');
            $settings = $this->sns_operation_configuration_model->showSnsSettings($this->user_model->getLoginUserID());
            $this->render('captive/sns', array('form_data'=>$settings));
        }
    }

    public function show_poi_datatable(){
        $user_id = $this->user_model->getLoginUserID();
        $keyword = $this->input->post('search');
        if($keyword)
            $keyword = $keyword['value'];
        return $this->datatable->buildCustomizeData($this->sns_token_model->getWeiboPOIs($user_id, 'weibo', $keyword));
    }

    public function show_poi(){
        $this->load->library(array('listview'));
        $this->init_responsive();
        $this->jquery_listview();
        $this->less('captive/show_poi_css');
        $this->render('captive/show_poi');
    }

    public function sns(){
        $this->init_responsive();
        $this->less('captive/sns_css');
        $settings = $this->sns_operation_configuration_model->showSnsSettings($this->user_model->getLoginUserID());
        $this->render('captive/sns', array('form_data'=>$settings));
    }

    public function oauth($provider = 'qq'){
        $this->session->set_userdata('sns_settings_url', site_url('captive/sns'));
        redirect(site_url('oauth/session/'.$provider));
    }
}
