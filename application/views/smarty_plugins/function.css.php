<?php defined('BASEPATH') or exit('No direct script access allowed');

function smarty_function_css($params, $template) {
	$CI = &get_instance();
	foreach($CI->cssFiles as $css) {
		echo $css->render();
	}
}