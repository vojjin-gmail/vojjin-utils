<?php

namespace VoxxxUtils\xlsx;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use ReflectionClass;

class ExcelReportStyles {

	public static array $styleDefault = ['font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'size' => 10, 'wrap' => TRUE],
		'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE]];
	public static array $styleDefault12 = ['fill' => ['fillType' => Fill::FILL_NONE], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'size' => 12, 'wrap' => TRUE],
		'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE]];
	public static array $styleBold = ['fill' => ['fillType' => Fill::FILL_NONE], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true],
		'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE]];
	public static array $styleLeftBold = ['fill' => ['fillType' => Fill::FILL_NONE], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true,'size'=>18],
		'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE]];
	public static array $styleCenterBold = ['fill' => ['fillType' => Fill::FILL_NONE], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true],
		'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE]];
	public static array $styleCenter = ['fill' => ['fillType' => Fill::FILL_NONE], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000']],
		'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE]];
	public static array $styleGrayBack = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffeeeeee']]];
	public static array $styleGrayBackBold = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffdddddd']],
		'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true]];
	public static array $styleTeamBack = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffFDE9D9']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000']]];
	public static array $styleCustomBack = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffDAEEF3']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000']]];
	public static array $stylePeersBack = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffE4DFEC']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000']]];
	public static array $styleDRBack = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffEBF1DE']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000']]];
	public static array $styleSSCBack = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffDDD9C4']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000']]];

	public static array $styleZone1 = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffffc7ce']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff9c0006']]];
	public static array $styleZone2 = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffffeb9c']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff9c5700']]];
	public static array $styleZone3 = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffc6efce']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff006100']]];
	public static array $styleZone1Bold = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffffc7ce']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff9c0006'], 'bold' => true]];
	public static array $styleZone2Bold = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffffeb9c']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff9c5700'], 'bold' => true]];
	public static array $styleZone3Bold = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffc6efce']], 'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff006100'], 'bold' => true]];

	public static array $styleTeamBackHBold = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffFCD5B4']],
		'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true]];
	public static array $styleCustomBackHBold = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffB7DEE8']],
		'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true]];
	public static array $stylePeersBackHBold = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffCCC0DA']],
		'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true]];
	public static array $styleDRBackHBold = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffD8E4BC']],
		'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true]];
	public static array $styleSSCBackHBold = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffC4BD97']],
		'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true]];
	public static array $styleCenterHorVer = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE]];
	public static array $styleCenterVer = ['alignment' => ['vertical' => Alignment::HORIZONTAL_CENTER, 'wrap' => TRUE]];
	public static array $styleCenterHor = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'wrap' => TRUE]];
	public static array $styleLeftHor = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'wrap' => TRUE]];
	public static array $styleLeftHorCenterVer = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE]];
	public static array $styleRightHor = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'wrap' => TRUE]];
	public static array $styleRightHorCenterVer = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE]];
	public static array $styleTableHead = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrap' => TRUE],
		'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ffdddddd']],
		'font' => ['type' => Fill::FILL_SOLID, 'color' => ['argb' => 'ff000000'], 'bold' => true]];

	public static array $styleAllBorders = ['borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]]];
	public static array $styleAllBorders2 = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]]];

	public static function mixedStyle($mix, $noborders = false): array {
		if (is_array($mix)) {
			$m = $mix;
		} else {
			$m = explode(" ", $mix);
		}
		$out = array();
		for ($i = 0; $i < count($m); $i++) {
			$stavka = "style" . $m[$i];
			if (property_exists('tpi\xlsx\ExcelReportStyles', $stavka)) {
				$class = new ReflectionClass('tpi\xlsx\ExcelReportStyles');
				$ar = $class->getStaticPropertyValue($stavka);
				if (isset($ar['fill']))
					$out['fill'] = $ar['fill'];
				if (isset($ar['font']))
					$out['font'] = $ar['font'];
			} else if (str_starts_with($m[$i], "s-")) {
				$fs = (int)substr($m[$i], 2);
				if (isset($out['font'])) {
					$out['font']['size'] = $fs;
				} else {
					$out['font'] = array('size' => $fs);
				}
			} else {
				switch ($m[$i]) {
					case "a-c":
						$out['alignment'] = self::$styleCenterHor['alignment'];
						break;
					case "a-cc":
						$out['alignment'] = self::$styleCenterHorVer['alignment'];
						break;
					case "a-r":
						$out['alignment'] = self::$styleRightHor['alignment'];
						break;
					case "a-rc":
						$out['alignment'] = self::$styleRightHorCenterVer['alignment'];
						break;
					case "a-l":
						$out['alignment'] = self::$styleLeftHor['alignment'];
						break;
					case "a-lc":
						$out['alignment'] = self::$styleLeftHorCenterVer['alignment'];
						break;
					case "b":
						if ($noborders === false)
							$out['borders'] = self::$styleAllBorders['borders'];
						break;
					case "bb":
						if ($noborders === false)
							$out['borders'] = self::$styleAllBorders2['borders'];
						break;
				}
			}
		}
		return $out;
	}

}