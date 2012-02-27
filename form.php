<?php
$wiz = array();
$wizHead = <<<HTML
<div class="hero-unit">
	<h1>Page Statistics Tool</h1>
	<p>Gather many different statistics on various pages.</p>
</div>
<form method="post">
	<div class="row">
		<div class="span8 offset2">
			<h2>Get Started!</h2>
			<p>Follow this short wizard to get started quickly</p>
			<div class="well">
HTML;
$wiz[0] = <<<HTML
				<div class="progress progress-success progress-striped active">
					<div class="bar" style="width: 0%;"></div>
				</div>
				<label class="control-label">Which base site do you want to look at?

					<select class="span2" name="wmfdomain">
						<option>wikipedia.org</option>
						<option>wiktionary.org</option>
						<option>wikiquote.org</option>
						<option>wikibooks.org</option>
						<option>wikisource.org</option>
						<option>wikinews.org</option>
						<option>wikiversity.org</option>
						<!-- species -->
						<!-- commons -->
						<!-- mediawiki -->
						<!-- meta -->
					</select></label>

				<button type="submit" class="btn btn-large btn-primary" name="jump" value="1">Next</button>
HTML;

$wizFoot = <<<HTML
			</div>
		</div>
	</div>
	<input type="hidden" name="from" value="{$_REQUEST['jump']}" />
</form>
HTML;


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
