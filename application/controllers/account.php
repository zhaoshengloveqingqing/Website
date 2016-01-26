<?php defined("BASEPATH") or exit("No direct script access allowed");

class Account extends Pinet_Controller {

    public $title = 'User and Account Settings';
    public $messages = 'User and Account Settings';

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library();
        $this->load->model(array('user_model', 'group_model', 'group_user_model', 'gateway_model'));
        $this->load->library(array('datatable', 'session', 'navigation'));
        $this->default_model = array('index'=>$this->user_model);
        $this->init_responsive();
        $this->jquery_ui();
        $this->jquery_pinet();
    }

    public function index_datatable_customize($pagination) {
        $search_condition='';
        $user_condition='';
        $user_id = $this->user_model->getLoginUserID();
        if(!$this->group_user_model->isAdmin($user_id))
            $user_condition = " pu.user_id='".$user_id."' ";
        foreach($pagination->where as $column=>$search){
            if($search_condition)
                $search_condition .= ' or '.$column." like '%".mysql_real_escape_string($search)."%'";
            else
                $search_condition .= $column." like '%".mysql_real_escape_string($search)."%'";
        }
        if($user_condition){
            $pagination->customized_query->query .= ' where '.$user_condition;
            $pagination->customized_query->dbtotal_count_query .= ' where '.$user_condition;
            $pagination->customized_query->total_count_query .= ' where '.$user_condition;
        }
        if($search_condition){
            $where_and = $user_condition ? ' and ' : ' where ';
            $pagination->customized_query->query .= $where_and.' ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= $where_and.' ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= $where_and.' ('.$search_condition.")";
        }
        return $pagination;
    }

    public function index(){
        $user_id = $this->user_model->getLoginUserID();
        if(!($this->group_user_model->isAdmin($user_id) || $this->group_user_model->isPartner($user_id))){
            redirect(site_url('account/summary_details/'.$user_id));
        }else{
            $this->less('account/index_css');
            $this->render('account/index');
        }
    }

    public function change_password_form($user_id=''){
        $current_id = $this->_getUserId($user_id);
        $result = $this->user_model->changePassword($current_id, $this->input->post('password'), $this->input->post('new_password'), $this->input->post('password_confirm'));
        if(is_numeric($result)){
            $result = lang('Change successfully!');
        }
        $this->addAlert(array(
            'type' => 'info',
            'message' => $result
        ));
        $this->less('account/change_password_css');
        $this->render('account/change_password', array('account_menus' => $this->_build_menu($user_id)));
    }

    public function change_password($user_id=''){
        $this->less('account/change_password_css');
        $this->render('account/change_password', array('account_menus' => $this->_build_menu($user_id)));
    }

    public function reset_password($user_id=''){
        $current_id = $this->_getUserId($user_id);
        $this->user_model->result_model= 'object';
        $user = $this->user_model->load($current_id);
        if($user){
            $email = FCPATH.APPPATH.'views/account/reset_password_'.get_lang().'.tpl';
            send_admin_email($user->email_address, lang('Reset Password Request'), @file_get_contents($email));
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Has sent the reset password email!')
            ));
        }
        $this->less('account/reset_password_css');
        $this->render('account/reset_password', array('account_menus' => $this->_build_menu($user_id)));
    }

    public function summary_details($user_id=''){
        $current_id = $this->_getUserId($user_id);
        $this->state = 'readonly';
        $this->less('account/summary_details_css');
        $settings = $this->user_model->getUserInfo($current_id);
        $sex = array('n'=>lang('Other'), 'm'=>lang('Male'), 'f'=>lang('Female'));
        if($settings){
            if(in_array($settings->sex, array_keys($sex)))
                $settings->sex = $sex[$settings->sex];
            else
                $settings->sex = lang('Other');
        }
        $profile_image_path = 'user-logo.png';
        if($settings && $settings->profile_image_path)
            $profile_image_path = $settings->profile_image_path;
        $this->render('account/summary_details', array('form_data' => $settings, 'profile_image_path'=>$profile_image_path, 'account_menus' => $this->_build_menu($user_id), 'edit_url'=>site_url('account/summary_edit/'.$user_id)));
    }

    public function summary_edit_form($user_id=''){
        if(!$this->input->post('operate_type')){
            $this->load->library(array('upload', 'session'));
            $this->upload->allowed_types = '*';
            $this->jquery_file_upload();
            if($this->upload->do_upload()){
                $this->upload->done_upload('account_photo');
                $this->session->set_userdata('account_photo', $this->upload->relative_path);
                $this->jsonOut(array(
                    'path' => $this->upload->relative_path
                ));
            }
        }else{
            $data = $this->input->post();
            if($this->session->userdata('account_photo')){
                $data['type'] = 'upload';
                $data['path'] = $this->session->userdata('account_photo');
            }
            $result = $this->user_model->updateUserInfo($data);
            if($result){
                $this->addAlert(array(
                    'type' => 'info',
                    'message' => lang('Update successfully!')
                ));
            }
            redirect(site_url('account/summary_details'. ($user_id ? '/'.$user_id:'')));
        }
    }

    public function summary_edit($user_id=''){
        $this->jquery_file_upload();
        $current_id = $this->_getUserId($user_id);
        $url = site_url('account/summary_edit'. ($user_id ? '/'.$user_id:''));
        $goback_url = site_url('account/summary_details'. ($user_id ? '/'.$user_id:''));
        $this->datepicker();
        $this->jquery_selectBoxIt();                       
        $this->less('account/summary_edit_css');
        $settings = $this->user_model->getUserInfo($current_id);
        $profile_image_path = 'user-logo.png';
        if($settings && $settings->profile_image_path)
            $profile_image_path = $settings->profile_image_path;
        $sex = array('n'=>lang('Other'), 'm'=>lang('Male'), 'f'=>lang('Female'));
        $this->render('account/summary_edit', array('form_data' => $settings, 'profile_image_path'=>$profile_image_path, 'form_action_url'=>$url, 'goback_url'=>$goback_url, 'account_menus' => $this->_build_menu($user_id), 'sexs'=>$sex));
    }

    public function register_form(){
        $user_info = $this->input->post();
        if($user_info['password'] != $user_info['password_confirm']){
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Username or email address is exits!')
            ));
            redirect(site_url('account/register/'.$user_info['id']));
        }
        $user_info['group_id'] = $this->group_model->getUserGroup()->id;
        $user_info['user_type'] = '0';
        $user_id = $this->user_model->register($user_info);
        if($user_id == -1){
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Username or email address is exits!')
            ));
            redirect(site_url('account/register/'.$user_info['id']));
        }else{
            if($user_info['id']){
                $this->gateway_model->assignOwner($user_info['id'], $user_id);
            }
            $this->user_model->login($user_info['email_address'], $user_info['password']);
            redirect(site_url('account/index'));
        }
    }

    public function register($gateway_id=''){
        $form_data = new stdClass();
        $form_data->id=$gateway_id;
        $sex = array('m'=>lang('Male'), 'f'=>lang('Female'));
        $this->init_responsive();
        $this->datepicker();
        $this->less('account/register_css');
        $this->render('account/register', array('form_data'=>$form_data, 'sexs'=>$sex));
    }

    public function login(){
        $this->session->set_userdata('need_to_redirect_url', current_url());
        $this->init_responsive();
        $this->less('account/login_css');
        $form_data = new stdClass();
        $gateway_id = $this->session->userdata('gateway_id');
        $this->session->unset_userdata('gateway_id');
        $form_data->id = $gateway_id;
        $this->render('account/login', array('form_data'=> $form_data, 'register_url'=>site_url('account/register/'.$gateway_id)));
    }

    private function _build_menu($user_id){
        return array(
            'account_summary' => copy_new(array(
                'controller' => 'Account',
                'method' => 'summary_details',
                'args' => $user_id,
                'label' => lang('Account Summary')
            ), 'Action'),
            'change_password' => copy_new(array(
                'controller' => 'Account',
                'method' => 'change_password',
                'args' => $user_id,
                'label' => lang('Change Password')
            ), 'Action'),
            'reset_password' => copy_new(array(
                'controller' => 'Account',
                'method' => 'reset_password',
                'args' => $user_id,
                'label' => lang('Reset Password')
            ), 'Action'),
        );
    }
    
    private function _getUserId($user_id){
        if(!$user_id)
            $user_id = $this->user_model->getLoginUserID();
        return $user_id;
    }
}
