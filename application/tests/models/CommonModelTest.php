<?php defined('BASEPATH') or exit('No direct script access allowed');

class CommonModelTest extends Pinet_PHPUnit_Framework_TestCase {

	private $the_account_id = 1200;
	private $the_name = 'andy';

	public function doSetUp() {
		$this->model(array('user_model','account_model'));
		$this->CI->user_model->setResultMode();
		$this->CI->user_model->clear();
		$this->CI->account_model->clear();
	}

	public function doTearDown() {
		$this->CI->user_model->clear();
	}

	public function testQuery() {
		$result = $this->user_model->query('select now()');
		print_r($result);
	}

	public function testMyInsert() {
		$this->CI->user_model->myinsert('accounts',array(
			'id' => 1200,
			'name' => 'andy'
		));
		$ret = $this->CI->account_model->load($this->the_account_id);
		$this->assertEquals($ret->name, $this->the_name);
	}

	public function testMyUpdate() {
		$this->CI->account_model->insert(array(
			'id' => 1200,
			'name' => 'andy'
		));			
		$this->CI->user_model->myupdate('accounts', 1200, array(
			'name' => 'jack'
		));
		$ret = $this->CI->account_model->load($this->the_account_id);
		$this->assertEquals($ret->name, 'jack');		
	}

	public function testMyGet() {
		$this->CI->user_model->myinsert('accounts',array(
			'id' => 1200,
			'name' => 'andy'
		));	
		$ret = $this->CI->user_model->myget('accounts',array(
			'name'=>'andy'
		));
		$this->assertEquals($ret->name, 'andy');
	}
 
	public function testMyDelete() {
		$this->CI->account_model->insert(array(
			'id' => 1200,
			'name' => 'andy'
		));		
		$count = $this->CI->account_model->count_all();
		$this->CI->user_model->mydelete('accounts','name','andy');
		$count = $this->CI->account_model->count_all();
		$this->assertEquals($count, 0);
	}

}
