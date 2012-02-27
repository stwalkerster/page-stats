<?php
$wiz = array();

$wiz[2] = <<<HTML
				<div class="progress progress-success progress-striped active">
					<div class="bar" style="width: 66%;"></div>
				</div>
				<label class="control-label" for="pageName">Which page do you want to look at?</label>
				<div class="input-prepend">
					<span class="add-on">
						<select class="span2" style="position: relative;left: -6px;top: -5px;">
HTML;
foreach($ds->getNamespaces() as $id=>$ns)
{
	$wiz[2] .='<option value="' . $id . '">' .$ns .'</option>';
}
$wiz[2].= <<<HTML
						</select>
						<span style="position: relative;left: -6px;top: -7px;font-weight: bold;">:</span>
					</span>
					<input type="text" id="pageName" class="span4 inline" placeholder="Page title" />
				</div>

				<button type="submit" class="btn btn-large" name="jump" value="0">Back</button>
				<button type="submit" class="btn btn-large btn-primary" name="jump" value="4">Next</button>
HTML;

$wiz[1] = <<<HTML
<div class="progress progress-success progress-striped active">
	<div class="bar" style="width: 0%;"></div>
</div>
<label class="control-label">Which language site do you want to look at?</label>
<div class="input-append">
	<select class="span2" id="appendedInput" name="wmflanguage" style="float:left;border-radius:3px 0 0 3px;-webkit-border-radius:3px 0 0 3px;-moz-border-radius:3px 0 0 3px;">
		<option value="en">en</option>
HTML;

foreach(getWikimediaLanguages() as $lang)
{
	if($lang == "en") continue;
	$wiz[1] .='<option value="' . $lang . '">' .$lang .'</option>';
}

$wiz[1].= '<select><span class="add-on">.';
$wiz[1].= $_SESSION['rootdomain'];
$wiz[1].= '</span></div><button type="submit" class="btn btn-large btn-primary" name="jump" value="1">Next</button>';
