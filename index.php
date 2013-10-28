<?php

require_once("helical.php");

$reqFields = array(
	'outsideDiameter'   => 15,
	'pitchDiameter'     => 12.7,
	'toothCount'        => 12,
	'toothDepth'        => 2.1,
	'gearWidth'         => 10,
	'cutterDiameter'    => 30,
	'gearType'          => 'rh',
	'angle'             => 45,
	'roughingStepDown'  => 10,
	'finishingStepDown' => 0,
	'cutFrom'           => -1,
	'safetyDistance'    => 3,
	'feed'              => 50,
	'seek'              => 900,
);
foreach ($reqFields as $name=>$value) {
	if (isset($_GET) && !isset($_GET[$name]) || strLen($_GET[$name]) == 0) {
		header(sprintf("Location: ?%s\n", http_build_query($reqFields)));
		exit;
	}
}


if ( !empty($_GET['download']) ) {
	header("Content-type: Text/Plain\n");
	header(sprintf('Content-disposition: attachment; filename="%s"'
		, $_GET['gearType'] . $_GET['angle'] . '_'
		. $_GET['toothCount'] . 'tooth' . '_'
		. $_GET['gearWidth'] . 'width' . '_'
		. (($_GET['cutFrom']<0)?'frontCut':'backCut') 
		. '.ngc')); 

	$_GET['angle'] *= ($_GET['gearType']=='lh')?-1:1;

	$h = new Helical($_GET);
	echo $h->gcode();
} else {
	include('form.php');
}


