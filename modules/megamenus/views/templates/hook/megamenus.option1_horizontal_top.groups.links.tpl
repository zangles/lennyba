<div class="col-md-{$width} {$custom_class}">
	{if $display_title == '1'}
		<h5 class="group-title megamenu-title">{$name}</h5>
	{/if}
	{if isset($megamenus_menuitems) && $megamenus_menuitems|@count >0}
		<ul>
		{foreach from=$megamenus_menuitems item=menuitem name=menuitems}
		<li class="{$menuitem.custom_class}">
			{if $menuitem.menu_type == 'module'}			
				<div class="menu-item-module">{$menuitem.content}</div>
			{elseif $menuitem.menu_type == 'image'}
				<div class="menu-item-image">
					<img class="img-responsive" src="{$menuitem.content}" alt="{$menuitem.imageAlt}" />
					<div class="menu-item-image-des">{$menuitem.html}</div>
				</div>
			{elseif $menuitem.menu_type == 'html'}
				<div class="menu-item-html">{$menuitem.content}</div>
			{else}
				<a href="{$menuitem.link}" title="{$menuitem.name}">{$menuitem.name}</a>
				{*}sub menu level 1 {*}
				{if isset($menuitem.subs) && $menuitem.subs|@count >0}
				<ul class="menuitem_sub_level_1">
					{foreach from=$menuitem.subs item=submenuitem1 name=submenuitem1s}
					<li class="{$submenuitem1.custom_class}">
						<a href="{$submenuitem1.link}" title="{$submenuitem1.name}">{$submenuitem1.name}</a>
						{*}sub menu level 2 {*}
						{if isset($submenuitem1.subs) && $submenuitem1.subs|@count >0}
						<ul class="menuitem_sub_level_2">
							{foreach from=$submenuitem1.subs item=submenuitem2 name=submenuitem2s}
							<li class="{$submenuitem2.custom_class}">
								<a href="{$submenuitem2.link}" title="{$submenuitem2.name}">{$submenuitem2.name}</a>
								{*}sub menu level 2 {*}
								{if isset($submenuitem2.subs) && $submenuitem2.subs|@count >0}
									<ul class="menuitem_sub_level_2">
									{foreach from=$submenuitem2.subs item=submenuitem3 name=submenuitem3s}
										<li class="{$submenuitem3.custom_class}">
											<a href="{$submenuitem3.link}" title="{$submenuitem3.name}">{$submenuitem3.name}</a>			
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
			{/if}		
		</li>		
		{/foreach}
		</ul>
	{/if}
</div>