<?php

namespace VoxxxUtils;

use GdImage;
use VoxxxUtils\files\FileFormatCheck;

class Image {
	private string $srcfile = "", $file_type = "", $mime_type = "";
	private int $width = 0, $height = 0;
	private ?GdImage $resource = null;
	private array $img_info;

	function __construct($file = "") {
		if ($file != "") {
			$this->srcfile = $file;
			$this->get_image_properties();
		}
	}

	function get_image_properties($file = ""): bool {
		if ($file == "")
			$file = $this->srcfile;
		if (!file_exists($file)) {
			return false;
		}
		$fc = new FileFormatCheck($file);

		$this->width = $fc->getWidth();
		$this->height = $fc->getHeight();
		$this->file_type = $fc->getExt();
		$this->mime_type = $fc->getMimeType();

		$this->resource = $this->createImageResource();
		if ($this->resource === false) return false;
		return true;
	}

	function createImageResource(): ?GdImage {
		switch ($this->mime_type) {
			case 'image/jpeg':
				return @imagecreatefromjpeg($this->srcfile);
			case 'image/png':
				$o_im = @imagecreatefrompng($this->srcfile);
				@imagealphablending($o_im, true);
				@imagesavealpha($o_im, true);
				return $o_im;
			case 'image/gif':
				$o_im = @imagecreatefromgif($this->srcfile);
				@imagealphablending($o_im, true);
				return $o_im;
			case 'image/webp':
				$o_im = @imagecreatefromwebp($this->srcfile);
				@imagealphablending($o_im, true);
				@imagesavealpha($o_im, true);
				return $o_im;
			default:
				return null;
		}
	}

	function imageWidth(): int { return $this->width; }

	function imageHeight(): int { return $this->height; }

	function imageType(): string { return $this->file_type; }

	public function create($width, $height = null, $color = null) {
		$height = $height ? $height : $width;
		$this->width = $width;
		$this->height = $height;
		$this->resource = imagecreatetruecolor($width, $height);
		$this->file_type = 'png';
		$this->mime_type = 'image/png';
		if ($color) {
			$this->fill($color);
		}

		return $this;
	}

	public function createFromBase64($base64string): Image {
		if (extension_loaded('gd')) {
			$img_base64 = base64_decode(str_replace(' ', '+', preg_replace('#^data:image/[^;]+;base64,#', '', $base64string)));
			$this->resource = imagecreatefromstring($img_base64);
			return $this->get_meta_data();
		}
		return new Image();
	}

