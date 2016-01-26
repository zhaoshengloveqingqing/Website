<?php defined('BASEPATH') or exit('No direct script access allowed');

function smarty_function_navigation($params, $template) {
	$CI = &get_instance();
	if(isset($CI->navigation)) { // We can only work when the navigation library is loaded
		$navigations = $CI->navigation->getNavigations();
	}
}
