<?php

namespace VoxxxUtils\xlsx;



use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelReader {

	private IReader $reader;
	private Spreadsheet $spreadsheet;
	public array $allRows = [];

	/**
	 * @throws Exception
	 * @throws Exception|\PhpOffice\PhpSpreadsheet\Calculation\Exception
	 */
	public function __construct(string $file) {
		$this->reader = IOFactory::createReader(IOFactory::READER_XLS);
		$this->spreadsheet = $this->reader->load($file);
		foreach ($this->spreadsheet->getWorksheetIterator() as $worksheet) {
			foreach ($worksheet->getRowIterator() as $row) {
				$currentRow = [];
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
				foreach ($cellIterator as $cell) {
					if (!is_null($cell)) {
						$currentRow[] = $cell->getCalculatedValue();
					}
				}
				$this->allRows[] = $currentRow;
			}
		}
	}
}