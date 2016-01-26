<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('smarty_function_input')) {
	require_once(dirname(__FILE__).'/function.input.php');
}

function smarty_function_a($params, $template) {
	$uri = get_default($params, 'uri', '');
	$title = lang(get_default($params, 'title', ''));
	unset($params['uri']);
	return anchor($uri, $title, $params);
}
