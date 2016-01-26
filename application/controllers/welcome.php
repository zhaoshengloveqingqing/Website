<?php defined("BASEPATH") or exit("No direct script access allowed");

class Welcome extends Pinet_Controller {
	public $title = 'Welcome';
	public $messages = 'welcome';

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library(array('navigation', 'session'));
        $this->init_responsive();
		$this->jquery_ui();
        $this->jquery_pinet();
		$this->load->model('user_model');
		$this->default_model = $this->user_model;
		$this->load->model('security_subject_model');
	}

	public function listview_form() {
		$this->load->library('upload');
		$this->upload->allowed_types = '*';
		if($this->upload->do_upload('test')){
			$this->upload->done_upload('user_photo');
			$this->jsonOut(array(
				'path' => site_url($this->upload->site_path)
			));
		}
	}

	public function listview() {
        $this->load->model('user_model');
        $this->load->library(array('listview', 'test_data', 'upload')); 
		ci_log('Uploads', $this->upload);
		$this->test_data->addUserInsane();
        $this->jquery_listview();
		$this->jquery_file_upload();
		$this->render('listview_test',array());
	}

    public function playground() {
        $this->load->library(array('datatable')); 
		$this->addAlert(array(
			'type' => 'info',
			'message' => 'Hello'
		));
		$this->addAlert(array(
			'type' => 'warning',
			'message' => 'It is a bug'
		));
		$this->setState('disabled', 'toolbar');
        $this->jquery_listview();
        $this->dateTimePicker();
        $this->jquery_selectBoxIt();               
        $this->jquery_inputmask();
        $this->datepicker();
        $this->jquery_pinet();
        $this->jquery_mousewheel();    
        $this->less('home/welcome_css');              
        $this->render('welcome_message',array());        
    } 

	/**
	 * Need to use transaction to fix the problem that the datatable and listview can't use together
	 */
	public function index($type = '') {
		ci_log('breadscrums', get_breadscrums());
        $this->session->unset_userdata('need_to_redirect_url');
		$data = array();
        $this->stickup();
        if($type == 'test'){
			$this->log('Navigations is ', $this->navigation->getNavigations());
            $this->less('home/welcome_css');              
		    $this->render('welcome_message',$data);
        }else{
            $this->less('home/index_css');        
            $this->render('index', $data); 
        }       
	}

    public function logout(){
        $this->load->model('user_model');
        $this->user_model->logout();
        redirect(site_url());
    }

    public function login(){
        $this->load->library('session');
        $this->load->model('user_model');
        $result = $this->user_model->login($this->input->post('username'), $this->input->post('password'));
        if(is_numeric($result))
            echo json_encode(array('success'=>true, 'msg'=>site_url('account/index')));
        else{
            echo json_encode(array('success'=>false, 'msg'=>$result));
        }
    }

    public function request(){
        $this->load->model('customer_request_model');
        $this->customer_request_model->insert(array(
            'name' => $this->input->post('request_name'),
            'email_address' => $this->input->post('request_email_address'),
            'contact_number' => $this->input->post('request_contact_number'),
            'company_name' => $this->input->post('request_company_name'),
            'company_address' => $this->input->post('request_company_address'),
            'industry_type' => $this->input->post('request_industry_type'),
        ));
        redirect();
    }

    public function switch_lang(){
        $url = '';
        if($this->session->userdata('need_to_redirect_url')){
            $url = $this->session->userdata('need_to_redirect_url');
            $this->session->unset_userdata('need_to_redirect_url');
        }
        $this->setLang($this->input->post('language'));
        redirect($url);
    }

    public function send_reset_email(){
        $email = FCPATH.APPPATH.'views/account/reset_password_'.get_lang().'.tpl';
        send_admin_email($this->input->post('email_address'), lang('Reset Password Request'), @file_get_contents($email));
    }

    public function awd(){
        $this->load->library(array('test_data'));
        $this->test_data->addWholeData();
    }

    /**
     * sns account testing script
     * @param int $insert | default 1 to insert default serial record
     * @author jake
     * @since 2014-08-13
     */
    public function snsaccount($insert=1){
        $this->load->model(array('group_model','account_model','device_network_counter_model','device_model','gateway_model','sns_account_model','sns_token_model','token_model','user_model','sns_operation_configuration_model'));
        $this->group_model->clear();
        $this->account_model->clear();
        $this->device_network_counter_model->clear();
        $this->device_model->clear();
        $this->gateway_model->clear();
        $this->sns_account_model->clear();
        $this->sns_token_model->clear();
        $this->token_model->clear();
        $this->user_model->clear();
        if($insert){
            $this->account_model->insert(array(
                'id'=>1,
                'user_id'=>1,
                'name'=>'苏州派尔网络科技'
            ));
            $this->gateway_model->insert(array(
                'id'=>1,
                'serial'=>'36bd44c6-c39e-11e3-8fe6-001f16ffb1bf',
                'owner_id'=>1,
                'longitude'=>120.739238,
                'latitude'=>31.269494
            ));
            $this->device_model->insert(array(
                'id'=>1,
                'owner_id'=>1,
                'gateway_id'=>1,
                'mac'=>'b0:10:41:29:29:15',
                'os'=>'Windows 8.1',
                'browser'=>'Firefox',
                'browser_version'=>'31.0',
                'uagent'=>'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0'
            ));
            $this->sns_account_model->insert(array(
                'id'=>1,
                'user_id'=>1,
                'provider'=>'weibo',
                'uid'=>'3819705898',
                'nickname'=>'苏州派尔网络科技',
                'gender'=>'m',
                'province'=>'32',
                'city'=>'5',
                'profile_image_url'=>'http://tp3.sinaimg.cn/3819705898/50/40041997592/1'
            ));
            $this->sns_account_model->insert(array(
                'id'=>2,
                'user_id'=>1,
                'provider'=>'qq',
                'uid'=>'45024B90997C95894051E40AAAEC88CD',
                'nickname'=>'苏州派尔网络科技',
                'gender'=>'m',
                'province'=>'江苏',
                'city'=>'苏州',
                'profile_image_url'=>'http://q.qlogo.cn/qqapp/101144154/45024B90997C95894051E40AAAEC88CD/40'
            ));
            $this->sns_operation_configuration_model->insert(array(
                'id'=>1,
                'platform'=>'weibo',
                'user_id'=>1,
                'type'=>3,
                'content'=>'a:2:{s:4:"text";s:13:"你好 派尔";s:3:"img";a:3:{s:4:"path";s:56:"/var/www/html/static/img/signin-let-me-online-active.png";s:4:"name";s:31:"signin-let-me-online-active.png";s:4:"mime";s:9:"image/png";}}',
                'poi_id'=>'B2094650D164A6FC4899'
            ));
            $this->sns_operation_configuration_model->insert(array(
                'id'=>2,
                'platform'=>'qq',
                'user_id'=>1,
                'type'=>2,
                'content'=>'a:2:{s:4:"text";s:13:"你好 派尔";s:3:"img";a:3:{s:4:"path";s:56:"/var/www/html/static/img/signin-let-me-online-active.png";s:4:"name";s:31:"signin-let-me-online-active.png";s:4:"mime";s:9:"image/png";}}',
                'poi_id'=>''
            ));
            $this->user_model->insert(array(
                'id'=>1,
                'email_address'=>'3819705898@pinet.co',
                'username'=>'3819705898',
                'password'=>'password',
                'user_type'=>'-1'
            ));
        }
    }

	public function user_form($uid = -1) {
		if($this->isValid()) {
			print_r($this->input->post());
		}
		else {
			show_error('Wrong form');
		}
	}

	public function user($uid = -1) {
		if($uid == -1) {
			redirect(site_url('/'));
		}
		else {
			$this->jqBootstrapValidation();
			$user = $this->user_model->load($uid);
			$groups = $this->user_model->getAllGroups();
			$this->log('user is',$user);
			$this->render('user_details', array('form_data' => $user, 'groups' => $groups));
		}
	}

    public function forget_password() {
        $this->load->library('session');
        $this->session->set_userdata('need_to_redirect_url', current_url());
        if(!isset($_POST['__nouse__'])){
            $email = FCPATH.APPPATH.'views/account/reset_password_'.get_lang().'.tpl';
            send_admin_email($this->input->post('email_address'), lang('Reset Password Request'), @file_get_contents($email));
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Send reset email successfully, please check your email!')
            ));
        }
        $this->init_responsive();
        $this->less('home/forget_password_css');
        $this->render('home/forget_password');
    }
        


    function error(){
        $this->less('home/error_css');
        $this->render('home/error');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
