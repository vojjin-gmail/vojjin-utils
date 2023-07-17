<?php
/**
 * Copyright (c) Vojin Petrovic. All rights reserved.
 */

/**
 * Created by PhpStorm.
 * User: imac
 * Date: 3/9/17
 * Time: 4:38 PM
 */

namespace VoxxxUtils\various;


class Validator {
	static function pregcheck($a, $pattern): bool {
		if ($a == "") return false;
		$s = false;
		if (preg_match($pattern, $a)) $s = true;
		return $s;
	}

	static function validate_url($a): bool {
		return self::pregcheck($a, '/^[a-zA-Z0-9\-\_\.\/]{1,255}$/');
	}

	static function validate_com($a): bool {
		return self::pregcheck($a, '/^[a-zA-Z0-9\-\_\.]{1,255}$/');
	}

	static function validate_code($a): bool {
		return self::pregcheck($a, '/^[0-9]{6}$/');
	}

	static function validate_sha($a): bool {
		return self::pregcheck($a, '/^[a-z0-9]{40}$/');
	}

	static function validate_act($a): bool {
		return self::pregcheck($a, '/^[a-z0-9\_]{1,255}$/');
	}

	static function validate_username($a): bool {
		return self::pregcheck($a, '/^[a-zA-Z0-9!@$%*()\-_={}`. ]{2,20}$/');
	}

	static function validate_name($a): bool {
		return (strlen($a) >= 2 && strlen($a) < 40);
	}

	static function validate_message($a): bool {
		return (strlen($a) > 5);
	}

	static function validate_shortcut($a): bool {
		return self::pregcheck($a, '/^[a-zA-Z0-9\-_ ]{2,50}$/');
	}

	static function validate_gender($a): bool {
		return self::pregcheck($a, '/^[mf]{1}$/');
	}

	static function validate_age($a): bool {
		return self::pregcheck($a, '/^[0-9\+\-]{3,6}$/');
	}

	static function validate_ethnicity($a): bool {
		return self::pregcheck($a, '/^[a-zA-Z\- ]{2,20}$/');
	}

	static function validate_email($a) {
		return filter_var($a, FILTER_VALIDATE_EMAIL);
	}

	static function validate_contact_address($a): bool {
		return self::pregcheck($a, '/^[a-zäöüA-ZÄÖÜ0-9#&\,\.\-\(\) ]{2,}$/');
	}

	static function validate_contact_zip($a): bool {
		return self::pregcheck($a, '/^[0-9]{5}$/');
	}

	static function validate_contact_country($a): bool {
		return self::pregcheck($a, '/^[a-zA-Z]{2}$/');
	}

	static function validate_contact_phone($a): bool {
		return self::pregcheck($a, '/^([0-9]{3})(\-)([0-9]{3})(\-)([0-9]{4})$/');
	}

	static function validate_year($a): bool {
		return self::pregcheck($a, '/^[0-9]{4}$/');
	}

	static function validate_mob($a): bool {
		return self::pregcheck($a, '/^([1-9]{1})([0-9]{9,17})$/');
	}

	static function validate_secret($a): bool {
		return self::pregcheck($a, '/^[1-9a-z]{8}$/');
	}

	static function validate_function($a): bool {
		return self::pregcheck($a, '/^[a-zA-Z0-9\_]{1,255}$/');
	}

	static function validate_module($a): bool {
		return self::pregcheck($a, '/^[a-z_0-9]{1,32}$/');
	}

	static function validate_serbian_phone($a): bool {
		return strlen($a) > 7 && strlen($a) < 18;
	}

	static function validate_color($a): bool {
		return self::pregcheck($a, '/^\#[a-fA-F0-9]{6}$/');
	}

	static function validate_color_rgba($a): bool {
		return self::pregcheck($a, '/^\#[a-fA-F0-9]{8}$/');
	}

	static function validate_colorshort($a): bool {
		return self::pregcheck($a, '/^[a-f0-9]{6}$/');
	}

	static function validate_promo($a): bool {
		if (filter_var($a, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return self::pregcheck($a, '/^[a-zA-Z]{1,127}$/');
	}

	static function validate_host($domain): bool {
		if ($domain == "") return false;
		if (filter_var(gethostbyname($domain), FILTER_VALIDATE_IP)) {
			return true;
		}
		return false;
	}

	static function validate_path($a): bool {
		if ($a == "") return true;
		return self::pregcheck($a, '/^[0-9a-z_\/\-]{1,255}$/');
	}

}
