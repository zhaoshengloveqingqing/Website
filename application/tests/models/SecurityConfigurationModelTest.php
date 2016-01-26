<?php defined("BASEPATH") or exit("No direct script access allowed");

class SecurityConfigurationModelTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->model('security_configuration_model', 'scm');
	}

	public function testGetAllMatch() {
		$all = $this->scm->getAllMatch();
		$this->assertEquals($all->type, 'action');
		$this->assertEquals($all->controller, '*');
		$this->assertEquals($all->method, '*');
	}

	public function testGetCurrentConfigurationsNone() {
		$all = $this->scm->getCurrentConfigurations();
		$this->assertEquals(count($all), 1);
	}

	public function testGetCurrentConfigurationsExact() {
		$this->scm->addConfig(array(
			'type' => 'action',
			'controller' => 'Welcome',
			'method' => 'index'
		));
		$all = $this->scm->getCurrentConfigurations();
		$this->assertEquals(count($all), 2);
		$last = $all[1];
		$this->assertEquals($last->method, 'index');
	}

	public function testGetCurrentConfigurationsComplex() {
		$this->scm->addConfig(array(
			'type' => 'action',
			'controller' => 'Welcome',
			'method' => 'index'
		));
		$this->scm->addConfig(array(
			'type' => 'action',
			'controller' => '*',
			'method' => 'index'
		));
		$this->scm->addConfig(array(
			'type' => 'action',
			'controller' => 'Welcome',
			'method' => '/.*/'
		));
		$all = $this->scm->getCurrentConfigurations();
		$this->assertEquals(count($all), 4);
	}

	public function doTearDown() {
		$this->scm->clear();
	}
}
