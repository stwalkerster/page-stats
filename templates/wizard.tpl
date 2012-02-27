{extends file="base.tpl"}
{block name="body"}
	<form method="post" action="?wizard={$wizardPage}">
	<div class="row">
		<div class="span8 offset2">
			<h2>Get Started!</h2>
			<p>Follow this short wizard to get started quickly</p>
			<div class="well">
			<div class="progress progress-success progress-striped active">
				<div class="bar" style="width: {$wizProgress}%;"></div>
			</div>
{include file="$wizardPageTemplate"}
			</div>
		</div>
	</div>
	<input type="hidden" name="from" value="{$wizardPage}" />
</form>
{/block}