<?php

require_once("helical.php");

$reqFields = array(
	'outsideDiameter' => 15,
	'pitchDiameter'   => 12.7,
	'toothCount'      => 12,
	'toothDepth'      => 2.1,
	'gearWidth'       => 10,
	'cutterDiameter'  => 30,
	'gearType'        => 'rh',
	'angle'           => 45,
	'safetyDistance'  => 3,
	'feed'            => 50,
	'seek'            => 900,
);
foreach ($reqFields as $name=>$value) {
	if (isset($_GET) && !isset($_GET[$name]) || strLen($_GET[$name]) == 0) {
		header(sprintf("Location: ?%s\n", http_build_query($reqFields)));
		exit;
	}
}


if ( !empty($_GET['download']) ) {
	header("Content-type: Text/Plain\n");

	$_GET['angle'] *= ($_GET['gearType']=='lh')?-1:1;

	$h = new Helical($_GET);
	echo $h->gcode();
} else {
	include('form.php');
}


