<?php
/**
 * Copyright (c) Vojin Petrovic. All rights reserved.
 */
namespace VoxxxUtils;

class FileSystem {
	static function createFolder($folder): void {
		if (!is_file($folder)) {
			$parts = explode(DIRECTORY_SEPARATOR, $folder);
			if (count($parts) > 1) {
				if ($parts[count($parts) - 1] == "") {
					array_pop($parts);
				}
				$lasts = [];
				if (count($parts) > 1) {
					$all = "";
					while (true) {
						$lasts[] = array_pop($parts);
						$all = implode(DIRECTORY_SEPARATOR, $parts);
						if (file_exists($all)) {
							break;
						}
					}
					if (count($lasts) > 0) {
						for ($i = count($lasts) - 1; $i >= 0; $i--) {
							$all .= DIRECTORY_SEPARATOR . $lasts[$i];
							@mkdir($all);
						}
					}
				}
			}
		}
	}

	static function renameFolder($dir1, $dir2): void {
		if (is_dir($dir1)) {
			rename($dir1, $dir2);
		}
	}

	static function renameFile($dir1, $dir2): void {
		if (is_file($dir1)) {
			rename($dir1, $dir2);
		}
	}

	static function removeFolder($dir): void {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . DIRECTORY_SEPARATOR . $object) == "dir")
						self::removeFolder($dir . DIRECTORY_SEPARATOR . $object); else unlink($dir . DIRECTORY_SEPARATOR . $object);
				}
			}
			rmdir($dir);
		}
	}

	static function removeFile($file): bool {
		if (!file_exists($file))
			return false;
		@unlink($file);
		return true;
	}

	static function findFiles($path, $ext): array {
		$files = [];
		if (!file_exists($path))
			return $files;
		$dir = opendir($path);
		while (($currentFile = readdir($dir)) !== false) {
			if ($currentFile == '.' or $currentFile == '..' or str_starts_with($currentFile, ".")) {
				continue;
			}
			$f = explode(".", $currentFile);
			if (count($f) > 1) {
				if ($f[count($f) - 1] == $ext || $ext == "")
					$files[] = $path . DIRECTORY_SEPARATOR . $currentFile;
			}
		}
		closedir($dir);
		return $files;
	}

	static function findAllFiles($path): array {
		$files = [];
		if (!file_exists($path))
			return $files;
		$dir = opendir($path);
		while (($currentFile = readdir($dir)) !== false) {
			if ($currentFile == '.' or $currentFile == '..' or str_starts_with($currentFile, ".")) {
				continue;
			}
			if (filetype($path . DIRECTORY_SEPARATOR . $currentFile) != "dir") {
				$files[] = $path . DIRECTORY_SEPARATOR . $currentFile;
			}
		}
		closedir($dir);
		return $files;
	}

	static function findFolders($path): array {
		if (substr($path, -1) == DIRECTORY_SEPARATOR) {
			$path = substr($path, 0, strlen($path) - 1);
		}
		$folders = [];
		if (is_dir($path)) {
			$objects = scandir($path);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($path . DIRECTORY_SEPARATOR . $object) == "dir") {
						$folders[] = ["folder" => $path . DIRECTORY_SEPARATOR . $object, "subs" => self::findFolders($path . DIRECTORY_SEPARATOR . $object)];
					}
				}
			}
		}
		return $folders;
	}

	static function filesizeinkb($a): string {
		if ($a < 1024) {
			return $a . " b";
		} else if ($a < 1024 * 1024) {
			return number_format($a / 1024, 2) . " Kb";
		} else if ($a < 1024 * 1024 * 1024) {
			return number_format($a / 1024 / 1024) . " Mb";
		} else {
			return number_format($a / 1024 / 1024 / 1024) . " Gb";
		}
	}
}