<?php defined('BASEPATH') or exit('No direct script access allowed');

class UserModelTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->model(array('user_model', 'account_model', 'group_model'));
		$this->library('test_data');
	}

	public function doTearDown() {
		$this->test_data->reset();
	}

	public function testRegister() {
		$this->test_data->registerUser();
		$this->assertTrue($this->test_data->the_user->id > 0);
		$group = $this->user_model->myget('groups_users',array(
			'user_id'=>$this->test_data->the_user->id
		));
		$this->assertNotNuLL($group);
		$this->assertEquals($group->user_id, $this->test_data->the_user->id);
	}

	public function testGetGroups() {
		$this->test_data->registerUser();
		$this->assertEquals(1, count($this->user_model->getGroups($this->test_data->the_user->id)));
	}

	public function testGetGroupID() {
		$this->test_data->registerUser();
		$ret = $this->user_model->getGroupID($this->test_data->the_user->id);
		$this->assertEquals($ret, 2);
		$this->assertEquals($this->user_model->getGroupID(1000), -1);
	}

    public function testLogin(){
        $this->test_data->registerUser();
        $ret = $this->user_model->login($this->test_data->the_user->email_address, $this->test_data->the_user_password);
        $this->assertTrue(is_numeric($ret));
    }
}
