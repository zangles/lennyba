<div class="col-sm-{$width} {$custom_class}">
	{if $display_title == '1'}
		<h5 class="megamenu-title">{$name}</h5>
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
				<a href="{$menuitem.link}" title="{$menuitem.name}">
					{if isset($menuitem.icon.img) && $menuitem.icon.img !=''}
						{if $menuitem.icon.type == 'class'}
							<span class="{$menuitem.icon.img}"></span>
						{elseif $menuitem.icon.type == 'image'}
							<img src="{$menuitem.icon.img}" alt="{$menuitem.name}" />
						{/if}
					{/if}
					{$menuitem.name}
				</a>
				{*}sub menu level 1 {*}
				{if isset($menuitem.subs) && $menuitem.subs|@count >0}
				<ul class="menuitem_sub_level_1">
					{foreach from=$menuitem.subs item=submenuitem1 name=submenuitem1s}
					<li class="{$submenuitem1.custom_class}">
						<a href="{$submenuitem1.link}" title="{$submenuitem1.name}">
							{if isset($submenuitem1.icon.img) && $submenuitem1.icon.img !=''}
								{if $submenuitem1.icon.type == 'class'}
									<span class="{$submenuitem1.icon.img}"></span>
								{elseif $submenuitem1.icon.type == 'image'}
									<img src="{$submenuitem1.icon.img}" alt="{$submenuitem1.name}" />
								{/if}
							{/if}
							{$submenuitem1.name}
						</a>
						{*}sub menu level 2 {*}
						{if isset($submenuitem1.subs) && $submenuitem1.subs|@count >0}
						<ul class="menuitem_sub_level_2">
							{foreach from=$submenuitem1.subs item=submenuitem2 name=submenuitem2s}
							<li class="{$submenuitem2.custom_class}">
								<a href="{$submenuitem2.link}" title="{$submenuitem2.name}">
									{if isset($submenuitem2.icon.img) && $submenuitem2.icon.img !=''}
										{if $submenuitem2.icon.type == 'class'}
											<span class="{$submenuitem2.icon.img}"></span>
										{elseif $submenuitem2.icon.type == 'image'}
											<img src="{$submenuitem2.icon.img}" alt="{$submenuitem2.name}" />
										{/if}
									{/if}
									{$submenuitem2.name}
								</a>
								{*}sub menu level 2 {*}
								{if isset($submenuitem2.subs) && $submenuitem2.subs|@count >0}
									<ul class="menuitem_sub_level_2">
									{foreach from=$submenuitem2.subs item=submenuitem3 name=submenuitem3s}
										<li class="{$submenuitem3.custom_class}">
											<a href="{$submenuitem3.link}" title="{$submenuitem3.name}">
												{if isset($submenuitem3.icon.img) && $submenuitem3.icon.img !=''}
													{if $submenuitem3.icon.type == 'class'}
														<span class="{$submenuitem3.icon.img}"></span>
													{elseif $submenuitem3.icon.type == 'image'}
														<img src="{$submenuitem3.icon.img}" alt="{$submenuitem3.name}" />
													{/if}
												{/if}
												{$submenuitem3.name}
											</a>			
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