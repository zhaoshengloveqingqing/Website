<?php defined('BASEPATH') or exit('No direct script access allowed');

class PinetControllerTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$CI = &get_instance();
		$CI->default_model = null;
	}

	public function doTearDown() {
	}

	public function testGetDefaultModelNull() {
		$CI = &get_instance();
		$this->assertNull($CI->default_model);
		$this->assertNull($CI->getDefaultModel());

		$CI->default_model = 'test';
		$this->assertNull($CI->getDefaultModel());

		$CI->default_model = array('not exists' => $CI->user_model);
		$this->assertNull($CI->getDefaultModel());

		$CI->default_model = array('not exists' => $CI->user_model);
		$this->assertNull($CI->getDefaultModel());

		$method = get_controller_method();
		$CI->default_model = array($method => 'model');
		$this->assertNull($CI->getDefaultModel());
	}

	public function testGetDefaultModelOK() {
		$CI = &get_instance();
		$CI->default_model = $CI->user_model;
		$this->assertNotNull($CI->getDefaultModel());

		$method = get_controller_method();
		$CI->default_model = array($method => $CI->user_model);
		$this->assertNotNull($CI->getDefaultModel());
	}
}
