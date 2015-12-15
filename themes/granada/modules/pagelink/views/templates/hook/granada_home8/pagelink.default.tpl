{if isset($menuContents) && $menuContents|@count >0}
	<ul class="header-links hidden-sm hidden-xs">
		{foreach from=$menuContents item=parent_menu name=parent_menus}
			<li class="{$parent_menu.custom_class}">
           		<a href="{$parent_menu.link}" title="{$parent_menu.name}">
           			{if $parent_menu.icon_type == 'class'}
           				<span class="{$parent_menu.full_path}"></span>
           			{else}
           				{if $parent_menu.full_path != ''}
           					<img src="{$parent_menu.full_path}" alt="{$parent_menu.name}" />
           				{/if}               			
           			{/if}
           			<span>{$parent_menu.name}</span>
           		</a>
           	</li>
		{/foreach}
    </ul>	
    <div class="user-dropdown dropdown visible-sm visible-xs">
       <a title="{l s='My Account' mod='pagelink'}" class="dropdown-toggle" data-toggle="dropdown"><span class="header-links-icon icon-account"></span><span class="user-text hidden-xs">{l s='My Account' mod='pagelink'}</span></a>
       <ul class="dropdown-menu" role="menu">
			{foreach from=$menuContents item=parent_menu name=parent_menus}
				<li class="{$parent_menu.custom_class}">
	           		<a href="{$parent_menu.link}" title="{$parent_menu.name}">
	           			{if $parent_menu.icon_type == 'class'}
	           				<span class="{$parent_menu.full_path}"></span>
	           			{else}
	           				{if $parent_menu.full_path != ''}
	           					<img src="{$parent_menu.full_path}" alt="{$parent_menu.name}" />
	           				{/if}               			
	           			{/if}
	           			<span>{$parent_menu.name}</span>
	           		</a>
	           	</li>
			{/foreach}          
       </ul>
    </div>
{/if}