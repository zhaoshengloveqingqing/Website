<?php defined('BASEPATH') or exit('No direct script access allowed');


class DataTableModelTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->model('datatable_model');
	}

	public function doTearDown() {
	}

	public function testReadingFromJSON() {
		$this->datatable_model->init();
		$this->assertNotNull($this->datatable_model->columns);
		echo json_encode($this->datatable_model);
	}
}
