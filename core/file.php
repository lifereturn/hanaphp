<?php

class file
{
	public static function json_file_get($args){
		$file = $args->from;
		$target = $args->target;
		$item = $args->item;
		
		$args_json = va::args();
		$args_json->from = $file;
		$json = file::get($args_json);
		$json = json_decode($json);
		foreach($json->$target as $key=>$val){
			echo $val->$item.".";
		}
	}

	public static function get($args){
		
		$fname = $args->from;
		
		if(file_exists($fname) && is_file($fname)){
			$proc_file = fopen($fname, 'r');
			$output = fread($proc_file, filesize($fname));
			fclose($proc_file);
			return $output;
		}else{
			return FALSE;
		}
	}
	
	public static function chk_ext($args)
	{
		
		/*$string = $args->str;
		//multi ext filter = jpg|jpeg|png|gif
		$ext = $args->ext;
		
		if(preg_match('/\.('.$ext'.)(?:[\?\#].*)?$/i', $string, $matches)){
			return TRUE;
		}else{
			return FALSE;
		}*/
	}

	public static function filesize($args)
	{
		
		$file = $args->filesize;
		
		$bytes = filesize($file);
		
		if ($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		}
		elseif ($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		}
		elseif ($bytes > 1)
		{
			$bytes = $bytes . ' bytes';
		}
		elseif ($bytes == 1)
		{
			$bytes = $bytes . ' byte';
		}
		else
		{
			$bytes = '0 bytes';
		}

		return $bytes;
	}

	/**
	 * remove file
	 *
	 * @param  string/array args->path
	 *
	 * @return pdo
	 */
	public static function remove($args){
		
		//args
		$path = $args->path;
		
		//remove single file
		if(!is_array($path)){
			if(file_exists($path)){
				if(!unlink($path)){
					return FALSE;
				}
			}
		}else{
		//remove array file
			foreach($path as $val){
				if(file_exists($val)){
					if(!unlink($val)){
						return FALSE;
					}
				}
			}
		}
		return TRUE;
	}
	
	/**
	 * copy file
	 *
	 * @param  string/array args->from
	 * @param  string/array args->to
	 *
	 * @return pdo
	 */
	public static function copy($args){
		
		//variables
		$arr_dest = array();
		$input = NULL;
		$index = NULL;
		
		//args
		$source = $args->from;
		$dest = $args->to;
		
		//copy single file
		if(!is_array($source) && !is_array($dest)){
			if(file_exists($source) && !file_exists($dest)){
				if(!copy($source, $dest)){
					return FALSE;
				}
			}
			
		//copy multi file
		}elseif(is_array($source) && is_array($dest)){
			foreach($source as $index=>$input){
				$arr_dest = $dest[$index];
				if(file_exists($input) && !file_exists($arr_dest)){
					if(!copy($input, $arr_dest)){
						return FALSE;
					}
				}
			}
		}
	}
	
	/**
	 * move(rename) file
	 *
	 * @param  string/array args->from
	 * @param  string/array args->to
	 *
	 * @return pdo
	 */
	public static function move($args){
		
		//variabless
		$arr_dest = array();
		
		//args
		$source = $args->from;
		$dest = $args->to;
		
		//single
		if(!is_array($source) && !is_array($dest)){
			rename($source, $dest);
			
		//array
		}elseif(is_array($source) && is_array($dest)){
			
			//check array
			if(count($source)!=count($dest)){
				return FALSE;
			}
			
			foreach($source as $index=>$val){
				$arr_dest = $dest[$index];
				rename($val, $arr_dest);
			}
		}
	}
	
