<?php defined("BASEPATH") or exit("No direct script access allowed");

class API extends Pinet_Controller {
	var $title = 'api';
	var $messages = 'api';

	public function __construct() {
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		$this->load->helper('common');
		$this->form_validation->set_error_delimiters('','');
	}

	public function ping() {
		// TODO: Add regex validation
		$this->_param('serial', 'Serial');
		$this->_param('sys_uptime', 'Up Time');
		$this->_param('sys_memfree', 'Memory Usage');
		$this->_param('sys_load', 'CPU Usage');
		$this->_param('firmware_version', 'Firmware', '');
		$this->_param('system_version', 'System', '');
		// END
		
		$this->load->model(array('heartbeat_model','config_model','operation_model'));

		if ($this->isValid()) {
			if($this->heartbeat_model->addHeartBeat($this->input)) {
				$config_changes = $this->config_model->getChangesForAPI($this->input->get('serial'));
				$operations = $this->operation_model->getOperationsForAPI($this->input->get('serial'));
                if($config_changes){
                    if($operations)
                        $config_changes .= PHP_EOL.$operations;
                    echo $config_changes;
                }else{
                    echo $operations;
                }
			}
			else {
				echo 'Gateway '.$this->input->get('serial').' is not exists!';
			}
		}
		else {
			echo validation_errors();
		}
	}

    private function _validation_log($code, $level='log', $message=''){
        if($message)
            $this->_write_log($level, $message);
        echo 'Auth: ' . $code;
    }
	
	public function validation() {
		// TODO: Add regex validation
		$this->_param('serial', 'Serial');
		$this->_param('ip', 'Service Ip');
		$this->_param('mac', 'Service Mac');
		$this->_param('token', 'Token');
		$this->_param('incoming', 'Incoming');
		$this->_param('outgoing', 'Outgoing');
		// END		

		$this->load->model(array('token_model', 'device_network_counter_model'));

		if($this->isValid()) {
			if($this->token_model->validate($this->input->get('token'))) {
                $this->device_network_counter_model->insertRecord($this->input->get('token'), array(
                    'incoming' => $this->input->get('incoming'),
                    'outgoing' => $this->input->get('outgoing')
                ));
				$this->_validation_log('1');
			}
			else {
                $this->_validation_log('-1', 'warn', 'Could not find user token. ');
			}
		}
		else {
            $this->_validation_log('-1', 'warn', validation_errors());
		}
	}
	
	public function config() {
		// TODO: Add regex validation
		$this->_param('serial', 'Serial');
		$this->_param('item', 'Item');
		// END

		$this->load->model('config_model');

		if($this->isValid()) {
			// TODO: Find the format to output
		}
		else {
			$this->jsonErr(array(
				'code' => 1,
				'message'=> validation_errors()
			));
		}
	}
	
	public function login() {
		#TODO: Fetch the logo from user's account
		$this->init_responsive();
		$this->less('api/signin_css');
		$data = array(
			'logo' => 'signin-logo.png',
			'welcome_message'=>lang_f('<span>Welcome to</span>%s', 'WALDORF ASTORIA'),
			'title' => 'Waldorf Astoria'
		);
		if($this->input->get('preview') == 'true') {
			$this->render('api/signin', $data);
			return;
		}
		// TODO: Add regex validation
		$this->_param('serial', 'Serial');
		$this->_param('gateway_ip', 'Gateway Ip',array('required','valid_ip'));
		$this->_param('gateway_port', 'Gateway port');
		$this->_param('ip', 'ip',array('required','valid_ip'));
		$this->_param('mac', 'mac');
		$this->_param('url', 'url');
		// END		 
		
		if($this->isValid()) {
			// First, store all the data into session
			$this->load->library('session');
			
			$sessions = $this->input->get();
			$this->session->set_userdata($sessions);   
			
			$data = copy_arr($this->session->all_userdata(), $data);

			// Then add the login request
			$this->load->model('loginrequest_model');
			$this->loginrequest_model->add($this->input->get());

			// Then show the login page
			$this->render('api/signin', $data);
		}
		else {
			echo validation_errors();
			//redirect(site_url('/'));
		}
	}

    public function logout(){
        $this->load->model('device_model');
        $token = $this->device_model->getTokenByMac($this->input->get('mac'));
        redirect($url = 'http://' . $this->session->userdata('gateway_ip') . ':' . $this->session->userdata('gateway_port') . '/pinet/logout?token='.$token);
    }

    public function portal() {
        $this->load->model(array('user_model', 'portal_page_model'));
        $settings = $this->portal_page_model->getPortalSettings($this->user_model->getLoginUserID());
        $this->init_responsive();
        $this->less('api/signin_css');
        $data = array(
            'logo' => 'signin-logo.png',
            'contents'=>lang_f('<span>Welcome to</span> %s', 'Waldorf Astoria'),
            'company' => 'Waldorf Astoria'
        );
        $this->render('api/signin', array_merge($data, $settings));
    }
}
