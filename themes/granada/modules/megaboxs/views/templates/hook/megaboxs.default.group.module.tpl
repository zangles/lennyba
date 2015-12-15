{if isset($megaboxs_group_content) && $megaboxs_group_content != ''}
<div class="col-md-{$megaboxs_group_width} {$megaboxs_group_custom_class}">
	{if $megaboxs_group_display_title == '1'}<h4>{$megaboxs_group_name}</h4>{/if}
	{$megaboxs_group_content}		
</div>
{/if}

