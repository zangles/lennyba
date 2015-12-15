{if isset($customhtml_item) && $customhtml_item|@count >0}
	{if $customhtml_item.display_name == '1'}<h3 class="{$customhtml_item.custom_class} title">{$customhtml_item.name}</h3>{/if}
	{$customhtml_item.content}	
{/if}