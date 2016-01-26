<?php defined("BASEPATH") or exit("No direct script access allowed");

define("CONFIG_DIR", FCPATH.APPPATH.'config/');

/**
 * The class of Action object
 */
class Action {
	public $controller;
	public $method;
	public $group;
	public $logo;
	public $name;
	public $label;
    public $args;
	public $fields;

	public function data() {
		$arr = (array) $this;
		unset($arr['fields']);
		return (object) array_merge($arr, (array) $this->fields);
	}

	public function uri() {
		if(isset($this->controller) && isset($this->method))
			return site_url(strtolower($this->controller).'/'.$this->method.(isset($this->args) ? '/'.$this->args : ''));
		return '';
	}

	public function __get($key) {
		if(isset($this->$key))
			return $this->$key;

		if(gettype($this->fields) === 'string') {
			$this->fields = json_decode($this->fields);
		}

		if(isset($this->fields) && isset($this->fields->$key)) {
			return $this->fields->$key;
		}

		return null;
	}
}

function get_timestamp() {
	return strftime('%Y%m%d%H%M%S');
}

function humanize($count, $unit) {
	$result = $count.' '.$unit;
	if($count > 1)
		$result .= 's';
	return $result;
}

function rollover($arr) {
	return array_reduce($arr, function($carry, $item){
		for($i = 0; $i < count($item); $i++) {
			if(!isset($carry[$i]))
				$carray[$i] = array();
			$carry[$i] []= $item[$i];
		}
		return $carry;
	} ,array());
}
    

function parse_datetime($datetime, $default = null) {
	if(is_string($datetime)) {
		if($datetime != '')
			return new DateTime($datetime);
	}
	else {
		if(is_object($datetime) && get_class($datetime) == 'DateTime') {
			return $datetime;
		}
	}
	return $default;
}

function tokenize_time($begin, $end = null, $mode = 'day', $step = 1) {
	$i = DateInterval::createFromDateString(humanize($step, $mode));
	$result = array();

	$date = parse_datetime($begin);
	if($date == null) {
		// If we still can't find the begin date, make it 1 month ago
		$date = new DateTime();
		$date->sub(DateInterval::createFromDateString('1 month'));
	}

	$end = parse_datetime($end, new DateTime());

	while($date <= $end) {
		$tmp = clone $date;
		$result []= $tmp;
		$date->add($i);
	}

	if($result[count($result) -1] != $end) {
		$result []= $end;
	}
	return $result;
}

function get_request_url() {
	$CI = &get_instance();
	return implode('/', $CI->uri->rsegment_array());
}

function clear_breadscrum() {
	$CI = &get_instance();
	$CI->load->library('session');
	$CI->session->set_userdata('bread_scrums', array());
}

function get_breadscrums() {
	$CI = &get_instance();
	$CI->load->library('session');
	return $CI->session->userdata('bread_scrums');
}

function set_breadscrum() {
	$CI = &get_instance();
	if(isset($CI->action_model) && !$CI->action_model->getCurrentAction()) {
		return;
	}
	$CI->load->library('session');
	$scrums = get_breadscrums();

	if(count($scrums) && get_request_url() == $scrums[count($scrums) - 1])
		return;

	$scrums []= get_request_url();
	if(count($scrums) > get_ci_config('breadscrum_depth', 5)) {
		array_shift($scrums);
	}
	$CI->session->set_userdata('bread_scrums', $scrums);
}

function is_class($obj, $class) {
    return isset($obj) && is_object($obj) && get_class($obj) == $class;
}

function smarty_get_parent_tag($template) {
	if(isset($template->parent)) {
		$parent = $template->parent;
		return $parent->_tag_stack[count($parent->_tag_stack) - 2][0];
	}
	return '';
}

function stacktrace($level = 2) {
	$trace = debug_backtrace();
	for($i = 1; $i < $level; $i++) {
		$t = $trace[$i];
		ci_log('The trace is', $t);
	}
}

