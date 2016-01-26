<?php defined('BASEPATH') or exit('No direct script access allowed');

class CurlTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->CI =& get_instance();
		$this->CI->load->spark('curl/1.3.0');
	}

	public function testCurl() {
		$this->assertTrue($this->CI->curl != null);
	}
}
