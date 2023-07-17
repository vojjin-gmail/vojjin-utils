<?php
/**
 * Created by PhpStorm.
 * User: Vojin
 * Date: 03-Apr-16
 * Time: 15:03
 */

namespace VoxxxUtils\various;

use DateTime;

class DateClass {
	const NULLTIME = "2001-01-01 00:00:00";
	const NULLDATE = "2001-01-01";


	static function now(): string {
		return date('Y-m-d H:i:s');
	}

	static function nowShort(): string {
		return date('Y-m-d');
	}

	static function nowMorning(): string {
		return date('Y-m-d 00:00:00');
	}

	static function dateToString(int|string $a): string {
		return date('Y-m-d H:i:s', is_string($a) ? self::stringToDate($a) : $a);
	}

	static function dateToStringShort(int|string $a): string {
		return date('Y-m-d', is_string($a) ? self::stringToDate($a) : $a);
	}

	static function dateToStringMorning(int|string $a): string {
		return date('Y-m-d', is_string($a) ? self::stringToDate($a) : $a) . " 00:00:00";
	}

	static function tomorrowMorning(): string {
		return date('Y-m-d 00:00:00', time() + 86400);
	}

	static function dateToStringTomorrowMorning(): string {
		return date('Y-m-d 00:00:00', time() + 86400);
	}


	static function nowTimeShort(): string {
		return date('H:i:s');
	}


	static function before($a): string {
		return date('Y-m-d H:i:s', time() - $a);
	}

	static function beforeShort($a): string {
		return date('Y-m-d', time() - $a);
	}


	public static function getDayBegin(int|string $time): int {
		return self::stringToDate(self::dateToStringMorning($time));
	}

	static function yearWeekDayofweek(?int $time = null, int $offset = 0): array {
		if ($time == null) $time = time();
		$week = (int)date('W', $time - $offset);
		$year = (int)date('Y', $time - $offset);
		$dayofweek = (int)date('N', $time - $offset);
		if ((int)date('m', $time - $offset) == 1 && $week > 40)
			$year--;
		return [$year, $week, $dayofweek];
	}

	public static function getWeekdayStart(int $time): bool|int {
		$day = date("w", $time);
		$diff = $day - 1;
		if ($diff > 0) {
			$time -= $diff * 86400;
		} else if ($diff < 0) {
			$time -= (7 + $diff) * 86400;
		}
		return mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
	}

	public static function timeDiff(int|string $time1, int|string $time2): int {
		return (is_string($time2) ? self::stringToDate($time2) : $time2) - (is_string($time1) ? self::stringToDate($time1) : $time1);
	}

	public static function passedTime(int|string $time1, int|string $time2, int $levels = 6): string {
		$a = self::timeDiff($time1, $time2);
		if ($levels < 1) $levels = 1;
		if ($levels > 6) $levels = 6;
		$ar = [0, 0, 0, 0, 0, 0];
		$arSign = ["Y", "D", "M", "h", "m", "s"];
		$ar[2] = (int)floor($a / 86400);
		$a -= $ar[2] * 86400;
		$ar[3] = (int)floor($a / 3600);
		$a -= $ar[3] * 3600;
		$ar[4] = (int)floor($a / 60);
		$ar[5] = (int)floor($a - 60 * $ar[4]);
		if ($ar[2] > 365) {
			$ar[0] = (int)floor($ar[2] / 365.25);
			$ar[2] -= 365 * $ar[0];
			if ($ar[2] > 30) {
				$ar[1] = (int)floor($ar[2] / 30.4375);
				$ar[2] -= 30 * $ar[1];
			}
		}
		$startFrom = 0;
		$roundField = $startFrom + $levels;
		if ($ar[0] == 0) {
			$startFrom = 1;
			$roundField = max(6, $startFrom + $levels);
			if ($ar[1] == 0) {
				$startFrom = 2;
				$roundField = max(6, $startFrom + $levels);
				if ($ar[2] == 0) {
					$startFrom = 3;
					$roundField = max(6, $startFrom + $levels);
					if ($ar[3] == 0) {
						$startFrom = 4;
						$roundField = max(6, $startFrom + $levels);
						if ($ar[4] == 0) {
							$startFrom = 5;
							$roundField = max(6, $startFrom + $levels);
						}
					}
				}
			}
		}
		if ($roundField < 6) {
			if ($roundField == 5) {
				if ($ar[5] > 29) {
					$ar[4]++; //minutes ++
				}
				if ($ar[4] > 59) {
					$ar[4] = 0;
					$ar[3]++; //hours ++
				}
				if ($ar[3] > 23) {
					$ar[3] = 0;
					$ar[2]++; //days ++
				}
				if ($ar[2] > 29) {
					$ar[2] = 0;
					$ar[1]++; //months++
				}
				if ($ar[1] > 11) {
					$ar[1] = 0;
					$ar[0]++; //years++
				}
			} else if ($roundField == 4) {
				if ($ar[4] > 29) {
					$ar[3]++; //hours ++
				}
				if ($ar[3] > 23) {
					$ar[3] = 0;
					$ar[2]++; //days ++
				}
				if ($ar[2] > 29) {
					$ar[2] = 0;
					$ar[1]++; //months++
				}
				if ($ar[1] > 11) {
					$ar[1] = 0;
					$ar[0]++; //years++
				}
			} else if ($roundField == 3) {
				if ($ar[3] > 11) {
					$ar[2]++; //days ++
				}
				if ($ar[2] > 29) {
					$ar[2] = 0;
					$ar[1]++; //months++
				}
				if ($ar[1] > 11) {
					$ar[1] = 0;
					$ar[0]++; //years++
				}
			} else if ($roundField == 2) {
				if ($ar[2] > 14) {
					$ar[1]++; //months++
				}
				if ($ar[1] > 11) {
					$ar[1] = 0;
					$ar[0]++; //years++
				}
			} else if ($roundField == 1) {
				if ($ar[1] > 5) {
					$ar[0]++; //years++
				}
			}
		}
		$out = [];
		for ($i = $startFrom; $i < $startFrom + $levels; $i++) {
			if ($i < 6) {
				if ($ar[$i] > 0) {
					$out[] = $ar[$i] . $arSign[$i];
				}

			}
		}
		return implode(" ", $out);
	}

	public static function passedTimeMinSec(int|string $time1, int|string $time2): string {
		$a = self::timeDiff($time1, $time2);
		$secs = $a % 60;
		$mins = ($a - $secs) / 60;
		return sprintf("%02s", $mins) . ":" . sprintf("%02s", $secs);
	}

	static function stringToDate(string $timeStr): int {
		if ($timeStr == self::NULLTIME) return 0;
		if (!self::validateDateStr($timeStr)) return 0;
		return strtotime($timeStr);
	}

	public static function validateDateStr($date, $format = 'Y-m-d H:i:s'): bool {
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}

}