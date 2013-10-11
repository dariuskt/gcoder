<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>gcoder</title>
	</head>
	<body>


<form action="?" method="GET">
	<label for="outsideDiameter">outsideDiameter</label>
	<input name="outsideDiameter" id="outsideDiameter" type="text" value="<?=@$_GET['outsideDiameter']?>">
<br/>
	<label for="pitchDiameter">pitchDiameter</label>
	<input name="pitchDiameter" id="pitchDiameter" type="text" value="<?=@$_GET['pitchDiameter']?>">
<br/>
	<label for="toothCount">toothCount</label>
	<input name="toothCount" id="toothCount" type="text" value="<?=@$_GET['toothCount']?>">
<br/>
	<label for="toothDepth">toothDepth</label>
	<input name="toothDepth" id="toothDepth" type="text" value="<?=@$_GET['toothDepth']?>">
<br/>
	<label for="gearWidth">gearWidth</label>
	<input name="gearWidth" id="gearWidth" type="text" value="<?=@$_GET['gearWidth']?>">
<br/>
	<label for="cutterDiameter">cutterDiameter</label>
	<input name="cutterDiameter" id="cutterDiameter" type="text" value="<?=@$_GET['cutterDiameter']?>">
<br/>
	<label for="gearType">gearType</label>
	<select name="gearType" id="gearType">
		<option value="rh" <?=('rh'==@$_GET['gearType'])?'selected="selected"':'';?>>Right Hand</option>
		<option value="lh" <?=('lh'==@$_GET['gearType'])?'selected="selected"':'';?>>Left Hand</option>
	</select>
<br/>
	<label for="angle">angle</label>
	<input name="angle" id="angle" type="text" value="<?=@$_GET['angle']?>">
<br/>
	<label for="cutFrom">cutFrom</label>
	<select name="cutFrom" id="cutFrom">
		<option value="-1" <?=(@$_GET['cutFrom']<0)?'selected="selected"':'';?>>Y negative (front)</option>
		<option value="+1" <?=(@$_GET['cutFrom']>0)?'selected="selected"':'';?>>Y positive (rear)</option>
	</select>
<br/>
	<label for="safetyDistance">safetyDistance</label>
	<input name="safetyDistance" id="safetyDistance" type="text" value="<?=@$_GET['safetyDistance']?>">
<br/>
	<label for="feed">feed</label>
	<input name="feed" id="feed" type="text" value="<?=@$_GET['feed']?>">
<br/>
	<label for="seek">seek</label>
	<input name="seek" id="seek" type="text" value="<?=@$_GET['seek']?>">
<br/>
	<input name="generate" id="generate" type="submit" value="generate">
	<input name="download" id="download" type="submit" value="download">

</form>


</body>
</html>
