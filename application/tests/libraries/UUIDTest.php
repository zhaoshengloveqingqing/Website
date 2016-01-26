<?php defined('BASEPATH') or exit('No direct script access allowed');

class UUIDTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->CI =& get_instance();
		$this->CI->load->library('uuid');
	}

	public function testUUID() {
		$this->assertNotNull($this->CI->uuid->get());
	}
}
