<?php defined('BASEPATH') or exit('No direct script access allowed');

class AccountModelTest extends Pinet_PHPUnit_Framework_TestCase {
	private $the_user_id = 1000;
	private $the_username = 'andy';

	public function doSetUp() {
		$this->CI->load->model('account_model');
		$this->CI->account_model->clear();
		$this->CI->account_model->insert(array(
			'user_id' => $this->the_user_id,
			'name' => $this->the_username
		));
	}

	public function doTearDown() {
		$this->CI->account_model->clear();
	}

	public function testGetAccount() {
		$ac = $this->CI->account_model->getAccount($this->the_user_id);
		$this->assertEquals($this->the_username, $ac->name);
	}

}