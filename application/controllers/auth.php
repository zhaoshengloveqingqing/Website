<?php defined("BASEPATH") or exit("No direct script access allowed");

class Auth extends Pinet_controller {

	public function __construct() {
		parent::__construct();
		$this->form_validation->set_error_delimiters('','');
		$this->load->library('securimage/securimage');
		$this->load->model('user_model');			
		$this->jquery();	
		$this->bootstrap();
	}

	public function login() {
		$this->user_model->rememberMe();
		$data = array();
		//TODO add regex
		$this->_param(config_item('username_field'), 'EmailAddress');
		$this->_param(config_item('password_field'), 'PassWord');

		if ($this->isValid()) {
			$ret = $this->user_model->login($this->input->post());		
			if(!$ret) {
				$this->render('login', $data);				
			}
		}
		else{
			//load view
			$this->render('login', $data);
		}	 			
	}

	public function register() {
		$data = array();		
		//TODO add regex		
		$this->_param(config_item('username_field'), 'Email Address');
		$this->_param(config_item('password_field'), 'Password');
		$this->_param(config_item('confirm_password'), 'Confirm Password');

		if ($this->isValid()) {
			$captcha = $this->input->post('captcha_code'); 
			if(!$this->securimage->check($captcha)) {
				$this->render('register', $data);	
			}		
			unset($_POST['captcha_code']);

			$ret = $this->user_model->register($this->input->post());
			if(!$ret) {
				$this->render('register', $data);
			}				
		}
		else{
			//load view
			$this->render('register', $data);
		}		
	}
}
