<?php defined("BASEPATH") or exit("No direct script access allowed");

class SecurityTargetModelTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->model(array('security_target_model', 'security_subject_model', 'group_model'));
		$this->library('test_data');
	}

	public function testGetTarget() {
		$target = $this->test_data->addSecTarget();
		$this->assertNotNull($target);
		$this->assertEquals(
			$this->security_target_model->getTarget(
				$this->security_subject_model->getUserSubject(),
				$this->test_data->the_sec_config
			),
			$target
		);
	}

	public function testGetTemplateTargetAction() {
		$subject = $this->security_subject_model->getAdminSubject();
		$action = new Action();
		$action->controller = 'Welcome';
		$action->method = 'asdf';
		$action->args = '1';
		$this->assertNotNull($this->security_target_model->getTemplateTarget($subject, $action));
	}

	public function testGetTemplateTargetView() {
		$subject = $this->security_subject_model->getAdminSubject();
		$action = new Action();
		$action->controller = 'Welcome';
		$action->method = 'index';
		$action->args = '1';
		print_r($this->security_target_model->getTemplateTarget($subject, $action, 'views'));
		$this->assertNotNull($this->security_target_model->getTemplateTarget($subject, $action, 'views'));
	}

	public function testLoadConfig() {
		$this->security_target_model->loadTemplate();
		print_r($this->security_target_model->sec_template);
	}

	public function doTearDown() {
		$this->test_data->reset();
	}
}
