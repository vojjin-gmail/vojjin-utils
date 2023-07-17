<?php

namespace VoxxxUtils\minifiers;

class CssMinifier {

	public static function initCss(array $cssFiles, string $combinedFile): void {
		$f = fopen($combinedFile, "w");
		foreach ($cssFiles as $cssFile) {
			$css = file_get_contents($cssFile[0]);
			if ($cssFile[1] === true) {
				$out=self::compressCss($css);
			} else {
				$out = $css;
			}
			fwrite($f, $out . "\n");
		}
		fclose($f);
	}

	private static function compressCss(string $css): string {
		$css = str_replace("\t", "", $css);
		$css = str_replace("\r", "", $css);
		$css = str_replace("\n", "", $css);
		$pattern = '/\/\*(.*?)\*\//i';
		$replacement = '';
		$css= preg_replace($pattern, $replacement, $css);
		$css = str_replace("  ", " ", $css);
		$css = str_replace("  ", " ", $css);
		$css = str_replace("  ", " ", $css);
		$css = str_replace("  ", " ", $css);
		$css = str_replace(": ", ":", $css);
		$css = str_replace("{ ", "{", $css);
		$css = str_replace(" {", "{", $css);
		$css = str_replace(" }", "}", $css);
		$css = str_replace("} ", "}", $css);
		$css = str_replace(" ;", ";", $css);
		return str_replace("; ", ";", $css);
	}
}