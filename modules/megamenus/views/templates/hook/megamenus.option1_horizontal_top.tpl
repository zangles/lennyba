{if isset($megamenus_menus) && $megamenus_menus|@count >0}
<nav id="main-nav" class="{$custom_class}" role="navigation">
	<div id="responsive-nav">
		<a id="responsive-btn" href="#"><span class="responsive-btn-icon"><span class="responsive-btn-block"></span> <span class="responsive-btn-block"></span> <span class="responsive-btn-block last"></span></span> <span class="responsive-btn-text">{$module_name}</span></a>
		<div id="responsive-menu-container"></div>
	</div>
	<ul class="menu clearfix">
		{foreach from=$megamenus_menus item=menu name=menus}
			{if !isset($menu.rows) || $menu.rows == ''}
			<li class="{$menu.custom_class}">
				<a href="{$menu.link}" title="{$menu.name}">{$menu.name}</a>
				{*}sub menu level 1 {*}
				{if isset($menu.subs) && $menu.subs|@count >0}							
				<ul class="sub_level_1">
					{foreach from=$menu.subs item=submenu1 name=submenu1s}
						<li class="{$submenu1.custom_class}">
							<a href="{$submenu1.link}" title="{$submenu1.name}">{$submenu1.name}</a>
							{*}sub menu level 2 {*}
							{if isset($submenu1.subs) && $submenu1.subs|@count >0}
							<ul class="sub_level_2">
								{foreach from=$submenu1.subs item=submenu2 name=submenu2s}
									<li class="{$submenu2.custom_class}">
										<a href="{$submenu2.link}" title="{$submenu2.name}">{$submenu2.name}</a>
										{*}sub menu level 3 {*}
										{if isset($submenu2.subs) && $submenu2.subs|@count >0}
										<ul class="sub_level_3">
											{foreach from=$submenu2.subs item=submenu3 name=submenu3s}
											<li class="{$submenu3.custom_class}">
												<a href="{$submenu3.link}" title="{$submenu3.name}">{$submenu3.name}</a>		
											</li>		
											{/foreach}		
										</ul>					
										{/if}
									</li>		
								{/foreach}
							</ul>										
							{/if}
						</li>
					{/foreach}
                 </ul>
				{/if}
			</li>					
			{else}
			<li class="megamenu-container {$menu.custom_class}">
				<a href="{$menu.link}" title="{$menu.name}">{$menu.name}</a>
				{$menu.rows}
			</li>
			{/if}				
		{/foreach}
	</ul>     
</nav>
{/if}
