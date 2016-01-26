<?php defined("BASEPATH") or exit("No direct script access allowed");

class ListView {
	public function __construct() {
		$CI = &get_instance();
		$CI->jquery_listview();
		$CI->load->library('datatable');
		$js = 'window.listview_conf = '.str_replace('\/', '/', json_encode($CI->datatable_model)).";\n";
		$js .= "$('ul#listview').listview(window.listview_conf);";
		$CI->initJS($js);
	}
}
