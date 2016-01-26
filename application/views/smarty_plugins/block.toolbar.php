<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('smarty_block_container')) {
	require_once(dirname(__FILE__).'/block.container.php');
}

function smarty_block_toolbar($params, $content = '', $template, &$repeat) {
	if($repeat) { // This is the start part
		add_container($params, $template, 'toolbar');
		return;
	}
	$params['id'] = get_default($params, 'id', 'toolbar');
	$classes = get_default($params, 'class', array());
	if(is_string($classes)) {
		$classes = explode(' ', $classes);
	}
	$classes []= 'toolbar';
	$classes []= 'pinet_toolbar';
	$params['class'] = implode(' ', $classes);
	return build_tag('div', $params, $content);
}
