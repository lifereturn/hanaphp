<?php

class cookie
{
	public static function get($args){
		$name = $args->name;
		
		if(!is_array($name)){
			return $_COOKIE[$name];
		}
	}
	
	public static function set($args){
		$name = $args->name;
		$value = $args->val;
		$encode = $args->encode;
		$expired = $args->exp;
		settype($encode,"boolean");
		settype($expired,"integer");
		
		if(!is_array($name) && !is_array($value)){
			if(isset($encode)){
				if($encode == TRUE){
					if(isset($expired)){
						setrawcookie($name,$value,$expired);
					}elseif(!isset($expired)){
						setrawcookie($name,$value);
					}
				}elseif($encode == FALSE){
					if(isset($expired)){
					setcookie($name,$value,$expired);
					}elseif(!isset($expired)){
						setcookie($name,$value);
					}
				}
			}else{
				if(isset($expired)){
					setcookie($name,$value,$expired);
				}elseif(!isset($expired)){
					setcookie($name,$value);
				}
			}
		}
	}
	
	public static function unset($args){
		$name = $args->name;
		
		if(!is_array($name)){
			unset($_COOKIE[$name]);
		}
	}
}