	public function resize($width, $height): void {
		if ($this->resource === false) return;
		$new = imagecreatetruecolor($width, $height);
		if ($this->file_type === 'gif' || $this->file_type === 'webp') {
			$transparent_index = imagecolortransparent($this->resource);
			if ($transparent_index >= 0) {
				$transparent_color = imagecolorsforindex($this->resource, $transparent_index);
				$transparent_index = imagecolorallocate($new, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
				imagefill($new, 0, 0, $transparent_index);
				imagecolortransparent($new, $transparent_index);
			}
		} else {
			// Preserve transparency in PNGs (benign for JPEGs)
			imagealphablending($new, false);
			imagesavealpha($new, true);
		}
		// Resize
		imagecopyresampled($new, $this->resource, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
		// Update meta data
		$this->width = $width;
		$this->height = $height;
		$this->resource = $new;
	}

	public function crop($x1, $y1, $x2, $y2): void {
		if ($this->resource === false) return;
		if ($x2 < $x1) {
			[$x1, $x2] = [$x2, $x1];
		}
		if ($y2 < $y1) {
			[$y1, $y2] = [$y2, $y1];
		}

		$crop_width = $x2 - $x1;
		$crop_height = $y2 - $y1;
		$new = imagecreatetruecolor($crop_width, $crop_height);
		imagealphablending($new, false);
		imagesavealpha($new, true);
		imagecopyresampled($new, $this->resource, 0, 0, $x1, $y1, $crop_width, $crop_height, $crop_width, $crop_height);
		$this->width = $crop_width;
		$this->height = $crop_height;
		$this->resource = $new;
	}

	public function fill($color = '#ffffff'): void {
		$rgba = $this->normalize_color($color);
		$fill_color = imagecolorallocatealpha($this->resource, $rgba['r'], $rgba['g'], $rgba['b'], $rgba['a']);
		imagealphablending($this->resource, false);
		imagesavealpha($this->resource, true);
		imagefilledrectangle($this->resource, 0, 0, $this->width, $this->height, $fill_color);
	}


	function resizeAndCropToFixedSize($newW, $newH, $destFile, $quality = 85): bool {
		if ($this->resource == null) return false;
		$dw = $this->width;
		$dh = $this->height;
		if (($dw / $dh) > ($newW / $newH)) {
			$dw = $dh * ($newW / $newH);
		} else {
			$dh = $dw * ($newH / $newW);
		}
		$sx = ($this->width - $dw) / 2;
		$sy = ($this->height - $dh) / 2;
		$t_im = imagecreatetruecolor($newW, $newH);
		$back_color = imagecolorallocate($t_im, 255, 255, 255);
		imagefilledrectangle($t_im, 0, 0, $newW, $newH, $back_color);
		imagecopyresampled($t_im, $this->resource, 0, 0, $sx, $sy, $newW, $newH, $dw, $dh);
		imagejpeg($t_im, $destFile, $quality);
		imagedestroy($this->resource);
		imagedestroy($t_im);
		return true;
	}

	function resizeAndCropToFixedSizeJpeg($newW, $newH): bool {
		$resource = $this->createImageResource();
		if ($this->resource == null) return false;
		$dw = $this->width;
		$dh = $this->height;
		if (($dw / $dh) > ($newW / $newH)) {
			$dw = $dh * ($newW / $newH);
		} else {
			$dh = $dw * ($newH / $newW);
		}
		$sx = ($this->width - $dw) / 2;
		$sy = ($this->height - $dh) / 2;
		$this->resource = imagecreatetruecolor($newW, $newH);
		$back_color = imagecolorallocate($this->resource, 255, 255, 255);
		imagefilledrectangle($this->resource, 0, 0, $newW, $newH, $back_color);
		imagecopyresampled($this->resource, $resource, 0, 0, $sx, $sy, $newW, $newH, $dw, $dh);
		return true;
	}

	function resizeToMaxSize($newW, $newH, $destFile, $quality = 85): bool {
		$resource = $this->createImageResource();
		if (!$resource) {
			return false;
		}
		$dw = $this->width;
		$dh = $this->height;
		$odn1 = $newW / $dw;
		$odn2 = $newH / $dh;
		$odn = min($odn1, $odn2);
		$newW = round($odn * $dw);
		$newH = round($odn * $dh);

		$t_im = imagecreatetruecolor($newW, $newH);
		$back_color = imagecolorallocate($t_im, 255, 255, 255);
		imagefilledrectangle($t_im, 0, 0, $newW, $newH, $back_color);
		imagecopyresampled($t_im, $resource, 0, 0, 0, 0, $newW, $newH, $dw, $dh);
		imagejpeg($t_im, $destFile, $quality);
		imagedestroy($resource);
		imagedestroy($t_im);
		return true;
	}

	public function resizeImageToFixedSizeWithOffset($newW, $newH, $destFile, $cx1, $cx2, $cy1, $cy2, $quality = 85): bool {
		$resource = $this->createImageResource();
		if (!$resource) {
			return false;
		}
		$sx = (int)($cx1 * $this->width);
		$sx2 = (int)($cx2 * $this->width);
		$sy = (int)($cy1 * $this->height);
		$dw = $sx2 - $sx;
		$dh = (int)(($newH / $newW) * $dw);
		if ($sy + $dh >= $this->height) {
			$sy = $this->height - $dh - 1;
		}

		$t_im = imagecreatetruecolor($newW, $newH);
		$back_color = imagecolorallocate($t_im, 255, 255, 255);
		imagefilledrectangle($t_im, 0, 0, $newW, $newH, $back_color);
		imagecopyresampled($t_im, $resource, 0, 0, $sx, $sy, $newW, $newH, $dw, $dh);
		imagejpeg($t_im, $destFile, $quality);
		imagedestroy($resource);
		imagedestroy($t_im);
		return true;
	}

	/* saving  */

	public function save($filename = null, $quality = null): void {
		// Determine quality, filename, and format
		$quality = $quality ? $quality : 85;
		$filename = $filename ? $filename : $this->srcfile;
		switch (strtolower($this->file_type)) {
			case 'gif':
				imagegif($this->resource, $filename);
				break;
			case 'jpg':
			case 'jpeg':
				imageinterlace($this->resource, true);
				imagejpeg($this->resource, $filename, round($quality));
				break;
			case 'png':
				imagepng($this->resource, $filename, round(9 * $quality / 100));
				break;
			case 'webp':
				imagewebp($this->resource, $filename, round($quality));
				break;
			default:
				break;
		}
	}

	public function savewebp($filename = null, $quality = null): void {
		// Determine quality, filename, and format
		$quality = $quality ?: 85;
		$filename = $filename ?: $this->srcfile;
		imagewebp($this->resource, $filename, round($quality));
	}

	public function savepng($filename = null, $quality = null): void {
		// Determine quality, filename, and format
		$quality = $quality ?: 85;
		$filename = $filename ?: $this->srcfile;
		imagepng($this->resource, $filename);
	}


	/* tools */

	private function normalize_color($color): bool|array {
		if (is_string($color)) {
			$color = trim($color, '#');
			if (strlen($color) == 6) {
				[$r, $g, $b] = [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];
			} elseif (strlen($color) == 3) {
				[$r, $g, $b] = [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]];
			} else {
				return false;
			}
			return ['r' => hexdec($r), 'g' => hexdec($g), 'b' => hexdec($b), 'a' => 0];
		} elseif (is_array($color) && (count($color) == 3 || count($color) == 4)) {
			if (isset($color['r'], $color['g'], $color['b'])) {
				return ['r' => $this->keep_within($color['r'], 0, 255), 'g' => $this->keep_within($color['g'], 0, 255),
					'b' => $this->keep_within($color['b'], 0, 255), 'a' => $this->keep_within($color['a'] ?? 0, 0, 127)];
			} elseif (isset($color[0], $color[1], $color[2])) {
				return ['r' => $this->keep_within($color[0], 0, 255), 'g' => $this->keep_within($color[1], 0, 255),
					'b' => $this->keep_within($color[2], 0, 255), 'a' => $this->keep_within($color[3] ?? 0, 0, 127)];
			}
		}
		return false;
	}

	private function keep_within($value, $min, $max) {
		if ($value < $min) {
			return $min;
		}
		if ($value > $max) {
			return $max;
		}
		return $value;
	}

	private function get_meta_data() {

		if (empty($this->img_base64)) {
			$info = getimagesize($this->srcfile);
			switch ($info['mime']) {
				case 'image/gif':
					$this->resource = imagecreatefromgif($this->srcfile);
					break;
				case 'image/jpeg':
					$this->resource = imagecreatefromjpeg($this->srcfile);
					break;
				case 'image/png':
					$this->resource = imagecreatefrompng($this->srcfile);
					break;
				case 'image/webp':
					$this->resource = imagecreatefromwebp($this->srcfile);
					break;
				default:
					exit('Invalid image: ' . $this->srcfile);
			}
		} elseif (function_exists('getimagesizefromstring')) {
			$info = getimagesizefromstring($this->img_base64);
		} else {
			$info = [0, 0, "mime" => ""];
		}

		$this->img_info = ['width' => $info[0], 'height' => $info[1], 'format' => preg_replace('/^image\//', '', $info['mime']),
			'mime' => $info['mime']];
		$this->width = $info[0];
		$this->height = $info[1];

		imagesavealpha($this->resource, true);
		imagealphablending($this->resource, true);

		return $this;

	}
}