<?php

namespace VoxxxUtils\inputs;

use VoxxxUtils\various\DateClass;
use VoxxxUtils\various\Validator;

/**
 * Class for receiving input variables... $_POST, $_GET, or json in request body
 */
class R {
	static function getKey($key): string {
		if (isset($_POST[$key])) return $_POST[$key];
		if (isset($_GET[$key])) return $_GET[$key];
		if (self::isJson()) {
			$content = self::getJsonFromBody();
			if (isset($content->{$key})) return (string)$content->{$key};
		}
		return "";
	}

	static function getObjKey($key): object {
		if (self::isJson()) {
			$content = self::getJsonFromBody();
			if (isset($content->{$key})) return (object)$content->{$key};
		}
		return (object)[];
	}

	static function isSet($key): bool {
		if (isset($_POST[$key])) return true;
		if (isset($_GET[$key])) return true;
		if (self::isJson()) {
			$content = self::getJsonFromBody();
			if (isset($content->{$key})) return true;
		}
		return false;
	}

	static function getAllValues(): object {
		$values = [];
		$ct=$_SERVER["CONTENT_TYPE"]??"";
		if ($ct == null) $ct="";
		$contentType = trim($ct);
		if ($contentType == "application/json") {
			$content = json_decode(file_get_contents("php://input"));
			foreach ($content as $key => $value) {
				$values[$key] = $value;
			}
		} else {
			foreach ($_POST as $key => $value) {
				$values[$key] = $value;
			}
			foreach ($_GET as $key => $value) {
				$values[$key] = $value;
			}
		}
		return (object)$values;
	}

	static function getAnyNum($key): float|int {
		if (!self::isSet($key)) return 0;
		$value = self::getKey($key);
		return ($value == (int)$value) ? (int)$value : (float)$value;
	}

	static function getAnyInt($key, $canBeNegative = false): int {
		return $canBeNegative === true ? (int)round(self::getAnyNum($key)) : (int)abs(round(self::getAnyNum($key)));
	}

	static function getAnyBool($key): int {
		return self::getAnyInt($key) == 1 ? 1 : 0;
	}

	static function getAnyStr($key, $def = ""): string {
		if (!self::isSet($key)) return $def;
		return self::getKey($key);
	}

	static function getAnyDate($key): string {
		$d = self::getAnyStr($key);
		return $d == "" || $d == DateClass::NULLTIME ? DateClass::NULLTIME : DateClass::dateToString(strtotime($d));
	}

	static function getAnyDateVal($key): int {
		$d = self::getAnyDate($key);
		return $d == "" || $d == DateClass::NULLTIME ? 0 : strtotime($d);
	}

	static function getAnyDateShort($key): string {
		$d = self::getAnyStr($key);
		return $d == "" || $d == DateClass::NULLTIME || $d == DateClass::NULLDATE ? DateClass::NULLDATE : DateClass::dateToStringShort(strtotime($d));
	}

	static function getAnyDateValShort($key): int {
		$d = self::getAnyStr($key);
		return $d == "" || $d == DateClass::NULLTIME || $d == DateClass::NULLDATE ? 0 : strtotime(DateClass::dateToStringShortZeros(strtotime($d)));
	}

	static function getAnyColor($key): string {
		$d = self::getAnyStr($key);
		if (Validator::validate_color($d)) {
			return $d;
		}
		if (Validator::validate_color_rgba($d)) {
			if (strtolower(substr($d, -2)) == "ff") {
				return substr($d, 0, 7);
			}
			return $d;
		}
		return "";
	}

	static function getAnyIntArray($key): array {
		$id = [];
		$items = self::getObjKey($key);
		foreach ($items as $ids) {
			$id[] = (int)$ids;
		}
		return $id;
	}

	static function getAnyStrArray($key): array {
		$id = [];
		$items = self::getObjKey($key);
		foreach ($items as $ids) {
			$id[] = $ids;
		}
		return $id;
	}

	private static function isJson(): bool {
		$contentType = trim($_SERVER["CONTENT_TYPE"] ?? '');
		return $contentType == "application/json";
	}

	private static function getJsonFromBody() {
		$content = @json_decode(trim(file_get_contents("php://input")));
		if (is_object($content)) return $content;
		return (object)[];
	}
}