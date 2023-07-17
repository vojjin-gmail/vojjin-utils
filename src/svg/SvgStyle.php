<?php
/**
 * Copyright (c) Vojin Petrovic. All rights reserved.
 */

/**
 * Created by PhpStorm.
 * User: imac
 * Date: 10/1/17
 * Time: 12:54 AM
 */

namespace VoxxxUtils\svg;
class SvgStyle {
	private string $fill, $stroke, $strokeLinecap, $strokeDash;
	private float $strokeWidth, $opacity;

	public function __construct() {
		$this->fill = "#000000";
		$this->stroke = "#000000";
		$this->strokeWidth = 0;
		$this->opacity = 1;
		$this->strokeLinecap = "butt";
		$this->strokeDash = "0";
	}

	public function setStyle(string $fill = "#000000", float $opacity = 1, string $stroke = "#000000", float $strokeWidth = 0, string $strokelinecap = "butt", string $strokedash = ""): void {
		$this->fill = $fill;
		$this->opacity = $opacity;
		$this->stroke = $strokeWidth > 0 ? $stroke : "";
		$this->strokeWidth = $strokeWidth;
		$this->strokeLinecap = $strokeWidth > 0 ? $strokelinecap : "";
		$this->strokeDash = $strokeWidth > 0 ? $strokedash : "";
	}

	public function setFillStyle(string $fill = "#000000"): void { $this->fill = $fill; }

	public function setStroke(string $stroke = "#000000"): void { $this->stroke = $stroke; }

	public function setStrokeWidth(float $sw = 1): void { $this->strokeWidth = $sw; }

	public function setOpacity(float $opacity = 1): void { $this->opacity = $opacity; }

	public function setLineCap(string $linecap = "butt"): void { $this->strokeLinecap = $linecap; }

	public function setLineDash(string $dahses = ""): void { $this->strokeDash = $dahses; }


	public function getStyle(): string {
		$out = ' fill="' . $this->fill . '" opacity="' . $this->opacity . '"';
		if ($this->strokeWidth > 0) {
			$out .= ' stroke="' . $this->stroke . '" stroke-width="' . $this->strokeWidth . '"';
			if ($this->strokeLinecap != "butt") $out .= ' stroke-linecap="' . $this->strokeLinecap . '"';
			if ($this->strokeDash != "") $out .= ' stroke-dasharray="' . $this->strokeDash . '"';
		} else {
			$out .= ' stroke-width="0"';
		}
		return $out;
	}

}