<?php defined('BASEPATH') or exit('No direct script access allowed');


function find_file($file, $path, $basepath = FCPATH) {
	$f = null;
	if(file_exists($file)) { // Test if the file exists
		$f = $file;
	} else if(file_exists($basepath.$path.$file)) { // Test if the file is exists in the static img folder
		$f = $basepath.$path.$file;
	}
	return $f;
}

function create_image_thumbnail($orig, $width, $height = 0) {
	$output_dir = 'application/cache/img/'.$width.'x'.$height.'/'; // All the thumbnails is located in cache

	$out_file = find_file($orig, $output_dir); // Try to find the file from output dir
	if($out_file != null) { // If the cached file is exists, return it
		return file_get_contents($out_file);
	}

	$file = find_file($orig, 'static/uploads/'); // Try to find the image in static/img
	if($file == null) { // We can't read the in uploads
		$file = find_file($orig, 'static/img/'); // Try to find the image in static/img
		if($file == null) // We can't read the file {
			return null;
	}
	if($width == 'normal')
		return file_get_contents($file);

	if(!file_exists($output_dir)) { // If the output dir is not exists, then create it
		mkdir($output_dir, 0777, true);
	}

	$path_parts = pathinfo($file);
	$name = $path_parts['filename'];
	$ext = $path_parts['extension'];
	$out_file = FCPATH.$output_dir.$name.'.'.$ext;

	if (extension_loaded('imagick')) {
		$img = new Imagick($file);
		$img->thumbnailImage($width, $height);
		$img->writeImage($out_file);
		return file_get_contents($out_file);
	}
	if (extension_loaded('gd')) {
		ci_log('Thumbnailing file %s using GD', $file);
		if($ext == 'jpg' || $ext == 'jpeg')
			$src_img=imagecreatefromjpeg($file);
		else
			$src_img=imagecreatefrompng($file);

		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
	
		if($height == 0) {
			$height = $old_y * $width / $old_x;
		}

		$dst_img=ImageCreateTrueColor($width,$height);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$width,$height,$old_x,$old_y);
		if($ext == 'jpg' || $ext == 'jpeg')
			imagejpeg($dst_img, $out_file);
		else
			imagepng($dst_img,$out_file);
		imagedestroy($dst_img);
		imagedestroy($src_img);
	}
	return null;
}
