<?php defined("BASEPATH") or exit("No direct script access allowed");

if(!function_exists('smarty_function_picture')) {
	require_once(dirname(__FILE__).'/function.picture.php');
}

function smarty_function_action($params, $template) {
	$action = get_default($params, 'obj', null);
	$alt = get_default($params, 'alt', '');
	if($action == null) {
		trigger_error('The obj parameter is required for action!');
		return '';
	}

	if(gettype($action) != 'object' || get_class($action) != 'Action') {
		trigger_error('The obj parameter must be of Class Action!');
		return '';
	}

    $fields = json_decode($action->fields);
	ci_log('The action to show is', $action);
	$data = array();
	$uri = $action->uri();
	if($uri)
		$data['href'] = $uri;
	$content = lang($action->label);
	if(isset($action->logo) && $action->logo != '') {
		$data = array(
			'src'=>$action->logo, 
			'path'=>'/responsive/size',
			'data-toggle'=>'tooltip',
			'data-placement'=> isset($fields->placement) ? $fields->placement : 'right',
			'data-original-title'=> $action->label
		);
		$CI = &get_instance();
		$CI->load->helper('image');

		$file = find_file($data['src'], 'static/img/'); // Try to find the image in static/img
		if($file == null) {// We can't read the file
			$data['src'] = 'default.png';
		}

		$content = smarty_function_picture($data, $template);
        if(isset($action->controller) && isset($action->method) && $uri){
            $data['href'] = $uri;
        }
	}
	return build_tag('a', $data, $content);
}
