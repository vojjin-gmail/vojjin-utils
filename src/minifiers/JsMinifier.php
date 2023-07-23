<?php

namespace VoxxxUtils\minifiers;

class JsMinifier {

	public static function initJs(array $jsFiles, string $combinedFile): void {
		$f = fopen($combinedFile, "w");
		foreach ($jsFiles as $jsFile) {
			$js = file_get_contents($jsFile[0]);
			if ($jsFile[1] === true) {
				$out = self::compressJs($js);
			} else {
				$out = $js;
			}
			fwrite($f, $out . "\n");
		}
		fclose($f);
	}

	public static function compressJs($js): array|string {
		$chr0 = chr(0);
		$chr1 = chr(1);
		$st = 0;
		while (true) {
			$j1 = strpos($js, "//", $st);
			if ($j1 === false) break;
			if (substr($js, $j1 - 1, 1) == ":" || substr($js, $j1 - 1, 1) == "'" || substr($js, $j1 - 1, 1) == '"') {
				$st = $j1 + 2;
			} else {
				$j2 = strpos($js, "\n", $j1 + 1);
				$js1 = substr($js, 0, $j1);
				$js2 = substr($js, $j2);
				$js = $js1 . $js2;
				$st = $j1;
			}
		}
		$js = str_replace("\t", "", $js);
		$js = str_replace("\r", "", $js);
		$js = str_replace("\n", "", $js);

		$pattern = '/\/\*(.*?)\*\//i';
		$replacement = '';
		$js = preg_replace($pattern, $replacement, $js);
		$js = str_replace("''", "'" . $chr1 . "'", $js);
		$js = str_replace('""', '"' . $chr1 . '"', $js);

		$rplBefore = "||@-";
		$rplAfter = "-@||";

		preg_match_all("/(?:(?:\"(?:\\\\\"|[^\"])+\")|(?:'(?:\\\'|[^'])+'))/i", $js, $match);
		foreach ($match[0] as $id => $m) {
			$js = self::str_replace_first($m, $rplBefore . $id . $rplAfter, $js);
		}
		$js = str_replace("  ", " ", $js);
		$js = str_replace("  ", " ", $js);
		$js = str_replace("  ", " ", $js);
		$statements = ["let", "var", "return", "class", "const", "function", "new", "typeof", "abstract", "as", "delete", "case", "switch",
			"instanceof", "extends", "export", "final", "implements", "import", "package", "private", "public", "super", "static", "interface",
			"void", "throw", "await", "async"];

		$statements = ["abstract", "arguments", "await", "boolean",
			"break", "byte", "case", "catch",
			"char", "class", "const", "continue",
			"debugger", "default", "delete", "do",
			"double", "enum", "eval",
			"export", "extends", "false", "final",
			"finally", "float", "for", "function",
			"goto","implements", "import",
			"instanceof", "int", "interface",
			"let", "long", "native", "new",
			"null", "package", "private", "protected",
			"public", "return", "short", "static",
			"super", "switch", "synchronized", "this",
			"throw", "throws", "transient", "true",
			"try", "typeof", "var", "void",
			"volatile", "while", "with", "yield"];

		foreach ($statements as $statement) {
			$js = str_replace($statement . " ", $statement . $chr0, $js);
		}
		$js = str_replace("else if", "else" . $chr0 . "if", $js);
		$js = str_replace(" else ", $chr0 . "else" . $chr0, $js);
		$js = str_replace(" in ", $chr0 . "in" . $chr0, $js);
		$js = str_replace(" ", "", $js);
		$js = str_replace($chr0, " ", $js);

		$js = str_replace("},}", "}}", $js);
		$js = str_replace("function (", "function(", $js);
		$js = str_replace("return ;", "return;", $js);
		foreach ($match[0] as $id => $m) {
			$js = str_replace($rplBefore . $id . $rplAfter, $m, $js);
		}
		return str_replace(chr(1), "", $js);
	}

	static function str_replace_first($search, $replace, $subject): array|string|null {
		$search = '/' . preg_quote($search, '/') . '/';
		return preg_replace($search, $replace, $subject, 1);
	}
}