{if $postcategory == ''}
	<h2 class="color2">{l s='No Post in This Tag' mod='smartblog'}</h2>
{else}
<div id="smartblogcat" class="block">
	{foreach from=$postcategory item=post}
	    {include file="./category_loop.tpl" postcategory=$postcategory}
	{/foreach}
</div>
{/if}