<?php

class zlib
{
	
	public static function unzip($args){
		
		$sorce = $args->from;
		$dest = $args->to;

		$fp=fopen($sorce,'rb');  
		$uncompresscontents = fread($fp,filesize($sorce));  
		fclose($fp);  

		$uncompressing = gzuncompress($uncompresscontents);  

		$fp = fopen($dest, 'wb');  
		fwrite($fp, $uncompressing);  
		fclose($fp);
		
	}
	
	public static function zip($args){
		
		$sorce = $args->from;
		$dest = $args->to;

		$fp=fopen($sorce,'rb');  
		$compresscontents = fread($fp,filesize($sorce));  
		fclose($fp);  

		$compressing = gzcompress($compresscontents);  

		$fp = fopen($dest, 'wb');  
		fwrite($fp, $compressing);  
		fclose($fp);
		
	}
	
}
?>
