{if $megaboxs_group_menus && $megaboxs_group_menus|@count >0}
	<div class="col-md-{$megaboxs_group_width} {$megaboxs_group_custom_class}">
		{if $megaboxs_group_display_title == '1'}<h4>{$megaboxs_group_name}</h4>{/if}
		<ul class="links">
		{foreach from=$megaboxs_group_menus item=menuitem name=menuitems}
			<li class="{$menuitem.custom_class}">
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
			</li>				
		{/foreach}
		</ul>
	</div>
{/if}