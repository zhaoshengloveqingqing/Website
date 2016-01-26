<?php defined('BASEPATH') or exit('No direct script access allowed');

class InterceptorSupportTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->CI =& get_instance();
		$this->CI->load->library('interceptor_support');
	}

	public function testBuildInterceptorConfig() {
		$ret = $this->CI->interceptor_support
			->buildInterceptorConfig(get_class($this->CI));
		$this->assertNotNull($ret);
	}

	public function testGetInterceptors() {
		$ret = $this->CI->interceptor_support
			->getInterceptors();
		$this->assertNotNull($ret);
		var_dump($ret);
	}
}
