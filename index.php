<?php

$reqFields = array(
	'outsideDiameter' => 15,
	'pitchDiameter'   => 12.7,
	'toothCount'      => 12,
	'toothDepth'      => 2.1,
	'gearWidth'       => 10,
	'cutterDiameter'  => 30,
	'angle'           => 45,
	'safetyDistance'  => 3,
	'feed'            => 50,
	'seek'            => 900,
);
if (php_sapi_name() != 'cli') {
	foreach ($reqFields as $name=>$value) {
		if (isset($_GET) && !isset($_GET[$name]) || strLen($_GET[$name]) == 0) {
			header(sprintf("Location: ?%s\n", http_build_query($reqFields)));
			exit;
		}
	}
}

// positive angle = right, negative = left
if ( php_sapi_name() == 'cli' ) {
	$h = new Helical($reqFields);
} else {
	header("Content-type: Text/Plain\n");
	$h = new Helical($_GET);
}
echo $h->gcode();


class Helical {

	private $outsideDiameter = null;
	private $pitchDiameter = null;
	private $toothCount = null;
	private $toothDepth = null;
	private $gearWidth = null;
	private $cutterDiameter = null;
	private $angle = null;
	private $safetyDistance = null;
	private $feed = null;
	private $seek = null;

	private $leadInOut = null;
	private $toothAngle = null;


	public function __construct($params=array()) {
		foreach ($params as $name => $value) {
			$this->$name = $value;
		}
	}

	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}
	    return $this;
	}

	public function __toString() {
		$str = '';
		foreach (get_object_vars($this) as $name=>$val) {
			$str.= sprintf("(%s = %s)\n", $name, $val);
		}
		return $str;
	}

	private function tooth2g($toothNumber) {
		$s=sprintf("(TOOTH %d)\n", $toothNumber);

		$y0 = (($this->outsideDiameter + $this->cutterDiameter) / 2);
		$a0 = 360 / $this->toothCount * $toothNumber;

		// go to safety distance
		$s.=Gcode::seek(array(
			'y' => $y0 + $this->safetyDistance,
		));

		$s.=Gcode::seek(array(
			'x' => -$this->leadInOut,
			'a' => $a0,
		));

		$s.=Gcode::seek(array(
			'y' => $y0 - $this->toothDepth,
		));

		$s.=Gcode::feed(array(
			'x' => $this->gearWidth + $this->leadInOut,
			'a' => $a0 + $this->toothAngle,
		));

		$s.=Gcode::seek(array(
			'y' => $y0 + $this->safetyDistance,
		));

		return $s;
	}

	public function gcode() {
		$this->leadInOut = $this->getLeadInOut(
			$this->cutterDiameter, 
			$this->toothDepth
		);

		$this->toothAngle = $this->getToothAngle(
			$this->pitchDiameter,
 			$this->gearWidth+2*$this->leadInOut,
			$this->angle
		);

		$gcode="(helical gear g-code generator)\n";
		$gcode.="(author Darius Vozbutas <dariuskt@gmail.com>)\n";
		$gcode.="\n";
		$gcode.=$this->__toString();
		$gcode.="\n";


		// setup coordinate system
		$gcode.= sprintf("G21\n");
		$gcode.= sprintf("G90\n");
		//$gcode.= sprintf("G92 X0 Y%.3f Z0 A0\n", ($this->outsideDiameter + $this->cutterDiameter) /2 );
		$gcode.= sprintf("G0 F%d\n", $this->seek );
		$gcode.= sprintf("G1 F%d\n", $this->feed );

		for ($tooth=0; $tooth<$this->toothCount; $tooth++) {
			$gcode.="\n";
			$gcode.= $this->tooth2g($tooth);
		}

		$gcode.="\n";
		$gcode.="M2\n";
	
		return $gcode;
	}

	/**
	 * @url http://en.wikipedia.org/wiki/Sagitta_(geometry)
	 * @todo should I take gead angle into account here?
	 */
	public static function getLeadInOut($cutterDiameter, $toothDepth) {
		return sqrt( ($cutterDiameter * $toothDepth) - pow($toothDepth,2) );
	}
	/**
	 * @url http://en.wikipedia.org/wiki/Trigonometric_functions#Properties_and_applications
	 * @todo take into account leadInOut distances
	 */
	public static function getToothAngle($pitchDiameter, $width, $angle) {
		$absAngle = abs($angle);
		$otherAngle = 90 - $absAngle;
		$tmp1 = sin(deg2rad($otherAngle))/$width;
		$angleLenght = sin(deg2rad($absAngle))/$tmp1;

		$circleLenght = M_PI * $pitchDiameter;

		$toothAngle = ( 360 / $circleLenght ) * $angleLenght;

		return ($angle<0)?-$toothAngle:$toothAngle;
	}

}




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
