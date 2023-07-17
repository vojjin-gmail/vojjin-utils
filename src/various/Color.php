<?php
/**
 * Copyright (c) Vojin Petrovic. All rights reserved.
 */

/**
 * Created by PhpStorm.
 * User: imac
 * Date: 6/16/17
 * Time: 6:37 PM
 */

namespace VoxxxUtils\various;

class Color {
	public int $red = 0, $green = 0, $blue = 0;

	function __construct(string|array $a) {
		if (is_array($a)) {
			$this->red = $a[0];
			$this->green = $a[1];
			$this->blue = $a[2];
		} else {
			if (Validator::validate_color($a)) {
				$this->red = hexdec(substr($a, 1, 2));
				$this->green = hexdec(substr($a, 3, 2));
				$this->blue = hexdec(substr($a, 5, 2));
			}
		}
	}

	/**
	 * @param $p number percentage to darken
	 */
	function darken($p): void {
		$this->red = round($this->red * (100 - $p) / 100);
		$this->green = round($this->green * (100 - $p) / 100);
		$this->blue = round($this->blue * (100 - $p) / 100);
	}

	/**
	 * @param $p number percentage to lighten
	 */
	function lighten($p): void {
		$this->red = $this->red + round((255 - $this->red) * ($p) / 100);
		$this->green = $this->green + round((255 - $this->green) * ($p) / 100);
		$this->blue = $this->blue + round((255 - $this->blue) * ($p) / 100);
	}

	/**
	 * Invert color
	 */
	function invert(): void {
		$this->red = 255 - $this->red;
		$this->green = 255 - $this->green;
		$this->blue = 255 - $this->blue;
	}

	/**
	 * @return string return recalculated color
	 */
	function getColor(): string {
		return "#" . substr("00" . dechex($this->red), -2) . substr("00" . dechex($this->green), -2) . substr("00" . dechex($this->blue), -2);
	}

	/**
	 * @param $p number transparency of new color (0-1)
	 * @return string return recalcualted color with
	 */
	function getRGBA($p): string {
		return "rgba(" . $this->red . "," . $this->green . "," . $this->blue . "," . $p . ")";
	}

	/**
	 * @return string return recalcualted color with
	 */
	function getRGB(): string {
		return "rgb(" . $this->red . "," . $this->green . "," . $this->blue . ")";
	}

	/**
	 * @return string return recalcualted color with
	 */
	function getRGBSimple(): string {
		return $this->red . "," . $this->green . "," . $this->blue;
	}

	/**
	 * @return array return hsv color array
	 */
	function toHSV(): array {
		$Max = max($this->red, $this->green, $this->blue);
		$Min = min($this->red, $this->green, $this->blue);
		$d = $Max - $Min;
		$s = ($Max === 0 ? 0 : $d / $Max);
		$v = $Max / 255;
		$h = 0;
		switch ($Max) {
			case $this->red:
				$h = ($this->green - $this->blue) + $d * ($this->green < $this->blue ? 6 : 0);
				$h /= 6 * $d;
				break;
			case $this->green:
				$h = ($this->blue - $this->red) + $d * 2;
				$h /= 6 * $d;
				break;
			case $this->blue:
				$h = ($this->red - $this->green) + $d * 4;
				$h /= 6 * $d;
				break;
		}
		return [round($h * 360), round($s * 100), round($v * 100)];
	}

	static function HSVtoHTMLRGB($h, $s, $v): string {
		[$r, $g, $b] = self::HSVtoRGB($h, $s, $v);
		return "#" . substr("00" . dechex($r), -2) . substr("00" . dechex($g), -2) . substr("00" . dechex($b), -2);
	}

	static function HSVtoRGB($h, $s, $v): array {
		$r = 0;
		$g = 0;
		$b = 0;
		$h /= 360;
		$s /= 100;
		$v /= 100;
		$i = floor($h * 6);
		$f = $h * 6 - $i;
		$p = $v * (1 - $s);
		$q = $v * (1 - $f * $s);
		$t = $v * (1 - (1 - $f) * $s);
		switch ($i % 6) {
			case 0:
				$r = $v;
				$g = $t;
				$b = $p;
				break;
			case 1:
				$r = $q;
				$g = $v;
				$b = $p;
				break;
			case 2:
				$r = $p;
				$g = $v;
				$b = $t;
				break;
			case 3:
				$r = $p;
				$g = $q;
				$b = $v;
				break;
			case 4:
				$r = $t;
				$g = $p;
				$b = $v;
				break;
			case 5:
				$r = $v;
				$g = $p;
				$b = $q;
				break;
		}
		return [round($r * 255), round($g * 255), round($b * 255)];
	}



}