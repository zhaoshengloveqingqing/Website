<?php defined("BASEPATH") or exit("No direct script access allowed");

class Page extends Pinet_Controller {

	public function __construct() { 
		parent::__construct();
        $this->jquery();
	}

	public function index($path, $page='') {
		if(func_num_args() > 2) {
			$arr = func_get_args();
			$page = implode('/', $arr);
		}
		ci_log($page);
        if($page)
            $path .= '/'.$page;
		$this->render($path, array());
	}
}
