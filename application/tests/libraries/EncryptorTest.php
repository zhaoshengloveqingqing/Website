<?php defined("BASEPATH") or exit("No direct script access allowed");

class EncryptorTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->library('encryptor');
	}

	public function testEncrypt() {
		$text = 'test';
		$result = $this->encryptor->encrypt($text);
		echo $result;
		echo "\n";
		$decrypted = $this->encryptor->decrypt($result);
		$this->assertEquals($text, $decrypted);
	}
}
