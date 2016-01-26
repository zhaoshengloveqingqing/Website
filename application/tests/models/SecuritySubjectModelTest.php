<?php defined("BASEPATH") or exit("No direct script access allowed");

class SecuritySubjectModelTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->model(array('security_subject_model', 'group_model', 'user_model'));
		$this->library('test_data');
		$this->test_data->registerUser();
		$this->library('session');
	}

	public function doTearDown() {
		$this->test_data->reset();
	}

	public function testGetCurrentSubjectsAnonymous() {
		$ss = $this->security_subject_model->getCurrentSubjects();
		$this->assertEquals($ss, array($this->security_subject_model->getAnonymousSubject()));
	}

	public function testGetCurrentSubjectsLoggedIn() {
		$this->session->set_userdata('user_id', $this->test_data->the_user->id);
		$this->session->set_userdata('email_address', $this->test_data->the_user->email_address);
		$this->session->set_userdata('password', $this->test_data->the_user->password);
		$ss = $this->security_subject_model->getCurrentSubjects();
		print_r($ss);
	}
}
