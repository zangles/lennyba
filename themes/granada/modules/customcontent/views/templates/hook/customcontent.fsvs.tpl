{if isset($module_items) && $module_items|@count >0}
	<div id="vslider_body" class="{$module_custom_class}" {if $module_background != ''} style="background-image: url('{$module_background}');" {/if}>	
		{if $module_display_name == '1'}<h3 class="title">{$module_name}</h3>{/if}
		{foreach from=$module_items item=item name=items}                       
	        <div class="slide" style="background-image: url({$item.background});">
	        	{$item.content}
	        </div>
	    {/foreach}
    </div>
{/if}