function ci_trace($msg = '') {
	$CI = &get_instance();
	$CI->trace($msg);
}
function ci_log() {
	$CI = &get_instance();
	call_user_func_array(array($CI, 'log'), func_get_args());
}
function ci_error() {
	$CI = &get_instance();
	call_user_func_array(array($CI, 'error'), func_get_args());
}
function is_regex($str) {
	return preg_match('/^\/.*\//', $str);
}

function dump_s($obj) {
	ob_start();
	var_dump($obj);
	$contents = ob_get_contents();
	ob_end_clean();
	return $contents;
}

function create_tag($tagname = 'div', $attr = array(), $defaults = array(), $text = null) {
	$CI = &get_instance();
	$CI->load->helper('form');
	foreach($attr as $k => $v) { // Support array in the value, especially for class
		if(is_array($v)) {
			$attr[$k] = implode(' ', $v);
		}
	}
	if($text === null) {
		return '<'.$tagname.' '._parse_form_attributes($attr, $defaults). ' />';
	}
	else {
		return '<'.$tagname.' '._parse_form_attributes($attr, $defaults).'>'.$text.'</'.$tagname.'>';
	}
}

function get_controller_meta() {
	$action = new Action();
	$action->controller = get_controller_class();
	$action->method = get_controller_method();
	$action->args = get_controller_args();
	return $action;
}

function get_controller_args() {
	$CI = &get_instance();
	return array_slice($CI->uri->rsegments, 2);
}

function get_controller_class() {
	$CI = &get_instance();
	return get_class($CI);
}

function get_controller_method() {
	$CI = &get_instance();
	$method = $CI->uri->rsegment(2);
	if($method == '' || $method == null)
		$method = 'index';
	return $method;
}

function guess_lang() {
	$CI = &get_instance();

	// Check for the cookie first
	$lang = $CI->input->cookie('pinet_language');

	if($lang != '') { // If have the cookie, use it
		return $lang;
	}

	// Guess the language from the browser's accept language head
	$langs = array();
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		// break up string into pieces (languages and q factors)
		preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

		if (count($lang_parse[1])) {
			// create a list like "en" => 0.8
			$langs = array_combine($lang_parse[1], $lang_parse[4]);
			
			// set default to 1 for any without q factor
			foreach ($langs as $lang => $val) {
				if ($val === '') $langs[$lang] = 1;
			}

			// sort list based on value	
			arsort($langs, SORT_NUMERIC);
		}
	}

	// look through sorted list and use first one that matches our languages
	foreach ($langs as $lang => $val) {
		if (strpos($lang, 'de') === 0) {
			// show German site
		} else if (strpos($lang, 'en') === 0) {
			// show English site
		} 
	}
	foreach($langs as $key => $value) {
		if($value == 1) {
			// Try to translate the language to CI one
			switch(strtolower($key)) {
			case 'en-us':
				return 'english';
			case 'zh-cn':
				return 'chinese';
			default:
				return get_default_lang();
			}
			return $key;
		}
	}
	return null;
}

function get_translated_lang(){
    switch(get_lang()){
        case 'english':
            return 'en-US';
        case 'chinese':
            return 'zh-CN';
    }
}

function get_lang() {
	$lang = guess_lang();
	if($lang != null)
		return $lang;
	return get_default_lang();
}

function get_default_lang() {
	return get_ci_config('language');
}

function get_smarty_variable($params, $template, $name, $default = null) {
	if(strpos($name, '$') !== false) {
		$src = str_replace('$', '', $name); // Try to remove the $ in the name
		$parent_vars = $template->parent->tpl_vars; // If not found, try to get the variable from parent
		$t = get_default($parent_vars, $src, '');
		if($t != '')
			return $t;
	}
	$t = get_default($params, $name, ''); // Try to get the variable from parameters first
	if($t != '')
		return $t;
	return $default;
}

