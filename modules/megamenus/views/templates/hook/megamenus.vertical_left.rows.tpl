{if isset($megamenus_rows) && $megamenus_rows|@count >0}
	
		
	{foreach from=$megamenus_rows item=row name=rows}
	<div class="dropdown-menu megamenu">		
		{if isset($row.background) && $row.background != ''}
			<img src="{$row.background}" alt="{$row.name}" class="bgimage">
		{/if}	
		{$row.groups}
	</div>
	{/foreach}
{/if}
