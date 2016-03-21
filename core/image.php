<?php

class image
{
	
	public static function ignore_warning(){
		ini_set('gd.jpeg_ignore_warning', true);
	}
	
	public static function getPictureWidth($file)
	{
		$imageInfo = getimagesize($file);
		if ($imageInfo['mime'] == ("image/png"))
		{
			$img = imagecreatefromjpeg($file);
			$width = imagesx($img);
		}
		elseif($imageInfo['mime'] == ("image/jpeg"))
		{
			$img = imagecreatefromjpeg($file);
			$width = imagesx($img);
		}
		elseif($imageInfo['mime'] == ("image/png"))
		{
			$img = imagecreatefrompng($file);
			$width = imagesx($img);
		}
		
		return $width;
	}
	
	public static function thumbnail($args){
		
		$info = pathinfo($pathToImages);
		
		if(strtolower($info['extension']) == 'jpg'){
			$img = imagecreatefromjpeg($pathToImages);
		}elseif(strtolower($info['extension']) == 'png'){
			$img = ImageCreateFromPNG($pathToImages);
		}
	
		$width = imagesx($img);
		$height = imagesy($img);

		$new_width = $thumbWidth;
		
		if($thumbHeight=="0"){
			$new_height = floor($height*($thumbWidth/$width));
		}else{
			$new_height = $thumbHeight;
		}
		
		$tmp_img = imagecreatetruecolor($new_width, $new_height);

		imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		if(strtolower($info['extension']) == 'jpg'){
			imagejpeg($tmp_img, $pathToThumbs);
		}elseif(strtolower($info['extension']) == 'png'){
			ImagePng($tmp_img, $pathToThumbs);
		}
	}
	
}
