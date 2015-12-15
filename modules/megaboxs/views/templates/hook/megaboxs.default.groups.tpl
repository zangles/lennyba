{if isset($megaboxs_groups) && $megaboxs_groups|@count > 0}
	{foreach from=$megaboxs_groups item=group name=groups}
		{$group.group_content}
	{/foreach}
{/if}

