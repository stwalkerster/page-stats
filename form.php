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
				<label class="control-label">Which site do you want to look at?</label>
				<div class="input-prepend">
					<span class="add-on">
						<select class="span1" style="position: relative;left: -6px;top: -5px;" name="wmflanguage">
							<option value="en">en</option>
HTML;
foreach(getWikimediaLanguages() as $lang)
{
	if($lang == "en") continue;
	$wiz[0] .='<option value="' . $lang . '">' .$lang .'</option>';
}
$wiz[0].= <<<HTML
						</select>
						<span style="position: relative;left: -3px;top: -7px;font-weight: bold;">.</span>
					</span>
					<select class="span2 inline" name="wmfdomain">
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
					</select>
				</div>

				<button type="submit" class="btn btn-large btn-primary" name="jump" value="1">Next</button>
HTML;

$wizFoot = <<<HTML
			</div>
		</div>
	</div>
</form>
HTML;


$wiz[1] = <<<HTML
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
	$wiz[1] .='<option value="' . $id . '">' .$ns .'</option>';
}
$wiz[1].= <<<HTML
						</select>
						<span style="position: relative;left: -6px;top: -7px;font-weight: bold;">:</span>
					</span>
					<input type="text" id="pageName" class="span4 inline" placeholder="Page title" />
				</div>

				<button type="submit" class="btn btn-large" name="jump" value="0">Back</button>
				<button type="submit" class="btn btn-large btn-primary" name="jump" value="4">Next</button>
HTML;
            