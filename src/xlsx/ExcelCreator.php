<?php
/**
 * Copyright (c) 2020 Job Manager Application. All rights reserved.
 */

namespace VoxxxUtils\xlsx;

use PhpOffice\PhpSpreadsheet\Exception as ExcelExcepton;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExcelCreator {
	public Spreadsheet $spreadsheet;
	public Worksheet $sheet;
	public int $row = 0;
	public int $columns = 0;
	public string $filePath = "";

	public function __construct(string $filePath) {
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = new Worksheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		try {
			$this->sheet->getParent()->getDefaultStyle()->getFont()->setSize(11);
		} catch (ExcelExcepton) {
		}
		$this->filePath = $filePath;
	}

	public function saveExcel(): bool {
		$writer = new Xlsx($this->spreadsheet);
		try {
			$writer->save($this->filePath);
		} catch (ExcelExcepton) {
			return false;
		}
		return true;
	}

	public function wrapText($cells, $value, $style = []): void {
		if (str_contains($cells, ":")) {
			$c = explode(":", $cells);
			try {
				$this->sheet->mergeCells($cells);
			} catch (ExcelExcepton) {
			}
			$this->sheet->setCellValue($c[0], ($value));
		} else {
			$this->sheet->setCellValue($cells, ($value));
		}
		$this->applyStyle($cells, $style);
	}

	public function wrapTextsInARow($row, $values, $style = []): void {
		for ($i = 0; $i < count($values); $i++) {
			$this->sheet->setCellValue(ExcelFunctions::excelColumn(1 + $i) . $row, $values[$i]);
		}
	}

	public function wrapTitle(ExcelColumn $excolumn, $row): void {
		if ($excolumn->Hsize == 1 && $excolumn->Vsize == 1) {
			$this->wrapText(ExcelFunctions::excelColumn($excolumn->start) . $row, $excolumn->title);
		} else {
			if (count($excolumn->subtitles) > 0) {
				$this->wrapText(ExcelFunctions::excelColumn($excolumn->start) . $row . ":" . ExcelFunctions::excelColumn($excolumn->start + $excolumn->Hsize - 1) . ($row), $excolumn->title);
				for ($i = 0; $i < count($excolumn->subtitles); $i++) {
					$this->wrapText(ExcelFunctions::excelColumn($excolumn->start + $i) . ($row + 1), $excolumn->subtitles[$i]);

				}
			} else {
				$this->wrapText(ExcelFunctions::excelColumn($excolumn->start) . $row . ":" . ExcelFunctions::excelColumn($excolumn->start + $excolumn->Hsize - 1) . ($row + $excolumn->Vsize - 1), $excolumn->title);

			}
		}
	}

	public function applyStyle($cells, $style = []): void {
		if (is_array($style)) {
			if (count($style) > 0) {
				try {
					$this->sheet->getStyle($cells)->applyFromArray(ExcelReportStyles::mixedStyle($style));
				} catch (ExcelExcepton) {
				}
			}

		} else {
			if ($style != "") {
				try {
					$this->sheet->getStyle($cells)->applyFromArray(ExcelReportStyles::mixedStyle($style));
				} catch (ExcelExcepton) {
				}
			}

		}
	}

	public function borderText($cells): void {
		try {
			$this->sheet->getStyle($cells)->applyFromArray(ExcelReportStyles::$styleAllBorders2);
		} catch (Exception $e) {
		}
	}

}