function if_not_exists_then_create_dir($dir) {
    if(!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}

function write_to_file($content, $filename) {
	$fp = fopen($filename, 'w');
	fwrite($fp, $content);
	fclose($fp);
}

function get_image_size($src) {
	$CI = &get_instance();
	$CI->load->helper('image');

	$file = find_file($src, 'static/img/'); // Try to find the image in static/img
	if($file == null) {// We can't read the file
        $file = find_file($src, 'static/uploads/');
        if($file == null) {
            trigger_error('The responsive image can\'t be found');
            return '';
        }
	}

	if (extension_loaded('imagick')) {
		$img = new Imagick($file);
		return $img->getImageGeometry(); 
	}
	if (extension_loaded('gd')) {
		$path_parts = pathinfo($file);
		$ext = $path_parts['extension'];
		if($ext == 'jpg' || $ext == 'jpeg')
			$src_img=imagecreatefromjpeg($file);
		else
			$src_img=imagecreatefrompng($file);
		return array(
			'width' => imageSX($src_img), 
			'height' => imageSY($src_img));
	}
	return array(0, 0);
}

function smarty_plugin_get_variable($params, $template, $name, $required = false) {
	$name = get_default($params, $name, '');
	if($name == '' && $required) {
		trigger_error('The '.$name.' parameter must be set!');
		return '';
	}
	return get_smarty_variable($params, $template, $name, $name);
}

function get_ci_config($name, $default = null) {
	$CI = &get_instance();
	$item = $CI->config->item($name);
	if($item)
		return $item;
	return $default;
}

function build_tag($tag, $params, $content) {
	$attr = array();
	foreach($params as $key => $value) {
		$attr[$key] = $value;
	}
	$ret = array();
	$ret []= '<'.$tag.' '._parse_form_attributes($attr, array()).'>';
	$ret []= $content;
	$ret []= '</'.$tag.'>';
	return implode("\n", $ret);
}

function get_default($arr, $key, $default = '') {
	return isset($arr[$key])? $arr[$key]: $default;
}

function copy_new($src, $class = null) {
	return copy_object($src, null, $class);
}

function copy_arr($src, $dest = null) {
	if($src == null)
		return null;

	if($dest == null) {
		$dest = array();
	}

	foreach($src as $key => $value) {
		$dest[$key] = $value;
	}
	return $dest;
}

function copy_object($src, $dest = null, $class = null) {
	if($src == null)
		return null;

	if($dest == null) {
		if($class == null)
			$dest = new stdclass();
		else
			$dest = new $class();
	}

	foreach($src as $key => $value) {
		$k = str_replace('.', '_', $key);
		$dest->$k = $value;
	}
	return $dest;
}

function insert_at($array, $item, $index) {
	if(gettype($item) === 'object') {
		array_splice( $array, $index, 0, array($item) );
	}
	else {
		array_splice( $array, $index, 0, $item );
	}
	return $array;
}

function copyArray2Obj($src, $dest) {
	foreach($src as $key=>$value) {
		$dest->$key = $value;
	}
}


function obj2array ( &$Instance ) {
    $clone = (array) $Instance;
    $rtn = array ();
    $rtn['___SOURCE_KEYS_'] = $clone;

    while ( list ($key, $value) = each ($clone) ) {
        $aux = explode ("\0", $key);
        $newkey = $aux[count($aux)-1];
        $rtn[$newkey] = &$rtn['___SOURCE_KEYS_'][$key];
    }

    return $rtn;
}

function make_classes() {
	 $arg_list = func_get_args();
	 $ret = array();
	 foreach($arg_list as $c) {
		 if(is_string($c) && $c != '')
			 $ret[] = array($c);
		 else if(is_array($c))
			 $ret []= $c;
	 }
	 return call_user_func_array('combine_and_unique_arrays', $ret);
}

function combine_arrays() {
	 $numargs = func_num_args();
	 if($numargs < 1)
		 return array();

	 $arg_list = func_get_args();

	 if($numargs == 1)
		 return $arg_list[0];

	 $ret = array();

	 foreach($arg_list as $arg) {
		 if(is_array($arg)) {
			 foreach($arg as $e) {
				 $ret []= $e;
			 }
		 }
	 }
	 return $ret;
}

function combine_and_unique_arrays() {
	$arr = call_user_func_array('combine_arrays', func_get_args());
	$arr = array_unique($arr);
	sort($arr);
	return $arr;
}

function combine_karrays() {
	$numargs = func_num_args();
	if($numargs < 1)
		return array();

	$arg_list = func_get_args();

	if($numargs == 1)
		return $arg_list[0];

	$ret = array();

	foreach($arg_list as $arg) {
		if(is_array($arg)) {
			foreach($arg as $k=>$e) {
				$ret [$k]= $e;
			}
		}
	}
	return $ret;
}

function to_yes($bool) {
    if($bool)
        return 'yes';
    else
        return 'no';
}

function get_upload_path($folder) {
    $upload_path = './uploads/'.$folder;
    if_not_exists_then_create_dir($upload_path);
    return $upload_path;
}

function get_upload_config($folder) {
    $config = array();
    $config['upload_path'] = get_upload_path($folder);
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '1000';
    $config['max_width']  = '1024';
    $config['max_height']  = '768';
    return $config;
}

function send_admin_email($to, $subject, $message, $attachments = array(), $mail_type = 'qq'){
    $CI = &get_instance();
    $CI->config->load('email_settings');
    $CI->load->library('email');
    $config = get_ci_config('email_settings');
    if($config){
        $email_config = $config[$mail_type];
        $from = $config['admin_info']['from'];
        $name = $config['admin_info']['name'];
        $CI->email->initialize($email_config);
        $CI->email->from($from, $name);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);
        foreach($attachments as $attachment){
            $CI->email->attach($attachment);
        }
        $CI->email->send();
    }
}


