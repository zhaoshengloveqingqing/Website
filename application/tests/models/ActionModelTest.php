<?php defined('BASEPATH') or exit('No direct script access allowed');

class ActionModelTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->library('test_data');
		$this->model(array('action_model', 'user_model', 'security_configuration_model', 'security_target_model', 'security_subject_model'));
	}

	public function testGetCurrentAction() {
		$this->assertNull($this->action_model->getCurrentAction());
		$this->test_data->addAction();
		$action = $this->action_model->getCurrentAction();
		$this->assertNotNull($action);
		print_r($action);
		$this->assertEquals($action->controller, 'Welcome');
	}

	public function testGetActionsByGroup() {
		$this->assertTrue(count($this->action_model->getActionsByGroup($this->test_data->the_action_group)) == 0);
		$this->test_data->addAction();
		$this->assertTrue(count($this->action_model->getActionsByGroup($this->test_data->the_action_group)) == 1);
		$result = $this->action_model->getActionsByGroup($this->test_data->the_action_group);
		$jack = $result[0];
		$this->assertEquals($jack->nick, 'Jack');
		$this->assertEquals($jack->controller, 'Welcome');
		$this->assertEquals($jack->method, 'main');
	}

    public function testGetActionByName(){
		$this->assertNull($this->action_model->getActionByName('welcome'));
        $this->test_data->addAction();
		$this->assertNotNull($this->action_model->getActionByName('welcome'));
    }

	public function doTearDown() {
		$this->test_data->reset();
	}
}
