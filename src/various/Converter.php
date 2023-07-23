<?php
/**
 * Created by PhpStorm.
 * User: imac
 * Date: 3/9/17
 * Time: 4:59 PM
 */

namespace VoxxxUtils\various;

class Converter {
	private array $cirfrom = [
		"А", "A", "Б", "B", "В", "V", "Г", "G", "Д", "D", "Ђ", "Đ", "Е", "E", "Ж", "Ž", "З", "Z", "И", "I", "Ј", "J", "К", "K", "Л", "L", "Љ", "М", "M",
		"Н", "N", "Њ", "О", "O", "П", "P", "Р", "R", "С", "S", "Т", "T", "Ћ", "Ć", "У", "U", "Ф", "F", "Х", "H", "Ц", "C", "Ч", "Č", "Џ", "Ш", "Š", "Q", "W", "X", "Y"
	];
	private array $latfrom = [
		"А", "A", "Б", "B", "Ц", "C", "Ч", "Č", "Ћ", "Ć", "Д", "D", "Џ", "Ђ", "Đ", "Е", "E", "Ф", "F", "Г", "G", "Х", "H", "И", "I", "Ј", "J", "К", "K", "Л", "L", "Љ", "М", "M",
		"Н", "N", "Њ", "О", "O", "П", "P", "Q", "Р", "R", "С", "S", "Ш", "Š", "Т", "T", "У", "U", "В", "V", "W", "X", "Y", "З", "Z", "Ж", "Ž"
	];
	private array $engfrom = [
		"A", "B", "C", "Č", "Ć", "D", "Đ", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "Š", "T", "U", "V", "W", "X", "Y", "Z", "Ž"
	];

