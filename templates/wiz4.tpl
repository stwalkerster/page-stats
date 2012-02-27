<label class="control-label" for="pageName">Which page do you want to look at on <a href="{$sitebase}">{$sitename}</a>?</label>
<div class="input-prepend">
	<span class="add-on">
		<select class="span2" style="position: relative;left: -6px;top: -5px;" name="ns">
{foreach $namespaces as $id=>$name}
			<option value="{$id}">{$name}</option>
{/foreach}
		</select>
		<span style="position: relative;left: -6px;top: -7px;font-weight: bold;">:</span>
	</span>
	<input type="text" id="pageName" class="span4 inline" placeholder="Page title" name="title" />
</div>
<button type="submit" class="btn btn-large btn-primary">Next</button>