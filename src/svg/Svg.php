<?php
/**
 * Copyright (c) Vojin Petrovic. All rights reserved.
 */

/**
 * Created by PhpStorm.
 * User: imac
 * Date: 8/27/17
 * Time: 3:58 AM
 */
namespace VoxxxUtils\svg;

class Svg {
	private int $width, $height;
	private string $output;
	private array $styles = array();
	private array $path = array();

	public function __construct($width = 640, $height = 480, $class = "", $id = "") {
		$this->width = $width;
		$this->height = $height;
		$this->output = '<svg ' . ($class != "" ? ' class="' . $class . '"' : "") . ($id != "" ? ' id="' . $id . '"' : "") . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 ' . $this->width . ' ' . $this->height . '" xml:space="preserve" >' . "\n";

		$this->styles['default'] = new SvgStyle();
	}

	public function addStyle($stylename, $fill = "#000000", $opacity = 1, $stroke = "#000000", $strokeWidth = 0, $strokelinecap = "butt", $strokedash = ""): void {
		$this->styles[$stylename] = new SvgStyle();
		$this->styles[$stylename]->setStyle($fill, $opacity, $stroke, $strokeWidth, $strokelinecap, $strokedash);
	}


	public function addLine($x1 = 0, $y1 = 0, $x2 = 100, $y2 = 100, $style = "default"): void {
		$this->output .= '<line x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '" ' . $this->styles[$style]->getStyle() . ' />' . "\n";
	}

	public function addRect($x = 0, $y = 0, $w = 100, $h = 100, $style = "default"): void {
		$this->output .= '<rect x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '" ' . $this->styles[$style]->getStyle() . ' />' . "\n";
	}

	public function addText($text = "text", $x = 0, $y = 0, $fontname = "Calibri", $fontsize = 12, $align="", $style = "default"): void {
		$this->output .= '<text transform="matrix(1 0 0 1 ' . $x . ' ' . $y . ')" font-family="\'' . $fontname . '\'" font-size="' . $fontsize . '" ' . ($align=="center"?' text-anchor="middle" ':' ') .($align=="right"?' text-anchor="end" ':' ') . $this->styles[$style]->getStyle() . '>' . $text . '</text>' . "\n";
	}

	public function addCircle($cx = 0, $cy = 0, $r = 1, $style = "default"): void {
		$this->output .= '<circle cx="' . $cx . '" cy="' . $cy . '" r="' . $r . '" ' . $this->styles[$style]->getStyle() . '/>' . "\n";
	}

	public function addEllipse($cx = 0, $cy = 0, $rx = 1, $ry = 1, $style = "default"): void {
		$this->output .= '<ellipse cx="' . $cx . '" cy="' . $cy . '" rx="' . $rx . '" ry="' . $ry . '" ' . $this->styles[$style]->getStyle() . '/>' . "\n";
	}

	public function addPolygon($dots = array(), $style = "default"): void {
		$this->output .= '<polygon points="' . implode(" ", $dots) . '" ' . $this->styles[$style]->getStyle() . ' />' . "\n";
	}

	public function addPolyline($dots = array(), $style = "default"): void {
		$this->output .= '<polyline points="' . implode(" ", $dots) . '" ' . $this->styles[$style]->getStyle() . ' />' . "\n";
	}

	public function addPath($path = "", $style = "default"): void {
		$this->output .= '<path d="' . $path . '" ' . $this->styles[$style]->getStyle() . ' />' . "\n";
	}

	function path_initialize(): void {
		$this->path = array();
	}

	function path_moveTo($x, $y, $relative = false): void {
		$name = $relative ? 'm' : 'M';
		$command = $name . $x . ',' . $y;
		$this->path[] = $command;
	}

	function path_lineTo($x, $y, $relative = false): void {
		$name = $relative ? 'l' : 'L';
		$command = $name . $x . ',' . $y;
		$this->path[] = $command;
	}

	function path_horizontalLineTo($x, $relative = false): void {
		$name = $relative ? 'h' : 'H';
		$command = $name . $x;
		$this->path[] = $command;
	}

	function path_verticalLineTo($y, $relative = false): void {
		$name = $relative ? 'v' : 'V';
		$command = $name . $y;
		$this->path[] = $command;
	}

	function path_curveTo($x1, $y1, $x2, $y2, $x, $y, $relative = false): void {
		$name = $relative ? 'c' : 'C';
		$command = $name . $x1 . ',' . $y1 . ' ' . $x2 . ',' . $y2 . ' ' . $x . ',' . $y;
		$this->path[] = $command;
	}

	function path_smoothCurveTo($x1, $y1, $x2, $y2, $x, $y, $relative = false): void {
		$name = $relative ? 'c' : 'C';
		$command = $name . $x1 . ',' . $y1 . ' ' . $x2 . ',' . $y2 . ' ' . $x . ',' . $y;
		$this->path[] = $command;
	}

	function path_quadraticCurveTo($x1, $y1, $x, $y, $relative = false): void {
		$name = $relative ? 'q' : 'Q';
		$command = $name . $x1 . ',' . $y1 . ' ' . $x . ',' . $y;
		$this->path[] = $command;
	}

	function path_smoothQuadraticCurveTo($x, $y, $relative = false): void {
		$name = $relative ? 't' : 'T';
		$command = $name . $x . ',' . $y;
		$this->path[] = $command;
	}

	function path_ellipticalArch($rx, $ry, $x_axis_rotation, $large_arch_flag, $sweep_flag, $x, $y, $relative = false): void {
		$name = $relative ? 'a' : 'A';
		$command = $name . $rx . ',' . $ry . ' ' . $x_axis_rotation . ' ' . $large_arch_flag . ',' . $sweep_flag . ' ' . $x . ',' . $y;
		$this->path[] = $command;
	}

	function path_close($relative = false): void {
		$name = $relative ? 'z' : 'Z';
		$command = $name;
		$this->path[] = $command;
	}

	function path_get(): string {
		$output = '';
		foreach ($this->path as $command)
			$output .= $command . ' ';
		return $output;
	}

	public function out(): string {
		return $this->output . "</svg>";
	}
}
