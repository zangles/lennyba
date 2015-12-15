{if isset($megamenus_rows) && $megamenus_rows|@count >0}	
	{foreach from=$megamenus_rows item=row name=rows}
	<div class="megamenu {$row.custom_class}">
		<div class="container">
			<div class="row">
				{if $row.display_name == '1'}<h4 class="row-title">{$row.name}</h4>{/if}				
				{$row.groups}
			</div>
		</div>
	</div>		
	{/foreach}
{/if}
