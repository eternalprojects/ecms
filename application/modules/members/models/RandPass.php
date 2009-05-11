<?php


class RandPass{
	final public static function generatePass($length = 8){
		$password = '';
		$validChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_@%&[]";
 		for($i=$length;$i>0;$i--) {
    			$password .= substr($validChars, (mt_rand()%(strlen($validChars))), 1);
 		}
 		return $password;
		
	}
}
?>