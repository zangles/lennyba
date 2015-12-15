<div class="col-md-{$megaboxs_group_width} {$megaboxs_group_custom_class}">
	{if $megaboxs_group_display_title == '1'}<h4>{$megaboxs_group_name}</h4>{/if}
	<ul class="twitter-top-widget" 
		data-username="{$megaboxs_group_username}"
		data-query="{$megaboxs_group_query}" 
		data-count="{$megaboxs_group_countItem}" 
		data-favorites="{$megaboxs_group_favorites}" 
		data-avatar_size="{$megaboxs_group_avatar_size}" 
		data-intro_text="{$megaboxs_group_intro_text}" 
		data-outro_text="{$megaboxs_group_outro_text}" 
		data-page="{$megaboxs_group_page}" ></ul>	
</div>
{addJsDef megaboxsJsUrl=$megaboxsJsUrl}
{addJsDefL name=loading_text}{l s='Searching twitter...' mod='megaboxs' js=1}{/addJsDefL}


