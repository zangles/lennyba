<div class="widget side-menu-container">
	{if $display_name == '1'}<h3>{$module_name}</h3>{/if}
	{if isset($megamenus_menus) && $megamenus_menus|@count >0}
	<div class="side-menu {$custom_class}">
		<ul>
			{foreach from=$megamenus_menus item=menu name=menus}
				{if !isset($menu.rows) || $menu.rows == ''}				
				<li class="{$menu.custom_class}">
					<a href="{$menu.link}" title="{$menu.name}">
						{if isset($menu.icon.img) && $menu.icon.img !=''}
							{if $menu.icon.type == 'class'}
								<span class="{$menu.icon.img}"></span>
							{elseif $menu.icon.type == 'image'}
								<img src="{$menu.icon.img}" alt="{$menu.name}" />
							{/if}
						{/if}
						{$menu.name}						
					</a>
					{*}sub menu level 1 {*}
					{if isset($menu.subs) && $menu.subs|@count >0}							
					<ul class="sub_level_1">
						{foreach from=$menu.subs item=submenu1 name=submenu1s}
							<li class="{$submenu1.custom_class}">
								<a href="{$submenu1.link}" title="{$submenu1.name}">
									{if isset($submenu1.icon.img) && $submenu1.icon.img !=''}
										{if $submenu1.icon.type == 'class'}
											<span class="{$submenu1.icon.img}"></span>
										{elseif $submenu1.icon.type == 'image'}
											<img src="{$submenu1.icon.img}" alt="{$submenu1.name}" />
										{/if}
									{/if}
									{$submenu1.name}
								</a>
								{*}sub menu level 2 {*}
								{if isset($submenu1.subs) && $submenu1.subs|@count >0}
								<ul class="sub_level_2">
									{foreach from=$submenu1.subs item=submenu2 name=submenu2s}
										<li class="{$submenu2.custom_class}">
											<a href="{$submenu2.link}" title="{$submenu2.name}">
												{if isset($submenu2.icon.img) && $submenu2.icon.img !=''}
													{if $submenu2.icon.type == 'class'}
														<span class="{$submenu2.icon.img}"></span>
													{elseif $submenu2.icon.type == 'image'}
														<img src="{$submenu2.icon.img}" alt="{$submenu2.name}" />
													{/if}
												{/if}
												{$submenu2.name}
											</a>
											{*}sub menu level 3 {*}
											{if isset($submenu2.subs) && $submenu2.subs|@count >0}
											<ul class="sub_level_3">
												{foreach from=$submenu2.subs item=submenu3 name=submenu3s}
												<li class="{$submenu3.custom_class}">
													<a href="{$submenu3.link}" title="{$submenu3.name}">
														{if isset($submenu3.icon.img) && $submenu3.icon.img !=''}
															{if $submenu3.icon.type == 'class'}
																<span class="{$submenu3.icon.img}"></span>
															{elseif $submenu3.icon.type == 'image'}
																<img src="{$submenu3.icon.img}" alt="{$submenu3.name}" />
															{/if}
														{/if}
														{$submenu3.name}
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
				{else}
				<li class="megamenu-container {$menu.custom_class}">
					<a href="{$menu.link}" title="{$menu.name}" class="dropdown-toggle" data-toggle="dropdown">
						{if isset($menu.icon.img) && $menu.icon.img !=''}
							{if $menu.icon.type == 'class'}
								<span class="{$menu.icon.img}"></span>
							{elseif $menu.icon.type == 'image'}
								<img src="{$menu.icon.img}" alt="{$menu.name}" />
							{/if}
						{/if}
						{$menu.name} 
						<span class="category-dropdown-icon"></span>
					</a>					
					{$menu.rows}
				</li>
				{/if}
			{/foreach}
		</ul>
	</div>
	{/if}
</div>