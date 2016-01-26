<?php defined('BASEPATH') or exit('No direct script access allowed');

class NavigationTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->library(array('navigation','test_data'));
	}

	public function doTearDown() {
		$this->test_data->reset();
	}

	public function testGetNavigations() {
		$this->test_data->addAction();
		print_r($this->navigation->getNavigations());
	}
}
