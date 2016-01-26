<?php defined("BASEPATH") or exit("No direct script access allowed");

class Responsive extends Pinet_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('image');
	}

	public function size($size, $img) {
		$path = $img;
		if(func_num_args() > 2) {
			$arr = func_get_args();
			array_shift($arr);
			$path = implode('/', $arr);
		}

		$path_parts = pathinfo($path);
		switch($path_parts['extension']){
		case 'png':
			header('Content-Type: image/png');
			break;
		case 'jpg':
			header('Content-Type: image/jpeg');
			break;
		case 'gif':
			header('Content-Type: image/gif');
			break;
		case 'ico':
			header('Content-Type: image/ico');
			break;
		}
		echo create_image_thumbnail($path, $size);
	}
}
