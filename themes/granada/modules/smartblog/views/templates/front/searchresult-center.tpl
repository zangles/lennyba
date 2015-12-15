     {if $postcategory == ''}
        {include file="./search-not-found.tpl" postcategory=$postcategory}
    {else}
    <div id="smartblogcat" class="block">
		{foreach from=$postcategory item=post}
		    {include file="./category_loop.tpl" postcategory=$postcategory}
		{/foreach}
	</div>
	{/if}


