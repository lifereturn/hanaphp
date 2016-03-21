<?php

class request
{
	
	public static function move($args){
		$location = $args->location;
		header("Location: ".$location);
	}
	
	public static function obclean($args){
		 while (ob_get_level()) {
			ob_end_clean();
		}
	}
	public static function get_req_post(){
		if($_SERVER['REQUEST_METHOD']==="POST"){
			$arr = array();
			foreach($_POST as $key=>$val){
				$arr[$key] = $val;
			}
			return $arr;
		}
	}
	
	public static function get_req_get(){
		if($_SERVER['REQUEST_METHOD']==="GET"){
			$arr = array();
			foreach($_GET as $key=>$val){
				$arr[$key] = $val;
			}
			return $arr;
		}
	}
	
	public static function set_srl(){
		$var = $args->srl;
		return serialize($var);
	}
	
	public static function unset_srl(){
		$var = $args->srl;
		return unserialize($var);
	}
	
	public static function get_header(){
		return $http_response_header;
	}
	
	public static function get_lang(){
		return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	}
	
	public static function get_ip(){
		return $_SERVER['REMOTE_ADDR'];
	}
	
	public static function is_ajax(){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public static function can_foreach($args){
		$array = $args->array;
		if($array instanceof \Traversable){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public static function get_sign(){
		return $_SERVER['SERVER_SIGNATURE'];
	}
	
	public static function get_agent(){
		return $_SERVER['HTTP_USER_AGENT'];
	}
	
	public static function get_root(){
		return $_SERVER['DOCUMENT_ROOT'];
	}
	
	public static function get_req_method(){
		return $_SERVER['REQUEST_METHOD'];
	}
	
}
