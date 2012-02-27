<label class="control-label">Which language site do you want to look at?</label>
<div class="input-append">
	<select class="span2" id="appendedInput" name="wmflanguage" style="float:left;border-radius:3px 0 0 3px;-webkit-border-radius:3px 0 0 3px;-moz-border-radius:3px 0 0 3px;">
		<option value="en">en</option>
{foreach $wmflangs as $lang}
		<option value="{$lang}">{$lang}</option>
{/foreach}
	</select>
	<span class="add-on">{$rootdomain}</span>
</div>
<button type="submit" class="btn btn-large btn-primary">Next</button>