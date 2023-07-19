<?php

namespace VoxxxUtils\xlsx;

use JetBrains\PhpStorm\NoReturn;
use ZipArchive;

class ExcelFunctions {

	public static function excelColumn(int $a): string {
		if ($a <= 26) {
			return chr($a + 64);
		} else {
			$a1 = floor($a / 26);
			$a2 = $a - $a1 * 26;
			if ($a2 == 0) {
				$a1--;
				$a2 = 26;
			}
			return chr($a1 + 64) . chr($a2 + 64);
		}
	}

	#[NoReturn] public static function downloadFiles(string $pathToZippedFile, array $files): void {
		@unlink($pathToZippedFile);
		$zip = new ZipArchive();
		$zip->open($pathToZippedFile, ZIPARCHIVE::OVERWRITE || ZIPARCHIVE::CREATE);
		foreach ($files as $file) {
			$zip->addFile($file, basename($file));
		}
		$zip->close();
		foreach ($files as $file) {
			@unlink($file);
		}
		self::downloadExcelOrZip($pathToZippedFile, false);
	}

	#[NoReturn] public static function downloadExcelOrZip(string $pathToExcelOrZipFile, bool $deleteFile = true): void {
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"" . basename($pathToExcelOrZipFile) . "\"");
		readfile($pathToExcelOrZipFile);
		if ($deleteFile) {
			sleep(1);
			@unlink($pathToExcelOrZipFile);
		}
		exit;
	}
}