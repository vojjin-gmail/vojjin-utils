<?php

namespace VoxxxUtils\inputs;

use ReflectionObject;
use ReflectionProperty;

class StandardObject {
	public function __construct($a = "") {
		if (is_object($a)) {
			$arr = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);
			foreach ($arr as $property) {
				$name = $property->getName();
				if (isset($a->{$name})) {
					$this->{$name} = $a->{$name};
				}
			}
		} else {
			if ($a != "") {
				$s = json_decode($a);
				$arr = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);
				foreach ($arr as $property) {
					$name = $property->getName();
					if (isset($s->{$name})) {
						$this->{$name} = $s->{$name};
					}
				}
			}
		}
	}

}