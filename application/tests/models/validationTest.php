<?php defined('BASEPATH') or exit('No direct script access allowed');

class ValidationTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->CI->load->spark('curl/1.3.0');
		$this->CI->gateway_model->clear();
		$this->CI->device_model->clear();		
		$this->CI->load->model(array(
			'gateway_model',
			'device_model',
			'token_model'
		));
	}
}
