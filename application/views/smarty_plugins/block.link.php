<?php defined('BASEPATH') or exit('No direct script access allowed');


if(!function_exists('smarty_function_input')) {
	require_once(dirname(__FILE__).'/function.input.php');
}

function smarty_block_link($params, $content = '', $template, &$repeat) {
	if($repeat)
		return;
	$uri = get_default($params, 'uri', '');
	unset($params['uri']);
	return anchor($uri, $content, $params);
}
