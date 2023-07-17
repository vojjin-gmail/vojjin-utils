<?php

namespace VoxxxUtils\template;

class ChunkReplacer {
	private array $replaceItems = [];

	public function add($key, $value): void {
		$this->replaceItems[$key] = $value;
	}

	public function replace($str): string {
		$out = $str;
		foreach ($this->replaceItems as $key => $value) {
			$out = str_replace("{" . $key . "}", $value, $out);
		}
		return $out;
	}
}