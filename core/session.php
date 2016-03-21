<?php

class session
{
	
	public static function get($args){
		$name = $args->name;
		
		if(!is_array($name)){
			return $_SESSION[$name];
		}
	}
	
	public static function set($args){
		$name = $args->name;
		$value = $args->val;
		
		if(!is_array($name) && !is_array($value)){
			$_SESSION[$name] = $value;
		}
	}
	
	public static function unset($args){
		$name = $args->name;
		
		if(!is_array($name)){
			unset($_SESSION[$name]);
		}
	}
}
