<?php defined('BASEPATH') or exit('No direct script access allowed');


function smarty_block_sect($params, $content = '', $template, &$repeat) {
	if($repeat)
		return;
	return build_tag('section', $params, $content);
}
