{if isset($megabox_rows) && $megabox_rows|@count >0}
    {foreach from=$megabox_rows item=row name=rows}
    	<div id="megabox-row-{$row.id}" class="{$row.custom_class} {if $row.width}col-sm-{$row.width}{/if}">
    		{if $row.display_name == "1"}<h3>{$row.name}</h3>{/if}
    		<div class="row">{$row.groups}</div>
    		<div class="cleafix"></div>	
    	</div>        
    {/foreach}    
{/if}