	/**
	 * put file
	 *
	 * @param  string/array args->target
	 * @param  string/array args->content
	 *
	 * @return pdo
	 */
	public static function put($args){
		
		//variables
		$proc_file = NULL;
		$input = NULL;
		$target = NULL;
		$index = NULL;
		$arr_fname = array();
		
		//args
		$fname = $args->target;
		$content = $args->content;
		$seek = $args->seek;
		$is_append = $args->append;
		$sort_input = $args->sort;
		if(!isset($sort_input)){
			$sort_input = TRUE;
		}
		
		//set variable type
		settype($seek,"integer");
		settype($is_append,"boolean");
		settype($sort_input,"boolean");
	
		//not array | not array
		if(!is_array($fname) && !is_array($content)){
			
			//write single content
			if(!is_array($content)){
				
				//append
				if($is_append==TRUE){
					$proc_file = fopen($fname, 'a');
				}elseif($is_append==FALSE){
					$proc_file = fopen($fname, 'w');
				}
				
				//seek
				if(isset($seek)){
					fseek($proc_file,$seek,SEEK_SET);
				}
				
				fwrite($proc_file, $content);
				fclose($proc_file);
			
			//write array content
			}elseif(is_array($content)){
				foreach($content as $input){
					
					//append
					if($is_append==TRUE){
						$proc_file = fopen($fname, 'a');
					}elseif($is_append==FALSE){
						$proc_file = fopen($fname, 'w');
					}
				
					//seek
					if(isset($seek)){
						fseek($proc_file,$seek,SEEK_SET);
					}
				
					fwrite($proc_file, $input);
					fclose($proc_file);
				}
			}
			
		//array | array
		}elseif(is_array($fname) && is_array($content)){
			
			if(isset($sort_input)){
				
				//sort
				if($sort_input == TRUE){
					foreach($content as $index=>$input){
						
						$arr_fname = $fname[$index];
						
						//append
						if($is_append==TRUE){
							$proc_file = fopen($arr_fname, 'a');
						}elseif($is_append==FALSE){
							$proc_file = fopen($arr_fname, 'w');
						}
						
						//seek
						if(isset($seek)){
							fseek($proc_file,$seek,SEEK_SET);
						}
				
						fwrite($proc_file, $input);
						fclose($proc_file);
					}
					
				//no sort
				}elseif($sort_input == FALSE){
					foreach($fname as $index=>$target){
						
						//append
						if($is_append==TRUE){
							$proc_file = fopen($target, 'a');
						}elseif($is_append==FALSE){
							$proc_file = fopen($target, 'w');
						}
						
						//array input
						foreach($content as $index2=>$input){
							
							//seek
							if(isset($seek)){
								fseek($proc_file,$seek,SEEK_SET);
							}
							
							fwrite($proc_file, $input);
						}
						
						fclose($proc_file);
					}
				}
			}
			
		//not array | array
		}elseif(!is_array($fname) && is_array($content)){
			foreach($content as $index=>$input){
				
				//append
				if($is_append==TRUE){
					$proc_file = fopen($fname, 'a');
				}elseif($is_append==FALSE){
					$proc_file = fopen($fname, 'w');
				}
				
				//seek
				if(isset($seek)){
					fseek($proc_file,$seek,SEEK_SET);
				}
				
				fwrite($proc_file, $input);
				fclose($proc_file);
			}
		}
	}
	
	/**
	 * last modified time
	 *
	 * @param  string args->from
	 *
	 * @return string
	 */
	public static function last($args){
		
		//args
		$name = $args->name;
		
		return fileatime($filename);
	}
	
	/**
	 * filesize
	 *
	 * @param  string args->from
	 *
	 * @return string
	 */
	public static function upload($args){
		
		//args
		$source = $args->from;
		$dest = $args->to;
		$sort_input = $args->sort;
		if(!isset($sort_input)){
			$sort_input = TRUE;
		}
		
		//single
		if(!is_array($source) && !is_array($dest)){
			return move_uploaded_file($source["tmp_name"], $dest);
		
		//array
		}elseif(is_array($source) && is_array($dest)){
			
			//check array
			if(count($souce)!=count($dest)){
				return FALSE;
			}
			
			foreach($source as $index=>$input){
				
				//sort
				if($sort_input == TRUE){
					$arr_dest = $dest[$index];
					move_uploaded_file($input["tmp_name"][$index], $arr_dest);
					
				//no sort
				}elseif($sort_input == FALSE){
					foreach($dest as $index2=>$input2){
						move_uploaded_file($input["tmp_name"][$index], $input2);
					}
				}
				
			}
			
		}
	}
	
	/**
	 * filesize
	 *
	 * @param  string args->from
	 *
	 * @return string
	 */
	public static function size($args){
		
		//args
		$name = $args->from;
		
		return filesize($name);
	}
	
	/**
	 * filetype
	 *
	 * @param  string args->from
	 *
	 * @return string
	 */
	public static function type($args){
		
		//args
		$name = $args->from;
		
		return filetype($name);
	}
	
	/**
	 * is_file
	 *
	 * @param  string args->from
	 *
	 * @return string
	 */
	public static function check($args){
		
		//args
		$name = $args->from;
		
		return is_file($name);
	}
	
	/**
	 * file_exist
	 *
	 * @param  string args->from
	 *
	 * @return string
	 */
	public static function exist($args){
		
		//args
		$name = $args->from;
		
		return file_exists($name);
	}
	
	/**
	 * get basename
	 *
	 * @param  string args->path
	 *
	 * @return string
	 */
	public static function root($args){
		
		//variables
		$$arr_path = array();
		
		//args
		$path = $args->path;
		
		//single
		if(!is_array($path)){
			return basename($path);
		
		//array
		}elseif(is_array($path)){
			$arr_path = NULL;
			foreach($path as $index=>$value){
				$arr_path .= $value;
			}
			return $arr_path;
		}
	}
	
	public static function download($url, $path){
		$newfname = $path;
		$file = fopen ($url, 'rb');
		if ($file) {
			$newf = fopen ($newfname, 'wb');
			if ($newf) {
				while(!feof($file)){
					fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
				}
			}
		}
		if ($file) {
			fclose($file);
		}
		if ($newf) {
			fclose($newf);
		}
	}

}
