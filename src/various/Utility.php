<?php
/**
 * Created by PhpStorm.
 * User: Vojin
 * Date: 03-Apr-16
 * Time: 15:23
 */

namespace VoxxxUtils\various;

use SimpleXMLElement;

class Utility {
	static function isEmptyString($a): bool {
		if ($a == null || empty(trim($a)) == "")
			return true;
		return false;
	}

	static function isZero($a): bool {
		if (abs($a) < 0.005)
			return true;
		return false;
	}

	static function avoidZero($a) {
		return ($a == 0) ? 1 : $a;
	}

	static function emptyIfZero($a): string {
		if ($a == 0)
			return "";
		return $a . "";
	}

	static function safeDivide(float|int $a, float|int $b): float|int {
		if ($b == 0)
			return 0;
		return $a / $b;
	}

	static function cleanFromTags($a): string {
		$a = strip_tags($a);
		$a = str_replace("<", "", $a);
		$a = str_replace(">", "", $a);
		$a = str_ireplace("&lt;", "", $a);
		$a = str_ireplace("&gt;", "", $a);
		$a = str_ireplace("%3C;", "", $a);
		$a = str_ireplace("%3E;", "", $a);
		return trim($a);
	}

	static function cleanFromTagsForTag($a): string {
		$a = self::cleanFromTags($a);
		$a = str_replace("'", "", $a);
		$a = str_replace('"', "", $a);
		$a = str_ireplace("/", "", $a);
		$a = str_ireplace("\\", "", $a);
		$a = str_ireplace("*", "", $a);
		$a = str_ireplace("#", "", $a);
		$a = str_ireplace("?", "", $a);
		return strtolower($a);
	}

	static function convertXmlObjToArr(SimpleXMLElement $obj, array &$arr): void {
		$children = $obj->children();
		foreach ($children as $elementName => $node) {
			$nextIdx = count($arr);
			$arr[$nextIdx] = [];
			$arr[$nextIdx]['name'] = $elementName;
			$arr[$nextIdx]['attr'] = [];
			$attributes = $node->attributes();
			foreach ($attributes as $attributeName => $attributeValue) {
				$attribName = (trim((string)$attributeName));
				$attribVal = trim((string)$attributeValue);
				$arr[$nextIdx]['attr'][$attribName] = $attribVal;
			}
			$text = (string)$node;
			$text = trim($text);
			if (strlen($text) > 0)
				$arr[$nextIdx]['text'] = $text;
			$arr[$nextIdx]['child'] = [];
			self::convertXmlObjToArr($node, $arr[$nextIdx]['child']);
		}
	}

	static function convertXmlObjToStd($obj, &$arr): void {
		$children = $obj->children();
		foreach ($children as $elementName => $node) {
			$arr[(string)$elementName] = [];
			$text = (string)$node;
			$text = trim($text);
			if (strlen($text) > 0) {
				$arr[(string)$elementName] = $text;
			} else {
				if ($node->count() == 0) {
					$arr[(string)$elementName] = "";
				} else {
					self::convertXmlObjToStd($node, $arr[(string)$elementName]);
				}
			}
		}
	}

	static function countStdItems(object $object): int {
		$cnt = 0;
		foreach ($object as $key => $value) {
			$cnt++;
		}
		return $cnt;
	}

	static function randomToken($k = 64): string {
		$passLetters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123467890";
		$pass = "";
		for ($i = 0; $i < $k; $i++) {
			$pass .= substr($passLetters, mt_rand(0, strlen($passLetters) - 1), 1);
		}
		return $pass;
	}

	static function randomString($k = 8): string {
		$passLetters = "abcdefghijklmnopqrstuvwxyz";
		$pass = "";
		for ($i = 0; $i < $k; $i++) {
			$pass .= substr($passLetters, mt_rand(0, strlen($passLetters) - 1), 1);
		}
		return $pass;
	}

	static function randomNumber($k = 6): string {
		$passLetters = "0123456789";
		$pass = "";
		for ($i = 0; $i < $k; $i++) {
			$pass .= substr($passLetters, mt_rand(0, strlen($passLetters) - 1), 1);
		}
		return $pass;
	}

	static function filesizekb($bytes): string {
		if ($bytes < 1024) {
			return $bytes . " B";
		} else if ($bytes < 1024 * 1024) {
			return number_format($bytes / 1024, 2) . " KB";
		} else if ($bytes < 1024 * 1024 * 1024) {
			return number_format($bytes / 1024 / 1024, 2) . " MB";
		} else {
			return number_format($bytes / 1024 / 1024 / 1024, 2) . " GB";
		}
	}

	static function parseURI($uri): array {
		return explode("/", self::cleanuri($uri));
	}

	static function cleanuri($f) {
		if (str_contains($f, ".html"))
			$f = substr($f, 0, strpos($f, ".html"));
		if (str_contains($f, "?"))
			$f = substr($f, 0, strpos($f, "?"));
		if (str_contains($f, "#"))
			$f = substr($f, 0, strpos($f, "#"));
		return $f;
	}

