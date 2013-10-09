<?php


class Gcode {

	public static function array2g($arr) {
		$a=array();
		foreach ($arr as $name => $value) {
			$a []= sprintf("%s%.3f", strToUpper($name), $value);
		}
		return implode(" ", $a);
	}

	public static function seek($array) {
		return sprintf("G0 %s\n", Gcode::array2g($array));
	}

	public static function feed($array) {
		return sprintf("G1 %s\n", Gcode::array2g($array));
	}

	

}
