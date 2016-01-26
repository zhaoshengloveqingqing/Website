<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('smarty_function_input')) {
	require_once(dirname(__FILE__).'/function.function.input.php');
}

function smarty_block_select($params, $content, $template, &$repeat) {
	if($repeat) // Skip the first time
		return;

	$attr = get_attr($params, $template);
	$options = get_default($params, 'options', array());
	$selected = get_default($params, 'selected', array());
	$extra = _parse_form_attributes($attr, array());
	if(count($selected) == 0)
		$selected = $attr['value'];
	return form_dropdown($attr['name'], $options, $selected, $extra);
}