	private array $file_from = [
		" ", "A", "B", "V", "G", "D", "Đ", "E", "Ž", "Z", "I", "J", "K", "L", "M", "N", "O", "P", "R", "S", "T", "Ć", "U", "F", "H", "C", "Č", "Š", "Q", "W", "X", "Y",
		"a", "b", "v", "g", "d", "đ", "e", "ž", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "ć", "u", "f", "h", "c", "č", "š", "q", "w", "x", "y", ".",
		'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß',
		'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ',
		'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ',
		'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł',
		'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ',
		'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ',
		'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ',
		"0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "_", "@"
	];
	private array $file_to = [
		"-", "a", "b", "v", "g", "d", "dj", "e", "z", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "c", "u", "f", "h", "c", "c", "s", "q", "w", "x", "y",
		"a", "b", "v", "g", "d", "dj", "e", "z", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "c", "u", "f", "h", "c", "c", "s", "q", "w", "x", "y", ".",
		'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'ss',
		'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y',
		'a', 'a', 'a', 'a', 'a', 'a', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'd', 'd', 'd', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'g', 'g', 'g', 'g', 'g', 'g', 'g', 'g',
		'h', 'h', 'h', 'h', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'ij', 'ij', 'j', 'j', 'k', 'k', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l',
		'n', 'n', 'n', 'n', 'n', 'n', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'oe', 'oe', 'r', 'r', 'r', 'r', 'r', 'r', 's', 's', 's', 's', 's', 's', 's', 's', 't', 't', 't', 't', 't', 't',
		'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'w', 'w', 'y', 'y', 'y', 'z', 'z', 'z', 'z', 'z', 'z', 's', 'f', 'o', 'o', 'u', 'u', 'a', 'a', 'i', 'i', 'o', 'o',
		'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'a', 'a', 'ae', 'ae', 'o', 'o',
		"0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-", "-"
	];
	private array $folder_from = [
		" ", "A", "B", "V", "G", "D", "Đ", "E", "Ž", "Z", "I", "J", "K", "L", "M", "N", "O", "P", "R", "S", "T", "Ć", "U", "F", "H", "C", "Č", "Š", "Q", "W", "X", "Y",
		"a", "b", "v", "g", "d", "đ", "e", "ž", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "ć", "u", "f", "h", "c", "č", "š", "q", "w", "x", "y", ".",
		'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß',
		'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ',
		'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ',
		'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł',
		'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ',
		'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ',
		'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ',
		"0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "_", "@"
	];
	private array $folder_to = [
		"-", "a", "b", "v", "g", "d", "dj", "e", "z", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "c", "u", "f", "h", "c", "c", "s", "q", "w", "x", "y",
		"a", "b", "v", "g", "d", "dj", "e", "z", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "c", "u", "f", "h", "c", "c", "s", "q", "w", "x", "y", "_",
		'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'ss',
		'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y',
		'a', 'a', 'a', 'a', 'a', 'a', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'd', 'd', 'd', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'g', 'g', 'g', 'g', 'g', 'g', 'g', 'g',
		'h', 'h', 'h', 'h', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'ij', 'ij', 'j', 'j', 'k', 'k', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l',
		'n', 'n', 'n', 'n', 'n', 'n', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'oe', 'oe', 'r', 'r', 'r', 'r', 'r', 'r', 's', 's', 's', 's', 's', 's', 's', 's', 't', 't', 't', 't', 't', 't',
		'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'w', 'w', 'y', 'y', 'y', 'z', 'z', 'z', 'z', 'z', 'z', 's', 'f', 'o', 'o', 'u', 'u', 'a', 'a', 'i', 'i', 'o', 'o',
		'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'a', 'a', 'ae', 'ae', 'o', 'o',
		"0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-", "-"
	];
	private array $url_from = [
		" ", "А", "Б", "В", "Г", "Д", "Ђ", "Е", "Ж", "З", "И", "Ј", "К", "Л", "Љ", "М", "Н", "Њ", "О", "П", "Р", "С", "Т", "Ћ", "У", "Ф", "Х", "Ц", "Ч", "Џ", "Ш",
		"а", "б", "в", "г", "д", "ђ", "е", "ж", "з", "и", "ј", "к", "л", "љ", "м", "н", "њ", "о", "п", "р", "с", "т", "ћ", "у", "ф", "х", "ц", "ч", "џ", "ш",
		"A", "B", "V", "G", "D", "Đ", "E", "Ž", "Z", "I", "J", "K", "L", "LJ", "M", "N", "NJ", "O", "P", "R", "S", "T", "Ć", "U", "F", "H", "C", "Č", "DŽ", "Š", "Q", "W", "X", "Y",
		"a", "b", "v", "g", "d", "đ", "e", "ž", "z", "i", "j", "k", "l", "lj", "m", "n", "nj", "o", "p", "r", "s", "t", "ć", "u", "f", "h", "c", "č", "dz", "š", "q", "w", "x", "y",
		".", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "/"
	];
	private array $url_to = [
		"-", "a", "b", "v", "g", "d", "dj", "e", "z", "z", "i", "j", "k", "l", "lj", "m", "n", "nj", "o", "p", "r", "s", "t", "c", "u", "f", "h", "c", "c", "dz", "s",
		"a", "b", "v", "g", "d", "dj", "e", "z", "z", "i", "j", "k", "l", "lj", "m", "n", "nj", "o", "p", "r", "s", "t", "c", "u", "f", "h", "c", "c", "dz", "s",
		"a", "b", "v", "g", "d", "dj", "e", "z", "z", "i", "j", "k", "l", "lj", "m", "n", "nj", "o", "p", "r", "s", "t", "c", "u", "f", "h", "c", "c", "dz", "s", "q", "w", "x", "y",
		"a", "b", "v", "g", "d", "dj", "e", "z", "z", "i", "j", "k", "l", "lj", "m", "n", "nj", "o", "p", "r", "s", "t", "c", "u", "f", "h", "c", "c", "dz", "s", "q", "w", "x", "y",
		"-", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-"
	];
	private array $url_utf8_from_dash = [
		" ", "&", "–", "_"
	];
	private array $url_utf8_from_blank = [
		"/", "#", "?", "\\", "*", "'", '"', ".", ",", "!", "\$", "¿", "？", ":", ";", "(", ")", "*", "+", "=", "~"
	];
	private array $cir_str = ["Љ", "Њ", "Џ", "љ", "њ", "џ",
		"А", "Б", "В", "Г", "Д", "Ђ", "Е", "Ж", "З", "И", "Ј", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "Ћ", "У", "Ф", "Х", "Ц", "Ч", "Ш", "а", "б", "в", "г", "д", "ђ",
		"е", "ж", "з", "и", "ј", "к", "л", "м", "н", "о", "п", "р", "с", "т", "ћ", "у", "ф", "х", "ц", "ч", "ш"];
	private array $lat_str = ["Lj", "Nj", "Dž", "lj", "nj", "dž",
		"A", "B", "V", "G", "D", "Đ", "E", "Ž", "Z", "I", "J", "K", "L", "M", "N", "O", "P", "R", "S", "T", "Ć", "U", "F", "H", "C", "Č", "Š", "a", "b", "v", "g", "d", "đ",
		"e", "ž", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "ć", "u", "f", "h", "c", "č", "š"];

