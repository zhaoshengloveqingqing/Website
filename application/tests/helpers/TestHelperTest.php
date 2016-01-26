<?php defined('BASEPATH') or exit('No direct script access allowed');

class TestHelperTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->CI =& get_instance();
		$this->CI->load->helper(array('test', 'email'));
	}

	public function testChoice() {
		$a = array(1,2,3,4);
		$r = choice($a);
		echo $r;
		$this->assertTrue(array_search($r, $a) !== FALSE);
	}

	public function testFakeName() {
		$name = fake_name();
		$this->assertTrue($name != null);
		$this->assertTrue($name->simple_name != null);
		$this->assertTrue($name->first_name != null);
		$this->assertTrue($name->last_name != null);
	}

	public function testFakeEmail() {
		$email = fake_email();
		$this->assertTrue(valid_email($email));
	}

	public function testFakeUser() {
		$user = fake_user();
		$this->assertEquals($user->id, 1000);
		$this->assertTrue($user->email_address != null);
	}

	public function testNTimes() {
		$the_count = 10;
		$n = n_times($the_count, 'fake_user');
		$this->assertEquals($the_count, count($n));
	}

	public function testFakeIP() {
		$this->assertTrue($this->CI->input->valid_ip(fake_ip()));
	}

	public function testFakeGateway() {
		$the_user_id = 1;
		$gateway = fake_gateway($the_user_id);
		$this->assertEquals($gateway->owner_id, $the_user_id);
		$this->assertNotNull($gateway->name);
		$this->assertNotNull($gateway->serial);
		$this->assertNotNull($gateway->mac);
		$this->assertNotNull($gateway->ip);
	}

	public function testFakeUserAgetn() {
		$this->assertNotNull(fake_uagent());
	}
}
