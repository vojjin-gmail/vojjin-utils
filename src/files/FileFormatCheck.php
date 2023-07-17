<?php


namespace VoxxxUtils\files;

use getID3;

require_once dirname(__DIR__,4) . DIRECTORY_SEPARATOR . "james-heinrich" . DIRECTORY_SEPARATOR . "getid3" . DIRECTORY_SEPARATOR . "getid3" . DIRECTORY_SEPARATOR . "getid3.php";

class FileFormatCheck {
	public array $fi;

	public function __construct($file) {
		$getID3 = new getID3();
		$this->fi = $getID3->analyze($file);
	}

	function getExt(): string {
		return $this->fi['fileformat'] ?? ($this->fi['video']['dataformat'] ?? "");
	}

	function getMimeType(): string {
		return $this->fi['mime_type'] ?? ($this->fi['video']['mime_type'] ?? "");
	}

	function getValidExt(): string {
		$f = $this->fi['fileformat'] ?? "";
		if (strtolower($f) == "zip.msoffice") {
			$f = "xlsx";
			if (strtolower(substr($this->fi['filename'], -4)) == "docx") {
				$f = "docx";
			}
		}
		return $f;

	}

	function getImageDimension(): array {
		if (!$this->isImage()) {
			return ["w" => 0, "h" => 0];
		}
		if (isset($this->fi['video']['resolution_x'])) {
			return ["w" => $this->fi['video']['resolution_x'], "h" => $this->fi['video']['resolution_y']];
		}
		return ["w" => 0, "h" => 0];
	}

	function isImage(): bool {
		$ext = $this->getValidExt();
		return $ext == "jpg" || $ext == "png" || $ext == "gif" || $ext == "webp" || $ext == "svg";
	}

	function isRaster(): bool {
		$ext = $this->getValidExt();
		return $ext == "jpg" || $ext == "png" || $ext == "gif" || $ext == "webp";
	}

	function isValidDocument(): bool {
		$ext = $this->getValidExt();
		return $ext == "pdf" || $ext == "zip" || $ext == "xlsx" || $ext == "docx" || $ext == "mp3" || $ext == "mp4" || $this->isImage();
	}

	function getWidth() {
		return $this->getImageDimension()['w'];
	}

	function getHeight() {
		return $this->getImageDimension()['h'];
	}
}