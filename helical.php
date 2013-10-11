<?php

require_once("gcode.php");


class Helical {

	private $outsideDiameter = null;
	private $pitchDiameter = null;
	private $toothCount = null;
	private $toothDepth = null;
	private $gearWidth = null;
	private $cutterDiameter = null;
	private $angle = null;
	private $cutFrom = null;
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
		$s=sprintf("(TOOTH %d/%d)\n", $toothNumber+1, $this->toothCount);

		$y0 = (($this->outsideDiameter + $this->cutterDiameter) / 2);
		$a0 = 360 / $this->toothCount * $toothNumber;

		// go to safety distance
		$s.=Gcode::seek(array(
			'y' => ($y0 + $this->safetyDistance) * $this->cutFrom,
		));

		$s.=Gcode::seek(array(
			'x' => -$this->leadInOut,
			'a' => $a0 * $this->cutFrom,
		));

		$s.=Gcode::seek(array(
			'y' => ($y0 - $this->toothDepth) * $this->cutFrom,
		));

		$s.=Gcode::feed(array(
			'x' => $this->gearWidth + $this->leadInOut,
			'a' => ($a0 + $this->toothAngle) * $this->cutFrom,
		));

		$s.=Gcode::seek(array(
			'y' => ($y0 + $this->safetyDistance) * $this->cutFrom,
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
		$gcode.= sprintf("G54\n");
		$gcode.= sprintf("G90\n");
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



