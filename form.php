<!DOCTYPE html>
<?php
$version = 'v0.2.0+';
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>gcoder</title>
	</head>
	<body>

<aside>
	Note: This software is distributed "AS IS" without any warranties. Use it AT YOUR OWN RISK.
</aside>
<aside>
	Warning: This software is in early stage of development. Gcoder may be 
	unstable and/or produce unpredictable results. Some features are not 
	yet tested at all. 
</aside>
<aside>
	Want to help? Contact me: 
	<mark><script>document.write('gcoder+<?=$version?>ATatDOTlt'.replace('AT','@').replace('DOT','.'))</script></mark>
</aside>
<hr>
<form action="?" method="GET">
	<label for="outsideDiameter">outsideDiameter</label>
	<input name="outsideDiameter" id="outsideDiameter" type="text" value="<?=@$_GET['outsideDiameter']?>">
<br>
	<label for="pitchDiameter">pitchDiameter</label>
	<input name="pitchDiameter" id="pitchDiameter" type="text" value="<?=@$_GET['pitchDiameter']?>">
<br>
	<label for="toothCount">toothCount</label>
	<input name="toothCount" id="toothCount" type="text" value="<?=@$_GET['toothCount']?>">
<br>
	<label for="toothDepth">toothDepth</label>
	<input name="toothDepth" id="toothDepth" type="text" value="<?=@$_GET['toothDepth']?>">
<br>
	<label for="gearWidth">gearWidth</label>
	<input name="gearWidth" id="gearWidth" type="text" value="<?=@$_GET['gearWidth']?>">
<br>
	<label for="cutterDiameter">cutterDiameter</label>
	<input name="cutterDiameter" id="cutterDiameter" type="text" value="<?=@$_GET['cutterDiameter']?>">
<br>
	<label for="gearType">gearType</label>
	<select name="gearType" id="gearType">
		<option value="rh" <?=('rh'==@$_GET['gearType'])?'selected="selected"':'';?>>Right Hand</option>
		<option value="lh" <?=('lh'==@$_GET['gearType'])?'selected="selected"':'';?>>Left Hand</option>
	</select>
<br>
	<label for="angle">angle</label>
	<input name="angle" id="angle" type="text" value="<?=@$_GET['angle']?>">
<hr>
	<label for="cutFrom">cutFrom</label>
	<select name="cutFrom" id="cutFrom">
		<option value="-1" <?=(@$_GET['cutFrom']<0)?'selected="selected"':'';?>>Y negative (front)</option>
		<option value="+1" <?=(@$_GET['cutFrom']>0)?'selected="selected"':'';?>>Y positive (rear)</option>
	</select>
<br>
	<label for="roughingStepDown">roughingStepDown</label>
	<input name="roughingStepDown" id="roughingStepDown" type="text" value="<?=@$_GET['roughingStepDown']?>">
<br>
	<label for="finishingStepDown">finishingStepDown</label>
	<input name="finishingStepDown" id="finishingStepDown" type="text" value="<?=@$_GET['finishingStepDown']?>">
<br>
	<label for="safetyDistance">safetyDistance</label>
	<input name="safetyDistance" id="safetyDistance" type="text" value="<?=@$_GET['safetyDistance']?>">
<br>
	<label for="feed">feed</label>
	<input name="feed" id="feed" type="text" value="<?=@$_GET['feed']?>">
<br>
	<label for="seek">seek</label>
	<input name="seek" id="seek" type="text" value="<?=@$_GET['seek']?>">
<br>
	<input name="generate" id="generate" type="submit" value="generate">
	<input name="download" id="download" type="submit" value="download">

</form>

<br>
<hr>

<aside>

	Donations are accepted via PayPal: 
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="display:inline;">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="DCPCKQYH9TRNL">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
 
	and GitTip: <script data-gittip-username="dariuskt"
        data-gittip-widget="button"
        src="//gttp.co/v1.js"></script>

</aside>


</body>
</html>
