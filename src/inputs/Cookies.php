<?php
/**
 * Copyright (c) Vojin Petrovic. All rights reserved.
 */

/**
 * Created by PhpStorm.
 * User: imac
 * Date: 9/30/17
 * Time: 8:52 PM
 */

namespace VoxxxUtils\inputs;

class Cookies {

	public static function getCookie($cookie) {
		return $_COOKIE[$cookie] ?? false;
	}

	public static function setCookie($cookie, $value): void {
		setcookie($cookie, $value, 0, "/");
	}

	public static function setCookiePerm($cookie, $value, $days = 10000): void {
		setcookie($cookie, $value, time() + $days * 86400, "/");
	}

	public static function delCookie($cookie): void {
		setcookie($cookie, "", -1, "/");
	}

}