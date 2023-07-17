<?php

namespace VoxxxUtils\inputs;


class Uris {
	static array $uris = [];

	static function getUris(array $pss): string {
		self::$uris = [];
		while (true) {
			if (count($pss) > 0) {
				self::$uris[] = array_shift($pss);
			} else {
				break;
			}
		}
		if (count(self::$uris) < 5) {
			while (true) {
				self::$uris[] = "";
				if (count(self::$uris) >= 5) {
					break;
				}
			}
		}
		return array_shift(self::$uris);
	}

	static function checkFirstUri(): bool {
		if (count(self::$uris) == 0) return false;
		if (self::$uris[0] == "") return false;
		return true;
	}

	static function getNextUri() {
		if (count(self::$uris) == 0) return "";
		return array_shift(self::$uris);
	}

	static function getNextIntUri(): int {
		if (count(self::$uris) == 0) return 0;
		return (int)array_shift(self::$uris);
	}

	static function insertUri($uri): void {
		array_unshift(self::$uris, $uri);
	}
}