/**
 * Builds the request string.
 *
 * The files array can be a combination of the following (either data or file):
 *
 * file => "path/to/file", filename=, mime=, data=
 *
 * @param array params		(name => value) (all names and values should be urlencoded)
 * @param array files		(name => filedesc) (not urlencoded)
 * @return array (headers, body)
 */
function encodeBody ( $params, $files )
{
    $headers  	= array();
    $body		= '';
    $boundary	= 'OAuthRequester_'.md5(uniqid('multipart') . microtime());
    $headers['Content-Type'] = 'multipart/form-data; boundary=' . $boundary;


    // 1. Add the parameters to the post
    if (!empty($params))
    {
        foreach ($params as $name => $value)
        {
            $body .= '--'.$boundary."\r\n";
            $body .= 'Content-Disposition: form-data; name="'.$name.'"';
            $body .= "\r\n\r\n";
            $body .= urldecode($value);
            $body .= "\r\n";
        }
    }

    // 2. Add all the files to the post
    if (!empty($files))
    {
        $untitled = 1;

        foreach ($files as $name => $f)
        {
            $data     = false;
            $filename = false;

            if (isset($f['filename']))
            {
                $filename = $f['filename'];
            }

            if (!empty($f['file']))
            {
                $data = @file_get_contents($f['file']);
                if ($data === false)
                {
                    trigger_error(sprintf('Could not read the file "%s" for form-data part', $f['file']));
                }
                if (empty($filename))
                {
                    $filename = basename($f['file']);
                }
            }
            else if (isset($f['data']))
            {
                $data = $f['data'];
            }

            // When there is data, add it as a form-data part, otherwise silently skip the upload
            if ($data !== false)
            {
                if (empty($filename))
                {
                    $filename = sprintf('untitled-%d', $untitled++);
                }
                $mime  = !empty($f['mime']) ? $f['mime'] : 'application/octet-stream';
                $body .= '--'.$boundary."\r\n";
                $body .= 'Content-Disposition: form-data; name="'.rawurlencode($name).'"; filename="'.rawurlencode($filename).'"'."\r\n";
                $body .= 'Content-Type: '.$mime;
                $body .= "\r\n\r\n";
                $body .= $data;
                $body .= "\r\n";
            }

        }
    }
    $body .= '--'.$boundary."--\r\n";

    $headers['Content-Length'] = strlen($body);
    return array($headers, $body);
}

function read_config_file($file) {
	if(file_exists(CONFIG_DIR.$file)) {
		return file_get_contents(CONFIG_DIR.$file);
	}
	return null;
}
