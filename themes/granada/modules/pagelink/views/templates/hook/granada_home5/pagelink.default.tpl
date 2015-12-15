{if isset($menuContents) && $menuContents|@count >0}
	<ul class="header-link">
		{foreach from=$menuContents item=parent_menu name=parent_menus}
			<li>
           		<a href="{$parent_menu.link}" title="{$parent_menu.name}">
           			{if $parent_menu.icon_type == 'class'}
           				<span class="{$parent_menu.full_path}"></span>
           			{else}
           				{if $parent_menu.full_path != ''}
           					<img src="{$parent_menu.full_path}" alt="{$parent_menu.name}" />
           				{/if}               			
           			{/if}
           			<span class="hidden-xs">{$parent_menu.name}</span>
           		</a>
           	</li>
		{/foreach}
    </ul>	
{/if}