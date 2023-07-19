<?php

namespace VoxxxUtils\xlsx;

class ExcelColumn {
	public string $title = "";
	public int $Hsize = 1;
	public int $Vsize = 1;
	public array $subtitles = [];
	public int $start = 0;

	public function __construct($title, $start, $Hsize = 1, $Vsize = 1, $subtitles = []) {
		$this->title = $title;
		$this->start = $start;
		$this->Hsize = $Hsize;
		$this->Vsize = $Vsize;
		$this->subtitles = $subtitles;
	}

	public function startCol($delta = 0): string {
		return ExcelFunctions::excelColumn($this->start + $delta);
	}

	public function endCol($delta = 0): string {
		return ExcelFunctions::excelColumn($this->start + $delta + $this->Hsize - 1);
	}
}