	public array $cirto = [];
	public array $latto = [];
	public array $engto = [];

	function makeCleanFile(string $inputFilename, int $maxLength = 128): string {
		$ret = str_replace($this->file_from, $this->file_to, trim($inputFilename));
		$final = "";
		for ($i = 0; $i < strlen($ret); $i++) {
			if (in_array(substr($ret, $i, 1), $this->file_to)) $final .= substr($ret, $i, 1);
		}
		while (true) {
			if (!str_contains($final, "--")) break;
			$final = str_replace("--", "-", $final);
		}
		while (true) {
			if (!str_contains($final, "-.")) break;
			$final = str_replace("-.", ".", $final);
		}
		while (true) {
			if (!str_starts_with($final, "-")) break;
			$final = substr($final, 1);
		}
		if (strlen($final) > $maxLength) {
			$ff = explode(".", $final);
			if (count($ff) == 1) {
				$final = substr($final, 0, $maxLength);
			} else {
				$ext = array_pop($ff);
				$file = implode(".", $ff);
				if (strlen($file) > $maxLength - strlen($ext) - 1) {
					$file = substr($file, 0, $maxLength - strlen($ext) - 1);
					if (str_ends_with($file, ".")) {
						$file = substr($file, 0, strlen($file) - 1);
					}
				}
				$final = $file . "." . $ext;
			}
		}
		return $final;
	}

	function makeCleanFolder(string $inputFolderName, int $maxLength = 64): string {
		$ret = str_replace($this->folder_from, $this->folder_to, trim($inputFolderName));
		$final = "";
		for ($i = 0; $i < strlen($ret); $i++) {
			if (in_array(substr($ret, $i, 1), $this->folder_to)) $final .= substr($ret, $i, 1);
		}
		while (true) {
			if (!str_contains($final, "--")) break;
			$final = str_replace("--", "-", $final);
		}
		while (true) {
			if (!str_starts_with($final, "-")) break;
			$final = substr($final, 1);
		}
		if (strlen($final) > $maxLength) {
			$final = substr($final, 0, $maxLength);
		}
		return $final;
	}

	function makeCleanUrl(string $inputUrl): string {
		if (trim($inputUrl) == "") return "";
		$ret = str_replace($this->url_from, $this->url_to, trim($inputUrl));
		$final = "";
		for ($i = 0; $i < strlen($ret); $i++) {
			if (in_array(substr($ret, $i, 1), $this->url_to)) $final .= substr($ret, $i, 1);
		}
		while (true) {
			if (!str_contains($final, "--")) break;
			$final = str_replace("--", "-", $final);
		}
		while (true) {
			if (!str_contains($final, "-.")) break;
			$final = str_replace("-.", ".", $final);
		}
		while (true) {
			if (!str_starts_with($final, "-")) break;
			$final = substr($final, 1);
		}
		return $final;
	}

	function makeCleanUTFUrl(string $inputUrl): string {
		if (trim($inputUrl) == "") return "";
		$final = mb_strtolower(str_replace($this->url_utf8_from_dash, "-", trim($inputUrl)), "utf-8");
		$final = mb_strtolower(str_replace($this->url_utf8_from_blank, "", $final), "utf-8");
		while (true) {
			if (!str_contains($final, "--")) break;
			$final = str_replace("--", "-", $final);
		}
		while (true) {
			if (mb_substr($final, 0, 1, "utf-8") != "-") break;
			$final = mb_substr($final, 1, mb_strlen($final, "utf-8") - 1, "utf-8");
		}
		while (true) {
			if (!str_ends_with($final, "-")) break;
			$final = mb_substr($final, 0, mb_strlen($final, "utf-8") - 1, "utf-8");
		}
		while (true) {
			if (strlen($final) <= 255) break;
			$final = mb_substr($final, 0, mb_strlen($final, "utf-8") - 1, "utf-8");
		}
		return $final;
	}

