<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

if (!function_exists('pr')) {
	function pr($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
		die;
	}
}

if (!function_exists('generateRandomString')) {
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}


?>