	static function cleanuri2($f) {
		if (str_contains($f, ".html"))
			$f = substr($f, 0, strpos($f, ".html"));
		if (str_contains($f, "#"))
			$f = substr($f, 0, strpos($f, "#"));
		return $f;
	}

	static function ifNotSetStd(object $a, string $property, $def = "") {
		return $a->{$property} ?? $def;
	}

	static function ifNotSetArray(array $a, string $property, $def = "") {
		return $a[$property] ?? $def;
	}

	static function jsonDecodeToArray($a): array {
		$A = @json_decode($a);
		if ($A === null || $A === false) {
			return [];
		} else {
			if (is_array($A)) {
				return $A;
			} else {
				return [];
			}
		}
	}

	static function jsonObjectToArray($a): array {
		if ($a === null || $a === false) {
			return [];
		} else {
			if (is_object($a)) {
				$out = [];
				foreach ($a as $key => $value) {
					$out[(int)$key] = $value;
				}
				return $out;
			} else {
				return [];
			}
		}
	}

	static function shortContent(string $content, int $length = 150, bool $dots = true): string {
		$g = $length;
		$content = trim(strip_tags(strip_tags($content)));

		$pattern = '/\{\{(.*?)\}\}/';
		$matches = [];
		preg_match_all($pattern, $content, $matches);
		for ($i = 0; $i < count($matches[1]); $i++) {
			$content = str_replace($matches[0][$i], "", $content);
		}
		$content = str_replace("&nbsp;", " ", $content);
		$pattern = '/\[\[(.*?)\]\]/';
		$matches = [];
		preg_match_all($pattern, $content, $matches);
		for ($i = 0; $i < count($matches[1]); $i++) {
			$content = str_replace($matches[0][$i], "", $content);
		}
		$content = str_replace("&nbsp;", " ", $content);
		$content = str_replace("\n", " ", $content);
		$content = str_replace("\r", " ", $content);

		while (true) {
			if (str_contains($content, "  ")) {
				$content = str_replace("  ", " ", $content);
			} else {
				break;
			}
		}
		if (strlen($content) < $g)
			return $content;
		while (true) {
			$f = mb_substr($content, $g, 1, "utf-8");
			if ($f == " " || $f == "." || $f == "," || $f == "?" || $f == "!" || $f == ":")
				break;
			$g--;
		}
		$content = trim($content);
		return trim(strip_tags(strip_tags(mb_substr($content, 0, $g, "utf-8")))) . ($dots ? "..." : "");
	}

	static function excerpt($content, $q, $dots = true): string {
		$c = strip_tags($content);
		$pattern = '/\{\{(.*?)\}\}/';
		$matches = [];
		preg_match_all($pattern, $c, $matches);
		for ($i = 0; $i < count($matches[1]); $i++) {
			$c = str_replace($matches[0][$i], "", $c);
		}
		$c = str_replace("&nbsp;", " ", $c);
		$pattern = '/\[\[(.*?)\]\]/';
		$matches = [];
		preg_match_all($pattern, $c, $matches);
		for ($i = 0; $i < count($matches[1]); $i++) {
			$c = str_replace($matches[0][$i], "", $c);
		}
		$c = str_replace("&nbsp;", " ", $c);

		$g1 = mb_stripos($c, $q, 0, "utf-8");
		if ($g1 === false) {
			return mb_substr($c, 0, 200, "utf-8");
		}
		if ($g1 < 100) {
			$cc = mb_substr($c, 0, 100 + $g1, "utf-8");
		} else {
			$cc = mb_substr($c, $g1 - 100, 200, "utf-8");
		}
		return ($dots === true ? "..." : "") . str_ireplace($q, '<mark style="color:inherit; background-color: yellow;">' . $q . '</mark>', $cc) . ($dots === true ? "..." : "");
	}

	static function addBr($a): array|string {
		return str_replace("\n", "<br/>", $a);
	}

	static function addBrToArray($a): string {
		return implode("<br/>", $a);
	}

	static function addNToArray($a): string {
		return implode("\n", $a);
	}

	static function removeNToMakeArray($a): array {
		return explode("\n", $a);
	}

	static function removeBrToMakeArray($a): array {
		return explode("<br/>", $a);
	}

	static function fromStdOrArray($object, $param) {
		if (isset($object->{$param})) {
			return $object->{$param};
		}
		if (isset($object[$param])) {
			return $object[$param];
		}
		return "";
	}

	static function stringToPath(string $a): string {
		return str_replace('/', DIRECTORY_SEPARATOR, $a);
	}

	static function stringToUrl(string $a): string {
		return str_replace(DIRECTORY_SEPARATOR, '/', $a);
	}

	static function noparentheses(string $a): array|string {
		return str_replace(["(", ")"], ["%28", "%29"], $a);
	}

	static function lowercase(string $a): string {
		return mb_convert_case($a, MB_CASE_LOWER, "UTF-8");
	}

	static function uppercase(string $a): string {
		return mb_convert_case($a, MB_CASE_UPPER, "UTF-8");
	}

}