	function anythingToUtf8($text): bool|string {
		return iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
	}

	function cir2lat(string $inputCyrText): string {
		return str_replace($this->cir_str, $this->lat_str, $inputCyrText);
	}

	function lat2cir(string $inputLatinText): string {
		$ret = "";
		$b = $inputLatinText;
		$arrs = [];

		while (true) {
			if (!str_contains($b, "<head")) {
				$ret .= $b;
				break;
			} else {
				$j1 = strpos($b, "<head");
				$j2 = strpos($b, "</head>", $j1 + 1);
				if ($j2 !== false) {
					$ret .= substr($b, 0, $j1);
					$b = substr($b, $j1);
					$j2 = strpos($b, "</head>");
					$arrs[] = substr($b, 0, $j2 + 7);
					$ret .= "@@" . chr(9) . "@@" . (count($arrs) - 1);
					$b = substr($b, $j2 + 7);
				} else {
					$ret .= $b;
					break;
				}
			}
		}
		$b = $ret;
		$ret = '';
		while (true) {
			if (!str_contains($b, "<script")) {
				$ret .= $b;
				break;
			} else {
				$j1 = strpos($b, "<script");
				$j2 = strpos($b, "</script>", $j1 + 1);
				if ($j2 !== false) {
					$ret .= substr($b, 0, $j1);
					$b = substr($b, $j1);
					$j2 = strpos($b, "</script>");
					$arrs[] = substr($b, 0, $j2 + 9);
					$ret .= "@@" . chr(9) . "@@" . (count($arrs) - 1);
					$b = substr($b, $j2 + 9);
				} else {
					$ret .= $b;
					break;
				}
			}
		}
		$b = $ret;
		$ret = '';
		while (true) {
			if (!str_contains($b, "<style")) {
				$ret .= $b;
				break;
			} else {
				$j1 = strpos($b, "<style");
				$j2 = strpos($b, "</style>", $j1 + 1);
				if ($j2 !== false) {
					$ret .= substr($b, 0, $j1);
					$b = substr($b, $j1);
					$j2 = strpos($b, "</script>");
					$arrs[] = substr($b, 0, $j2 + 8);
					$ret .= "@@" . chr(9) . "@@" . (count($arrs) - 1);
					$b = substr($b, $j2 + 8);
				} else {
					$ret .= $b;
					break;
				}
			}
		}
		$b = $ret;
		$ret = '';

		while (true) {
			if (!str_contains($b, "<")) {
				$ret .= $b;
				break;
			} else {
				$j1 = strpos($b, "<");
				$j2 = strpos($b, ">", $j1 + 1);
				if ($j2 !== false) {
					$ret .= substr($b, 0, $j1);
					$b = substr($b, $j1);
					$j2 = strpos($b, ">");
					$arrs[] = substr($b, 0, $j2 + 1);
					$ret .= "@@" . chr(9) . "@@" . (count($arrs) - 1);
					$b = substr($b, $j2 + 1);
				} else {
					$ret .= $b;
					break;
				}
			}
		}


		$ret = str_replace($this->lat_str, $this->cir_str, $ret);
		for ($i = count($arrs) - 1; $i >= 0; $i--) {
			$ret = str_replace("@@" . chr(9) . "@@" . $i, $arrs[$i], $ret);
		}
		return $ret;

	}

	function makeLangIndex($cir = "", $eng = ""): array {
		$lat = $this->cir2lat($cir);
		for ($i = 0; $i < count($this->cirfrom); $i++) $this->cirto[] = sprintf("%02s", $i);
		for ($i = 0; $i < count($this->latfrom); $i++) $this->latto[] = sprintf("%02s", $i);
		for ($i = 0; $i < count($this->engfrom); $i++) $this->engto[] = sprintf("%02s", $i);
		$ret = [];
		$ret[] = str_ireplace($this->cirfrom, $this->cirto, Utility::uppercase($cir));
		$ret[] = str_ireplace($this->latfrom, $this->latto, Utility::uppercase($lat));
		$ret[] = str_ireplace($this->engfrom, $this->engto, Utility::uppercase($eng));
		return $ret;
	}


}